<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->post('login-submit', 'Auth::loginSubmit');
$routes->get('logout', 'Auth::logout');

$routes->options('api', 'Api\BaseApiController::options');
$routes->options('api/(:any)', 'Api\BaseApiController::options');
$routes->group('api', ['namespace' => 'App\Controllers\Api'], static function ($routes) {
    $routes->get('banners', 'Banners::index');
    $routes->get('countries', 'Countries::index');
    $routes->get('countries/(:num)/states', 'States::byCountry/$1');
    $routes->get('countries/(:num)/cities', 'Cities::byCountry/$1');
    $routes->get('countries/(:segment)', 'Countries::show/$1');
    $routes->get('states', 'States::index');
    $routes->get('states/(:num)/cities', 'Cities::byState/$1');
    $routes->get('states/(:num)', 'States::show/$1');
    $routes->get('cities', 'Cities::index');
    $routes->get('cities/(:num)', 'Cities::show/$1');
    $routes->get('destinations', 'Destinations::index');
    $routes->get('destinations/(:segment)', 'Destinations::show/$1');
    $routes->get('hotels/search', 'Hotels::search');
    $routes->get('packages', 'Packages::index');
    $routes->get('packages/(:segment)', 'Packages::show/$1');
    $routes->get('testimonials', 'Testimonials::index');
    $routes->get('partners', 'Partners::index');
    $routes->get('faqs', 'Faqs::index');
    $routes->get('gallery', 'Gallery::index');
    $routes->post('contact-enquiries', 'ContactEnquiries::create');
    $routes->get('servicemenu', 'ServicesMenu::index');
});

