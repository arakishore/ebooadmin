<?php

namespace App\Controllers\Api;

use App\Models\ContactEnquiryModel;
use Throwable;

class ContactEnquiries extends BaseApiController
{
    protected ContactEnquiryModel $model;

    public function __construct()
    {
        $this->model = new ContactEnquiryModel();
    }

    public function create()
    {


        // $rules = [
        //     'enquiry_type' => 'required|in_list[contact,package,hotel,car,forex,visa,cruise,other]',
        //     'name' => 'required|max_length[150]',
        //     'email' => 'permit_empty|valid_email|max_length[150]',
        //     'phone' => 'required|max_length[30]',
        //     'subject' => 'permit_empty|max_length[255]',
        //     'message' => 'permit_empty|max_length[2000]',
        //     'travel_date' => 'permit_empty|valid_date[Y-m-d]',
        //     'adults' => 'permit_empty|is_natural',
        //     'children' => 'permit_empty|is_natural',
        //     'hotel_id' => 'permit_empty|is_natural_no_zero',
        //     'hotel_name' => 'permit_empty|max_length[255]',
        //     'check_in' => 'permit_empty|valid_date[Y-m-d]',
        //     'check_out' => 'permit_empty|valid_date[Y-m-d]',
        //     'rooms' => 'permit_empty|is_natural',
        //     'page_url' => 'permit_empty|max_length[500]',
        //     'referrer_url' => 'permit_empty|max_length[500]',
        //     'utm_source' => 'permit_empty|max_length[100]',
        //     'utm_medium' => 'permit_empty|max_length[100]',
        //     'utm_campaign' => 'permit_empty|max_length[150]',
        // ];
        $rules = [
            'enquiry_type' => 'required|in_list[contact,package,hotel,car,forex,visa,cruise,flight]',
            'name'         => 'permit_empty|max_length[150]',
            'email'        => 'permit_empty|valid_email|max_length[150]',
            'phone'        => 'permit_empty|max_length[30]',
            'subject'      => 'permit_empty|max_length[255]',
            'message'      => 'permit_empty|max_length[2000]',
            'page_url'     => 'permit_empty|max_length[500]',
            'referrer_url' => 'permit_empty|max_length[500]',
            'utm_source'   => 'permit_empty|max_length[100]',
            'utm_medium'   => 'permit_empty|max_length[100]',
            'utm_campaign' => 'permit_empty|max_length[150]',
        ];
        $enquiryType = $this->sanitizeString($this->request->getVar('enquiry_type'));
        if ($enquiryType === 'contact') {
            $rules['name'] = 'required|max_length[255]';
            $rules['phone'] = 'required|max_length[30]';
            $rules['subject'] = 'required|max_length[255]';
            $rules['email'] = 'permit_empty|valid_email|max_length[150]';
            $rules['message'] = 'required';
        }

        if ($enquiryType === 'package') {
            $rules['package_id'] = 'required|is_natural_no_zero|is_not_unique[t_packages.id]';
            $rules['name'] = 'required|max_length[255]';
            $rules['phone'] = 'required|max_length[30]';
            $rules['message'] = 'required';
            $rules['travel_date'] = 'required|valid_date[Y-m-d]';
            $rules['email'] = 'permit_empty|valid_email|max_length[150]';
        }

        if ($enquiryType === 'hotel') {
            $rules['name'] = 'required|max_length[255]';
            $rules['phone'] = 'required|max_length[30]';
            $rules['email'] = 'permit_empty|valid_email|max_length[150]';
            $rules['hotel_name'] = 'permit_empty|max_length[255]';
            $rules['check_in'] = 'required|valid_date[Y-m-d]';
            $rules['check_out'] = 'required|valid_date[Y-m-d]';
            $rules['adults'] = 'required|integer|greater_than[0]';
            $rules['rooms'] = 'required|integer|greater_than[0]';
            $rules['children'] = 'permit_empty|integer|greater_than_equal_to[0]';
        }
        if ($enquiryType === 'car') {
            $rules['pickup_location'] = 'required|max_length[255]';
            $rules['dropoff_location'] = 'required|max_length[255]';
            $rules['pickup_date'] = 'required|valid_date[Y-m-d]';
            $rules['dropoff_date'] = 'required|valid_date[Y-m-d]';
            $rules['passengers'] = 'required|integer|greater_than[0]';
            $rules['vehicle_type'] = 'required|max_length[100]';
            $rules['is_air_con'] = 'required|in_list[0,1]';
            // $rules['children'] = 'permit_empty|integer|greater_than_equal_to[0]';
            $rules['email'] = 'permit_empty|valid_email|max_length[150]';
            $rules['phone'] = 'required|max_length[30]';
            $rules['message'] = 'permit_empty|max_length[2000]';
            $rules['name'] = 'required|max_length[255]';
        }
        if ($enquiryType === 'forex') {
            $rules['name'] = 'required|max_length[255]';
            $rules['phone'] = 'required|max_length[30]';
            $rules['message'] = 'permit_empty|max_length[2000]';
            $rules['currency_type'] = 'required|max_length[50]';
            $rules['currency_amount'] = 'required|decimal';
            $rules['travel_date'] = 'permit_empty|valid_date[Y-m-d]';
            $rules['email'] = 'permit_empty|valid_email|max_length[150]';
        }

        if ($enquiryType === 'flight' || $enquiryType === 'flights') {
            $rules['pickup_location'] = 'permit_empty|max_length[255]';
            $rules['dropoff_location'] = 'permit_empty|max_length[255]';
            $rules['pickup_date'] = 'permit_empty|valid_date[Y-m-d]';
            $rules['dropoff_date'] = 'permit_empty|valid_date[Y-m-d]';
            $rules['adults'] = 'permit_empty|integer|greater_than[0]';
            $rules['children'] = 'permit_empty|integer|greater_than_equal_to[0]';
            $rules['email'] = 'permit_empty|valid_email|max_length[150]';
            $rules['phone'] = 'required|max_length[30]';
            $rules['message'] = 'permit_empty|max_length[2000]';
            $rules['name'] = 'required|max_length[255]';
        }

        if (! $this->validate($rules)) {
            return $this->validationError($this->validator->getErrors());
        }


        $packageId = $this->request->getVar('package_id');

        if ($enquiryType === 'package' && empty($packageId)) {
            return $this->validationError([
                'package_id' => 'The package_id field is required for package enquiries.',
            ]);
        }
        if ($enquiryType === 'hotel' && ! empty($checkIn) && ! empty($checkOut) && strtotime($checkOut) <= strtotime($checkIn)) {
            return $this->validationError([
                'check_out' => 'Check-out date must be after check-in date.',
            ]);
        }
        if (
            $enquiryType === 'car' &&
            !empty($pickupDate) &&
            !empty($dropoffDate) &&
            strtotime($dropoffDate) < strtotime($pickupDate)
        ) {
            return $this->validationError([
                'dropoff_date' => 'Drop-off date must be on or after pickup date.',
            ]);
        }
        if (! $this->verifyTurnstile()) {
            return $this->captchaFailed();
        }

        $data = [
            'enquiry_type' => $enquiryType,
            'package_id' => $packageId !== null && $packageId !== '' ? (int) $packageId : null,
            'name' => $this->sanitizeString($this->request->getVar('name')),
            'email' => $this->sanitizeString($this->request->getVar('email')),
            'phone' => $this->nullableString('phone'),
            'subject' => $this->nullableString('subject'),
            'message' => $this->sanitizeText($this->request->getVar('message')),
            'travel_date' => $this->nullableString('travel_date'),
            'adults' => $this->nullableInt('adults'),
            'children' => $this->nullableInt('children'),
            'hotel_id' => $this->nullableInt('hotel_id'),
            'hotel_name' => $this->nullableString('hotel_name'),
            'check_in' => $this->nullableString('check_in'),
            'check_out' => $this->nullableString('check_out'),
            'rooms' => $this->nullableInt('rooms'),
            'currency_type' => $this->nullableString('currency_type'),
            'currency_amount' => $this->nullableString('currency_amount'),
            'pickup_location' => $this->nullableString('pickup_location'),
            'dropoff_location' => $this->nullableString('dropoff_location'),
            'pickup_date' => $this->nullableString('pickup_date'),
            'dropoff_date' => $this->nullableString('dropoff_date'),
            'passengers' => $this->nullableString('passengers'),
            'vehicle_type' => $this->nullableString('vehicle_type'),
            'is_air_con' => $this->nullableString('is_air_con'),

            'page_url' => $this->nullableString('page_url'),
            'referrer_url' => $this->nullableString('referrer_url'),
            'utm_source' => $this->nullableString('utm_source'),
            'utm_medium' => $this->nullableString('utm_medium'),
            'utm_campaign' => $this->nullableString('utm_campaign'),
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => $this->request->getUserAgent()->getAgentString(),
            'source' => 'website',
            'status' => 'new',
        ];

        if (! $this->model->insert($data)) {
            return $this->error('Something went wrong', $this->model->errors(), 500);
        }

        return $this->response
            ->setStatusCode(201)
            ->setJSON([
                'success' => true,
                'message' => 'Enquiry submitted successfully',
            ]);
    }

