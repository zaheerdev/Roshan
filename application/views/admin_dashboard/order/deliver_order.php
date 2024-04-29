<?php require_once(APPPATH . 'views/admin_dashboard/inc/header.php'); ?>
<?php require_once(APPPATH . 'views/admin_dashboard/inc/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Deliver Order</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Deliver Order</li>
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
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Deliver Order</h3>
                        </div>
                        <!-- /.card-header -->

                        <!-- search form -->
                        <div class="card-body">
                            <form id="search_form" action="#" method="post">
                                <div class="form-group">
                                    <label>Order ID</label>
                                    <div class="row">
                                        <div class="col-md-6 pb-3">
                                            <input type="search" class="form-control" id="order_id" name="order_id" placeholder="Enter Order ID">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="submit" class="btn btn-primary" value="Search">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <form action="<?= BASE_URL ?>order/save_deliver_order" method="post" id="deliver_order_form">
                            <div id="order_details"></div>
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

<script>
    $(document).ready(function() {

        $('#search_form').submit(function(e) {
            e.preventDefault();
            var order_id = $('#order_id').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo BASE_URL; ?>order/get_order_details',
                data: {
                    order_id: order_id
                },
                success: function(response) {
                    $('#order_details').html(response);
                }
            });
        });

        // Initialize Toastr
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Function to trigger a toast message
        function showToast(message, type) {
            toastr[type](message);
        }

    });
</script>

<?php if ($this->session->flashdata('toast_message')) : ?>
    <script>
        $(document).ready(function() {
            var message = "<?php echo $this->session->flashdata('toast_message'); ?>";
            showToast(message, 'success');
        });

        function showToast(message, type) {
            toastr[type](message);
        }
    </script>
<?php endif; ?>