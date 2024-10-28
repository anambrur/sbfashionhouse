@push('style')
    <style>
        [hidden] {
            display: none !important;
        }

        .submitButton {
            border-top: 3px solid #ced4da;
            text-align: right;
            padding-top: 15px;
        }

        body[dir="ltr"] .breadcum-area {
            background-image: url("../images/bar_bg_en.jpg");
        }

        .container-style {
            width: 95%;
            margin: auto;
            display: block;
        }

        .container-margin {
            margin-top: 15px;
        }

        .breadcum-area {
            background-repeat: no-repeat;
            background-size: cover;
            background-color: #fff;
            padding: 20px;
            margin-bottom: 30px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: start;
            -ms-flex-pack: start;
            justify-content: flex-start;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
        }

        .breadcum-area .breadcum-inner h3 {

            color: #F0CA4D;
            text-transform: uppercase;
            margin-bottom: 0;
        }

        .breadcum-area .breadcum-inner .breadcrumb {
            display: inline-block;
            background-color: transparent;
            margin-bottom: 0;
            padding: 0;
        }

        .breadcum-area .breadcum-inner .breadcrumb .breadcrumb-item {

            display: inline-block;
        }

        .breadcum-area .breadcum-inner .breadcrumb .breadcrumb-item a {
            color: #5d5d60;
            text-decoration: none;
        }

        .breadcum-area .breadcum-inner .breadcrumb .breadcrumb-item a:hover {
            color: #F0CA4D;
        }

        .breadcum-area .breadcum-inner .breadcrumb .active {
            color: #F0CA4D;
        }

        .cart-area {
            display: block;
            min-height: 550px;
            margin-bottom: 40px;
        }

        .cart-area .cart-left {
            padding-left: 30px;
            padding-right: 30px;
        }

        .cart-area .cart-left form {
            display: block;
            width: 100%;
        }

        .checkout-area {
            display: block;
            min-height: 550px;
            margin-bottom: 40px;
        }

        .checkout-area .checkout-left .nav {
            position: relative;
            margin-bottom: 30px;
            background-color: #fff;
        }

        .checkout-area .checkout-left .nav .nav-item {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            position: relative;
            background-color: #fff;
            margin-right: 50px;
            z-index: 9;
        }

        .checkout-area .checkout-left .nav .nav-item .nav-link {
            font-weight: 500;
            color: #adb5bd;
            text-transform: uppercase;
            padding-left: 50px;
            width: 140px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
        }

        .checkout-area .checkout-left .nav .nav-item .nav-link::before {
            position: absolute;
            left: 10px;
            width: 30px;
            height: 30px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            background-color: #adb5bd;
            color: #fff;
            border-radius: 50px;
            z-index: 9;
        }

        .checkout-area .checkout-left .nav .nav-item .nav-link.active {
            font-weight: 500;
            background-color: transparent;
            color: #5d5d60;
        }

        .checkout-area .checkout-left .nav .nav-item .nav-link.active::before {
            background-color: #F0CA4D;
        }

        .checkout-area .checkout-left .nav .nav-item .nav-link.active-check {
            font-weight: 500;
            background-color: transparent;
            color: #5d5d60;
        }

        .checkout-area .checkout-left .nav .nav-item .nav-link.active-check::before {
            background-color: #F0CA4D;
            content: "\F00C" !important;
            font-family: FontAwesome;
            font-style: normal;
            font-weight: normal;
            text-decoration: inherit;
        }

        .checkout-area .checkout-left .nav .nav-item:first-child .nav-link::before {
            content: "1";
        }

        .checkout-area .checkout-left .nav .nav-item:nth-child(2) .nav-link::before {
            content: "2";
        }

        .checkout-area .checkout-left .nav .nav-item:nth-child(3) .nav-link::before {
            content: "3";
        }

        .checkout-area .checkout-left .nav .nav-item:last-child {
            margin-right: 0;
        }

        .checkout-area .checkout-left .nav .nav-item:last-child .nav-link::before {
            content: "4";
        }

        .checkout-area .checkout-left .nav::after {
            content: "";
            position: absolute;
            left: 0;
            top: 29px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            height: 1px;
            width: 98%;
            background-color: #ced4da;
            z-index: 1;
        }

        .checkout-area .checkout-left .tab-content .tab-pane .title, .checkout-area .checkout-left .tab-content .tab-pane .banner-single .panel .block p, .banner-single .panel .block .checkout-area .checkout-left .tab-content .tab-pane p {
            font-weight: 500;

        }

        .checkout-area .checkout-left .tab-content .tab-pane .heading {
            margin-bottom: 15px;
        }

        .heading hr {
            position: relative;
            margin: 0px;
        }

        .checkout-area .checkout-left .tab-content .tab-pane .heading h2 {

            margin-bottom: 10px;
        }

        .checkout-area .checkout-left .tab-content .tab-pane .list {
            margin-top: 15px;
            padding-left: 0;
            margin-bottom: 20px;
        }

        .checkout-area .checkout-left .tab-content .tab-pane .list li {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            list-style: none;
            margin-bottom: 10px;
        }

        .checkout-area .checkout-left .tab-content .tab-pane .list li input {
            margin-right: 10px;
        }

        .checkout-area .checkout-left .tab-content .tab-pane .list li label {

            font-weight: 500;
            margin-bottom: 0;
        }

        .checkout-area .checkout-left .tab-content .tab-pane .order-review form {
            display: block;
            width: 100%;
        }

        .checkout-area .checkout-left .tab-content .tab-pane .notes-summary-area .order-notes .form-control {
            height: 180px;
            margin-bottom: 15px;
        }

        .checkout-area .checkout-left .tab-content .tab-pane .notes-summary-area .order-summary .table td, .checkout-area .checkout-left .tab-content .tab-pane .notes-summary-area .order-summary .table th {
            border-top: none;
            border-bottom: 1px solid #ced4da;
        }

        .checkout-area .checkout-left .tab-content .tab-pane .notes-summary-area .order-summary .table .last {
            font-weight: 500;
        }

        /* Cart, Checkout and Order-detail Products ----------------
-------------------------*/
        .table .item .cart-thumb {
            float: left;
            width: 80px;
            height: 80px;
            display: block;
            overflow: hidden;
            border-radius: 0;
            border: 1px solid #ced4da;
            margin-right: 15px;
        }

        .table .item .cart-thumb .img-fluid {
            position: relative;
            top: 50%;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
        }

        .table .item .cart-product-detail .title, .table .item .cart-product-detail .banner-single .panel .block p, .banner-single .panel .block .table .item .cart-product-detail p {
            display: block;

            font-weight: 500;
            color: #5d5d60;
            text-decoration: none;
            margin-bottom: 15px;
        }

        .table .item .cart-product-detail .title:hover, .table .item .cart-product-detail .banner-single .panel .block p:hover, .banner-single .panel .block .table .item .cart-product-detail p:hover {
            color: #F0CA4D;
        }

        .table .item .cart-product-detail ul {
            padding-left: 0;
            margin-bottom: 0;
        }


        .table .item .cart-product-detail ul li span {
            display: inline-block;
            margin-left: 15px;
            color: #adb5bd;
        }

        .table .price span, .table .subtotal span {

            font-weight: 500;
        }

        .table .buttons {
            padding-bottom: 30px;
        }

        .Qty {

            font-weight: 700;
        }

        .Qty span {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            border: 1px solid #ced4da;
            width: 30px;
            height: 30px;
        }

        .Qty .input-group {
            -webkit-box-pack: end;
            -ms-flex-pack: end;
            justify-content: flex-end;
        }

        .Qty .input-group .input-group-btn {
            cursor: pointer;
        }

        .Qty .input-group .input-group-btn .fa {

            color: #5d5d60;
        }

        .Qty .input-group input {
            background-color: #f2f2f2;
            padding-left: 5px;
            padding-right: 5px;
            text-align: center;
            height: 30px;
            min-width: 30px;
            max-width: 40px;
        }

        /* Order Summary Cart and checkout page  ----------------
        ---------------------------------------------------------*/
        .order-summary-outer {
            padding: 15px;
            border: 1px solid #ced4da;
        }

        .order-summary-outer .order-summary .table {
            margin-bottom: 0;
        }

        .order-summary-outer .order-summary .table thead th {

            text-transform: uppercase;
            border-top: none;
            border-bottom: 3px solid #ced4da;
        }

        .order-summary-outer .order-summary .table tbody th {

            font-weight: 500;
            text-transform: uppercase;
        }

        .order-summary-outer .order-summary .table tbody .last {
            font-weight: 700;
        }

        .order-summary-outer .coupons {
            padding-top: 15px;
            padding-bottom: 15px;
            margin-bottom: 15px;
            border-top: 3px solid #ced4da;
            border-bottom: 3px solid #ced4da;
            padding-left: 10px;
            padding-right: 10px;
        }

        .order-summary-outer .coupons label {

            font-weight: 700;
            text-transform: uppercase;
        }

        /* Buttons ----------------
        -------------------------*/
        .btn {
            text-transform: uppercase;
        }

        .button {
            border-top: 3px solid #ced4da;
            text-align: right;
            padding-top: 15px;
        }

        /*---------------*/
        .different-address {
            font-size: 15px;
            color: #383636dd;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 21px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: -8px;
            bottom: 0;
            background-color: #a5a3a3;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 13px;
            width: 13px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #fa110d;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
@endpush