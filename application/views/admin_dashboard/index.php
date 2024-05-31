<?php require_once(APPPATH . 'views/admin_dashboard/inc/header.php'); ?>
<?php require_once(APPPATH . 'views/admin_dashboard/inc/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Dashboard</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Dashboard</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- Small boxes (Stat box) -->
			<div class="row">
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-info">
						<div class="inner">
							<h3><?= round($total_sales); ?></h3>
							<p>Total Sales</p>
						</div>
						<div class="icon">
							<i class="ion ion-bag"></i>
						</div>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-success">
						<div class="inner">
							<h3><?= round($total_paid_amount); ?></h3>
							<p>Paid Amount</p>
						</div>
						<div class="icon">
							<i class="ion ion-cash"></i>
						</div>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-danger">
						<div class="inner">
							<h3><?= round($total_due_amount); ?></h3>
							<p>Due Amount</p>
						</div>
						<div class="icon">
							<i class="ion ion-cash"></i>
						</div>
					</div>
				</div>
				<!-- ./col -->

				<?php if ($user_role != 2) : ?>

					<div class="col-lg-3 col-6">
						<!-- small box -->
						<div class="small-box bg-primary">
							<div class="inner">
								<h3><?= round($total_expense_amount); ?></h3>
								<p>Total Expenses</p>
							</div>
							<div class="icon">
								<i class="ion ion-pie-graph"></i>
							</div>
						</div>
					</div>
					<!-- ./col -->
					<!-- ./col -->
					<div class="col-lg-3 col-6">
						<!-- small box -->
						<div class="small-box" style="background-color:#d7f5a4">
							<div class="inner">
								<h3><?= round($total_paid_amount - $total_expense_amount); ?></h3>
								<p>Actual Profit</p>
							</div>
							<div class="icon">
								<i class="ion ion-pie-graph"></i>
							</div>
						</div>
					</div>
					<!-- ./col -->
					<!-- ./col -->
					<div class="col-lg-3 col-6">
						<!-- small box -->
						<div class="small-box" style="background-color:#a4f5df">
							<div class="inner">
								<h3><?= round($total_sales - $total_expense_amount); ?></h3>
								<p>Expected Profit</p>
							</div>
							<div class="icon">
								<i class="ion ion-pie-graph"></i>
							</div>
						</div>
					</div>
					<!-- ./col -->
				<?php endif; ?>
			</div>
			<!-- chart -->
			<div class="row">

				<!-- /.col (LEFT) -->
				<div class="col-md-12">

					<!-- /.card -->

					<!-- BAR CHART -->
					<div class="card card-info">
						<div class="card-header">
							<h3 class="card-title">Report</h3>
						</div>
						<div class="card-body">
							<div class="chart">
								<canvas id="barChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
							</div>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->



				</div>
				<!-- /.col (RIGHT) -->
			</div>
		</div>
</div>
</section>

<!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<?php require_once(APPPATH . 'views/admin_dashboard/inc/footer.php'); ?>
