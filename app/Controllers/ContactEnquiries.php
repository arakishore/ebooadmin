<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ContactEnquiryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ContactEnquiries extends BaseController
{
    protected ContactEnquiryModel $model;
    private array $statusTabs = ['new', 'read', 'replied', 'closed', 'archive'];
    private array $enquiryTypes = ['contact', 'package', 'hotel', 'forex', 'car', 'cruise', 'visa', 'flight'];

    public function __construct()
    {
        $this->model = new ContactEnquiryModel();
    }

    public function contactMessages(string $status = 'new')
    {
        return $this->listByTypeAndStatus('contact', $status);
    }

    public function packageEnquiries(string $status = 'new')
    {
        return $this->listByTypeAndStatus('package', $status);
    }
    public function hotelEnquiries(string $status = 'new')
    {
        return $this->listByTypeAndStatus('hotel', $status);
    }
    public function forexEnquiries(string $status = 'new')
    {
        return $this->listByTypeAndStatus('forex', $status);
    }
    public function carEnquiries(string $status = 'new')
    {
        return $this->listByTypeAndStatus('car', $status);
    }
    public function cruiseEnquiries(string $status = 'new')
    {
        return $this->listByTypeAndStatus('cruise', $status);
    }
    public function visaEnquiries(string $status = 'new')
    {        
        return $this->listByTypeAndStatus('visa', $status);
    }
    public function flightEnquiries(string $status = 'new')
    {
        return $this->listByTypeAndStatus('flight', $status);
    }
      
    public function view($id)
    {
        $enquiry = $this->findEnquiryWithPackage($id);

        if ($enquiry['status'] === 'new') {
            $this->model->update($id, [
                'status'    => 'read',
                'viewed_at' => date('Y-m-d H:i:s'),
                'viewed_by' => session()->get('admin_id') ?: null,
            ]);

            $enquiry = $this->findEnquiryWithPackage($id);
        }

        return view('contact_enquiry/view', [
            'enquiry'   => $enquiry,
            'pageTitle' => $enquiry['enquiry_type'] === 'package' ? 'Package Enquiry' : 'Contact Us Message',
        ]);
    }

    public function update($id)
    {
        $enquiry = $this->findEnquiry($id);

        $rules = [
            'status'        => 'required|in_list[read,replied,closed]',
            'admin_note'    => 'permit_empty',
            'reply_message' => 'permit_empty',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $replyMessage = trim((string) $this->request->getPost('reply_message'));
        $data = [
            'status'        => $this->request->getPost('status'),
            'admin_note'    => $this->request->getPost('admin_note') ?: null,
            'reply_message' => $replyMessage !== '' ? $replyMessage : null,
        ];

        if ($replyMessage !== '' && $data['status'] !== 'closed') {
            $data['status'] = 'replied';
        }

        if ($replyMessage !== '' && (empty($enquiry['replied_at']) || (string) ($enquiry['reply_message'] ?? '') !== $replyMessage)) {
            $data['replied_at'] = date('Y-m-d H:i:s');
            $data['replied_by'] = session()->get('admin_id') ?: null;
        }

        if (! $this->model->update($id, $data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/contact-enquiries/view/' . $id)
            ->with('success', 'Enquiry updated successfully!');
    }

    public function bulkArchive()
    {
        $ids = array_filter(array_map('intval', (array) $this->request->getPost('enquiry_ids')));

        if (empty($ids)) {
            return redirect()->back()
                ->with('error', 'Please select at least one enquiry to archive.');
        }

        $this->model->builder()
            ->whereIn('id', $ids)
            ->where('is_archived', 0)
            ->update([
                'is_archived' => 1,
                'archived_at' => date('Y-m-d H:i:s'),
                'archived_by' => session()->get('admin_id') ?: null,
                'updated_at'  => date('Y-m-d H:i:s'),
            ]);

        return redirect()->back()
            ->with('success', 'Selected enquiries archived successfully!');
    }

    public function restore($id)
    {
        $enquiry = $this->findEnquiry($id);

        if (! $this->model->update($id, [
            'is_archived' => 0,
            'archived_at' => null,
            'archived_by' => null,
        ])) {
            return redirect()->back()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to($this->getListUrl($enquiry['enquiry_type'], 'archive'))
            ->with('success', 'Enquiry restored successfully!');
    }

    public function delete($id)
    {
        $enquiry = $this->findEnquiry($id);

        if (! $this->model->delete($id)) {
            return redirect()->back()
                ->with('errors', $this->model->errors());
        }

        $redirect = $enquiry['enquiry_type'] === 'package' ? '/package-enquiries' : '/contact-messages';

        return redirect()
            ->to($redirect)
            ->with('success', 'Enquiry deleted successfully!');
    }

    public function data(string $type, string $status)
    {
        if (! in_array($type, $this->enquiryTypes, true) || ! in_array($status, $this->statusTabs, true)) {
            throw new PageNotFoundException('Enquiry data page not found');
        }

        $draw = (int) ($this->request->getGet('draw') ?? 0);
        $start = max(0, (int) ($this->request->getGet('start') ?? 0));
        $length = (int) ($this->request->getGet('length') ?? 10);
        $length = $length > 0 ? min($length, 100) : 10;

        $search = $this->request->getGet('search');
        $searchValue = is_array($search) ? trim((string) ($search['value'] ?? '')) : '';

        $order = $this->request->getGet('order');
        $orderColumnIndex = is_array($order) ? (int) ($order[0]['column'] ?? 0) : 0;
        $orderDirection = is_array($order) && strtolower((string) ($order[0]['dir'] ?? 'desc')) === 'asc' ? 'ASC' : 'DESC';

        $columns = $this->request->getGet('columns');
        $orderColumnName = is_array($columns) ? (string) ($columns[$orderColumnIndex]['name'] ?? '') : '';
        $orderColumns = [
            'id' => 'contact_enquiries.id',
            'name' => 'contact_enquiries.name',
            'subject' => 'contact_enquiries.subject',
            'package_title' => 't_packages.title',
            'status' => 'contact_enquiries.status',
            'created_at' => 'contact_enquiries.created_at',
        ];
        $orderBy = $orderColumns[$orderColumnName] ?? 'contact_enquiries.created_at';

        $total = $this->countEnquiries($type, $status);
        $filtered = $this->countEnquiries($type, $status, $searchValue);

        $builder = $this->enquiryDataBuilder($type, $status, $searchValue)
            ->orderBy($orderBy, $orderDirection)
            ->limit($length, $start);

        $rows = $builder->get()->getResultArray();

        return $this->response->setJSON([
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => array_map(static fn (array $enquiry): array => self::formatDataRow($enquiry, $status), $rows),
        ]);
    }

    private function listByTypeAndStatus(string $type, string $status)
    {
        if (! in_array($status, $this->statusTabs, true)) {
            throw new PageNotFoundException('Enquiry status page not found');
        }

        $sectionTitles = [
            'contact' => 'Contact Us',
            'package' => 'Package Enquiries',
            'hotel'   => 'Hotel Enquiries',
            'forex'   => 'Forex Enquiries',
            'car'     => 'Car Rental Enquiries',
            'cruise'  => 'Cruise Enquiries',
            'visa'    => 'Visa Enquiries',
        ];

        $sectionTitle = $sectionTitles[$type] ?? ucfirst($type) . ' Enquiries';
        $statusTitle = $status === 'archive' ? 'Archive' : ucfirst($status);

        return view('contact_enquiry/index', [
            'enquiries'   => [],
            'pageTitle'   => $sectionTitle . ' - ' . $statusTitle,
            'enquiryType' => $type,
            'statusTab'   => $status,
        ]);
    }

    private function enquiryDataBuilder(string $type, string $status, string $search = '')
    {
        $builder = db_connect()
            ->table('contact_enquiries')
            ->select('contact_enquiries.*, t_packages.title AS package_title')
            ->join('t_packages', 't_packages.id = contact_enquiries.package_id', 'left')
            ->where('contact_enquiries.deleted_at IS NULL', null, false)
            ->where('contact_enquiries.enquiry_type', $type);

        if ($status === 'archive') {
            $builder->where('contact_enquiries.is_archived', 1);
        } else {
            $builder
                ->groupStart()
                    ->where('contact_enquiries.is_archived', 0)
                    ->orWhere('contact_enquiries.is_archived IS NULL', null, false)
                ->groupEnd()
                ->where('contact_enquiries.status', $status);
        }

        if ($search !== '') {
            $builder
                ->groupStart()
                    ->like('contact_enquiries.id', $search)
                    ->orLike('contact_enquiries.name', $search)
                    ->orLike('contact_enquiries.email', $search)
                    ->orLike('contact_enquiries.phone', $search)
                    ->orLike('contact_enquiries.subject', $search)
                    ->orLike('contact_enquiries.message', $search)
                    ->orLike('contact_enquiries.hotel_name', $search)
                    ->orLike('t_packages.title', $search)
                    ->orLike('contact_enquiries.created_at', $search)
                ->groupEnd();
        }

        return $builder;
    }

    private function countEnquiries(string $type, string $status, string $search = ''): int
    {
        return $this->enquiryDataBuilder($type, $status, $search)->countAllResults();
    }

    private static function formatDataRow(array $enquiry, string $statusTab): array
    {
        $statusClasses = [
            'new'     => 'bg-danger',
            'read'    => 'bg-info',
            'replied' => 'bg-success',
            'closed'  => 'bg-secondary',
        ];

        $statusLabels = [
            'new'     => 'New',
            'read'    => 'Read',
            'replied' => 'Replied',
            'closed'  => 'Closed',
        ];

        $id = (int) $enquiry['id'];
        $subject = $enquiry['enquiry_type'] === 'package'
            ? ($enquiry['package_title'] ?? '-')
            : ($enquiry['subject'] ?? '-');

        $actions = '<a href="' . base_url('contact-enquiries/view/' . $id) . '" class="list-icons-item text-primary-600" data-popup="tooltip" title="View" data-original-title="View"><i class="icon-eye"></i></a>';

        if ($statusTab === 'archive') {
            $actions .= ' <a href="' . base_url('contact-enquiries/restore/' . $id) . '" class="list-icons-item text-success" data-popup="tooltip" title="Restore" data-original-title="Restore"><i class="icon-undo2"></i></a>';
        } else {
            $actions .= ' <a href="' . base_url('contact-enquiries/delete/' . $id) . '" class="list-icons-item text-danger bootbox_custom" data-original-title="Delete"><i class="icon-trash"></i></a>';
        }

        return [
            'checkbox' => $statusTab === 'archive' ? '' : '<input type="checkbox" class="enquiry-checkbox" name="enquiry_ids[]" value="' . esc((string) $id, 'attr') . '">',
            'id' => esc((string) $id),
            'name' => esc($enquiry['name'] ?? '-'),
            'subject' => esc($subject),
            'status' => '<span class="badge ' . esc($statusClasses[$enquiry['status']] ?? 'bg-secondary', 'attr') . '">' . esc($statusLabels[$enquiry['status']] ?? ucfirst((string) $enquiry['status'])) . '</span>',
            'created_at' => esc($enquiry['created_at'] ?? '-'),
            'actions' => $actions,
        ];
    }

    private function getListUrl(string $type, string $status): string
    {
        $base = $type === 'package' ? '/package-enquiries' : '/contact-messages';

        return $base . '/' . $status;
    }

    private function findEnquiry($id): array
    {
        $enquiry = $this->model->find($id);

        if (! $enquiry) {
            throw new PageNotFoundException('Enquiry not found');
        }

        return $enquiry;
    }

    private function findEnquiryWithPackage($id): array
    {
        $enquiry = $this->model
            ->select('contact_enquiries.*, t_packages.title AS package_title')
            ->join('t_packages', 't_packages.id = contact_enquiries.package_id', 'left')
            ->where('contact_enquiries.id', $id)
            ->first();

        if (! $enquiry) {
            throw new PageNotFoundException('Enquiry not found');
        }

        return $enquiry;
    }
}
