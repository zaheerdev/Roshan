<div class="card-body">
	<h2 class="mb-3">Order Information</h2>
	<?php if ($order_details) : ?>
		<p>Order ID: <?= $order_details[0]->order_id; ?></p>
		<input type="hidden" name="order_id" value="<?= $order_details[0]->order_id; ?>">
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
				<h4 class="mb-3">Dukandar Information</h4>
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
				<label for="paid_amount">Discount:
					
				</label>
				<select id="discount-type" class="form-control my-1" id="exampleFormControlSelect1">
					<option value="percentage">% Percentage</option>
					<option value="fixed-price">Fixed Price</option>
		
				</select>
				
				<input type="text" class="form-control" id="discount" name="discount" value="">
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
				<input type="text" class="form-control" id="paid_amount" name="paid_amount" value="" required>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="paid_amount">Due Amount:</label>
				<input type="text" class="form-control" id="due_amount" name="due_amount" value="" readonly>
			</div>
		</div>
	</div>

</div>

<div class="card-footer">
	<?php
	$order_id = $order_details[0]->order_id;
	if (is_order_delivered($order_id)) : ?>
		<button type="button" class="btn btn-danger" disabled>Delivered</button>
	<?php else : ?>
		<button type="submit" class="btn btn-primary">Deliver Order Now</button>
	<?php endif; ?>
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
		let discountType = $('#discount-type').find(':selected').val();
		$('#discount-type').on('change',function(){
	
			discountType = $(this).find(':selected').val();
			console.log(discountType);
			
			updateTotals();
		});
		
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
			if(discountType == 'percentage'){
				var discountAmount = (total * discountPercentage) / 100;
			}else if(discountType == 'fixed-price'){
				var discountAmount = discountInput.val();
			}
			
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
