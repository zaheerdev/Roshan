<?php require_once(APPPATH . 'views/admin_dashboard/inc/header.php'); ?>
<?php require_once(APPPATH . 'views/admin_dashboard/inc/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inventory</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Inventory</li>
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
                    <?php if ($this->session->flashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $this->session->flashdata('success'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Inventory</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="p-4" action="<?= BASE_URL . "inventory/save_inventory" ?>" method="post">
                            <div class="form-group w-sm-100 w-lg-50">
                                <label for="raw1">Raw Material1</label>
                                <input type="text" name="raw_material1" class="form-control" placeholder="Raw Material1">
                            </div>
                            <div class="form-group w-sm-100 w-lg-50">
                                <label for="raw1">Raw Material2</label>
                                <input type="text" name="raw_material2" class="form-control" placeholder="Raw Material2">
                            </div>
                            <div class="form-group w-sm-100 w-lg-50">
                                <label for="raw1">Raw Material3</label>
                                <input type="text" name="raw_material3" class="form-control" placeholder="Raw Material3">
                            </div>
                            <div class="form-group w-sm-100 w-lg-50">
                                <label for="raw1">Raw Material4</label>
                                <input type="text" name="raw_material4" class="form-control" placeholder="Raw Material4">
                            </div>
                            <div class="form-group w-sm-100 w-lg-50">
                                <label for="raw1">Raw Material5</label>
                                <input type="text" name="raw_material5" class="form-control" placeholder="Raw Material5">
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