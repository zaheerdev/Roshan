<div class="card-body">
    <h2>Order Information</h2><br>
    <?php if ($order_details) : ?>
        <div class="row">
            <div class="col-md-6">
                <h4 class="mb-3">Product Details</h4>
                <?php
                foreach ($order_details as $order) : ?>
                    <p>Product Name: <?= get_order_product_details($order->product_id)->product_name ?></p>
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

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="form-group">
                <label for="paid_amount">Sub Total:</label>
                <input type="text" class="form-control" id="total" name="total" readonly>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="paid_amount">Discount:</label>
                <input type="text" class="form-control" id="discount" name="discount">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="paid_amount">Net Total:</label>
                <input type="text" class="form-control" id="net_total" name="net_total" readonly>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="paid_amount">Paid Amount:</label>
                <input type="text" class="form-control" id="paid_amount" name="paid_amount">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="paid_amount">Due Amount:</label>
                <input type="text" class="form-control" id="due_amount" name="due_amount" readonly>
            </div>
        </div>
    </div>
   
</div>

<div class="card-footer">
    <button type="submit" class="btn btn-primary">Deliver Order</button>
    <button type="button" id="cancel-button" class="btn btn-default">Cancel</button>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

        var orderDetails = <?php echo json_encode($order_details); ?>;
        var totalInput = $("#total");
        var paidAmountInput = $("#paid_amount");
        var discountInput = $("#discount");
        var netTotalInput = $("#net_total");
        var dueAmountInput = $("#due_amount");

        function calculateTotal() {
            var totalPrice = 0;
            $.each(orderDetails, function(index, order) {
                totalPrice += parseFloat(order.total);
            });
            return totalPrice;
        }

        function updateTotals() {
            var total = calculateTotal();
            var discountPercentage = parseFloat(discountInput.val()) || 0;
            var discountAmount = (total * discountPercentage) / 100;
            var netTotal = total - discountAmount;
            var paidAmount = parseFloat(paidAmountInput.val()) || 0;
            var dueAmount = netTotal - paidAmount;
            totalInput.val(total.toFixed(2));
            netTotalInput.val(netTotal.toFixed(2));
            dueAmountInput.val(dueAmount.toFixed(2));
        }

        paidAmountInput.on("input", updateTotals);
        discountInput.on("input", updateTotals);

        updateTotals();
    });
</script>

