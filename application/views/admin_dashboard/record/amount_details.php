<div class="card-body">
    <?php if ($details) : ?>
        <p>Vendor ID: RTA-<?= $details[0]->vendor_id; ?></p>
    <?php
    endif; ?>

    <?php
    $total_due_amount = 0;
    foreach ($details as $record) {
        $total_due_amount += $record->due_amount;
    }
    ?>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="paid_amount">Due Amount:</label>
                <input type="text" class="form-control" id="due_amount" name="due_amount" value="<?= $total_due_amount ?>" readonly>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
				<?php if($total_due_amount > 0):?>
                <label for="pay_amount">Pay Amount:</label>
                <input type="text" class="form-control" id="pay_amount" name="pay_amount">
                <?php endif;?>
				<input type="hidden" name="vendor_id" value="<?= $details[0]->vendor_id; ?>">
                <input type="hidden" name="order_id" value="<?= $details[0]->order_id; ?>">
                <input type="hidden" name="paid_amount_percentage" id="paid_amount_percentage">
            </div>
        </div>
    </div>
</div>
<?php if((int)$total_due_amount > 0):?>
<div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>
<?php endif;?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var Details = <?php echo json_encode($details); ?>;

        var dueAmountInput = $("#due_amount");
        var paidAmountInput = $("#pay_amount");

        $('#vendor_payment_form').on('change', '#pay_amount', function() {
            var dueAmount = parseFloat(dueAmountInput.val());
            var paidAmount = parseFloat(paidAmountInput.val());
            var paidAmountPercentage = (paidAmount / dueAmount) * 100;
            $("#paid_amount_percentage").val(paidAmountPercentage);

            // Details.forEach(function(order) {
            //     let dueAmountEachOrder = order.due_amount;
            //     let calculateDueAmount = dueAmountEachOrder - paidAmountPercentage;
            //     $("#finalDueAmount").val(calculateDueAmount);
            //     let paidAmountEachOrder = order.paid_amount;
            //     let calculatePaidAmount = parseFloat(paidAmountEachOrder) + parseFloat(paidAmountPercentage);
            //     $("#finalPaidAmount").val(calculatePaidAmount);
            // });

        });
    });
</script>
