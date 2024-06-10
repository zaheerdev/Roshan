<?php require_once(APPPATH . 'views/admin_dashboard/inc/header.php'); ?>
<?php require_once(APPPATH . 'views/admin_dashboard/inc/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper paid-amount">

	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Sellers Amount Details</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Amount Detail</li>
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

					<!-- seller added successfully -->
					<?php if ($this->session->flashdata('success')) : ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('success') ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endif; ?>
					<!-- seller not found -->
					<?php if ($this->session->flashdata('seller404')) : ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('seller404') ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endif; ?>
					<!-- seller updated successfully -->
					<?php if ($this->session->flashdata('updated')) : ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('updated') ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endif; ?>
					<!-- seller deleted successfully -->
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
							<h3 class="card-title">Seller's Amount Details</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<div class="bg-white d-lg-flex justify-content-lg-between align-items-center ">
								<?php if ($user_role == 1) : ?>
									<a style="color:#fff !important;" class="btn btn-primary my-1" href="<?= BASE_URL . 'sellers/add_seller' ?>">Add New Seller</a>
								<?php endif; ?>
								<span style="float: end;">
									<form action="<?= BASE_URL . 'sellers/paid_amount/' . $id . '/filtered'; ?>" method="post">
										<div class="filter mt-2 d-lg-flex align-items-end">
											<div class="form-group m-1">
												<label for="date">Start Date</label>
												<input class="form-control" name="start" type="date" required>
											</div>
											<div class="form-group m-1">
												<label for="date">End Date</label>
												<input class="form-control" name="end" type="date" required>
											</div>
											<div class="form-group text-right m-1">
												<input class="btn btn-primary " type="submit">
											</div>
										</div>
								</span>
								</form>
							</div>
							<div class="p-2 my-3 border rounded bg-primary">
								Daily Delivered Orders
							</div>

							<!-- Table start -->
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th scope="col">Seller Name</th>
										<th scope="col">Order id</th>
										<th scope="col">Dukandar</th>
										<th scope="col">Sub total</th>
										<th scope="col">Discount</th>
										<th scope="col">Net total</th>
										<th scope="col">Paid amount</th>
										<th scope="col">Due amount</th>
										<th scope="col">Date</th>
									</tr>
								</thead>
								<tbody>
									
									<?php if (!empty($daily_orders)) : ?>
										<!-- if record found -->
										<?php foreach ($daily_orders as $order) : ?>
											<tr>
												<?php if ($order->name) : ?>
													<td><?= $order->name ?></td>
													<td><?= $order->order_id ?></td>
													<td><?= $order->vendor_name ?><br>Address: <?=$order->address?></td>
													<td><?= round($order->sub_total) ?></td>
													<td><?= round($order->discount) ?></td>
													<td><?= round($order->net_total) ?></td>
													<td><?= round($order->paid_amount) ?></td>
													<td><?= round($order->due_amount) ?></td>
													<td><?= $filter ?? $order->created_at ?></td>
												<?php else : ?>
													<td>No Record Found. You can apply date filter.</td>
												<?php endif; ?>
											</tr>
										<?php endforeach; ?>
									<?php else : ?>
										<tr>
											<td>Nothing found for today. You can apply date filter.</td>
										</tr>
									<?php endif; ?>
								</tbody>
							</table>
							<div class="p-2 my-3 border rounded bg-primary">
								Collected Amount From Dukandar
							</div>
							<!-- collected amount -->
							<!-- Table start -->
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th scope="col">Seller Name</th>
										<th scope="col">Dukandar Name</th>
										<th scope="col">Dukandar Address</th>
										<th scope="col">Collected Amount</th>
										<th scope="col">Date</th>
									</tr>
								</thead>
								<tbody>

									<?php if (!empty($collected_amount)) : ?>
										<?php $total_collected_amount = 0; ?>
										<!-- if record found -->
										<?php foreach ($collected_amount as $amount) : ?>
											<?php $total_collected_amount += $amount->collected_amount; ?>
											<tr>
												<?php if ($amount->user_name) : ?>
													<td><?= $amount->user_name ?></td>
													<td><?= $amount->vendor_name ?></td>
													<td><?= $amount->vendor_address ?></td>
													<td><?= round($amount->collected_amount) ?></td>
													<td><?= $filter ?? $amount->created_at ?></td>
												<?php else : ?>
													<td>No Record Found. You can apply date filter.</td>
												<?php endif; ?>
											</tr>
										<?php endforeach; ?>
										<!-- row for showing total -->
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<td><?='Total: '.round($total_collected_amount) ?></td>
											<td></td>
										</tr>
									<?php else : ?>
										<tr>
											<td>Nothing found for today. You can apply date filter.</td>
										</tr>
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
