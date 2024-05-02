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
    <script>
    	$(function() {
    		// $("#example1").DataTable({
    		// 	"responsive": true,
    		// 	"lengthChange": false,
    		// 	"autoWidth": false,
    		// 	"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    		// }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    		$('#example1').DataTable({
    			"paging": true,
    			"lengthChange": false,
    			"searching": true,
    			"ordering": true,
    			"info": true,
    			"autoWidth": false,
    			"responsive": true,
    		});
    	});
    </script>
	<!-- dashborad chart -->
	
	<script>
	
	$(function() {
		// Get context with jQuery - using jQuery's .get() method.
		<?php 
			$month = null;
			$net_total_js = null;
			if(isset($months)){
				$month = json_encode($months);
				$net_total_js = json_encode($monthly_net_total);
			} 
		?>
		var labels = <?php echo $month;?>;
		var data = <?php echo $net_total_js;?>;
		let months = ['January', 'February', 'March', 'April', 'May', 'June', 'July',
						'august','september','october','november','december'];
		for(let i = 0 ; i<labels.length;i++){
			let index = labels[i];
			labels[i] = months[index-1];
		}
		var areaChartData = {
			// labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July',
			// 			'august','september','october','november','december'],
			labels: labels,
			datasets: [{
					label: 'Total Sales',
					backgroundColor: 'rgba(60,141,188,0.9)',
					borderColor: 'rgba(60,141,188,0.8)',
					pointRadius: false,
					pointColor: '#3b8bba',
					pointStrokeColor: 'rgba(60,141,188,1)',
					pointHighlightFill: '#fff',
					pointHighlightStroke: 'rgba(60,141,188,1)',
					data: data
				},
				
			]
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
