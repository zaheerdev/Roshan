<?php require_once(APPPATH . 'views/admin_dashboard/inc/header.php'); ?>
<?php require_once(APPPATH . 'views/admin_dashboard/inc/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Inventory</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Inventory</li>
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
				<div class="col-lg-12">
					<?php if (validation_errors()) : ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<?php echo validation_errors(); ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endif; ?>
					<?php if ($this->session->flashdata('success')) : ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<?php echo $this->session->flashdata('success'); ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endif; ?>
					<!-- general form elements -->
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Inventory</h3>
						</div>
						<!-- /.card-header -->

						<div class="card-body">
							<nav>
								<div class="nav nav-tabs" id="nav-tab" role="tablist">
									<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Product Inventory</a>
									<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Raw Materials</a>
								</div>
							</nav>
							<div class="tab-content" id="nav-tabContent">
								<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
									<form id="add_product_inventory" action="<?= BASE_URL ?>inventory/save_product_inventory" method="post">
										<div class="card-body">
											<table id="items-table" class="table">
												<tbody>
													<tr>
														<td>
															<div class="form-group">
																<label for="item_select">Item</label>
																<select class="form-control" id="item_select" name="product_id" required>
																	<option value="">Select Item</option>
																	<?php foreach ($product_items as $item) : ?>
																		<option value="<?php echo $item['id']; ?>">
																			<?php echo $item['product_name']; ?>
																		</option>
																	<?php endforeach; ?>
																</select>
															</div>
														</td>
														<td>
															<div class="form-group">
																<label for="quantity">Quantity</label>
																<input type="number" min="1" class="form-control quantity" name="quantity">
															</div>
														</td>
													</tr>
												</tbody>
											</table>

										</div>
										<!-- /.card-body -->
										<div class="card-footer">
											<button type="submit" class="btn btn-primary">Submit</button>
											<button type="button" id="cancel-button" class="btn btn-default">Cancel</button>
										</div>
									</form>
								</div>
								<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
									<form id="add_raw_inventory" action="<?= BASE_URL ?>inventory/save_raw_inventory" method="post">
										<div class="card-body">
											<table id="items-table" class="table">
												<tbody>
													<tr>
														<td>
															<div class="form-group">
																<label for="item_select">Item</label>
																<select class="form-control" id="item_select" name="material_id" required>
																	<option value="">Select Item</option>
																	<?php foreach ($raw_items as $item) : ?>
																		<option value="<?php echo $item['id']; ?>">
																			<?php echo $item['material_name']; ?>
																		</option>
																	<?php endforeach; ?>
																</select>
															</div>
														</td>
														<td>
															<div class="form-group">
																<label for="quantity">Quantity</label>
																<input type="number" min="1" class="form-control quantity" name="quantity">
															</div>
														</td>
													</tr>
												</tbody>
											</table>

										</div>
										<!-- /.card-body -->
										<div class="card-footer">
											<button type="submit" class="btn btn-primary">Submit</button>
											<button type="button" id="cancel-button" class="btn btn-default">Cancel</button>
										</div>
									</form>
								</div>
							</div>

						</div>

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
	let BASE_URL = "<?php echo BASE_URL; ?>";
</script>
<script>
	$(document).ready(function() {

		$('#add-row').click(function(event) {
			event.preventDefault();
			var lastRow = $('#items-table tbody tr:last');
			var newRow = lastRow.clone();
			newRow.find('input').val('');
			newRow.find('.total input').val('0');
			lastRow.after(newRow);
		});

		$(document).on('change', '#item_select', function() {
			var selectedPrice = parseFloat($(this).find('option:selected').data('price'));
			$(this).closest('tr').find('.price_input').val(selectedPrice);
			var total = selectedPrice;
			$(this).closest('tr').find('.total input').val(total);
		});

		$('#items-table').on('change', 'input.quantity', function() {
			var quantity = $(this).val();
			var price = $(this).closest('tr').find('td:nth-child(2) input').val();
			var total = quantity * price;
			$(this).closest('tr').find('.total input').val(total);
		});

		$('#cancel-button').click(function() {
			$('#book_order_form')[0].reset();
			$('#items-table tbody tr:not(:first)').remove();
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

		// Submit form
		$('#book_order_form').submit(function(event) {
			event.preventDefault();

			var vendorId = $('select[name="vendor_id"]').val();
			var productItems = [];

			$('#items-table tbody tr').each(function() {
				var productId = $(this).find('td:nth-child(1) select').val();
				var quantityInput = $(this).find('td:nth-child(3) input');
				var quantity = quantityInput.val() ? parseInt(quantityInput.val()) : 1;
				var total = $(this).find('td:nth-child(4) input').val();
				productItems.push({
					productId: productId,
					quantity: quantity,
					total: total
				});
			});

			var formData = {
				vendorId: vendorId,
				productItems: productItems
			};

			$.ajax({
				type: 'POST',
				url: 'save_order',
				data: JSON.stringify(formData),
				contentType: 'application/json',
				success: function(response) {
					var responseData = JSON.parse(response);
					if (responseData.success) {
						var orderId = responseData.order_id;
						showToast(responseData.message, 'success');
						setTimeout(function() {
							window.location.href = BASE_URL + 'order/deliver_order/' + orderId;
						}, 1500);
					} else {
						showToast(responseData.message, 'error');
					}
				},
				error: function(xhr, status, error) {
					console.error(error);
					showToast('Order booking failed!', 'error');
				}
			});
		});

	});
</script>
