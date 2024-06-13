    <!-- jQuery -->
    <script src="<?= ASSETS ?>adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?= ASSETS ?>adminlte/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
    	$.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?= ASSETS ?>adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="<?= ASSETS ?>adminlte/plugins/chart.js/Chart.min.js"></script>
    <!-- JQVMap -->
    <script src="<?= ASSETS ?>adminlte/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="<?= ASSETS ?>adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?= ASSETS ?>adminlte/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="<?= ASSETS ?>adminlte/plugins/moment/moment.min.js"></script>
    <script src="<?= ASSETS ?>adminlte/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?= ASSETS ?>adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="<?= ASSETS ?>adminlte/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="<?= ASSETS ?>adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="<?= ASSETS ?>adminlte/plugins/toastr/toastr.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= ASSETS ?>adminlte/dist/js/adminlte.js"></script>
    <!-- Datatables -->
    <script src="<?= ASSETS ?>adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= ASSETS ?>adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= ASSETS ?>adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= ASSETS ?>adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?= ASSETS ?>adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= ASSETS ?>adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?= ASSETS ?>adminlte/plugins/jszip/jszip.min.js"></script>
    <script src="<?= ASSETS ?>adminlte/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?= ASSETS ?>adminlte/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?= ASSETS ?>adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= ASSETS ?>adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?= ASSETS ?>adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- select search -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
    	$(document).ready(function() {
    		// custom matcher
    		function matchCustom(params, data) {
    			// If there are no search terms, return all of the data
    			if ($.trim(params.term) === '') {
    				return data;
    			}

    			// Do not display the item if there is no 'text' property
    			if (typeof data.text === 'undefined') {
    				return null;
    			}
				var param = params.term.toLowerCase();
				var text = data.text.toLowerCase();
    			// `params.term` should be the term that is used for searching
    			// `data.text` is the text that is displayed for the data object
    			if (text.indexOf(param) === 0) {
    				var modifiedData = $.extend({}, data, true);
    				// modifiedData.text += ' (matched)';

    				// You can return modified objects from here
    				// This includes matching the `children` how you want in nested data sets
    				return modifiedData;
    			}

    			// Return `null` if the term should not be displayed
    			return null;
    		}
    		// custom matcher end

    		$('.dukandar').select2({
    			matcher: matchCustom
    		});
    		$('.select2-selection').css('height', '40px');
    		$('.dukandar').one('select2:open', function(e) {
    			$('input.select2-search__field').prop('placeholder', 'Search dukandar');
    		});
    	});
    </script>
    <!-- datatable with custom searching  -->
    <!-- <script>
    	$(document).ready(function() {
    		var table = $('#example0').DataTable({
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
    		});

    		// Add search input fields outside the table
    		$('#example0').before('<div class="my-2 form-inline" id="searchInputs"></div>');
    		var columnsToSearch = [1, 4]; // Specify the columns to add search fields to
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
    		$('#example0_filter').hide()

    	});
    </script> -->
    <!-- datatable  -->
    <script>
    	$(function() {
    		$('table').DataTable({
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
    		});
    		$.fn.dataTable.ext.search.push(
    			function(settings, searchData, index, rowData, counter) {
    				var match = false;
    				var searchTerm = settings.oPreviousSearch.sSearch.toLowerCase();
    				searchData.forEach(function(item, index) {
    					if (item.toLowerCase().startsWith(searchTerm)) {
    						match = true;
    					}
    				});
    				return match;
    			}
    		);
    	});
    </script>
    <!-- dashborad chart -->

    <script>
    	$(function() {
    		<?php
			$month = null;
			$net_total_js = null;
			$total_paid = null;
			$total_due = null;
			$total_expenses = null;
			if (isset($months)) {
				$month = json_encode($months);
				$net_total_js = json_encode($monthly_net_total);
				$total_paid = json_encode($monthly_total_paid);
				$total_due = json_encode($monthly_total_due);
				$total_expenses = json_encode($monthly_total_expenses ?? 'null');
			}
			?>
    		var labels = <?php echo $month; ?>;

    		var totalSalesData = <?php echo $net_total_js; ?>;
    		var totalPaid = <?php echo $total_paid; ?>;
    		var totalDue = <?php echo $total_due; ?>;
    		var totalExpenses = <?php echo $total_expenses; ?>;

    		let months = ['January', 'February', 'March', 'April', 'May', 'June', 'July',
    			'August', 'September', 'October', 'November', 'December'
    		];

    		for (let i = 0; i < labels.length; i++) {
    			let index = labels[i];
    			labels[i] = months[index - 1];
    		}
    		if (totalExpenses != 'null') {
    			var areaChartData = {
    				labels: labels,
    				datasets: [{
    						label: 'Total Sales',
    						backgroundColor: '#17a2b8',
    						borderColor: '#17a2b8',
    						pointRadius: false,
    						pointColor: '#17a2b8',
    						pointStrokeColor: '#17a2b8',
    						pointHighlightFill: '#fff',
    						pointHighlightStroke: '#17a2b8',
    						data: totalSalesData
    					},
    					{
    						label: 'Total Paid',
    						backgroundColor: '#28a745',
    						borderColor: '#28a745',
    						pointRadius: false,
    						pointColor: '#28a745',
    						pointStrokeColor: '#28a745',
    						pointHighlightFill: '#fff',
    						pointHighlightStroke: '#28a745',
    						data: totalPaid
    					},
    					{
    						label: 'Total Due',
    						backgroundColor: '#dc3545',
    						borderColor: '#dc3545',
    						pointRadius: false,
    						pointColor: '#dc3545',
    						pointStrokeColor: '#dc3545',
    						pointHighlightFill: '#fff',
    						pointHighlightStroke: '#dc3545',
    						data: totalDue
    					},

    					{
    						label: 'Total Expenses',
    						backgroundColor: '#007bff',
    						borderColor: '#007bff',
    						pointRadius: false,
    						pointColor: '#007bff',
    						pointStrokeColor: '#007bff',
    						pointHighlightFill: '#fff',
    						pointHighlightStroke: '#007bff',
    						data: totalExpenses
    					},
    				],

    			}
    		} else {
    			var areaChartData = {
    				labels: labels,
    				datasets: [{
    						label: 'Total Sales',
    						backgroundColor: '#17a2b8',
    						borderColor: '#17a2b8',
    						pointRadius: false,
    						pointColor: '#17a2b8',
    						pointStrokeColor: '#17a2b8',
    						pointHighlightFill: '#fff',
    						pointHighlightStroke: '#17a2b8',
    						data: totalSalesData
    					},
    					{
    						label: 'Total Paid',
    						backgroundColor: '#28a745',
    						borderColor: '#28a745',
    						pointRadius: false,
    						pointColor: '#28a745',
    						pointStrokeColor: '#28a745',
    						pointHighlightFill: '#fff',
    						pointHighlightStroke: '#28a745',
    						data: totalPaid
    					},
    					{
    						label: 'Total Due',
    						backgroundColor: '#dc3545',
    						borderColor: '#dc3545',
    						pointRadius: false,
    						pointColor: '#dc3545',
    						pointStrokeColor: '#dc3545',
    						pointHighlightFill: '#fff',
    						pointHighlightStroke: '#dc3545',
    						data: totalDue
    					},
    				],

    			}
    		}
    		var areaChartOptions = {
    			maintainAspectRatio: false,
    			responsive: true,
    			legend: {
    				display: false
    			},
    			scales: {
    				xAxes: [{
    					gridLines: {
    						display: false,
    					}
    				}],
    				yAxes: [{
    					gridLines: {
    						display: false,
    					}
    				}]
    			}
    		}
    		//-------------
    		//- BAR CHART -
    		//-------------
    		var barChartCanvas = $('#barChart').get(0).getContext('2d')
    		var barChartData = $.extend(true, {}, areaChartData)
    		var temp0 = areaChartData.datasets[0]
    		// var temp1 = areaChartData.datasets[1]
    		barChartData.datasets[0] = temp0
    		// barChartData.datasets[1] = temp0

    		var barChartOptions = {
    			responsive: true,
    			maintainAspectRatio: false,
    			datasetFill: false
    		}

    		new Chart(barChartCanvas, {
    			type: 'bar',
    			data: barChartData,
    			options: barChartOptions
    		})
    	});
    </script>
    </body>

    </html>
