<?php require_once(APPPATH . 'views/admin_dashboard/inc/header.php'); ?>
<?php require_once(APPPATH . 'views/admin_dashboard/inc/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Book Order</h1>
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
                        <div class="card-header">
                            <h3 class="card-title">Book Order</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="book_order_form">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Vendor</label>
                                    <select class="form-control">
                                        <option>Select Vendor</option>
                                        <option>option 2</option>
                                        <option>option 3</option>
                                        <option>option 4</option>
                                        <option>option 5</option>
                                    </select>
                                </div>

                                <!-- Your HTML structure using AdminLTE and Bootstrap -->

                                <table id="items-table" class="table">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" class="form-control"></td>
                                            <td><input type="number" class="form-control"></td>
                                            <td>
                                                <input type="number" class="form-control quantity">
                                            </td>
                                            <td class="total">
                                                <input type="number" class="form-control" value="0" readonly>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="text-right">
                                    <button id="add-row" class="btn btn-primary">Add Row</button>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Book Order</button>
                                <button type="button" id="cancel-button" class="btn btn-default">Cancel</button>
                            </div>
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
        $('#add-row').click(function(event) {
            event.preventDefault();
            var lastRow = $('#items-table tbody tr:last');
            var newRow = lastRow.clone();
            newRow.find('input').val('');
            lastRow.after(newRow);
        });

        $('#items-table').on('change', 'input.quantity', function() {
            var quantity = $(this).val();
            var price = $(this).closest('tr').find('td:nth-child(2) input').val();
            var total = quantity * price;
            $(this).closest('tr').find('.total input').val(total);
        });

        $('#cancel-button').click(function() {
            $('#book_order_form')[0].reset();
            $('#items-table tbody tr:not(:first)').remove();
        });
    });
</script>