$routes->group('', ['filter' => 'adminAuth'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');

    // Destinations CRUD
    $routes->get('destinations', 'Destinations::index');
    $routes->get('destinations/create', 'Destinations::create');
    $routes->post('destinations/store', 'Destinations::store');
    $routes->get('destinations/edit/(:num)', 'Destinations::edit/$1');
    $routes->post('destinations/update/(:num)', 'Destinations::update/$1');
    $routes->get('destinations/delete/(:num)', 'Destinations::delete/$1');
    $routes->post('destinations/images/upload/(:num)', 'Destinations::uploadImage/$1', ['filter' => 'adminAuth']);
    $routes->post('destinations/images/delete/(:num)', 'Destinations::deleteImage/$1', ['filter' => 'adminAuth']);

    // Gallery Management
    $routes->get('gallery', 'Gallery::index');
    $routes->post('gallery/images/upload', 'Gallery::uploadImage');
    $routes->post('gallery/images/delete/(:num)', 'Gallery::deleteImage/$1');

    // Activity Types CRUD
    $routes->get('activity_types', 'ActivityTypes::index');
    $routes->get('activity_types/create', 'ActivityTypes::create');
    $routes->post('activity_types/store', 'ActivityTypes::store');
    $routes->get('activity_types/edit/(:num)', 'ActivityTypes::edit/$1');
    $routes->post('activity_types/update/(:num)', 'ActivityTypes::update/$1');
    $routes->get('activity_types/delete/(:num)', 'ActivityTypes::delete/$1');

    // Amenity Types CRUD
    $routes->get('amenity_types', 'AmenityTypes::index');
    $routes->get('amenity_types/create', 'AmenityTypes::create');
    $routes->post('amenity_types/store', 'AmenityTypes::store');
    $routes->get('amenity_types/edit/(:num)', 'AmenityTypes::edit/$1');
    $routes->post('amenity_types/update/(:num)', 'AmenityTypes::update/$1');
    $routes->get('amenity_types/delete/(:num)', 'AmenityTypes::delete/$1');

    // Hotel Categories CRUD
    $routes->get('hotel_categories', 'HotelCategories::index');
    $routes->get('hotel_categories/create', 'HotelCategories::create');
    $routes->post('hotel_categories/store', 'HotelCategories::store');
    $routes->get('hotel_categories/edit/(:num)', 'HotelCategories::edit/$1');
    $routes->post('hotel_categories/update/(:num)', 'HotelCategories::update/$1');
    $routes->get('hotel_categories/delete/(:num)', 'HotelCategories::delete/$1');

    // Meal Plan Types CRUD
    $routes->get('meal_plan_types', 'MealPlanTypes::index');
    $routes->get('meal_plan_types/create', 'MealPlanTypes::create');
    $routes->post('meal_plan_types/store', 'MealPlanTypes::store');
    $routes->get('meal_plan_types/edit/(:num)', 'MealPlanTypes::edit/$1');
    $routes->post('meal_plan_types/update/(:num)', 'MealPlanTypes::update/$1');
    $routes->get('meal_plan_types/delete/(:num)', 'MealPlanTypes::delete/$1');

    // Package Categories CRUD
    $routes->get('package_categories', 'PackageCategories::index');
    $routes->get('package_categories/create', 'PackageCategories::create');
    $routes->post('package_categories/store', 'PackageCategories::store');
    $routes->get('package_categories/edit/(:num)', 'PackageCategories::edit/$1');
    $routes->post('package_categories/update/(:num)', 'PackageCategories::update/$1');
    $routes->get('package_categories/delete/(:num)', 'PackageCategories::delete/$1');

    // Packages CRUD
    $routes->get('packages', 'Packages::index');
    $routes->get('packages/create', 'Packages::create');
    $routes->post('packages/store', 'Packages::store');
    $routes->get('packages/edit/(:num)', 'Packages::edit/$1');
    $routes->post('packages/update/(:num)', 'Packages::update/$1');
    $routes->get('packages/delete/(:num)', 'Packages::delete/$1');
    $routes->post('packages/facts/store/(:num)', 'Packages::storeFact/$1');
    $routes->get('packages/facts/delete/(:num)', 'Packages::deleteFact/$1');
    $routes->post('packages/itinerary/store/(:num)', 'Packages::storeItinerary/$1');
    $routes->get('packages/itinerary/delete/(:num)', 'Packages::deleteItinerary/$1');
    $routes->post('packages/inclusions/store/(:num)', 'Packages::storeInclusions/$1');
    $routes->post('packages/images/upload/(:num)', 'Packages::uploadImage/$1');
    $routes->post('packages/images/delete/(:num)', 'Packages::deleteImage/$1');
    $routes->post('packages/exclusions/store/(:num)', 'Packages::storeExclusions/$1');

    // Package Exclude Types CRUD
    $routes->get('package_exclude_types', 'PackageExcludeTypes::index');
    $routes->get('package_exclude_types/create', 'PackageExcludeTypes::create');
    $routes->post('package_exclude_types/store', 'PackageExcludeTypes::store');
    $routes->get('package_exclude_types/edit/(:num)', 'PackageExcludeTypes::edit/$1');
    $routes->post('package_exclude_types/update/(:num)', 'PackageExcludeTypes::update/$1');
    $routes->get('package_exclude_types/delete/(:num)', 'PackageExcludeTypes::delete/$1');

    // Package Include Types CRUD
    $routes->get('package_include_types', 'PackageIncludeTypes::index');
    $routes->get('package_include_types/create', 'PackageIncludeTypes::create');
    $routes->post('package_include_types/store', 'PackageIncludeTypes::store');
    $routes->get('package_include_types/edit/(:num)', 'PackageIncludeTypes::edit/$1');
    $routes->post('package_include_types/update/(:num)', 'PackageIncludeTypes::update/$1');
    $routes->get('package_include_types/delete/(:num)', 'PackageIncludeTypes::delete/$1');

    // Package Fact Types CRUD
    $routes->get('package_fact_types', 'PackageFactTypes::index');
    $routes->get('package_fact_types/create', 'PackageFactTypes::create');
    $routes->post('package_fact_types/store', 'PackageFactTypes::store');
    $routes->get('package_fact_types/edit/(:num)', 'PackageFactTypes::edit/$1');
    $routes->post('package_fact_types/update/(:num)', 'PackageFactTypes::update/$1');
    $routes->get('package_fact_types/delete/(:num)', 'PackageFactTypes::delete/$1');

    // Transport Types CRUD
    $routes->get('transport_types', 'TransportTypes::index');
    $routes->get('transport_types/create', 'TransportTypes::create');
    $routes->post('transport_types/store', 'TransportTypes::store');
    $routes->get('transport_types/edit/(:num)', 'TransportTypes::edit/$1');
    $routes->post('transport_types/update/(:num)', 'TransportTypes::update/$1');
    $routes->get('transport_types/delete/(:num)', 'TransportTypes::delete/$1');

    // Banners CRUD
    $routes->get('banners', 'Banners::index');
    $routes->get('banners/create', 'Banners::create');
    $routes->post('banners/store', 'Banners::store');
    $routes->get('banners/edit/(:num)', 'Banners::edit/$1');
    $routes->post('banners/update/(:num)', 'Banners::update/$1');
    $routes->get('banners/delete/(:num)', 'Banners::delete/$1');

    // Testimonials CRUD
    $routes->get('testimonials', 'Testimonials::index');
    $routes->get('testimonials/create', 'Testimonials::create');
    $routes->post('testimonials/store', 'Testimonials::store');
    $routes->get('testimonials/edit/(:num)', 'Testimonials::edit/$1');
    $routes->post('testimonials/update/(:num)', 'Testimonials::update/$1');
    $routes->get('testimonials/delete/(:num)', 'Testimonials::delete/$1');

    // Partners CRUD
    $routes->get('partners', 'Partners::index');
    $routes->get('partners/create', 'Partners::create');
    $routes->post('partners/store', 'Partners::store');
    $routes->get('partners/edit/(:num)', 'Partners::edit/$1');
    $routes->post('partners/update/(:num)', 'Partners::update/$1');
    $routes->get('partners/delete/(:num)', 'Partners::delete/$1');

    // Contact Enquiries
    $routes->get('contact-messages', 'ContactEnquiries::contactMessages');
    $routes->get('contact-messages/new', 'ContactEnquiries::contactMessages/new');
    $routes->get('contact-messages/read', 'ContactEnquiries::contactMessages/read');
    $routes->get('contact-messages/replied', 'ContactEnquiries::contactMessages/replied');
    $routes->get('contact-messages/closed', 'ContactEnquiries::contactMessages/closed');
    $routes->get('contact-messages/archive', 'ContactEnquiries::contactMessages/archive');
    $routes->get('package-enquiries', 'ContactEnquiries::packageEnquiries');
    $routes->get('package-enquiries/new', 'ContactEnquiries::packageEnquiries/new');
    $routes->get('package-enquiries/read', 'ContactEnquiries::packageEnquiries/read');
    $routes->get('package-enquiries/replied', 'ContactEnquiries::packageEnquiries/replied');
    $routes->get('package-enquiries/closed', 'ContactEnquiries::packageEnquiries/closed');
    $routes->get('package-enquiries/archive', 'ContactEnquiries::packageEnquiries/archive');
    $routes->get('contact-enquiries/data/(:segment)/(:segment)', 'ContactEnquiries::data/$1/$2');
    $routes->get('contact-enquiries/view/(:num)', 'ContactEnquiries::view/$1');
    $routes->post('contact-enquiries/update/(:num)', 'ContactEnquiries::update/$1');
    $routes->post('contact-enquiries/bulk-archive', 'ContactEnquiries::bulkArchive');
    $routes->get('contact-enquiries/restore/(:num)', 'ContactEnquiries::restore/$1');
    $routes->get('contact-enquiries/delete/(:num)', 'ContactEnquiries::delete/$1');
    //hotel enquiries
    $routes->get('hotel-enquiries', 'ContactEnquiries::hotelEnquiries');
    $routes->get('hotel-enquiries/new', 'ContactEnquiries::hotelEnquiries/new');
    $routes->get('hotel-enquiries/read', 'ContactEnquiries::hotelEnquiries/read');
    $routes->get('hotel-enquiries/replied', 'ContactEnquiries::hotelEnquiries/replied');
    $routes->get('hotel-enquiries/closed', 'ContactEnquiries::hotelEnquiries/closed');
    $routes->get('hotel-enquiries/archive', 'ContactEnquiries::hotelEnquiries/archive');
    // $routes->get('hotel-enquiries/view/(:num)', 'ContactEnquiries::view/$1');
    // $routes->post('hotel-enquiries/update/(:num)', 'ContactEnquiries::update/$1');
    // $routes->post('hotel-enquiries/bulk-archive', 'ContactEnquiries::bulkArchive');
    // $routes->get('hotel-enquiries/restore/(:num)', 'ContactEnquiries::restore/$1');
    // $routes->get('hotel-enquiries/delete/(:num)', 'ContactEnquiries::delete/$1');
    //forex enquiries
    $routes->get('forex-enquiries', 'ContactEnquiries::forexEnquiries');
    $routes->get('forex-enquiries/new', 'ContactEnquiries::forexEnquiries/new');
    $routes->get('forex-enquiries/read', 'ContactEnquiries::forexEnquiries/read');
    $routes->get('forex-enquiries/replied', 'ContactEnquiries::forexEnquiries/replied');
    $routes->get('forex-enquiries/closed', 'ContactEnquiries::forexEnquiries/closed');
    $routes->get('forex-enquiries/archive', 'ContactEnquiries::forexEnquiries/archive');

    //car enquiries
    $routes->get('car-enquiries', 'ContactEnquiries::carEnquiries');
    $routes->get('car-enquiries/new', 'ContactEnquiries::carEnquiries/new');
    $routes->get('car-enquiries/read', 'ContactEnquiries::carEnquiries/read');
    $routes->get('car-enquiries/replied', 'ContactEnquiries::carEnquiries/replied');
    $routes->get('car-enquiries/closed', 'ContactEnquiries::carEnquiries/closed');
    $routes->get('car-enquiries/archive',  'ContactEnquiries::carEnquiries/archive');
    //cruise enquiries
    $routes->get('cruise-enquiries', 'ContactEnquiries::cruiseEnquiries');
    $routes->get('cruise-enquiries/new', 'ContactEnquiries::cruiseEnquiries/new');
    $routes->get('cruise-enquiries/read', 'ContactEnquiries::cruiseEnquiries/read');
    $routes->get('cruise-enquiries/replied', 'ContactEnquiries::cruiseEnquiries/replied');
    $routes->get('cruise-enquiries/closed', 'ContactEnquiries::cruiseEnquiries/closed');
    $routes->get('cruise-enquiries/archive', 'ContactEnquiries::cruiseEnquiries/archive');
    //visa enquiries
    $routes->get('visa-enquiries', 'ContactEnquiries::visaEnquiries');
    $routes->get('visa-enquiries/new', 'ContactEnquiries::visaEnquiries/new');
    $routes->get('visa-enquiries/read', 'ContactEnquiries::visaEnquiries/read');
    $routes->get('visa-enquiries/replied', 'ContactEnquiries::visaEnquiries/replied');
    $routes->get('visa-enquiries/closed', 'ContactEnquiries::visaEnquiries/closed');
    $routes->get('visa-enquiries/archive', 'ContactEnquiries::visaEnquiries/archive');
    //flight enquiries
    $routes->get('flight-enquiries', 'ContactEnquiries::flightEnquiries');
    $routes->get('flight-enquiries/new', 'ContactEnquiries::flightEnquiries/new');
    $routes->get('flight-enquiries/read', 'ContactEnquiries::flightEnquiries/read');
    $routes->get('flight-enquiries/replied', 'ContactEnquiries::flightEnquiries/replied');
    $routes->get('flight-enquiries/closed', 'ContactEnquiries::flightEnquiries/closed');
    $routes->get('flight-enquiries/archive', 'ContactEnquiries::flightEnquiries/archive');
    
    // FAQ Categories CRUD
    $routes->get('faq-categories', 'FaqCategories::index');
    $routes->get('faq-categories/create', 'FaqCategories::create');
    $routes->post('faq-categories/store', 'FaqCategories::store');
    $routes->get('faq-categories/edit/(:num)', 'FaqCategories::edit/$1');
    $routes->post('faq-categories/update/(:num)', 'FaqCategories::update/$1');
    $routes->get('faq-categories/delete/(:num)', 'FaqCategories::delete/$1');

    // FAQs CRUD
    $routes->get('faqs', 'Faqs::index');
    $routes->get('faqs/create', 'Faqs::create');
    $routes->post('faqs/store', 'Faqs::store');
    $routes->get('faqs/edit/(:num)', 'Faqs::edit/$1');
    $routes->post('faqs/update/(:num)', 'Faqs::update/$1');
    $routes->get('faqs/delete/(:num)', 'Faqs::delete/$1');
});
