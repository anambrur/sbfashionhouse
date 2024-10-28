<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice Mail</title>

    <link href="https://fonts.googleapis.com/css?family=Raleway:300,300i,400,400i,500,500i,600,600i,700,700i,800"
          rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        table {
            border-collapse: collapse !important;
        }

        .itemTable {
            width: 760px;
            max-width: 760px;
        }

        * {
            margin: 0;
            padding: 0;
        }

        * {
            font-family: "Raleway", "Helvetica", 'Arial', sans-serif;
        }

        img {
            max-width: 100%;
        }

        .collapse {
            margin: 0;
            padding: 0;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100% !important;
            height: 100%;
        }

        a {
            color: #f68c26;
            text-decoration: none;
        }

        table {
            width: 100%;
        }

        .container table td.logo {
            padding: 15px;
        }

        .container table td.label {
            padding: 15px;
            padding-left: 0px;
        }

        table {
            width: 100%;
            clear: both !important;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: "Raleway", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
            line-height: 1.1;
            margin-bottom: 18px;
            color: #1d2d5d;
        }

        h1 {
            font-weight: 400;
            font-size: 24px;
        }

        h2 {
            font-size: 20px;
        }

        h3 {
            font-size: 16px;
        }

        h4 {
            font-size: 14px;
        }

        h5 {
            font-size: 12px;
        }

        .collapse {
            margin: 0 !important;
        }

        p, ul {
            margin-bottom: 10px;
            font-weight: normal;
            font-size: 16px;
            line-height: 27px;
            color: #969696;
        }

        p.last {
            margin-bottom: 0px;
        }

        ul li {
            margin-left: 5px;
            list-style-position: inside;
        }

        /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
        .container {
            max-width: 1000px !important;
            margin: 0 auto !important; /* makes it centered */
            clear: both !important;
        }

        /* This should also be a block element, so that it will fill 100% of the .container */
        .content {
            padding: 15px;
            max-width: 700px;
            margin: 0 auto;
            display: block;
        }

        /* Let's make sure tables in the content area are 100% wide */
        .content table {
            width: 100%;
        }

        .clearfix {
            display: block;
            clear: both;
        }

        .width8 {
            width: 80px;
        }

        @media only screen and (max-width: 480px) {
            .column {
                width: 100%;
                display: block;
                text-align: left;
                padding: 0 0 0 0px;
            !important;
                max-width: 700px;
                padding-bottom: 30px !important;
            }

            .no-padding {
                padding-left: 0px !important;
            }

            .offer-img {
                width: 80%;
            }

            .width100 {
                width: 100% !important;
            }

            .column-heading-bg {
                background-color: #1d2d5d !important;
                background-image: none !important;
            }

            .single-table-pert1 {
                padding-bottom: 0 !important;
            }

            .padding-left30 {
                padding-left: 30px !important;
            }

            .text-left {
                text-align: left !important;
                padding-left: 30px !important;
            }
        }

        .logo img {
            width: 500px;
            height: 78px;
        }
    </style>
