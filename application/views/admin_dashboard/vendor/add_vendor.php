<?php require_once(APPPATH . 'views/admin_dashboard/inc/header.php'); ?>
<?php require_once(APPPATH . 'views/admin_dashboard/inc/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Add Vendor</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Add Vendor</li>
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
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<?php echo validation_errors(); ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<!-- general form elements -->
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Add Vendor</h3>
						</div>
						<!-- /.card-header -->
						<!-- form start -->
						<form class="p-4" action="<?= BASE_URL . "vendor/save_vendor" ?>" method="post">
							<div class="form-group w-sm-100 w-lg-50">
								<label for="exampleInputEmail1">Name</label>
								<input type="text" name="name" class="form-control" placeholder="Enter Name">

							</div>
							<div class="form-group w-sm-100 w-lg-50">
								<label for="exampleInputEmail1">Business Name</label>
								<input type="text" name="bussiness" class="form-control" placeholder="Enter Business Name">

							</div>
							<div class="form-group w-sm-100 w-lg-50">
								<label for="exampleInputEmail1">Address</label>
								<input type="text" name="address" class="form-control" placeholder="Enter Your Address">

							</div>
							<div class="form-group w-sm-100 w-lg-50">
								<label for="exampleInputEmail1">Phone No</label>
								<input type="text" name="phone" class="form-control" placeholder="Enter Phone No">

							</div>

							<input name="submit" type="submit" value="Submit" class="btn btn-primary mt-3">
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