    private function validationError(array $errors)
    {
        return $this->response
            ->setStatusCode(422)
            ->setJSON([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $errors,
            ]);
    }

    private function captchaFailed()
    {
        return $this->response
            ->setStatusCode(422)
            ->setJSON([
                'success' => false,
                'message' => 'CAPTCHA verification failed',
            ]);
    }

    private function verifyTurnstile(): bool
    {
        if (ENVIRONMENT === 'development') {
            return true;
        }

        $secretKey = env('TURNSTILE_SECRET_KEY');
        $captchaToken = $this->sanitizeString($this->request->getVar('turnstile_token'));

        if (empty($secretKey) || $captchaToken === '') {
            return false;
        }

        try {
            $client = service('curlrequest');
            $response = $client->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'form_params' => [
                    'secret' => $secretKey,
                    'response' => $captchaToken,
                    'remoteip' => $this->request->getIPAddress(),
                ],
                'http_errors' => false,
                'timeout' => 10,
            ]);

            $result = json_decode((string) $response->getBody(), true);

            return is_array($result) && ($result['success'] ?? false) === true;
        } catch (Throwable $exception) {
            return false;
        }
    }

    private function nullableString(string $field): ?string
    {
        $value = $this->sanitizeString($this->request->getVar($field));

        return $value !== '' ? $value : null;
    }

    private function nullableInt(string $field): ?int
    {
        $value = $this->request->getVar($field);

        return $value !== null && $value !== '' ? (int) $value : null;
    }

    private function sanitizeString($value): string
    {
        return trim(strip_tags((string) ($value ?? '')));
    }

    private function sanitizeText($value): string
    {
        return trim(strip_tags((string) ($value ?? '')));
    }
}
