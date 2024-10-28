<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Doodle Digital</title>

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
            max-width: 650px !important;
            margin: 0 auto !important; /* makes it centered */
            clear: both !important;
        }

        /* This should also be a block element, so that it will fill 100% of the .container */
        .content {
            padding: 15px;
            max-width: 650px;
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

        @media only screen and (max-width: 480px) {
            .column {
                width: 100%;
                display: block;
                text-align: center;
                padding: 0 !important;
                padding-bottom: 30px !important;
            }

            .offer-img {
                width: 80%;
            }
        }
    </style>
</head>
<?php
$footer_logo = SM::smGetThemeOption( "footer_logo", "" );
$siteName = SM::get_setting_value( "site_name" );
$mobile = SM::get_setting_value( 'mobile' );
$email = SM::get_setting_value( 'email' );
$address = SM::get_setting_value( 'address' );
$country = SM::get_setting_value( 'country' );
?>
<body bgcolor="#f5f5f5" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
<center>
    <table bgcolor="#f5f5f5" style="background: #f5f5f5;" class="container"
           align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="left" valign="top">
                <table bgcolor="#f5f5f5"
                       style="background-image: url({!! asset('images/offer-template-bg.jpg') !!});
                         background-repeat: no-repeat;
                         -moz-background-size: cover;
                         width: 100%;
                           padding: 60px 0 226px;
                          background-position: center center;"
                       class="container"
                       border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td align="center" valign="middle" style="padding-bottom: 50px;">
                            <a href="#">
                                <img src="{!! url(SM::sm_get_the_src( $footer_logo, 193, 78 ))  !!}"
                                     alt="{!! $siteName !!}">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="middle" style="padding-bottom: 25px;">
                            <img src="{!! url(SM::sm_get_the_src( $info->image ))  !!}" alt="offer type">
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="middle" style="padding-bottom: 20px;">
                            <img class="offer-img" src="{!! asset('images/offer.png') !!}" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="middle">
                            <p style="background-image: url({!! asset('images/parcen-offer-bg.png') !!});
                            background-repeat: no-repeat;
                            font-size: 14px;
                            font-weight: 500;
                            color: #ffffff;
                            text-transform: uppercase;
                            padding: 5px 0;
                            margin-bottom: 25px;
                            font-family: 'Arial',sans-serif;
                             background-position:center center;">
                                {{ $info->discount_title }}
                            </p>
                            <h2 style="font-size: 24px; color: #ffffff;
                            margin-bottom: 12px;
                            padding: 0 20px;
                            font-family: 'Arial',sans-serif; text-transform: uppercase;">{{ $info->available_title }}
                            </h2>
                            <h3 style="color: #ffffff; font-size: 16px; line-height: 28px; text-transform: uppercase; font-weight: 400;">
                                {!! $info->message !!}
                            </h3>
                            <a href=" {{ $info->btn_link }}" style="    font-size: 16px;
                                line-height: 28px;
                                color: #ffffff;
                                background: #f68c26;
                                display: inline-block;
                                padding: 6px 32px;
                                font-weight: 600;
                                border-radius: 6px;">
                                {{ $info->btn_title }}
                            </a>
                        </td>
                    </tr>
                </table>

                <table bgcolor="#f5f5f5"
                       style="background: #f5f5f5; padding: 40px 0; border-bottom: 1px solid #dddddd;"
                       class="container"
                       border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td align="left" valign="middle" style="padding-left: 20px;" class="column">
                            <img style="margin-right: 12px;" src="{!! asset('images/icon.png') !!}" alt="">
                            <p style="display: inline-block; font-size: 16px; margin-bottom: 0; color: #1d2d5d; font-weight: 500;">
                                {{$mobile}}
                                <span style="display: block; font-size: 12px; margin-bottom: 0; color: #969696;">Mon-Fri 9am-6pm</span>
                            </p>

                        </td>
                        <td align="left" valign="middle" class="column">
                            <img style="margin-right: 12px;" src="{!! asset('images/icon2.png') !!}" alt="">
                            <p style="display: inline-block; font-size: 16px; color: #1d2d5d; margin-bottom: 0; font-weight: 500;">
                                {{$email}}
                                <span style="display: block; font-size: 12px; color: #969696;">Online support</span>
                            </p>

                        </td>
                        <td align="left" valign="middle" class="column">
                            <img style="margin-right: 12px;" src="{!! asset('images/icon3.png') !!}" alt="">
                            <p style="display: inline-block; font-size: 16px; color: #1d2d5d; margin-bottom: 0; font-weight: 500;">
                                {{$address}}
                                <span style="display: block; font-size: 12px; color: #969696;">{{$country}}</span>
                            </p>

                        </td>
                    </tr>
                </table>
                <table bgcolor="#f5f5f5" style="background: #f5f5f5; padding: 30px 0; border-bottom: 1px solid #dddddd;"
                       class="container"
                       border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td align="center" valign="middle">
                            @empty(!SM::smGetThemeOption("social_facebook"))
                                <a href="{{SM::smGetThemeOption("social_facebook")}}" style="padding: 0 7px; display: inline-block">
                                    <img src="{!! asset('images/face-icon.png') !!}" alt="">
                                </a>
                            @endempty
                            @empty(!SM::smGetThemeOption("social_twitter"))
                                <a href="{{SM::smGetThemeOption("social_twitter")}}" style="padding:0 7px; display: inline-block">
                                    <img src="{!! asset('images/twitter-icon.png') !!}" alt="">
                                </a>
                            @endempty
                            @empty(!SM::smGetThemeOption("social_pinterest"))
                                <a href="{{SM::smGetThemeOption("social_pinterest")}}" style="padding: 0 7px; display: inline-block">
                                    <img src="{!! asset('images/pinterest-icon.png') !!}" alt="">
                                </a>
                            @endempty
                            @empty(!SM::smGetThemeOption("social_instagram"))
                                <a href="{{SM::smGetThemeOption("social_instagram")}}" style="padding: 0 7px; display: inline-block">
                                    <img src="{!! asset('images/instragram-icon.png') !!}" alt="">
                                </a>
                            @endempty
                            @empty(!SM::smGetThemeOption("social_youtube"))
                                <a href="{{SM::smGetThemeOption("social_youtube")}}" style="padding: 0 7px; display: inline-block">
                                    <img src="{!! asset('images/youtube-icon.png') !!}" alt="">
                                </a>
                            @endempty
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="middle" style="padding-top: 20px; padding-bottom: 40px;">
                            <a href="{{ url('/') }}" style="padding:0 10px 0 0; border-right: 1px solid #dddddd;">
                                View in browser
                            </a>
                            <a href="{!! url('career') !!}" style="padding:0 10px; border-right: 1px solid #dddddd;">
                                Careers
                            </a>
                            <a href="{!! url('terms-and-conditions') !!}" style="padding:0 0 0 10px;">
                                Privacy Statement
                            </a>
                        </td>
                    </tr>
                    {{--<tr>--}}
                        {{--<td align="center" valign="middle" style="padding: 0 20px;">--}}
                            {{--<p style="font-size: 16px; color: #969696; padding-bottom: 20px;">--}}
                                {{--To set your contact preferences visit the Promotional Communications Manager. If you--}}
                                {{--would prefer not to receive future promotional emails from Doodle and its family of--}}
                                {{--companies, please click here to unsubscribe.--}}
                            {{--</p>--}}
                            {{--<p style="font-size: 16px; color: #969696;">--}}
                                {{--730/3 West Kazipara, 7th Floor, Mirpur, Dhaka 1216, Bangladesh--}}
                            {{--</p>--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                </table>
            </td>
        </tr>
    </table>
</center>

</body>
</html>