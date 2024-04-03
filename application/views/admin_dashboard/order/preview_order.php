<?php require_once(APPPATH . 'views/admin_dashboard/inc/header.php'); ?>
<?php require_once(APPPATH . 'views/admin_dashboard/inc/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Preview Order</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Book Order</li>
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
                        <div class="card-body">
                            <h2 class="mb-3">Order Information</h2>
                            <?php if ($order_details) : ?>
                                <p>Order ID: <?= $order_details[0]->order_id; ?></p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="mb-3">Product Details</h4>
                                        <?php
                                        $totalAmount = 0;
                                        foreach ($order_details as $order) :
                                            $product = get_order_product_details($order->product_id);
                                            $totalAmount += $order->total;
                                        ?>
                                            <p>Product Name: <?= $product->product_name ?></p>
                                            <p>Total Price: <?= $order->total ?></p>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="mb-3">Vendor Information</h4>
                                        <p><?= $order_details[0]->business_name ?></p>
                                        <p><?= $order_details[0]->phone_no ?></p>
                                        <p><?= $order_details[0]->address ?></p><br>
                                    </div>
                                </div>

                            <?php
                            endif; ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <p>Sub Total: <?= $totalAmount ?></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <a href="<?= BASE_URL ?>order/share_pdf/<?= $order_details[0]->order_id; ?>" class="btn btn-success mt-4">Share via Whatsapp</a>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
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
    let BASE_URL = "<?php echo BASE_URL; ?>";
</script>