<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Admin</title>

	<!-- Global stylesheets -->
	<link href="<?= base_url('resources/assets/fonts/inter/inter.css') ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url('resources/assets/icons/phosphor/styles.min.css') ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url('resources/full/assets/css/ltr/all.min.css') ?>" id="stylesheet" rel="stylesheet" type="text/css">
	<link href="<?= base_url('resources/assets/icons/icomoon/styles.min.css') ?>" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<?= $this->renderSection('pageStyles') ?>
	<style>
		.sidebar {
			width: 13.875rem !important;
		}

		.sidebar .nav-sidebar {
			--nav-link-padding-x: 0.75rem;
		}

		.sidebar .nav-group-sub .nav-link {
			padding-left: 1.0rem;
		}

		.sidebar .nav-group-sub .nav-group-sub .nav-link {
			padding-left: 2.25rem;
		}

		.sidebar .nav-item-submenu>.nav-link {
			padding-right: 2rem;
		}

		.sidebar .nav-item-submenu>.nav-link:after {
			right: 0.75rem;
		}

		.datatable-basic th,
		.datatable-basic td,
		.datatable-enquiries th,
		.datatable-enquiries td {
			vertical-align: middle;
		}

		.datatable-basic th:last-child,
		.datatable-basic td:last-child,
		.datatable-basic td:has(.badge),
		.datatable-enquiries th:last-child,
		.datatable-enquiries td:last-child,
		.datatable-enquiries td:has(.badge) {
			white-space: nowrap;
			width: 1%;
		}

		.datatable-basic .table-status-nowrap,
		.datatable-basic .table-actions-nowrap,
		.datatable-basic .table-date-nowrap,
		.datatable-enquiries .table-status-nowrap,
		.datatable-enquiries .table-actions-nowrap,
		.datatable-enquiries .table-date-nowrap {
			white-space: nowrap;
		}

		.datatable-basic .table-status-nowrap,
		.datatable-enquiries .table-status-nowrap {
			width: 1%;
		}

		.datatable-basic .table-date-nowrap,
		.datatable-enquiries .table-date-nowrap {
			min-width: 10rem;
		}

		.datatable-basic .table-actions-nowrap,
		.datatable-enquiries .table-actions-nowrap {
			width: 1%;
			min-width: 6rem;
		}
	</style>
</head>
