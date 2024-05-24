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
				
				
					<!-- /.card -->
					<!-- payment successfull -->
					<div class="card">
						<!-- /.card-header -->
						<div class="card-body">
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>ID</th>
										<th>Seller Name</th>
										<th>Product Name</th>
										<th>Quantity</th>
										
									</tr>
								</thead>
								<tbody>
									<?php if (!empty($stocks)) : ?>
										<?php foreach ($stocks as $record) : ?>
											<tr>
												<td><?= $record->id ?></td>
												<td><?= $record->name ?></td>
												<td><?= $record->product_name ?></td>
												<td><?= $record->quantity ?></td>
												
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
