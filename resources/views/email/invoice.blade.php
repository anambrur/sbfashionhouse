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
            max-width: 750px !important;
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
    </style>
</head>
<body bgcolor="#f5f5f5" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
<?php
$sm_get_site_logo = url(SM::sm_get_the_src(SM::sm_get_site_logo(), 300, 63));
$site_name = SM::get_setting_value('site_name');
$orderUser = $order->user;

$orderId = SM::orderNumberFormat($order);
if (count($orderUser) > 0) {
    $flname = $orderUser->firstname . " " . $orderUser->lastname;
    $name = trim($flname != '') ? $flname : $orderUser->username;
}
?>
<center>
    <table bgcolor="#f5f5f5" style="background: #f5f5f5; max-width: 650px" class="container"
           align="center" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td align="left" valign="top">
            @if(isset($isWithExtraInfo) && $isWithExtraInfo ==1)
                <!-- start invoice extra -->
                    <table bgcolor="#1d2d5d" style="background: #1d2d5d; padding: 15px 40px;" class="container"
                           border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="left" valign="middle">
                                <?php
                                $footer_logo = SM::smGetThemeOption("footer_logo", "");
                                ?>
                                <a href="#">
                                    <img src="{!! url( SM::sm_get_the_src($footer_logo, 300, 63 )) !!}"
                                         alt="{{ $site_name }}">
                                </a>
                            </td>

                            <td align="right" valign="middle">
                                <img src="{!! asset('images/header-right-img.png') !!}" alt="">
                            </td>
                        </tr>
                    </table>

                    <table bgcolor="#f5f5f5" style="background: #f5f5f5; padding: 40px 40px;" class="container"
                           border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="left" valign="middle">
                                @if(count($orderUser)>0)
                                    <p style="font-size: 16px; color: #f38925; margin:0 0 10px;">Hi Mr {{ $name }},</p>
                                @endif
                                <h1 style="font-weight: 500; font-size: 24px; color: #1d2d5d; line-height: 27px; margin-top: 0;">
                                    Your Order Invoice id # {{ $orderId }} is <?php
                                    if ($order->order_status == 1) {
                                        echo 'Completed.';
                                    } else if ($order->order_status == 2) {
                                        echo 'Processing.';
                                    } else if ($order->order_status == 3) {
                                        echo 'Pending.';
                                    } else {
                                        echo 'Cancelled.';
                                    }
                                    ?>
                                </h1>
                                <p style="font-size: 15px;
                                    color: #777777;
                                    margin: 0;
                                    text-align: justify;
                                    font-family: Raleway;
                                    line-height: 24px;">
                                    {!! $mailMessage !!}
                                </p>
                                <p style="font-size: 14px; color: #777777; margin: 0;">
                                    Thanks
                                </p>
                            </td>
                        </tr>
                    </table>
                    <!-- end invoice extra -->
                @endif

                <table width="100%" border="0" cellpadding="0" bgcolor="#f9fdff" cellspacing="0"
                       style="width: 100%;padding: 30px 0 0 0 ;">
                    <tr>
                        <td align="left" valign="top" width="80%" style="padding-bottom: 30px; padding-left: 28px;"
                            class="single-table-pert column">
                            @if(count($orderUser)>0)
                                <?php
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
                                <a href="{{ url('/') }}">
                                    <img src="{!! $sm_get_site_logo !!}" alt="{{ $site_name }}">
                                </a>
                                <h4 style=" font-size: 18px; font-weight: 400; color: #1d2d5d; margin-bottom: 5px; padding-top: 0px; margin-top: 13px;">
                                    Invoice To :
                                </h4>
                                <h3 style="font-size: 24px; font-weight: 600; line-height: 36px; color: #1d2d5d; margin-bottom: 4px; margin-top: 0;">
                                    {{ $name }}</h3>
                                <p style="font-size: 16px; font-weight: 400; color: #605f5f; line-height: 26px; margin:0;">
                                    <span class="width8" style="display: inline-block;">Address </span>:
                                    {!!  $address !!}</p>
                                <p style="font-size: 16px; font-weight: 400; color: #605f5f; line-height: 26px; margin: 0;">
                                    <span class="width8" style="display: inline-block;">Phone </span>:
                                    {{ $orderUser->mobile }}</p>
                                <p style="font-size: 16px; font-weight: 400; color: #605f5f; line-height: 26px; margin:0;">
                                    <span class="width8" style="display: inline-block;">Email </span>:
                                    <a style="color: #f68c26;"
                                       href="mailto:{{ $order->contact_email }}">{{ $order->contact_email }}</a></p>
                            @endif
                        </td>
                        <td align="left" valign="top" width="20%" style="padding-bottom: 30px;"
                            class="single-table-pert column">
                            <h1 class="column-heading-bg" style="  font-size: 26px;
                                    padding: 9px 82px;
                                    margin-bottom: 31px;
                                    text-align: center;
                                    color: #FFFFFF;
                                    text-transform: uppercase;
                                    background-image: url(<?php echo asset('images/invoice.jpg');?>);
                                    background-repeat: no-repeat;">
                                invoice
                            </h1>
                            <p class="text-left"
                               style="font-size: 16px; font-weight: 500; color: #605f5f; line-height: 18px; padding-left: 30px; text-align: left">
                                Invoice ID No : {{ $orderId }}
                            </p>
                            <p class="text-left"
                               style="font-size: 16px; margin-right: 38px; font-weight: 500; color: #605f5f; padding-left: 30px; line-height: 18px; text-align: left">
                                Date :
                                {{ date('d-m-Y', strtotime($order->created_at)) }}
                            </p>
                            <p class="text-left"
                               style="font-size: 16px; font-weight: 500; color: #605f5f; line-height: 18px; padding-left: 30px; text-align: left">
                                Order Status : <span style="color: #f68c26;"><?php
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
                           style="width: 100%; background: #f9fdff;">
                        <tr>
                            <th style="font-size: 15px;
                                text-align: left;
                                padding: 20px 0 20px 28px;
                                text-transform: uppercase;
                                line-height: 21px;
                                font-weight: 500;
                                background: #1d2d5d;
                                color: #ffffff;">
                                DESCRIPTION
                            </th>
                            <th style="font-size: 15px;
                                text-align: left;
                                padding: 20px 0 20px 28px;
                                text-transform: uppercase;
                                line-height: 21px;
                                font-weight: 500;
                                background: #1d2d5d;
                                color: #ffffff;">
                                IMAGE
                            </th>
                            <th style="font-size: 15px;
                                text-align: center;
                                padding: 20px 0 20px 0px;
                                text-transform: uppercase;
                                line-height: 21px;
                                font-weight: 500;
                                background: #1d2d5d;
                                color: #ffffff;">
                                QUANTITY
                            </th>
                            <th style="font-size: 15px;
                                text-align: center;
                                padding: 20px 0 20px 0px;
                                text-transform: uppercase;
                                line-height: 21px;
                                font-weight: 500;
                                background: #1d2d5d;
                                color: #ffffff;">
                                AMOUNT
                            </th>
                            <th style="font-size: 15px;
                                text-align: left;
                                padding: 20px 0px 20px 0px;
                                text-transform: uppercase;
                                line-height: 21px;
                                font-weight: 500;
                                background: #1d2d5d;
                                color: #ffffff;">
                                total price
                            </th>
                        </tr>

                        <?php
                        $orderTotal = [];
                        ?>
                        @if(count($order->detail)>0)
                            @foreach($order->detail as $detail)
                                <?php

                                $title = $detail->product->title;
                                $price = $detail->product_price;
                                $total = $detail->product_qty * $price;
                                $orderTotal[] = $total;

                                ?>
                                <tr style="border-bottom: 1px solid #dddddd;">
                                    <td style="width: 25%;  padding: 18px 0 18px 28px; border-bottom: 1px solid #dddddd;"
                                        valign="top">
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
                                    <td style="width: 20%;  padding: 18px 0 18px 28px; border-bottom: 1px solid #dddddd;"
                                        valign="top">
                                        <img src="{{ url(SM::sm_get_the_src($detail->product_image, 100, 122)) }}"
                                             alt="{{ $title }}">

                                    </td>
                                    <td style="width: 13%; border-bottom: 1px solid #dddddd;" valign="middle"
                                        align="center">
                                        <p style="font-size: 18px; font-weight: 600; color: #1d2d5d; line-height: 28px; margin-bottom: 0;">
                                            {{ $detail->product_qty }}</p>
                                    </td>
                                    <td style="width: 13%; border-bottom: 1px solid #dddddd;" valign="middle"
                                        align="center">
                                        <p style="font-size: 18px; font-weight: 600; color: #1d2d5d; line-height: 28px; margin-bottom: 0;">
                                            {{ SM::currency_price_value($price) }}</p>
                                    </td>
                                    <td style="width: 13%; border-bottom: 1px solid #dddddd;" valign="middle"
                                        align="center">
                                        <p style="font-size: 18px; font-weight: 600; color: #1d2d5d; line-height: 28px; margin-bottom: 0;">
                                            {{ SM::currency_price_value($total) }}</p>
                                    </td>
                                </tr>
                            @endforeach

                        @endif

                    </table>
                @endif
                <?php
                $invoice_signature = SM::smGetThemeOption("invoice_signature");
                $invoice_approved_by_name = SM::smGetThemeOption("invoice_approved_by_name", "nptl author");
                $invoice_approved_by_designation = SM::smGetThemeOption("invoice_approved_by_designation", "Director of Development");
                $src = ($invoice_signature != '') ? SM::sm_get_the_src($invoice_signature) : "images/signature.png";

                ?>
                <table width="100%" bgcolor="#f9fdff" border="0" cellpadding="0" cellspacing="0"
                       style="width: 100%; background: #f9fdff;" class="table-responsive">
                    <tr>
                        <td valign="middle" class="column" align="left"
                            style="padding-left: 27px; padding-bottom: 20px;">
                            <p style="font-size: 14px; color: #605f5f; margin-bottom: 0; font-weight: 500;">Amount in
                                Words : <span style="color: #f68c26;">{{ title_case(SM::sm_convert_number_to_words($order->grand_total)) }}
                                    {{ SM::get_setting_value('currency') }} only.</span></p>
                            <p style="font-size: 14px; color: #605f5f; margin-bottom: 0; font-weight: 500;">Payment
                                Status : <span style="color: #f68c26;"><?php
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
                                    Status : <span style="color: #f68c26;">{{ SM::currency_price_value($due) }}</span></p>
                                <a href="{{ url("dashboard/orders/pay/$order->id") }}"
                                   style="display: none; color: #FFFFFF; background: #f68c26; padding: 6px 20px; border-radius: 20px;">Pay
                                    Your Due</a>
                            @endif
                            <?php
                        $payment_method = SM::get_payment_method_by_id($order->payment_method_id);
                        ?>
                        <label style="font-weight: 700; color: #1d2d5d"> Payment Method </label>:<span><?php echo $payment_method->title?></span>
                        <br>
                        <?php
                         
                        if ($order->payment_method_id != 3) {
                            $payment_details = json_decode($order->payment_details);
                            foreach ($payment_details as $key => $value) {
                                if ($key == 'card_number' || $key == 'card_type' || $key == 'pay_status' || $key == 'bank_txn') {
                                    $key_field = str_replace("_", " ", $key);
                                    echo '<label style="font-weight: 700; color: #1d2d5d">' . ucfirst($key_field) . ': </label> <span>' . $value . '</span><br>';
                                }
                            }
                        }
                        ?>
                        </td>
                        <td valign="middle" class="column no-padding" align="left"
                            style=" padding-top: 0px; padding-bottom: 20px; background: #f5fbfd; padding-left: 130px;">

                            <p style="font-size: 16px; color: #1d2d5d; margin-bottom: 0; border-bottom: 1px solid #dddddd; font-weight: 600; padding: 5px 20px 5px 27px;">
                                Sub Total : <span
                                        style="text-align: right; float: right">{{ SM::currency_price_value($order->sub_total) }}</span>
                            </p>

                            @if($order->tax>0)
                                <p style="font-size: 16px; color: #1d2d5d; margin-bottom: 0; border-bottom: 1px solid #dddddd;  font-weight: 600; padding: 5px 20px 5px 27px;">
                                    Tax + Vat : <span
                                            style="text-align: right; float: right">{{SM::currency_price_value($order->tax)}}</span>
                                </p>
                            @endif
                            @if($order->discount>0)

                                <p style="font-size: 16px; color: #1d2d5d; margin-bottom: 0; font-weight: 600; padding: 5px 20px 10px 27px;">
                                    Discount :<span
                                            style="text-align: right; float: right">-{{ SM::currency_price_value($order->discount)}}</span>
                                </p>
                            @endif
                             @if($order->shipping_method_charge>0)
                             <p style="font-size: 16px; color: #1d2d5d; margin-bottom: 0; font-weight: 600; padding: 5px 30px 10px 27px;">
                                    Delivery Charge :<span
                                            style="text-align: right; float: right"> -{{ SM::currency_price_value($order->shipping_method_charge)}}</span>
                                </p> 
                                @endif
                                
                            @if($order->coupon_amount>0)
                                <p style="font-size: 16px; color: #1d2d5d; margin-bottom: 0; font-weight: 600; padding: 5px 30px 10px 27px;">
                                    Coupon :<span
                                            style="text-align: right; float: right"> -{{ SM::currency_price_value($order->coupon_amount)}}</span>
                                </p>
                            @endif
                            <p style="min-width: 205px; font-size: 16px; color: #FFFFFF; margin-bottom: 0; font-weight: 600; padding: 9px 20px 10px 27px; background-image: url(<?php echo asset('images/total-bar.png');?>);
                                    background-repeat: no-repeat; background-size: cover;
                                    ">Total<span
                                        style="text-align: right; float: right;">{{ SM::currency_price_value($order->grand_total)}}</span>

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
                            style="width: 40%; padding: 0px 0 30px;">
                            <p><img src="{{ url($src) }}" alt="{{ $invoice_approved_by_name }}"></p>
                            <h2 style="font-size: 18px; font-weight: 700; margin-bottom: 5px; color: #4d4d4f; text-transform: uppercase">
                                {{ $invoice_approved_by_name }}
                            </h2>
                            <h3 style="font-size: 16px; font-weight: 700; color: #1d2d5d; margin: 0;">
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
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="width: 100%;"
                       class="table-responsive">
                    <tbody>
                    <tr bgcolor="#1d2d5d">
                        <!--<td class="single-table-pert" style="font-size: 16px; font-weight: 600; color: #fefefe; line-height: 26px; padding: 20px 0; text-align: center;" valign="middle">M : +01753 656542-->
                        <!--</td>-->
                        <td valign="middle" class="single-table-pert1 column"
                            style="font-size: 16px; font-weight: 500; color: #fefefe; line-height: 26px; padding: 20px 0 20px 20px; text-align: left;"
                            valign="middle">E : <a style="color: #f68c26;" href="mailto:{{ $email }}">{{ $email }}</a>
                        </td>
                        <td valign="middle" class="single-table-pert column"
                            style="font-size: 16px; font-weight: 500; color: #fefefe; line-height: 26px; padding: 20px 0; text-align: center;"
                            valign="middle">A : {{ $address }}
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