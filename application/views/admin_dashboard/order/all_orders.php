<?php require_once(APPPATH . 'views/admin_dashboard/inc/header.php'); ?>
<?php require_once(APPPATH . 'views/admin_dashboard/inc/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Orders List</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Orders</li>
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

					
					<!-- cancel -->
					<?php if ($this->session->flashdata('cancel')) : ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('cancel') ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endif; ?>
					<!-- cancel -->
					<?php if ($this->session->flashdata('success')) : ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('success') ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endif; ?>
					<!-- cancel -->
					<?php if ($this->session->flashdata('fail')) : ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('fail') ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endif; ?>
					<?php if ($this->session->flashdata('cannot')) : ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('cannot') ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endif; ?>
					

					<!-- general form elements -->
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">List of Orders</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
						
						<!-- Table start -->
						<table id="example1" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th scope="col">Order ID</th>
									<th scope="col">Seller</th>
									<th scope="col">Dukandar</th>
									<th scope="col">Product</th>
									<th scope="col">Quantity</th>
									<th scope="col">Total</th>
									<th scope="col">Cancelled</th>
									<th scope="col">Action</th>
									
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($orders)) : ?>
									<!-- if record found -->
									
									<?php foreach ($orders as $order) : ?>
										<tr>
											<td><?= $order->order_id ?></td>
											<td><?= $order->seller_name ?></td>
											<td><?= $order->vendor_name ?></td>
											<td><?= $order->product_name ?></td>
											<td><?= $order->quantity ?></td>
											<td><?= $order->total ?></td>
											<td><?= $order->c_id ? 'cancelled on<br>'.$order->c_time: ''; ?></td>
											<td>
												
												<?php if($order->c_id != ''): ?>
												<a class="btn btn-danger mt-1" href="<?=BASE_URL.'order/delete_cancelled/'.$order->order_id;?>" onclick="return confirm('are you sure to delete order no:<?= $order->order_id ?>')">Delete Cancelled Order</a>
												<?php else:?>
													<a class="btn btn-danger mt-1" href="<?=BASE_URL.'order/cancel_order/'.$order->user_id.'/'.$order->order_id;?>" onclick="return confirm('are you sure to cancel order no: <?= $order->order_id ?>')">Cancel Order</a>
												<?php endif;?>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php else : ?>
									<div class="p-3 text-center">No Record Found</div>
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
