	<?php
	use App\Models\ContactEnquiryModel;

	$contactEnquiryModel = new ContactEnquiryModel();

	$newEnquiriesCount = $contactEnquiryModel
		->where('contact_enquiries.status', 'new')
		->groupStart()
			->where('contact_enquiries.is_archived', 0)
			->orWhere('contact_enquiries.is_archived IS NULL', null, false)
		->groupEnd()
		->countAllResults();

	$newEnquiries = $contactEnquiryModel
		->select('contact_enquiries.*, t_packages.title AS package_title')
		->join('t_packages', 't_packages.id = contact_enquiries.package_id', 'left')
		->where('contact_enquiries.status', 'new')
		->groupStart()
			->where('contact_enquiries.is_archived', 0)
			->orWhere('contact_enquiries.is_archived IS NULL', null, false)
		->groupEnd()
		->orderBy('contact_enquiries.created_at', 'DESC')
		->findAll(15);

	$enquiryTypeLabels = [
		'contact' => 'Contact',
		'package' => 'Package',
		'hotel' => 'Hotel',
		'forex' => 'Forex',
		'car' => 'Car',
		'cruise' => 'Cruise',
		'visa' => 'Visa',
		'flight' => 'Flight',
	];
	?>
	<!-- Main navbar -->
	<div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-white border-opacity-10">
		<div class="container-fluid">
			<div class="d-flex d-lg-none me-2">
				<button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
					<i class="ph-list"></i>
				</button>
			</div>

			<div class="navbar-brand flex-1 flex-lg-0">


				<img src="<?= base_url('resources/assets/images/eboo-logo2.png') ?>" class="d-none d-sm-inline-block ms-3" alt="">

			</div>
			<ul class="nav flex-row">
				<li class="nav-item d-lg-d">
					<div>
							<button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
								<i class="ph-arrows-left-right"></i>
							</button>

							<button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
								<i class="ph-x"></i>
							</button>
						</div>
				</li>

				<li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
					<a href="#" class="navbar-nav-link navbar-nav-link-icon rounded-pill" data-bs-toggle="dropdown" data-bs-auto-close="outside">
						<i class="ph-chats"></i>
						<?php if ($newEnquiriesCount > 0): ?>
							<span class="badge bg-yellow text-black position-absolute top-0 end-0 translate-middle-top zindex-1 rounded-pill mt-1 me-1"><?= esc((string) $newEnquiriesCount) ?></span>
						<?php endif; ?>
					</a>
					<div class="dropdown-menu wmin-lg-400 p-0">
						<div class="d-flex align-items-center justify-content-between p-3">
							<h6 class="mb-0">Messages</h6>
							<span class="badge bg-primary rounded-pill"><?= esc((string) $newEnquiriesCount) ?> New</span>
						</div>
						<div class="dropdown-menu-scrollable pb-2">
							<?php if (empty($newEnquiries)): ?>
								<div class="dropdown-item text-muted py-2">No new messages</div>
							<?php else: ?>
								<?php foreach ($newEnquiries as $enquiry): ?>
									<?php
									$enquiryType = $enquiry['enquiry_type'] ?? 'contact';
									$enquiryLabel = $enquiryTypeLabels[$enquiryType] ?? ucfirst((string) $enquiryType);
									$enquirySubject = $enquiry['subject'] ?? $enquiry['package_title'] ?? $enquiry['hotel_name'] ?? 'New enquiry';
									$createdAt = ! empty($enquiry['created_at']) ? date('d-m-Y', strtotime((string) $enquiry['created_at'])) : '-';
									?>
									<a href="<?= base_url('contact-enquiries/view/' . $enquiry['id']) ?>" class="dropdown-item align-items-start text-wrap py-2">
										<div class="status-indicator-container me-3">
											<?= esc($enquiryLabel) ?>
										</div>
										<div class="flex-1">
											<span class="fw-semibold"><?= esc($enquiry['name'] ?? 'Unknown') ?></span>
											<span class="text-muted float-end fs-sm"><?= esc($createdAt) ?></span>
											<div class="text-muted"><?= esc($enquirySubject) ?></div>
										</div>
									</a>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>
					</div>
				</li>
			</ul>


			<!-- Sidebar header -->
			<div class="navbar-collapse flex-lg-1 order-2 order-lg-1 collapse">
				 
			</div>
			<!-- /sidebar header -->

			<ul class="nav flex-row justify-content-end order-1 order-lg-2">

				<li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
					<a href="#" class="navbar-nav-link align-items-center rounded-pill p-1" data-bs-toggle="dropdown">
						<div class="status-indicator-container">
							<img src="<?= base_url('resources/assets/images/placeholder.jpg') ?>" class="w-32px h-32px rounded-pill" alt="">
							<span class="status-indicator bg-success"></span>
						</div>
						<span class="d-none d-lg-inline-block mx-lg-2"><?= esc(session()->get('admin_name')) ?></span>
					</a>

					<div class="dropdown-menu dropdown-menu-end">

						<a href="<?= base_url('logout'); ?>" class="dropdown-item">
							<i class="ph-sign-out me-2"></i>
							Logout
						</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->
