<?php require_once(APPPATH . 'views/admin_dashboard/inc/header.php'); ?>
<?php require_once(APPPATH . 'views/admin_dashboard/inc/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Dukandar list</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Dukandar list</li>
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

					<!-- product added successfully -->
					<?php if ($this->session->flashdata('success')) : ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('success') ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endif; ?>
					<!-- vendor not found -->
					<?php if ($this->session->flashdata('route404')) : ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('route404') ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endif; ?>
					<!-- product updated successfully -->
					<?php if ($this->session->flashdata('updated')) : ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('updated') ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endif; ?>
					<!-- product deleted successfully -->
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
						<div class="card-body">
							
							<!-- /.card-header -->
							<!-- Table start -->
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Id</th>
										<th>Route</th>
										<th>Name</th>
										<th>Bussiness</th>
										<th>Address</th>
										<th>Phone</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php if (!empty($vendors)) : ?>
										<?php foreach ($vendors as $vendor) : ?>
											<tr>
												<td><?= $vendor->route_vendor_id ?></td>
												<td><?= $vendor->route ?></td>
												<td><?= $vendor->vendor_name ?></td>
												<td><?= $vendor->business_name ?></td>
												<td><?= $vendor->address ?></td>
												<td><?= $vendor->phone_no ?></td>
												<td>
													<a class="btn btn-sm btn-danger " href="<?= BASE_URL . "routes/delete_from_route/" . $vendor->route_vendor_id."/".$vendor->route_id ?>">Remove from route</a>
													
												</td>
											</tr>
										<?php endforeach; ?>
									<?php endif; ?>
								</tbody>
							</table>
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
