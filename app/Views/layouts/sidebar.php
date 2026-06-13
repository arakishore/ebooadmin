<?php
$segment = service('uri')->getSegment(1);
$segment2 = service('uri')->getSegment(2);
$enquiryStatuses = [
	'new'      => 'New',
	'read'     => 'Read',
	'replied'  => 'Replied',
	'closed'   => 'Closed',
	'archive'  => 'Archive',
];
?>
<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

	<!-- Sidebar content -->
	<div class="sidebar-content">




		<!-- Main navigation -->
		<div class="sidebar-section">
			<ul class="nav nav-sidebar" data-nav-type="accordion">
				<li class="nav-item">
					<a href="<?= base_url('dashboard') ?>" class="nav-link active">
						<i class="ph-house"></i>
						<span>
							Dashboard
						</span>
					</a>
				</li>

				<li class="nav-item nav-item-submenu <?= in_array($segment, [
															'packages',
															'destinations'

														]) ? 'nav-item-open' : '' ?>">

					<a href="#"
						class="nav-link <?= in_array($segment, [
											'packages',
											'destinations'


										]) ? 'active' : '' ?>">
						<span>Packages</span>
					</a>

					<ul class="nav-group-sub collapse <?= in_array($segment, [
															'packages',
															'destinations',


														]) ? 'show' : '' ?>">
						<li class="nav-item">
							<a href="<?= base_url('destinations') ?>"
								class="nav-link <?= $segment == 'destinations' ? 'active' : '' ?>">
								<i class="ph-list"></i>
								Destinations
							</a>
						</li>
						<li class="nav-item <?= $segment == 'destinations' && $segment2 == 'create' ? 'active' : '' ?>">
							<a href="<?= base_url('destinations/create') ?>"
								class="nav-link">
								<i class="ph-plus"></i>
								<span>Add Destination</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= base_url('packages') ?>"
								class="nav-link <?= $segment == 'packages' ? 'active' : '' ?>">
								<i class="ph-list"></i>
								<span>All Packages</span>
							</a>
						</li>

						<li class="nav-item <?= $segment == 'packages' && $segment2 == 'create' ? 'active' : '' ?>">
							<a href="<?= base_url('packages/create') ?>"
								class="nav-link">
								<i class="ph-plus"></i>
								<span>Add Package</span>
							</a>
						</li>

					</ul>
				</li>
				<li class="nav-item nav-item-submenu <?= in_array($segment, [
															'faq-categories',
															'faqs',
															'banners',
															'testimonials',
															'contact-messages',
															'package-enquiries',
															'contact-enquiries',
															'hotel-enquiries',
															'cruise-enquiries',
															'visa-enquiries',
															'car-enquiries',
															'flight-enquiries',
															'forex-enquiries'
														]) ? 'nav-item-open' : '' ?>">

					<a href="#"
						class="nav-link <?= in_array($segment, [
											'package-enquiries',
											'contact-enquiries',
											'contact-messages',
											'hotel-enquiries',
											'cruise-enquiries',
											'visa-enquiries',
											'car-enquiries',
											'flight-enquiries',
											'forex-enquiries'
										]) ? 'active' : '' ?>">


						<span>Enquiries</span>
					</a>

					<ul class="nav-group-sub collapse <?= in_array($segment, [
															'package-enquiries',
															'contact-enquiries',
															'contact-messages',
															'hotel-enquiries',
															'cruise-enquiries',
															'visa-enquiries',
															'car-enquiries',
															'flight-enquiries',
															'forex-enquiries'
														]) ? 'show' : '' ?>">
						<li class="nav-item nav-item-submenu <?= $segment == 'contact-messages' ? 'nav-item-open' : '' ?>">
							<a href="#" class="nav-link <?= $segment == 'contact-messages' ? 'active' : '' ?>">
								<i class="ph-envelope"></i>
								<span>Contact Us</span>
							</a>
							<ul class="nav-group-sub collapse <?= $segment == 'contact-messages' ? 'show' : '' ?>">
								<?php foreach ($enquiryStatuses as $statusValue => $statusLabel): ?>
									<li class="nav-item">
										<a href="<?= base_url('contact-messages/' . $statusValue) ?>"
											class="nav-link <?= $segment == 'contact-messages' && ($segment2 ?: 'new') == $statusValue ? 'active' : '' ?>">
											<?= esc($statusLabel) ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</li>

						<li class="nav-item nav-item-submenu <?= $segment == 'package-enquiries' ? 'nav-item-open' : '' ?>">
							<a href="#" class="nav-link <?= $segment == 'package-enquiries' ? 'active' : '' ?>">
								<i class="ph-chat-circle-text"></i>
								<span>Package Enquiries</span>
							</a>
							<ul class="nav-group-sub collapse <?= $segment == 'package-enquiries' ? 'show' : '' ?>">
								<?php foreach ($enquiryStatuses as $statusValue => $statusLabel): ?>
									<li class="nav-item">
										<a href="<?= base_url('package-enquiries/' . $statusValue) ?>"
											class="nav-link <?= $segment == 'package-enquiries' && ($segment2 ?: 'new') == $statusValue ? 'active' : '' ?>">
											<?= esc($statusLabel) ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</li>
						<li class="nav-item nav-item-submenu <?= $segment == 'hotel-enquiries' ? 'nav-item-open' : '' ?>">
							<a href="#" class="nav-link <?= $segment == 'hotel-enquiries' ? 'active' : '' ?>">
								<i class="ph-buildings"></i>
								<span>Hotel Enquiries</span>
							</a>
							<ul class="nav-group-sub collapse <?= $segment == 'hotel-enquiries' ? 'show' : '' ?>">
								<?php foreach ($enquiryStatuses as $statusValue => $statusLabel): ?>
									<li class="nav-item">
										<a href="<?= base_url('hotel-enquiries/' . $statusValue) ?>"
											class="nav-link <?= $segment == 'hotel-enquiries' && ($segment2 ?: 'new') == $statusValue ? 'active' : '' ?>">
											<?= esc($statusLabel) ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</li>
						<li class="nav-item nav-item-submenu <?= $segment == 'forex-enquiries' ? 'nav-item-open' : '' ?>">
							<a href="#" class="nav-link <?= $segment == 'forex-enquiries' ? 'active' : '' ?>">
								<i class="ph-coins"></i>
								<span>Forex Enquiries</span>
							</a>
							<ul class="nav-group-sub collapse <?= $segment == 'forex-enquiries' ? 'show' : '' ?>">
								<?php foreach ($enquiryStatuses as $statusValue => $statusLabel): ?>
									<li class="nav-item">
										<a href="<?= base_url('forex-enquiries/' . $statusValue) ?>"
											class="nav-link <?= $segment == 'forex-enquiries' && ($segment2 ?: 'new') == $statusValue ? 'active' : '' ?>">
											<?= esc($statusLabel) ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</li>
						<li class="nav-item nav-item-submenu <?= $segment == 'car-enquiries' ? 'nav-item-open' : '' ?>">
							<a href="#" class="nav-link <?= $segment == 'car-enquiries' ? 'active' : '' ?>">
								<i class="ph-car"></i>
								<span>Car Enquiries</span>
							</a>
							<ul class="nav-group-sub collapse <?= $segment == 'car-enquiries' ? 'show' : '' ?>">
								<?php foreach ($enquiryStatuses as $statusValue => $statusLabel): ?>
									<li class="nav-item">
										<a href="<?= base_url('car-enquiries/' . $statusValue) ?>"
											class="nav-link <?= $segment == 'car-enquiries' && ($segment2 ?: 'new') == $statusValue ? 'active' : '' ?>">
											<?= esc($statusLabel) ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</li>
						<li class="nav-item nav-item-submenu <?= $segment == 'cruise-enquiries' ? 'nav-item-open' : '' ?>">
							<a href="#" class="nav-link <?= $segment == 'cruise-enquiries' ? 'active' : '' ?>">
								<i class="ph-boat"></i>
								<span>Cruise Enquiries</span>
							</a>
							<ul class="nav-group-sub collapse <?= $segment == 'cruise-enquiries' ? 'show' : '' ?>">
								<?php foreach ($enquiryStatuses as $statusValue => $statusLabel): ?>
									<li class="nav-item">
										<a href="<?= base_url('cruise-enquiries/' . $statusValue) ?>"
											class="nav-link <?= $segment == 'cruise-enquiries' && ($segment2 ?: 'new') == $statusValue ? 'active' : '' ?>">
											<?= esc($statusLabel) ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</li>
						<li class="nav-item nav-item-submenu <?= $segment == 'visa-enquiries' ? 'nav-item-open' : '' ?>">
							<a href="#" class="nav-link <?= $segment == 'visa-enquiries' ? 'active' : '' ?>">
								<i class="ph-globe-simple"></i>
								<span>Visa Enquiries</span>
							</a>
							<ul class="nav-group-sub collapse <?= $segment == 'visa-enquiries' ? 'show' : '' ?>">
								<?php foreach ($enquiryStatuses as $statusValue => $statusLabel): ?>
									<li class="nav-item">
										<a href="<?= base_url('visa-enquiries/' . $statusValue) ?>"
											class="nav-link <?= $segment == 'visa-enquiries' && ($segment2 ?: 'new') == $statusValue ? 'active' : '' ?>">
											<?= esc($statusLabel) ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</li>
						<li class="nav-item nav-item-submenu <?= $segment == 'flight-enquiries' ? 'nav-item-open' : '' ?>">
							<a href="#" class="nav-link <?= $segment == 'flight-enquiries' ? 'active' : '' ?>">
								<i class="ph-airplane"></i>
								<span>Flight Enquiries</span>
							</a>
							<ul class="nav-group-sub collapse <?= $segment == 'flight-enquiries' ? 'show' : '' ?>">
								<?php foreach ($enquiryStatuses as $statusValue => $statusLabel): ?>
									<li class="nav-item">
										<a href="<?= base_url('flight-enquiries/' . $statusValue) ?>"
											class="nav-link <?= $segment == 'flight-enquiries' && ($segment2 ?: 'new') == $statusValue ? 'active' : '' ?>">
											<?= esc($statusLabel) ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</li>
					</ul>
				</li>
				<li class="nav-item nav-item-submenu <?= in_array($segment, [
															'faq-categories',
															'faqs',
															'banners',
															'testimonials',
															'partners',
															'gallery'

														]) ? 'nav-item-open' : '' ?>">

					<a href="#"
						class="nav-link <?= in_array($segment, [
											'faq-categories',
											'faqs',
											'banners',
											'testimonials',
											'partners',
											'gallery'
										]) ? 'active' : '' ?>">


						<span>CMS</span>
					</a>

					<ul class="nav-group-sub collapse <?= in_array($segment, [
															'faq-categories',
															'faqs',
															'banners',
															'testimonials',
															'partners',
															'gallery'

														]) ? 'show' : '' ?>">

						<li class="nav-item">
							<a href="<?= base_url('testimonials') ?>"
								class="nav-link <?= $segment == 'testimonials' ? 'active' : '' ?>">
								<i class="ph-image"></i>
								<span>Testimonials</span>
							</a>
						</li>

						<li class="nav-item <?= $segment == 'testimonials' && $segment2 == 'create' ? 'active' : '' ?>">
							<a href="<?= base_url('testimonials/create') ?>"
								class="nav-link">
								<i class="ph-plus"></i>
								<span>Add Testimonial</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= base_url('banners') ?>"
								class="nav-link <?= $segment == 'banners' ? 'active' : '' ?>">
								<i class="ph-image"></i>
								<span>Banners</span>
							</a>
						</li>

						<li class="nav-item <?= $segment == 'banners' && $segment2 == 'create' ? 'active' : '' ?>">
							<a href="<?= base_url('banners/create') ?>"
								class="nav-link">
								<i class="ph-plus"></i>
								<span>Add Banner</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= base_url('gallery') ?>"
								class="nav-link <?= $segment == 'gallery' ? 'active' : '' ?>">
								<i class="ph-image"></i>
								<span>Gallery</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= base_url('partners') ?>"
								class="nav-link <?= $segment == 'partners' ? 'active' : '' ?>">
								<i class="ph-handshake"></i>
								<span>Partners</span>
							</a>
						</li>

						<li class="nav-item <?= $segment == 'partners' && $segment2 == 'create' ? 'active' : '' ?>">
							<a href="<?= base_url('partners/create') ?>"
								class="nav-link">
								<i class="ph-plus"></i>
								<span>Add Partner</span>
							</a>
						</li>
						<li class="nav-item ">
							<a href="<?= base_url('faq-categories') ?>"
								class="nav-link <?= $segment == 'faq-categories' ? 'active' : '' ?>">
								<i class="ph-list"></i>
								<span>FAQ Categories</span>
							</a>
						</li>

						<li class="nav-item <?= $segment == 'faq-categories' && $segment2 == 'create' ? 'active' : '' ?>">
							<a href="<?= base_url('faq-categories/create') ?>"
								class="nav-link">
								<i class="ph-plus"></i>
								<span>Add FAQ Category</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= base_url('faqs') ?>"
								class="nav-link <?= $segment == 'faqs' ? 'active' : '' ?>">
								<i class="ph-question"></i>
								<span>FAQs</span>
							</a>
						</li>

						<li class="nav-item <?= $segment == 'faqs' && $segment2 == 'create' ? 'active' : '' ?>">
							<a href="<?= base_url('faqs/create') ?>"
								class="nav-link">
								<i class="ph-plus"></i>
								<span>Add FAQ</span>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item nav-item-submenu <?= in_array($segment, [

															'activity_types',
															'amenity_types',
															'hotel_categories',
															'meal_plan_types',
															'package_categories',
															'package_exclude_types',
															'package_include_types',
															'package_fact_types',
															'transport_types'
														]) ? 'nav-item-open' : '' ?>">

					<a href="#"
						class="nav-link <?= in_array($segment, [
											'activity_types',
											'amenity_types',
											'hotel_categories',
											'meal_plan_types',
											'package_categories',
											'package_exclude_types',
											'package_include_types',
											'package_fact_types',
											'transport_types'
										]) ? 'active' : '' ?>">


						<span>Master</span>
					</a>

					<ul class="nav-group-sub collapse <?= in_array($segment, [
															'activity_types',
															'amenity_types',
															'hotel_categories',
															'meal_plan_types',
															'package_categories',
															'package_exclude_types',
															'package_include_types',
															'package_fact_types',
															'transport_types'
														]) ? 'show' : '' ?>">



						<li class="nav-item">
							<a href="<?= base_url('amenity_types') ?>"
								class="nav-link <?= $segment == 'amenity_types' ? 'active' : '' ?>">
								Amenity Type
							</a>
						</li>

						<li class="nav-item">
							<a href="<?= base_url('hotel_categories') ?>"
								class="nav-link <?= $segment == 'hotel_categories' ? 'active' : '' ?>">
								Hotel Category
							</a>
						</li>

						<li class="nav-item">
							<a href="<?= base_url('meal_plan_types') ?>"
								class="nav-link <?= $segment == 'meal_plan_types' ? 'active' : '' ?>">
								Meal Plan Type
							</a>
						</li>

						<li class="nav-item">
							<a href="<?= base_url('package_categories') ?>"
								class="nav-link <?= $segment == 'package_categories' ? 'active' : '' ?>">
								Package Category
							</a>
						</li>



						<li class="nav-item">
							<a href="<?= base_url('package_exclude_types') ?>"
								class="nav-link <?= $segment == 'package_exclude_types' ? 'active' : '' ?>">
								Package Exclude Type
							</a>
						</li>

						<li class="nav-item">
							<a href="<?= base_url('package_include_types') ?>"
								class="nav-link <?= $segment == 'package_include_types' ? 'active' : '' ?>">
								Package Include Type
							</a>
						</li>

						<li class="nav-item">
							<a href="<?= base_url('package_fact_types') ?>"
								class="nav-link <?= $segment == 'package_fact_types' ? 'active' : '' ?>">
								Package Fact Type
							</a>
						</li>

						<li class="nav-item">
							<a href="<?= base_url('transport_types') ?>"
								class="nav-link <?= $segment == 'transport_types' ? 'active' : '' ?>">
								Transport Type
							</a>
						</li>

					</ul>
				</li>
		</div>
		<!-- /main navigation -->

	</div>
	<!-- /sidebar content -->

</div>
<!-- /main sidebar -->