</head>
<body bgcolor="#f5f5f5" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
<?php
$sm_get_site_logo = url(SM::sm_get_the_src(SM::sm_get_site_logo(), 300, 63));
$site_name = SM::get_setting_value('site_name');
$orderUser = $order->user;
$orderId = SM::orderNumberFormat($order);
?>
<center>
    <table bgcolor="#ffffff" style="background: #ffffff; padding-bottom: 0" class="container"
           align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="left" valign="top">

                <table width="100%" border="0" cellpadding="0" bgcolor="#f9fdff" cellspacing="0"
                       style="width: 100%;padding: 30px 0 0 0 ;">
                    <tr>
                        <td align="left" valign="top" width="80%" style="padding-bottom: 30px; padding-left: 28px;"
                            class="single-table-pert column">
                            {{--@if(count($orderUser)>0)--}}
                            @if(!empty($orderUser))
                                <?php
                                $flname = $orderUser->firstname . " " . $orderUser->lastname;
                                $name = trim($flname != '') ? $flname : $orderUser->username;
                                $address = "";
                                $address .= !empty($orderUser->street) ? $orderUser->street . ", " : "";
                                if (strlen($address) > 30) {
                                    $address .= '<br>';
                                }
                                $address .= !empty($orderUser->city) ? $orderUser->city . ", " : "";
                                $address .= !empty($orderUser->state) ? $orderUser->state . " - " : "";
                                $address .= !empty($orderUser->zip) ? $orderUser->zip . ", " : "";
                                $address .= $orderUser->country;
                                ?>
                                <p style="padding-bottom: 0; margin-bottom: 0;">
                                    <a href="{{ url('/') }}" class="logo"
                                       style="display:block; width: 300px !important; height: 63px; padding-bottom: 0; margin-bottom: 0; background-image: url(<?php echo $sm_get_site_logo;?>);
                                               background-repeat: no-repeat; background-color: #FFFFFF;">
                                        {{--<img style="width: 193px !important;" src="{!! $sm_get_site_logo !!}" alt="{{ $site_name }}">--}}


                                    </a>
                                </p>
                                <h4 style=" font-size: 18px; font-weight: 400; color: #1d2d5d; margin-bottom: 5px; padding-top: 0px;">
                                    Invoice To :
                                </h4>
                                <h3 style="font-size: 24px; font-weight: 600; line-height: 36px; color: #1d2d5d; margin-bottom: 4px;">
                                    {{ $name }}</h3>
                                <p style="font-size: 16px; font-weight: 400; color: #1d2d5d; line-height: 26px; margin-bottom: 0;">
                                    <span class="width8" style="font-weight: bold; color:#1d2d5d">Address </span>:
                                    <span style="position: relative; top: -13px; margin-top: -10px;"> {!!  $address !!}</span>
                                </p>
                                <p style="font-size: 16px; font-weight: 400; color: #1d2d5d; line-height: 26px; margin-bottom: 0;">
                                    <span class="width8" style="font-weight: bold; color:#1d2d5d">Phone </span>:
                                    {{ $orderUser->mobile }}</p>
                                <p style="font-size: 16px; font-weight: 400; color: #1d2d5d; line-height: 26px; margin-bottom: 10px;">
                                    <span class="width8" style="font-weight: bold; color:#1d2d5d">Email </span>:
                                    {{ $order->contact_email }}</p>
                            @endif
                        </td>
                        <td align="left" valign="top" style="padding-bottom: 30px; padding-right: 0px;"
                            class="single-table-pert column">
                            <h1 class="column-heading-bg" style="  font-size: 26px;
                                    padding: 9px 82px 9px 95px;
                                    margin-bottom: 31px;
                                    text-align: center;
                                    font-weight: 600;
                                    color: #FFFFFF;
                                    text-transform: uppercase;
                                    background-image: url(<?php echo asset('images/invoice.jpg');?>);
                                    background-repeat: no-repeat;">
                                invoice
                            </h1>
                            <p class="text-left"
                               style="font-size: 16px; font-weight: 500; color: #1d2d5d; line-height: 18px; margin-left: -15px; text-align: center">
                                <span style="color: #1d2d5d; font-weight: 700; ">Invoice ID No</span> : {{ $orderId }}
                            </p>
                            <p class="text-left"
                               style="font-size: 16px; margin-right: 38px; font-weight: 500; color: #1d2d5d; padding-left: 16px; line-height: 18px; text-align: left">
                                <span style='color: #1d2d5d; font-weight: 700'>Date :</span>
                                {{ date('d-m-Y', strtotime($order->created_at)) }}
                            </p>
                            <p class="text-left"
                               style="font-size: 16px; font-weight: 500; color: #1d2d5d; line-height: 18px; padding-left: 16px; text-align: left">
                                <span style="font-weight: 700">Order Status</span> : <span style="color: #f68c26;"><?php
                                    if ($order->order_status == 1) {
                                        echo 'Completed';
                                    } else if ($order->order_status == 2) {
                                        echo 'Processing';
                                    } else if ($order->order_status == 3) {
                                        echo 'Pending';
                                    } else {
                                        echo 'Cancel';
                                    }
                                    ?></span>
                            </p>

                        </td>
                    </tr>
                </table>
                <?php
                $order_detail = $order->detail;
                ?>
                @if(count($order_detail)>0)
                    <table class="table-product-info" width="100%" border="0" cellpadding="0" cellspacing="0"
                           style="width: 100%; border-bottom: 1px solid #dddddd; background: #f9fdff;">
                        <tr>
                            <th style="font-size: 16px;
                                text-align: left;
                                padding: 20px 0 20px 28px;
                                text-transform: uppercase;
                                line-height: 21px;
                                font-weight: 600;
                                background: #1d2d5d;
                                color: #ffffff;">
                                ITEM DESCRIPTION
                            </th>
                            <th style="font-size: 18px; text-align: left; padding: 15px 20px 15px 50px; text-transform: uppercase; line-height: 28px; font-weight: 500; background: #1d2d5d; color: #ffffff;">
                                Image
                            </th>
                            <th style="font-size: 16px;
                                text-align: center;
                                padding: 20px 0 20px 0px;
                                text-transform: uppercase;
                                line-height: 21px;
                                font-weight: 600;
                                background: #1d2d5d;
                                color: #ffffff;">
                                QUANTITY
                            </th>
                            <th style="font-size: 16px;
                                text-align: center;
                                padding: 20px 0 20px 0px;
                                text-transform: uppercase;
                                line-height: 21px;
                                font-weight: 600;
                                background: #1d2d5d;
                                color: #ffffff;">
                                AMOUNT
                            </th>
                            <th style="font-size: 16px;
                                text-align: left;
                                padding: 20px 0px 20px 0px;
                                text-transform: uppercase;
                                line-height: 21px;
                                font-weight: 600;
                                background: #1d2d5d;
                                color: #ffffff;">
                                total price
                            </th>
                        </tr>

                        <?php
                        $orderTotal = [];
                        ?>
                        @foreach($order->detail as $detail)
                            <?php

                            $title = $detail->product->title;
                            $price = $detail->product_price;
                            $total = $detail->product_qty * $price;
                            $orderTotal[] = $total;

                            ?>
                            <tr style="border-bottom: 1px solid #dddddd;">
                                <td style="width: 25%; padding: 18px 0 18px 50px;" valign="top">
                                    <h4 style="font-size: 16px; font-weight: 600; color: #1d2d5d; line-height: 28px; margin-bottom: 0;">
                                        {{ $title }}</h4>
                                    <?php
                                    if (!empty($detail->product_color)) {
                                    ?>
                                    <small>Color : {{ $detail->product_color}}</small>
                                    <br>
                                    <small>Size : {{ $detail->product_size}}</small>
                                    <?php } ?>

                                </td>
                                <td style="width: 20%; padding: 18px 0 18px 50px;" valign="top">
                                    <img src="{{ url(SM::sm_get_the_src($detail->product_image, 206, 251)) }}"
                                         alt="{{ $title }}">
                                </td>
                                <td style="width: 13%; border-bottom: 1px solid #dddddd;" valign="middle"
                                    align="center">
                                    <p style="font-size: 16px; font-weight: 600; color: #1d2d5d; line-height: 28px; margin-bottom: 0;">
                                        {{ $detail->product_qty }}</p>
                                </td>
                                <td style="width: 13%; border-bottom: 1px solid #dddddd;" valign="middle"
                                    align="center">
                                    <p style="font-size: 16px; font-weight: 600; color: #1d2d5d; line-height: 28px; margin-bottom: 0;">
                                        {{ SM::get_setting_value('currency') }} {{ number_format($price, 2) }}</p>
                                </td>
                                <td style="width: 13%; border-bottom: 1px solid #dddddd; padding-right: 30px;"
                                    valign="middle"
                                    align="right">
                                    <p style="font-size: 16px; font-weight: 600; color: #1d2d5d; line-height: 28px; margin-bottom: 0;">
                                        {{ SM::get_setting_value('currency') }} {{ number_format($total, 2) }}</p>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
                <?php
                $invoice_signature = SM::smGetThemeOption("invoice_signature");
                $invoice_approved_by_name = SM::smGetThemeOption("invoice_approved_by_name", "NPTL Author");
                $invoice_approved_by_designation = SM::smGetThemeOption("invoice_approved_by_designation", "Director of Development");
                $src = ($invoice_signature != '') ? SM::sm_get_the_src($invoice_signature) : "images/signature.png";
                ?>
                <table width="100%" bgcolor="#f9fdff" border="0" cellpadding="0" cellspacing="0"
                       style="width: 100%; background: #f9fdff;" class="table-responsive">
                    <tr>
                        <td valign="top" class="column" align="left"
                            style="padding-left: 27px; padding-bottom: 20px;">
                            <p style="font-size: 14px; color: #1d2d5d; margin-bottom: 0; font-weight: 500;"><span
                                        style="font-weight: 700">Amount in
                                Words</span> : <span style="color: #f68c26;">{{ title_case(SM::sm_convert_number_to_words($order->grand_total)) }}
                                    USD only.</span></p>
                            <p style="font-size: 14px; color: #1d2d5d; margin-bottom: 0; font-weight: 500;"><span
                                        style="font-weight: 700">Payment
                                Status</span> : <span style="color: #f68c26;"><?php
                                    if ($order->payment_status == 1) {
                                        echo 'Completed';
                                    } else if ($order->payment_status == 2) {
                                        echo 'Pending';
                                    } else {
                                        echo 'Cancel';
                                    }
                                    ?></span></p>
                            <?php
                            $due = $order->paid - $order->grand_total;
                            $dueSign = $due < 0 ? "-" : "+";
                            $dueSign = $due == 0 ? "" : $dueSign;
                            ?>
                            @if($due < 0)
                                <p style="font-size: 14px; color: #605f5f; margin-bottom: 10px; font-weight: 500;">Due
                                    Status : <span style="color: #f68c26;"><?php
                                        echo SM::get_setting_value('currency') . ' ' . number_format($due, 2);
                                        ?></span></p>
                                <a href="{{ url("dashboard/orders/pay/$order->id") }}"
                                   style="color: #FFFFFF; background: #f68c26; padding: 6px 20px; display: inline-block; border-radius: 20px;">Pay
                                    Your Due</a>
                            @endif
                        </td>
                        <td valign="middle" class="column no-padding" align="left"
                            style=" padding-top: 0px; padding-bottom: 20px; background: #f5fbfd; padding-left: 180px;">
                            <?php
                            $orderTotalValue = array_sum($orderTotal);
                            ?>
                            <p style="font-size: 16px; color: #1d2d5d; margin-bottom: 0; border-bottom: 1px solid #dddddd; font-weight: 600; padding: 5px 30px 5px 27px;">
                                Sub Total : <span
                                        style="text-align: right; float: right">{{ SM::get_setting_value('currency') }} {{ number_format($order->sub_total, 2) }}</span>
                            </p>
                            @if($order->tax>0)
                                <p style="font-size: 16px; color: #1d2d5d; margin-bottom: 0; border-bottom: 1px solid #dddddd;  font-weight: 600; padding: 5px 30px 5px 27px;">
                                    Tax + Vat : <span
                                            style="text-align: right; float: right">{{ SM::get_setting_value('currency') }} {{number_format($order->tax, 2)}}</span>
                                </p>
                            @endif
                            @if($order->discount>0)
                                <p style="font-size: 16px; color: #1d2d5d; margin-bottom: 0; font-weight: 600; padding: 5px 30px 10px 27px;">
                                    Discount :<span
                                            style="text-align: right; float: right">{{ SM::get_setting_value('currency') }} -{{ number_format($order->discount, 2)}}</span>
                                </p>
                            @endif
                            @if($order->coupon_amount>0)
                                <p style="font-size: 16px; color: #1d2d5d; margin-bottom: 0; font-weight: 600; padding: 5px 30px 10px 27px;">
                                    Coupon :<span
                                            style="text-align: right; float: right">{{ SM::get_setting_value('currency') }} -{{ number_format($order->coupon_amount, 2)}}</span>
                                </p>
                            @endif
                            <p style="font-size: 16px; color: #FFFFFF; margin-bottom: 0; font-weight: 600; padding: 7px 30px 12px 27px; background-image: url(<?php echo asset('images/total-bar.png');?>);
                                    background-repeat: no-repeat;
                                    ">Total Amount<span
                                        style="text-align: right; float: right;">{{ SM::get_setting_value('currency') }} {{ $order->grand_total }}</span>
                            </p>
                        </td>
                    </tr>
                </table>
                <table width="100%" bgcolor="#f9fdff" border="0" cellpadding="0" cellspacing="0"
                       style="width: 100%; background: #f9fdff;" class="table-responsive">
                    <tr>
                        <td style="width: 60%;" class="column">

                        </td>
                        <td valign="middle" class="width100 padding-left30" align="left"
                            style="width: 40%; padding: 20px 0 30px 40px;">
                            <p style="background-image: url(<?php echo url($src);?>);
                                    background-repeat: no-repeat; width: 240px; height: 50px;">
                                {{-- <img src="{{ url($src) }}" alt="{{ $invoice_approved_by_name }}">--}}
                            </p>
                            <h2 style="font-size: 18px; font-weight: 700; margin-bottom: 5px; color: #4d4d4f; text-transform: uppercase">
                                {{ $invoice_approved_by_name }}
                            </h2>
                            <h3 style="font-size: 16px; font-weight: 700; color: #1d2d5d;">
                                {{ $invoice_approved_by_designation }}
                            </h3>
                        </td>
                    </tr>
                </table>
                <?php
                $email = SM::get_setting_value('email');
                $address = SM::get_setting_value('address');
                $country = SM::get_setting_value('country');
                ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0"
                       style="width: 100%; padding-bottom: 0; margin-bottom: 0;"
                       class="table-responsive">
                    <tbody>
                    <tr bgcolor="#1d2d5d">
                        <!--<td class="single-table-pert" style="font-size: 16px; font-weight: 600; color: #fefefe; line-height: 26px; padding: 20px 0; text-align: center;" valign="middle">M : +01753 656542-->
                        <!--</td>-->
                        <td valign="middle" class="single-table-pert1 column"
                            style="font-size: 16px; font-weight: 600; color: #fefefe; line-height: 26px; padding: 20px 0 20px 28px; text-align: left;"
                            valign="middle"><img src="{!! url( "images/envelope_pdf.png" ) !!}"/> {{ $email }}
                        </td>
                        <td valign="middle" class="single-table-pert column"
                            style="font-size: 16px; font-weight: 600; color: #fefefe; line-height: 26px; padding: 20px 0; text-align: center;"
                            valign="middle"><img style="margin-top: 3px;"
                                                 src="{!! url( "images/address_pdf.png" ) !!}"/> {{ $address }}
                            , {{ $country }}
                        </td>
                    </tr>
                    </tbody>
                </table>


            </td>
        </tr>
    </table>
</center>


</body>
</html>