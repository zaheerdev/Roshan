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
					<?php if ($this->session->flashdata('expense404')) : ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('expense404') ?>
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
							<h3 class="card-title">Raw Materials</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">

							<!-- tabs start-->
							<nav>
								<div class="nav nav-tabs" id="nav-tab" role="tablist">
									<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Add Product Quantity</a>
									<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Add Raw Material</a>
									<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">View Raw Material</a>
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
																<input type="number" class="form-control quantity" name="quantity">
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
																<input type="number" class="form-control quantity" name="quantity">
															</div>
														</td>
													</tr>
												</tbody>
											</table>

										</div>
										<!-- /.card-body -->
										<div class="card-footer">
											<button type="submit" class="btn btn-primary">Submit</button>

										</div>
									</form>
								</div>
								<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
									<table id="example1" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th scope="col">ID</th>
												<th scope="col">Material Name</th>
												<th scope="col">Quantity</th>
											</tr>
										</thead>
										<tbody>
											<?php if (!empty($raw_items)) : ?>
												<!-- if record found -->
												<?php foreach ($raw_items as $item) : ?>
													<tr>
														<td><?= $item['id'] ?></td>
														<td><?= $item['material_name'] ?></td>
														<td><?= $item['quantity'] ?></td>
													</tr>
												<?php endforeach; ?>
											<?php else : ?>
												<div class="p-3 text-center">No Record Found</div>
											<?php endif; ?>
										</tbody>
									</table>
								</div>
							</div>
							<!-- tabs end -->
							<!-- Table start -->

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