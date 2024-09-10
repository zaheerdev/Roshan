<?php require_once(APPPATH . 'views/admin_dashboard/inc/header.php'); ?>
<?php require_once(APPPATH . 'views/admin_dashboard/inc/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Transfer Dukandar</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Transfer Dukandar</li>
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
							<h3 class="card-title">Transfer Dukandar</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<form action="<?= BASE_URL . 'vendor/save_transfer' ?>" method="post">
								<div class="bg-white">

									<div class="form-group">
										<label class="m-1">Transfer to</label>
										<select class="form-control form-control-sm m-1" name="transfer_to" required >
											<option value="">Select seller</option>
											<?php foreach ($sellers as $seller) : ?>
												<option value="<?php echo $seller->id; ?>">
													<?php echo $seller->name; ?>
												</option>
											<?php endforeach; ?>
										</select>
										<input name="submit" type="submit" value="Transfer" class="btn btn-primary m-1" onclick="return confirm('are you sure you want transfer these dukandar')">
									</div>



								</div>
								<!-- Table start -->
								<div style="overflow: auto;">
									<table class="table table-bordered table-striped">
										<thead>
											<tr>
												<th><input id="select_all" type="checkbox"> Select All </th>
												<th scope="col">ID</th>
												<th scope="col">Name</th>
												<th scope="col">Business Name</th>
												<th scope="col">Address</th>
												<th scope="col">Phone</th>

											</tr>
										</thead>
										<tbody>
											<?php if (!empty($vendors)) : ?>
												<!-- if record found -->
												<?php foreach ($vendors as $vendor) : ?>
													<tr>
														<td><input class="check_id" type="checkbox" value="<?= $vendor->id ?>" name="id_array[]"></td>
														<td><?= $vendor->id ?></td>
														<td><?= $vendor->vendor_name ?></td>
														<td><?= $vendor->business_name ?></td>
														<td><?= $vendor->address ?></td>
														<td><?= $vendor->phone_no ?></td>
													</tr>
												<?php endforeach; ?>
											<?php endif; ?>
										</tbody>
									</table>
								</div>
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

<?php require_once(APPPATH . 'views/admin_dashboard/inc/footer.php'); ?>
<script>
	$('#select_all').click(function() {
		$('.check_id').prop('checked', this.checked);
	});
</script>
