<?php require_once(APPPATH . 'views/admin_dashboard/inc/header.php'); ?>
<?php require_once(APPPATH . 'views/admin_dashboard/inc/sidebar.php'); ?>

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Records</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Records</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<?php if ($this->session->flashdata('pay_amount')) : ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<?php echo $this->session->flashdata('pay_amount'); ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endif; ?>
					
					<!-- /.card -->
					<!-- payment successfull -->
					<div class="card">
						<!-- /.card-header -->
						<div class="card-body">
							<table id="records" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Dukandar ID</th>
										<th>Dukandar Name</th>
										<th>Seller Name</th>
										<th>Sub Total</th>
										<th>Net Total</th>
										<th>Total Discount</th>
										<th>Total Paid amount</th>
										<th>Total Due Amount</th>
									</tr>
								</thead>
								<tbody>
									<?php if (!empty($records)) : ?>
										<?php foreach ($records as $record) : ?>
											<tr>
												<td><?= $record->vendor_id ?></td>
												<td><?= $record->vendor_name ?></td>
												<td><?= $record->user_name ?></td>
												<td><?= $record->total_sub_total ?></td>
												<td><?= $record->total_net_total ?></td>
												<td><?= $record->total_sub_total - $record->total_net_total ?></td>
												<td><?= $record->total_paid_amount ?></td>
												<td><?= $record->total_due_amount ?></td>
											</tr>
										<?php endforeach; ?>
									<?php endif; ?>
								</tbody>
							</table>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</div>
		<!-- /.container-fluid -->
	</section>
	<!-- /.content -->
</div>


<?php require_once(APPPATH . 'views/admin_dashboard/inc/footer.php'); ?>
