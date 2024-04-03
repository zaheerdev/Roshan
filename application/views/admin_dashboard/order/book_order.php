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
                        <form id="book_order_form" action="#" method="post">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Vendor</label>
                                    <select class="form-control" name="vendor_id" required>
                                        <option value="">Select Vendor</option>
                                        <?php foreach ($vendors as $vendor) : ?>
                                            <option value="<?php echo $vendor['id']; ?>"><?php echo $vendor['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

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
                                            <td>
                                                <div class="form-group">
                                                    <select class="form-control" id="item_select" required>
                                                        <option value="">Select Item</option>
                                                        <?php foreach ($product_items as $item) : ?>
                                                            <option value="<?php echo $item['id']; ?>" data-price="<?php echo $item['price']; ?>">
                                                                <?php echo $item['product_name']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input type="text" class="form-control price_input" readonly>
                                                </div>
                                            </td>
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
    let BASE_URL = "<?php echo BASE_URL; ?>";
</script>
<script>
    $(document).ready(function() {

        $('#add-row').click(function(event) {
            event.preventDefault();
            var lastRow = $('#items-table tbody tr:last');
            var newRow = lastRow.clone();
            newRow.find('input').val('');
            newRow.find('.total input').val('0');
            lastRow.after(newRow);
        });

        $(document).on('change', '#item_select', function() {
            var selectedPrice = parseFloat($(this).find('option:selected').data('price'));
            $(this).closest('tr').find('.price_input').val(selectedPrice);
            var total = selectedPrice;
            $(this).closest('tr').find('.total input').val(total);
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

        // Submit form
        $('#book_order_form').submit(function(event) {
            event.preventDefault();

            var vendorId = $('select[name="vendor_id"]').val();
            var productItems = [];

            $('#items-table tbody tr').each(function() {
                var productId = $(this).find('td:nth-child(1) select').val();
                var quantityInput = $(this).find('td:nth-child(3) input');
                var quantity = quantityInput.val() ? parseInt(quantityInput.val()) : 1;
                var total = $(this).find('td:nth-child(4) input').val();
                productItems.push({
                    productId: productId,
                    quantity: quantity,
                    total: total
                });
            });

            var formData = {
                vendorId: vendorId,
                productItems: productItems
            };

            $.ajax({
                type: 'POST',
                url: 'save_order',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                success: function(response) {
                    var responseData = JSON.parse(response);
                    if (responseData.success) {
                        var orderId = responseData.order_id;
                        showToast(responseData.message, 'success');
                        setTimeout(function() {
                            window.location.href = BASE_URL + 'order/preview_order/' + orderId;
                        }, 1500);
                    } else {
                        showToast(responseData.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    showToast('Order booking failed!', 'error');
                }
            });
        });

    });
</script>