<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Payment Invoice</title>

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

        .invoice-box table tr td:nth-child(2), .invoice-box table tr td:nth-child(3) {
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

        .invoice-box table tr.total td:nth-child(2) {
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
        <?php if ($payment_details) : ?>
            <table cellpadding="0" cellspacing="0">
                <tr class="top">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td class="title">
                                    <img src="<?php echo BASE_URL . 'assets/images/logo.jpg'; ?>" style="width: 100%; max-width: 110px" />
                                </td>
                                <td>

                                Dukandar ID#: RTA-<?= $payment_details->id ?><br />
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
                                    <?= $payment_details->business_name ?><br />
                                    <?= $payment_details->phone_no ?><br />
                                    <?= $payment_details->address ?><br />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table>

                <tr class="heading">
                    <td>Dukandar ID</td>
                    <td>Dukandar Name</td>
                    <td>Total Amount</td>
                </tr>

                <tr class="item">
                    <td>RTA-<?= $payment_details->id ?></td>
                    <td><?= $payment_details->business_name?></td>
                    <td><?= $payment_details->net_total?></td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td>Paid Amount: <?= $payment_details->total_paid_amount?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><strong>Total Due Amount: <?= $payment_details->total_due_amount?></strong></td>
                </tr>
            </table>
        <?php else : ?>
            <p>No payment details found for this vendor.</p>
        <?php endif; ?>
    </div>

</body>

</html>