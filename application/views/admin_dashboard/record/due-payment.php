<?php require_once(APPPATH . 'views/admin_dashboard/inc/header.php'); ?>
<?php require_once(APPPATH . 'views/admin_dashboard/inc/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Due Amount</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Due Payment</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<!-- left column -->
				<div class="col-md-12">
					<!-- general form elements -->
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Due Payment</h3>
						</div>
						<!-- /.card-header -->
						<!-- due amount eerors -->
						<?php if ($this->session->flashdata('pay_amount')):?>
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<?php echo $this->session->flashdata('pay_amount'); ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<?php endif; ?>
						<!-- search form -->
						<div class="card-body">
							<?php if (!isset($vendor_id)) : ?>
								<form id="search_due_form" action="#" method="post">
									<div class="form-group">
										<label>Vendor ID</label>
										<div class="row">
											<div class="col-md-6">
												<input type="search" class="form-control" id="vendor_id" value='<?= $vendor_id ?? '' ?>' name="vendor_id" placeholder="Enter Vendor ID">
											</div>
											<div class="col-md-4">
												<input type="submit" class="btn btn-primary" value="Search">
											</div>
										</div>
									</div>
								</form>
							<?php endif; ?>
						</div>

						<form action="<?= BASE_URL ?>records/save_payment" method="post" id="vendor_payment_form">
							<div id="amount_details"></div>
						</form>

					</div>
					<!-- /.card -->
				</div>
				<!--/.col (left) -->
			</div>
			<!-- /.row -->
		</div><!-- /.container-fluid -->
	</section>
	<!-- /.content -->


	<!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<?php require_once(APPPATH . 'views/admin_dashboard/inc/footer.php'); ?>

<script>
	$(document).ready(function() {

		$('#search_due_form').submit(function(e) {
			e.preventDefault();
			var vendor_id = $('#vendor_id').val();
			// alert(vendor_id);
			$.ajax({
				type: 'POST',
				url: '<?php echo BASE_URL; ?>records/get_amount_details',
				data: {
					vendor_id: vendor_id
				},
				success: function(response) {
					$('#amount_details').html(response);
				}
			});
		});

		// Initialize Toastr
		toastr.options = {
			"closeButton": true,
			"debug": false,
			"newestOnTop": false,
			"progressBar": true,
			"positionClass": "toast-top-right",
			"preventDuplicates": false,
			"onclick": null,
			"showDuration": "300",
			"hideDuration": "1000",
			"timeOut": "5000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		};

		// Function to trigger a toast message
		function showToast(message, type) {
			toastr[type](message);
		}

	});
</script>

<?php if (isset($vendor_id)) : ?>

	<script>
		$(document).ready(function() {


			var vendor_id = <?= $vendor_id ?>;
			$.ajax({
				type: 'POST',
				url: '<?php echo BASE_URL; ?>records/get_amount_details',
				data: {
					vendor_id: vendor_id
				},
				success: function(response) {
					$('#amount_details').html(response);
				}
			});


			// Initialize Toastr
			toastr.options = {
				"closeButton": true,
				"debug": false,
				"newestOnTop": false,
				"progressBar": true,
				"positionClass": "toast-top-right",
				"preventDuplicates": false,
				"onclick": null,
				"showDuration": "300",
				"hideDuration": "1000",
				"timeOut": "5000",
				"extendedTimeOut": "1000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
			};

			// Function to trigger a toast message
			function showToast(message, type) {
				toastr[type](message);
			}

		});
	</script>

<?php endif; ?>
<?php if ($this->session->flashdata('toast_message')) : ?>
	<script>
		$(document).ready(function() {
			var message = "<?php echo $this->session->flashdata('toast_message'); ?>";
			showToast(message, 'success');
		});

		function showToast(message, type) {
			toastr[type](message);
		}
	</script>
<?php endif; ?>
