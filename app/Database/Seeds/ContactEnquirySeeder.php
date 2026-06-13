<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ContactEnquirySeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $packages = $this->db->table('t_packages')
            ->select('id')
            ->where('status', 1)
            ->where('deleted_at', null)
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();

        $packageIds = array_column($packages, 'id');
        $packageIndex = 0;

        $rows = [
            ['contact', 'Ananya Sharma', 'ananya.sharma@example.com', '+91 98765 43210', 'Need help planning a family trip', 'We are planning a seven day holiday in June and would like suggestions for a family friendly destination.', null, null, null, 'new', null, null],
            ['contact', 'Rahul Verma', 'rahul.verma@example.com', '+91 99887 76655', 'Custom itinerary request', 'Can your team help create a relaxed itinerary with beach stays and local sightseeing?', null, null, null, 'read', 'Customer prefers a coastal destination.', null],
            ['package', 'Meera Nair', 'meera.nair@example.com', '+91 91234 56780', 'Kerala package enquiry', 'Please share hotel options and inclusions for this package. We prefer a houseboat stay.', '2026-07-15', 2, 1, 'new', null, null],
            ['package', 'Arjun Kapoor', 'arjun.kapoor@example.com', '+91 90000 11223', 'Honeymoon package details', 'We are interested in a premium honeymoon package with private transfers and candlelight dinner.', '2026-08-03', 2, 0, 'replied', 'Premium hotel preference.', 'Thank you for your enquiry. We will share premium honeymoon options with inclusions and pricing shortly.'],
            ['contact', 'Pooja Iyer', 'pooja.iyer@example.com', '+91 90909 80808', 'Visa support question', 'Do your international packages include visa guidance and document checklist support?', null, null, null, 'closed', 'Answered over phone.', 'Yes, our team provides visa guidance and documentation support for eligible packages.'],
            ['package', 'Nikhil Bansal', 'nikhil.bansal@example.com', '+91 98700 11122', 'Group tour pricing', 'We are six adults planning a holiday. Please send group pricing and available departures.', '2026-09-12', 6, 0, 'read', 'Group pricing needed.', null],
            ['contact', 'Sara Fernandes', 'sara.fernandes@example.com', '+91 98222 33445', 'Corporate travel enquiry', 'We need a short offsite for our team with stay, meals, and local activities included.', null, null, null, 'new', null, null],
            ['package', 'Vikram Singh', 'vikram.singh@example.com', '+91 97111 22233', 'Adventure package availability', 'Is this package suitable for first time adventure travellers? Please confirm the difficulty level.', '2026-10-05', 3, 0, 'replied', 'Asked about activity difficulty.', 'This package is suitable for beginners with guided support. We can also suggest a softer itinerary if needed.'],
            ['contact', 'Divya Shah', 'divya.shah@example.com', '+91 95555 12121', 'Payment options', 'Do you accept partial payment for booking confirmation?', null, null, null, 'read', 'Payment terms requested.', null],
            ['package', 'Amit Desai', 'amit.desai@example.com', '+91 94444 34343', 'Package customization', 'Can we add one extra night and airport pickup to this itinerary?', '2026-11-18', 2, 2, 'new', null, null],
            ['contact', 'Kavya Menon', 'kavya.menon@example.com', '+91 93333 45454', 'Best season to travel', 'Please suggest the best travel months for a hill station holiday with kids.', null, null, null, 'replied', 'Suggested summer and early winter.', 'For a hill station holiday with kids, April to June and October to December are usually comfortable.'],
            ['package', 'Rohan Mehta', 'rohan.mehta@example.com', '+91 92222 56565', 'Flight inclusion query', 'Does this package include flights or only land arrangements?', '2026-12-20', 2, 0, 'read', 'Flight query.', null],
            ['contact', 'Ishita Rao', 'ishita.rao@example.com', '+91 91111 67676', 'Senior citizen friendly tour', 'Looking for a slow paced tour for my parents with minimal walking and good hotels.', null, null, null, 'new', null, null],
            ['package', 'Sameer Kulkarni', 'sameer.kulkarni@example.com', '+91 90001 78787', 'Family package with children', 'Please confirm if child meals and sightseeing tickets are included in this package.', '2026-06-28', 2, 2, 'closed', 'Closed after sending quote.', 'We shared the detailed inclusions and child policy over email.'],
            ['contact', 'Neha Chawla', 'neha.chawla@example.com', '+91 98989 89898', 'Refund policy', 'Please share your cancellation and refund policy for domestic trips.', null, null, null, 'read', 'Policy link to be shared.', null],
            ['package', 'Harsh Patel', 'harsh.patel@example.com', '+91 97654 32109', 'Luxury hotel upgrade', 'Can we upgrade to a five star hotel and private sightseeing vehicle?', '2026-07-22', 4, 0, 'replied', 'Luxury upgrade requested.', 'Yes, we can customize the package with five star hotels and a private vehicle.'],
            ['contact', 'Tanya Dsouza', 'tanya.dsouza@example.com', '+91 96543 21098', 'Weekend getaway', 'Please suggest a weekend getaway from Mumbai for two adults.', null, null, null, 'new', null, null],
            ['package', 'Manish Gupta', 'manish.gupta@example.com', '+91 95432 10987', 'Departure date flexibility', 'Can the package start on a weekday instead of the listed departure date?', '2026-08-30', 2, 1, 'read', 'Flexible date request.', null],
            ['contact', 'Ayesha Khan', 'ayesha.khan@example.com', '+91 94321 09876', 'International honeymoon options', 'We are comparing Bali and Maldives for honeymoon. Please suggest budget ranges.', null, null, null, 'replied', 'Budget comparison requested.', 'We will share Bali and Maldives honeymoon options across standard, premium, and luxury budgets.'],
            ['package', 'Devansh Jain', 'devansh.jain@example.com', '+91 93210 98765', 'Early check-in request', 'Our flight arrives early morning. Can early check-in be arranged with this package?', '2026-09-09', 2, 0, 'new', null, null],
        ];

        $data = [];
        $archivedOffsets = [4, 13, 18];

        foreach ($rows as $offset => $row) {
            [$type, $name, $email, $phone, $subject, $message, $travelDate, $adults, $children, $status, $adminNote, $replyMessage] = $row;
            $packageId = null;

            if ($type === 'package' && ! empty($packageIds)) {
                $packageId = $packageIds[$packageIndex % count($packageIds)];
                $packageIndex++;
            }

            $createdAt = date('Y-m-d H:i:s', strtotime("-{$offset} hours"));
            $isArchived = in_array($offset, $archivedOffsets, true);

            $data[] = [
                'enquiry_type'  => $type,
                'package_id'    => $packageId,
                'name'          => $name,
                'email'         => $email,
                'phone'         => $phone,
                'subject'       => $subject,
                'message'       => $message,
                'travel_date'   => $travelDate,
                'adults'        => $adults,
                'children'      => $children,
                'status'        => $status,
                'viewed_at'     => in_array($status, ['read', 'replied', 'closed'], true) ? $now : null,
                'viewed_by'     => in_array($status, ['read', 'replied', 'closed'], true) ? 1 : null,
                'replied_at'    => in_array($status, ['replied', 'closed'], true) ? $now : null,
                'replied_by'    => in_array($status, ['replied', 'closed'], true) ? 1 : null,
                'reply_message' => $replyMessage,
                'admin_note'    => $adminNote,
                'is_archived'   => $isArchived ? 1 : 0,
                'archived_at'   => $isArchived ? $now : null,
                'archived_by'   => $isArchived ? 1 : null,
                'created_at'    => $createdAt,
                'updated_at'    => $now,
                
            ];
        }

        $this->db->table('contact_enquiries')->insertBatch($data);
    }
}
