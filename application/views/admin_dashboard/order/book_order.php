<?php require_once(APPPATH . 'views/admin_dashboard/inc/header.php'); ?>
<?php require_once(APPPATH . 'views/admin_dashboard/inc/sidebar.php'); ?>

<style>
	@media (max-width: 575px) {
		.book_order_table tr {
			display: grid;
		}
	}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Order</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Order</li>
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
							<h3 class="card-title">Deliver Order</h3>
						</div>
						<!-- /.card-header -->
						<!-- form start -->
						<form id="book_order_form" action="#" method="post">
							<div class="card-body">
								<div class="form-group">
									<label>Dukandar</label>
									<select class="form-control dukandar" name="vendor_id" required style="width: 100%;height:50px">
										<option value="">Select Dukandar</option>
										<?php foreach ($vendors as $vendor) : ?>
											<option value="<?php echo $vendor->id; ?>"><?php echo $vendor->vendor_name; ?><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Address: <?= $vendor->address ?></span></option>
										<?php endforeach; ?>
									</select>
								</div>

								<table id="items-table" class="table book_order_table">
									<tbody>
										<tr class="order_item">
											<td>
												<div class="form-group">
													<label for="item_select">Item</label>
													<select class="form-control item_select" required>
														<option value="">Select Item</option>
														<?php foreach ($product_items as $item) : ?>
															<option value="<?php echo $item['id']; ?>" data-price="<?php echo $item['price']; ?>">
																<?php echo $item['product_name']; ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
											</td>
											<td>
												<div class="form-group">
													<label for="price_input">Price</label>
													<input type="text" class="form-control price_input" readonly>
												</div>
											</td>
											<td>
												<div class="form-group">
													<label for="quantity">Quantity</label>
													<input type="number" class="form-control quantity">
												</div>
											</td>
											<td class="total">
												<div class="form-group">
													<label for="item_select">Total</label>
													<input type="number" class="form-control" value="0" readonly>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
								<div class="text-right">
									<button id="add-row" class="btn btn-primary">Add Row</button>
								</div>

							</div>
							<!-- /.card-body -->
							<div class="card-footer">
								<button id="submit-btn" type="submit" class="btn btn-primary">Deliver Order</button>
								<button type="button" id="cancel-button" class="btn btn-default">Cancel</button>
							</div>
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
	let BASE_URL = "<?php echo BASE_URL; ?>";
</script>

<script>
	$(document).ready(function() {
		$('#book_order_form button[type="submit"]').prop('disabled', true);

		$('#book_order_form').on('change', '.item_select, .quantity', function() {
			var selectedItemId = $(this).closest('.order_item').find('.item_select').val();
			var selectedQuantity = parseInt($(this).closest('.order_item').find('.quantity').val());

			if (selectedItemId && selectedQuantity) {
				<?php if ($this->session->userdata('user_session')->role_id == 1) : ?>
					$.ajax({
						url: 'check_product_quantity',
						type: 'GET',
						data: {
							id: selectedItemId
						},
						success: function(response) {
							var itemQuantity = parseInt(response);
							if (itemQuantity >= selectedQuantity) {
								$('#book_order_form button[type="submit"]').prop('disabled', false);
							} else {
								$('#book_order_form button[type="submit"]').prop('disabled', true);
								alert("Out of stock or invalid quantity");
							}
						}.bind(this),
						error: function() {
							console.log("Error fetching product quantity");
						}
					});
				<?php else : ?>
					$.ajax({
						url: 'check_seller_quantity',
						type: 'GET',
						data: {
							id: selectedItemId
						},
						success: function(response) {
							var itemQuantity = parseInt(response);
							if (itemQuantity >= selectedQuantity) {
								$('#book_order_form button[type="submit"]').prop('disabled', false);
							} else {
								$('#book_order_form button[type="submit"]').prop('disabled', true);
								alert("Your Assinged quantity is " + itemQuantity + ". You cannot deliver " + selectedQuantity);
							}
						}.bind(this),
						error: function() {
							console.log("Error fetching product quantity");
						}
					});
				<?php endif; ?>
			}

		});

	});
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

		$(document).on('change', '.item_select', function() {
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
			// disable submit button when ordered
			$('#submit-btn').attr('disabled',true);
			
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
