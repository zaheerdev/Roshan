<?php require_once(APPPATH . 'views/admin_dashboard/inc/header.php'); ?>
<?php require_once(APPPATH . 'views/admin_dashboard/inc/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Edit Order</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Edit Order</li>
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

					<!-- vendor added successfully -->
					<?php if ($this->session->flashdata('success')) : ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('success') ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endif; ?>
					<!-- vendor not found -->
					<?php if ($this->session->flashdata('vendor404')) : ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('vendor404') ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endif; ?>
					<!-- vendor updated successfully -->
					<?php if ($this->session->flashdata('updated')) : ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('updated') ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endif; ?>
					<!-- vendor deleted successfully -->
					<?php if ($this->session->flashdata('delete')) : ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('delete') ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endif; ?>

					<!-- general form elements -->
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Edit Order</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">

							<!-- Form start -->
							<form class="p-4" action="" method="post">
								<div class="form-group">
									<label>Dukandar</label>
									<select class="form-control dukandar" name="vendor_id" required style="width: 100%;height:50px">
										<option value="">Select Dukandar</option>
										<?php foreach ($vendors as $vendor) : ?>
											<option value="<?php echo $vendor->id; ?>"><?php echo $vendor->vendor_name; ?><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Address: <?= $vendor->address ?></span></option>
										<?php endforeach; ?>
									</select>
								</div>
								<?php foreach ($orders as $i => $order) : ?>
									<div class="p-2 bg-primary rounded">Edit Product <?= $i + 1 ?></div>
									<div class="form-group w-sm-100 w-lg-50">
										<label for="item_select">Item</label>
										<select class="form-control item_select" name="product_id[]" required>
											<option value="">Select Item</option>
											<?php foreach ($product_items as $item) : ?>
												<option value="<?php echo $item['id']; ?>" data-price="<?php echo $item['price']; ?>">
													<?php echo $item['product_name']; ?>
												</option>
											<?php endforeach; ?>
										</select>

									</div>
									<div class="form-group w-sm-100 w-lg-50">
										<label for="exampleInputEmail1">Quantity</label>
										<input type="number" min="1" name="quantity[]" value="" class="form-control" placeholder="<?='Old Quantity is '. $order->quantity ?>">
										<input type="number" min="1" name="old_quantity[]" value="" class="form-control" hidden>

									</div>
									<div class="form-group w-sm-100 w-lg-50">
										<label for="exampleInputEmail1">Total</label>
										<input type="text" name="total[]" value="<?=$order->total?>" class="form-control" disabled>

									</div>
								<?php endforeach; ?>

								<input name="submit" type="submit" value="Submit" class="btn btn-primary mt-3">
							</form>

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
<script>
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
</script>

<?php require_once(APPPATH . 'views/admin_dashboard/inc/footer.php'); ?>
