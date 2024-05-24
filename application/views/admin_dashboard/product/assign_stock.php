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
					<h1 class="m-0">Asign Quantity</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Asign Quantity</li>
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
						<div>
						<?php if (validation_errors()) : ?>
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<?php echo validation_errors(); ?>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
							<?php endif; ?>
							<?php if ($this->session->flashdata('p_quantity')) : ?>
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<?php echo $this->session->flashdata('p_quantity'); ?>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
							<?php endif; ?>
						</div>
						<div class="card-header">
							<h3 class="card-title">Assign Quantity</h3>
							
						</div>
						<!-- /.card-header -->
						<!-- form start -->
						<form id="book_order_form" action="<?= BASE_URL . 'product/save_assign_stock' ?>" method="post">
							<div class="card-body">
								<div class="form-group">
									<label>Seller</label>
									<select class="form-control" name="user_id" required>
										<option value="">Select Seller</option>
										<?php foreach ($sellers as $seller) : ?>
											<option value="<?php echo $seller->id; ?>"><?php echo $seller->name; ?></option>
										<?php endforeach; ?>
									</select>
								</div>

								<table id="items-table" class="table book_order_table">
									<tbody>
										<tr>
											<td>
												<div class="form-group">
													<label for="item_select">Product Item</label>
													<select class="form-control" name="product_id" id="product_id" required>
														<option value="">Select Item</option>
														<?php foreach ($products as $item) : ?>
															<option quantity="<?php echo $item->quantity; ?>" value="<?php echo $item->id; ?>" data-price="<?php echo $item->product_name; ?>">
																<?php echo $item->product_name; ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
											</td>


											<td>
												<div class="form-group">
													<label for="quantity">Quantity</label>
													<input type="number" name="quantity" min="1" class="form-control quantity" required>
												</div>
											</td>

										</tr>
									</tbody>
								</table>
								

							</div>
							<!-- /.card-body -->
							<div class="card-footer">
								<button type="submit" class="btn btn-primary">Assign</button>
								
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
	$(document).ready(function() {
		$("#product_id").on('change', function() {
			var product = $(this).find(":selected").attr('quantity');
			$("input[name='quantity']").attr('placeholder', "Out of " + product);
		});
	});
</script>
