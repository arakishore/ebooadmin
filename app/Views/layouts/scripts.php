	<!-- Core JS files -->
	<script src="<?= base_url('resources/assets/demo/demo_configurator.js') ?>"></script>
	<script src="<?= base_url('resources/assets/js/bootstrap/bootstrap.bundle.min.js') ?>"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="<?= base_url('resources/assets/js/vendor/visualization/d3/d3.min.js') ?>"></script>
	<script src="<?= base_url('resources/assets/js/vendor/visualization/d3/d3_tooltip.js') ?>"></script>
	<script src="<?= base_url('resources/assets/js/jquery/jquery.min.js') ?>"></script>
	<script src="<?= base_url('resources/assets/js/vendor/tables/datatables/datatables.min.js') ?>"></script>

	<script src="<?= base_url('resources/assets/js/vendor/notifications/bootbox.min.js') ?>"></script>
	<script src="<?= base_url('resources/assets/js/vendor/forms/selects/select2.min.js') ?>"></script>
	<script src="<?= base_url('resources/assets/js/vendor/uploaders/dropzone.min.js') ?>"></script>
	<script src="<?= base_url('resources/full/assets/js/app.js') ?>"></script>

	<script src="<?= base_url('resources/assets/demo/pages/datatables_basic.js') ?>"></script>

	<!-- <script src="<?= base_url('resources/assets/demo/pages/datatables_basic.js') ?>"></script> -->
	<!-- <script src="<?= base_url('resources/assets/demo/pages/dashboard.js') ?>"></script> -->
	<!-- <script src="<?= base_url('resources/assets/demo/charts/pages/dashboard/streamgraph.js') ?>"></script>
	<script src="<?= base_url('resources/assets/demo/charts/pages/dashboard/sparklines.js') ?>"></script>
	<script src="<?= base_url('resources/assets/demo/charts/pages/dashboard/lines.js') ?>"></script>	
	<script src="<?= base_url('resources/assets/demo/charts/pages/dashboard/areas.js') ?>"></script>
	<script src="<?= base_url('resources/assets/demo/charts/pages/dashboard/donuts.js') ?>"></script>
	<script src="<?= base_url('resources/assets/demo/charts/pages/dashboard/bars.js') ?>"></script>
	<script src="<?= base_url('resources/assets/demo/charts/pages/dashboard/progress.js') ?>"></script>
	<script src="<?= base_url('resources/assets/demo/charts/pages/dashboard/heatmaps.js') ?>"></script>
	<script src="<?= base_url('resources/assets/demo/charts/pages/dashboard/pies.js') ?>"></script>
	<script src="<?= base_url('resources/assets/demo/charts/pages/dashboard/bullets.js') ?>"></script> -->
	<!-- /theme JS files -->

	<?= $this->renderSection('pageScripts') ?>
	<script>
		// Bootbox extension
		const _componentModalBootbox = function() {
			if (typeof bootbox == 'undefined') {
				console.warn('Warning - bootbox.min.js is not loaded.');
				return;
			}


			document.addEventListener('DOMContentLoaded', function() {

				const deleteButtons = document.querySelectorAll('.bootbox_custom');

				deleteButtons.forEach(button => {

					button.addEventListener('click', function(e) {

						e.preventDefault();

						const url = this.getAttribute('href');

						bootbox.confirm({
							title: 'Delete Record',
							message: 'Are you sure you want to delete this record?',
							buttons: {
								confirm: {
									label: 'Yes, Delete',
									className: 'btn-danger'
								},
								cancel: {
									label: 'Cancel',
									className: 'btn-link'
								}
							},
							callback: function(result) {

								if (result) {
									window.location.href = url;
								}

							}
						});

					});

				});

			});
		};
		// Initialize module
		_componentModalBootbox();
	</script>
	<script>
		$('.select').select2();
		// Basic example
		$('.form-control-select2').select2();
	</script>

	</body>

	</html>