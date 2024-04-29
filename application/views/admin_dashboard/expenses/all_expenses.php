<?php require_once(APPPATH . 'views/admin_dashboard/inc/header.php'); ?>
<?php require_once(APPPATH . 'views/admin_dashboard/inc/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Expenses</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Expenses</li>
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
					<?php if ($this->session->flashdata('expense404')) : ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('expense404') ?>
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
							<h3 class="card-title">All Expenses</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
						<div class="bg-white">
							<a style="color:#fff !important;" class="btn btn-primary my-1" href="<?= BASE_URL . 'expenses/add_expense' ?>">Add New Expense</a>
						</div>
						<!-- Table start -->
						<table id="example1" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th scope="col">ID</th>
									<th scope="col">Expense Name</th>
									<th scope="col">Category</th>
									<th scope="col">Date</th>
									<th scope="col">Amount</th>
									<th scope="col">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($expenses)) : ?>
									<!-- if record found -->
									<?php foreach ($expenses as $expense) : ?>
										<tr>
											<td><?= $expense->id ?></td>
											<td><?= $expense->expense_name ?></td>
											<td><?= $expense->category ?></td>
											<td><?= $expense->date ?></td>
											<td><?= $expense->amount ?></td>
											<td>
												<a class="btn btn-primary " href="<?= BASE_URL . "expenses/edit_expense/" . $expense->id ?>">Edit</a>
												<a class="btn btn-danger " href="<?= BASE_URL . "expenses/delete_expense/" . $expense->id ?>" onclick="return confirm('are you sure to delete?')">Delete</a>
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
