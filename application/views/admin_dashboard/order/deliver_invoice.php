<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Delivered Invoice</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2), .invoice-box table tr td:nth-child(3), .invoice-box table tr td:nth-child(4) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(4) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="<?php echo BASE_URL . 'assets/images/logo.jpg'; ?>" style="width: 100%; max-width: 110px" />
                            </td>
                            <td>
                                Order ID#: <?= $order_details[0]->order_id; ?><br />
                                Dukandar ID#: RTA-<?= $order_details[0]->vendor_id; ?><br />
                                Created: <?php
                                            $currentDate = date("Y-m-d");
                                            $formattedDate = date("F j, Y", strtotime($currentDate));
                                            echo $formattedDate;
                                            ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                Roshan Tea Company <br />
                                Plot no# 5, old sabzi mandi<br />
                                Bhalwal, district sargodha
                            </td>
                            <td>
                                <?= $order_details[0]->business_name ?><br />
                                <?= $order_details[0]->phone_no ?><br />
                                <?= $order_details[0]->address ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table cellpadding="0" cellspacing="0">

            <tr class="heading">
                <td>Product Item</td>
                <td>Unit Price</td>
                <td>Quantity</td>
                <td>Total Price</td>
            </tr>

            <?php
            $totalAmount = 0;
            foreach ($order_details as $order) :
                $product = get_order_product_details($order->product_id);
                $totalAmount += $order->total;
            ?>
                <tr class="item">
                    <td><?= $product->product_name ?></td>
                    <td><?= $product->price ?></td>
                    <td><?= $order->order_quantity ?></td>
                    <td><?= $order->total ?></td>
                </tr>
            <?php endforeach; ?>

            <tr class="total">
                <td></td>
                <td></td>
                <td></td>
                <td>Sub Total: <?= $totalAmount ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>Discount: <?= $order_details[0]->discount ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>Net Total: <?= $order_details[0]->net_total ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>Paid Amount: <?= $order_details[0]->paid_amount ?></td>
            </tr>
            <tr class="total">
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <?php if ($order_details[0]->due_amount > 0) : ?>
                        Due Amount: <?= $order_details[0]->due_amount ?>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
