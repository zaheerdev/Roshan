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
							<table id="route-records" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>ID</th>
										<th>Dukandar</th>
										<th>Address</th>
										<th>Seller</th>
										<th>Sub Total</th>
										<th>Net Total</th>
										<th>Total Discount</th>
										<th>Total Paid</th>
										<th>Total Due</th>
										<th>Last collected</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>
									<?php if (!empty($records)) : ?>
										<?php foreach ($records as $record) : ?>
											<tr>
												<td><?= $record->vendor_id ?></td>
												<td><?= $record->vendor_name ?></td>
												<td><?= $record->address ?></td>
												<td><?= $record->user_name ?></td>
												<td><?= $record->total_sub_total ?></td>
												<td><?= $record->total_net_total ?></td>
												<td><?= $record->total_sub_total - $record->total_net_total ?></td>
												<td><?= $record->total_paid_amount ?></td>
												<td><?= $record->total_due_amount ?></td>
												<td><?= $record->collected ?? 'Not collected yet'?></td>
												<td><?= $record->collected_date ?? 'Not collected yet'?></td>
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
<script>
    	$(document).ready(function() {
    		var table = $('#route-records').DataTable({
    			"paging": true,
    			"lengthChange": false,
    			"searching": true,
    			"ordering": true,
    			"order": [
    				[0, 'desc']
    			],
    			"info": true,
    			"autoWidth": false,
    			"responsive": true,
    			dom: 'Bfrtip',
    			buttons: [
    {
        extend: 'pdf',
        orientation: 'landscape', // or 'portrait'
        pageSize: 'A4', // or 'LETTER'
        customize: function (doc) {
            // Custom settings for the PDF, e.g., adjust margins, font size
            doc.content[1].margin = [0, 0, 0, 12];
        }
    }
]
    		});

    		// Add search input fields outside the table
    		$('#route-records').before('<div class="my-2 form-inline" id="searchInputs"></div>');
    		var columnsToSearch = [2,3]; // Specify the columns to add search fields to
    		columnsToSearch.forEach(function(index) {
    			var title = table.column(index).header().innerText;
    			$('#searchInputs').append('<input class="mr-2 form-control" type="text" placeholder="Search ' + title + '" id="searchInput_' + index + '" />');
    		});

    		// Apply the search to the respective columns
    		$('#searchInputs input').on('input', function() {
    			var columnIndex = $(this).attr('id').split('_')[1];
    			var val = $.fn.dataTable.util.escapeRegex($(this).val());
    			table.column(columnIndex).search('^' + val, true, false).draw();
    		});
    		// disable default searchbar
    		$('#records_filter').hide()
			// csv button text change.
			$('.buttons-csv span').text('Download CSV');

    	});
    </script>
