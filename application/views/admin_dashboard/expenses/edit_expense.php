<?php require_once(APPPATH . 'views/admin_dashboard/inc/header.php'); ?>
<?php require_once(APPPATH . 'views/admin_dashboard/inc/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Edit Expense</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Edit Expense</li>
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

					<?php if ($this->session->flashdata('errors')) : ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('errors') ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endif; ?>
					<?php if ($this->session->flashdata('amount')) : ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('amount') ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endif; ?>

					<!-- general form elements -->
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Edit Expense</h3>
						</div>
						<!-- /.card-header -->
						<!-- form start -->
						<form class="p-4" action="<?= BASE_URL . "expenses/update_expense/$expense->id" ?>" method="post">
							<div class="form-group w-sm-100 w-lg-50">
								<label for="exampleInputEmail1">Expense Name</label>
								<input type="text" name="expense_name" value="<?= $expense->expense_name ?>" class="form-control" placeholder="Enter Expense Name">

							</div>
							<div class="form-group w-sm-100 w-lg-50">
								<label for="exampleInputEmail1">Category</label>
								<input type="text" name="category" value="<?= $expense->category ?>" class="form-control" placeholder="Enter Category">

							</div>
							<div class="form-group w-sm-100 w-lg-50">
								<label for="exampleInputEmail1">Date</label>
								<input type="date" name="date" value="<?= $expense->date ?>" class="form-control" placeholder="Enter Date">

							</div>
							<div class="form-group w-sm-100 w-lg-50">
								<label for="exampleInputEmail1">Amount</label>
								<input type="text" name="amount" value="<?= $expense->amount ?>" class="form-control" placeholder="Enter Amount">

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
