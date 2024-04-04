<?php require_once(APPPATH . 'views/admin_dashboard/inc/header.php'); ?>
<?php require_once(APPPATH . 'views/admin_dashboard/inc/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Vendors</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Vendors</li>
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
					<!-- general form elements -->
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">List of Vendors</h3>
						</div>
						<!-- /.card-header -->
						<!-- Table start -->
						<!-- vendor added successfully -->
						<?php if ($this->session->flashdata('success')) : ?>
							<div class="container bg-success text-center p-3">
								<?= $this->session->flashdata('success') ?>
							</div>
						<?php endif; ?>
						<!-- vendor not found -->
						<?php if ($this->session->flashdata('vendor404')) : ?>
							<div class="container bg-danger text-center p-3">
								<?= $this->session->flashdata('vendor404') ?>
							</div>
						<?php endif; ?>
						<!-- vendor updated successfully -->
						<?php if ($this->session->flashdata('updated')) : ?>
							<div class="container bg-success text-center p-3">
								<?= $this->session->flashdata('updated') ?>
							</div>
						<?php endif; ?>
						<!-- vendor deleted successfully -->
						<?php if ($this->session->flashdata('delete')) : ?>
							<div class="container bg-success text-center p-3">
								<?= $this->session->flashdata('delete') ?>
							</div>
						<?php endif; ?>


						<!-- if record found -->
						<?php if (!empty($vendors)) : ?>
							<table class="table">
								<thead class="thead-dark">
									<tr>
										<th scope="col">ID</th>
										<th scope="col">Name</th>
										<th scope="col">Bussiness Name</th>
										<th scope="col">Address</th>
										<th scope="col">Phone</th>
										<th scope="col">Action</th>
									</tr>
								</thead>
								<tbody>

									<?php foreach ($vendors as $vendor) : ?>
										<tr>
											<th><?= $vendor['id'] ?></th>
											<th><?= $vendor['name'] ?></th>
											<th><?= $vendor['business_name'] ?></th>
											<th><?= $vendor['Address'] ?></th>
											<th><?= $vendor['Phone'] ?></th>
											<th>
												<a class="btn btn-primary " href="<?= BASE_URL . "vendor/editvendor/" . $vendor["id"] ?>">Edit</a>
												<a class="btn btn-danger " href="<?= BASE_URL . "vendor/deletevendor/" . $vendor["id"] ?>" onclick="return confirm('are you sure to delete <?= $vendor['name'] ?>')">Delete</a>
											</th>
										</tr>
									<?php endforeach; ?>

								</tbody>
							</table>
						<!-- if not found -->
						<?php else : ?>
							<div class="p-3 text-center">No Record Found</div>
						<?php endif; ?>
						<?php echo validation_errors(); ?>

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
