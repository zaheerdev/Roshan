<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Receipt</title>

    <style>
        .header {
            display: flex;
            display: -webkit-box;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .row {
            display: flex;
            display: -webkit-box;
        }

        .logo {
            width: 100px;
            height: auto;
        }

        .contact-info {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="header">
            <img src="<?php echo BASE_URL.'assets/images/logo.jpg'; ?>" alt="Logo" class="logo" style="float: left;">
            <div class="contact-info">
                <p>Roshan tea company plot no# 5, old sabzi mandi<br> bhalwal, district sargodha</p>
                <p>+923077713000</p>
            </div>
        </div>
        <div class="content">
            <h2>Order Information</h2>
            <?php if ($order_details) : ?>
                <p>Order ID: <?= $order_details[0]->order_id; ?></p>
                <div class="row">
                    <div style="width: 50%;">
                        <h4>Product Details</h4>
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
                    <div style="width: 50%;">
                        <h4>Vendor Information</h4>
                        <p><?= $order_details[0]->business_name ?></p>
                        <p><?= $order_details[0]->phone_no ?></p>
                        <p><?= $order_details[0]->address ?></p><br>
                    </div>
                </div>
            <?php
            endif; ?>
            <div>
                <p>Sub Total: <?= $totalAmount ?></p>
            </div>
        </div>
    </div>
</body>

</html>
