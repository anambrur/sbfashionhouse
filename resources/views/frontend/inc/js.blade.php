<?php
$max_price = (int) \App\Model\Common\Product::max('regular_price');
$min_price = (int) \App\Model\Common\Product::min('regular_price');
?>
<!-- Script-->
<script type="text/javascript" src="{{ asset('frontend/lib/jquery/jquery-1.11.2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/lib/jquery/jquery_validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/lib/owl.carousel/owl.carousel.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/lib/bootstrap/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/lib/select2/js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/lib/jquery.bxslider/jquery.bxslider.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('frontend/lib/jquery.countdown/jquery.countdown.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/lib/jquery.elevatezoom.js') }}"></script>
<!-- COUNTDOWN -->
<script type="text/javascript" src="{{ asset('frontend/lib/countdown/jquery.plugin.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/lib/countdown/jquery.countdown.js') }}"></script>
<!-- ./COUNTDOWN -->
<script type="text/javascript" src="{{ asset('frontend/lib/jquery-ui/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/jquery.actual.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/lib/fancyBox/jquery.fancybox.js') }}"></script>

<script type="text/javascript" src="{{ asset('frontend/js/theme-script.js') }}"></script>
<!-- JQUERY VALIDATE -->
<script src="{{ asset('nptl-admin/js/plugin/jquery-validate/jquery.validate.min.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> --}}

{{-- dashboard --}}
<script type="text/javascript" src="{{ asset('frontend/dashboard/dashboard.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/dashboard/state.js') }}"></script>
{{-- sweetalert --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

{{-- sweetalert --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


{{-- toastr --}}
<script type="text/javascript" src="{{ asset('frontend/toastr/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/nptl.js') }}"></script>

{!! Toastr::message() !!}
<?php
SM::smGetSystemFrontEndJs([
    //    "sm-validation",
    ////	"sm-validation.min",
    //    "main",
    //"main.min",
    //    "doodle_digital",
    //	"doodle_digital.min",
]);
?>
<script type="text/javascript">
    // -----------currencyFormat--------
    var currency = "<?php echo SM::get_setting_value('currency'); ?>";

    function currencyFormat(num) {
        return currency + ' ' + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }

    // ----------toastr alert message--------------
    $(function() {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "1500",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        // ---------------coupon_check---------
        $('body').on('click', '.apply_coupon', function(event) {
            var coupon_code = $('#coupon_code').val();
            var sub_total_price = $('#sub_total_price').val();
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{ URL::route('coupon_check') }}',
                data: {
                    coupon_code: coupon_code,
                    sub_total_price: sub_total_price
                },
                success: function(data) {
                    if (data.check_coupon == 1) {
                        $('#coupon_amount').html(currencyFormat(data.coupon_amount))
                        $('#grand_total').html(currencyFormat(data.grand_total))
                        $('.coupon_amount').val(data.coupon_amount)
                        $('.grand_total').val(data.grand_total)
                        $('.coupon_code').val(data.coupon_code)
                        toastr.success(data.message, data.title);
                    } else {
                        toastr.error(data.message, data.title);
                    }
                }
            });
        });
        // ---------------ajax add to cart---------
        $('body').on('click', '.addToCart', function(event) {

            var cart = $('.cart_icon');
            var imgtodrag = $(this).parent().siblings('a').find("img").eq(0);
            // var imgtodrag = jQuery(this).parents('.product-grid').children('.product-image').find("img").eq(0);
            // console.log($(this).parent().siblings('a').find("img").eq(0));
            //  alert('fdsf');
            if (imgtodrag.length > 0) {
                var imgclone = imgtodrag.clone()
                    .offset({
                        top: imgtodrag.offset().top,
                        left: imgtodrag.offset().left
                    })
                    .css({
                        'opacity': '0.5',
                        'position': 'absolute',
                        'height': '150px',
                        'width': '150px',
                        'z-index': '100'
                    })
                    .appendTo($('body'))
                    .animate({
                        'top': cart.offset().top + 10,
                        'left': cart.offset().left + 10,
                        'width': 75,
                        'height': 75
                    }, 1000, 'easeInOutExpo');
                setTimeout(function() {
                    cart.effect("shake", {
                        times: 2
                    }, 200);
                }, 1500);
                imgclone.animate({
                    'width': 0,
                    'height': 0
                }, function() {
                    $(this).detach()
                });
                $('.nav-pills > li > a').hover(function() {
                    $(this).tab('show');
                });
            }



            var product_id = $(this).data("product_id");
            var regular_price = $(this).data("regular_price");
            var sale_price = $(this).data("sale_price");
            var qty = $('.productCartQty').val();
            var product_attribute_color = $("input[name='product_attribute_color']:checked").val();
            var colorname = $("input[name='product_attribute_color']:checked").data("colorname");
            var product_attribute_size = $("input[name='product_attribute_size']:checked").val();
            var sizename = $("input[name='product_attribute_size']:checked").data("sizename");
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{ URL::route('add_to_cart') }}',
                //                data: {product_id: product_id, regular_price: regular_price, sale_price: sale_price},
                data: {
                    product_id: product_id,
                    regular_price: regular_price,
                    sale_price: sale_price,
                    qty: qty,
                    product_attribute_size: product_attribute_size,
                    sizename: sizename,
                    product_attribute_color: product_attribute_color,
                    colorname: colorname
                },
                success: function(data) {
                    if (data.exists_cart == 1) {
                        toastr.error(data.error_message, data.error_title);
                    } else {
                        $('.header_cart_html').html(data.header_cart_html);
                        $('.right_cart_html').html(data.right_cart_html);
                        $('.cart_icon').html(data.cart_icon);
                        $('.cart_icon_popup').html(data.cart_icon_pop);
                        $('.popup_top_total').html(data.popup_top_total);
                        $('.sub_total').html(data.sub_total);
                        //                        $('[data-product_id="' + product_id + '"]').parent('.add-to-cart').html('<button data-product_id="' + product_id + '" class="addToCart" title="Product is added">Product is added</button>');
                        toastr.success(data.message, data.title);
                    }
                }
            });
        });
        //        $('body').on('click', '.addToCart', function (event) {
        //            var product_id = $(this).data("product_id");
        //            var regular_price = $(this).data("regular_price");
        //            var sale_price = $(this).data("sale_price");
        ////            var product_attribute_color = $("input[name='product_attribute_color']:checked").val();
        ////            var colorname = $("input[name='product_attribute_color']:checked").data("colorname");
        ////            var product_attribute_size = $("input[name='product_attribute_size']:checked").val();
        ////            var sizename = $("input[name='product_attribute_size']:checked").data("sizename");
        //            $.ajax({
        //                type: 'get',
        //                dataType: "json",
        //                url: '{{ URL::route('add_to_cart') }}',
        //                 data: {product_id: product_id, regular_price: regular_price, sale_price: sale_price,
        ////                data: {product_id: product_id, regular_price: regular_price, sale_price: sale_price,product_attribute_size: product_attribute_size,sizename: sizename,product_attribute_color: product_attribute_color,colorname: colorname},
        //                success: function (data) {
        //                    if (data.exists_cart == 1) {
        //                        toastr.error(data.error_message, data.error_title);
        //                    } else {
        //                        $('.header_cart_html').html(data.header_cart_html);
        //                        $('.cart_icon').html(data.cart_icon);
        //                        $('[data-product_id="' + product_id + '"]').parent('.add-to-cart').html('<button data-product_id="' + product_id + '" class="addToCart" title="Product is added">Product is added</button>');
        //                        toastr.success(data.message, data.title);
        //                    }
        //                }
        //            });
        //            });


        // -----------updateCart------
        $('body').on('click', '.updateToCart', function(event) {
            var row_id = $(this).data("row_id");
            var qty = $(this).data("qty");
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{ URL::route('update_to_cart') }}',
                data: {
                    row_id: row_id,
                    qty: qty
                },
                success: function(data) {

                    if (data.exists_cart == 1) {
                        toastr.error(data.message, data.title);
                    } else {
                        $('.header_cart_html').html(data.header_cart_html);
                        $('.cart_icon').html(data.cart_icon);
                        toastr.success(data.message, data.title);
                    }
                    //                    toastr.success(data.message, data.title);
                }
            });
        });
        $('body').on('click', '.incDetail', function(event) {
            event.preventDefault();
            var x;
            var row_id = $(this).data("row_id");
            x = $('#' + row_id).val();
            //            $(this).siblings('input').attr('value', ++x);


            var qty = x;
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{ URL::route('update_to_cart') }}',
                data: {
                    row_id: row_id,
                    qty: qty
                },
                success: function(data) {

                    if (data.exists_cart == 1) {
                        toastr.error(data.message, data.title);
                    } else {
                        $('.cart_icon').html(data.cart_icon);
                        $('.cart_table').html(data.cart_table);

                        toastr.success(data.message, data.title);
                    }
                }
            });
        });
        $('body').on('click', '.decDetail', function(event) {
            event.preventDefault();
            var x;
            var row_id = $(this).data("row_id");
            x = $('#' + row_id).val();
            if (x > 1) {

                var row_id = $(this).data("row_id");
                var qty = x;
                $.ajax({
                    type: 'get',
                    dataType: "json",
                    url: '{{ URL::route('update_to_cart') }}',
                    data: {
                        row_id: row_id,
                        qty: qty
                    },
                    success: function(data) {
                        if (data.exists_cart == 1) {
                            toastr.error(data.message, data.title);
                        } else {
                            $('.cart_icon').html(data.cart_icon);
                            $('.cart_table').html(data.cart_table);
                            toastr.success(data.message, data.title);
                        }
                    }
                });
            }
        });
        $('body').on('click', '.inc', function(event) {
            event.preventDefault();
            var x;
            var row_id = $(this).data("row_id");
            x = $('#' + row_id).val();
            //            $(this).siblings('input').attr('value', ++x);
            var qty = ++x;
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{ URL::route('update_to_cart') }}',
                data: {
                    row_id: row_id,
                    qty: qty
                },
                success: function(data) {
                    if (data.exists_cart == 1) {
                        toastr.error(data.message, data.title);
                    } else {
                        $('.header_cart_html').html(data.header_cart_html);
                        $('.cart_icon').html(data.cart_icon);
                        $('.cart_table').html(data.cart_table);
                        toastr.success(data.message, data.title);
                    }
                }
            });
        });
        $('body').on('click', '.dec', function(event) {
            event.preventDefault();
            var x;
            var row_id = $(this).data("row_id");
            x = $('#' + row_id).val();
            if (x > 1) {

                var row_id = $(this).data("row_id");
                var qty = --x;
                $.ajax({
                    type: 'get',
                    dataType: "json",
                    url: '{{ URL::route('update_to_cart') }}',
                    data: {
                        row_id: row_id,
                        qty: qty
                    },
                    success: function(data) {
                        if (data.exists_cart == 1) {
                            toastr.error(data.message, data.title);
                        } else {
                            $('.header_cart_html').html(data.header_cart_html);
                            $('.cart_icon').html(data.cart_icon);
                            $('.cart_table').html(data.cart_table);
                            toastr.success(data.message, data.title);
                        }
                    }
                });
            }
        });

        // -----------removeToCart-------------
        $('body').on('click', '.removeToCart', function(event) {
            var product_id = $(this).data("product_id");
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{ URL::route('remove_to_cart') }}',
                data: {
                    product_id: product_id
                },
                success: function(data) {
                    $('.cart_table').html(data.cart_table);
                    $('.header_cart_html').html(data.header_cart_html);
                    $('.right_cart_html').html(data.right_cart_html);
                    $('.cart_icon').html(data.cart_icon);
                    $('.popup_top_total').html(data.popup_top_total);
                    $('.sub_total').html(data.sub_total);
                    $('[data-product_id="' + product_id + '"]').parents('.removeCartTrLi')
                        .addClass('hidden');
                    $('.cart_count').text(data.cart_count);
                    toastr.error(data.message, data.title);
                    // $('.compare_data').text(data.compare_count);
                    // toastr.success(data.message, data.title);

                }
            });
        });
        // ---------------ajax add to compare---------
        $('body').on('click', '.addToCompare', function(event) {
            var product_id = $(this).data("product_id");
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{ URL::route('add_to_compare') }}',
                data: {
                    product_id: product_id
                },
                success: function(data) {
                    if (data.exists_compare == 1) {
                        toastr.error(data.error_message, data.error_title);
                    } else {
                        $('[data-product_id="' + product_id + '"]').parent('.quick-view')
                            .find('.addToCompare').addClass('red');
                        $('.compare_data').text(data.compare_count);
                        toastr.success(data.message, data.title);
                    }
                }
            });
        });
        $('body').on('click', '.removeToCompare', function(event) {
            var product_id = $(this).data("product_id");
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{ URL::route('remove_to_compare') }}',
                data: {
                    product_id: product_id
                },
                success: function(data) {
                    // $('.header_cart_html').html(data.header_cart_html);
                    // $('.cart_icon').html(data.cart_icon);
                    $('[data-product_id="' + product_id + '"]').parents('.compareRow')
                        .addClass('hidden');
                    $('.cart_compare').text(data.cart_compare);
                    toastr.error(data.message, data.title);
                    // $('.compare_data').text(data.compare_count);
                    // toastr.success(data.message, data.title);

                }
            });
        });
        // ---------------ajax add to Wishlist ---------
        $('body').on('click', '.addToWishlist', function(event) {
            var product_id = $(this).data("product_id");
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{ URL::route('add_to_wishlist') }}',
                data: {
                    product_id: product_id
                },
                success: function(data) {
                    if (data.check_wishlist == 1) {
                        toastr.error(data.error_message, data.error_title);
                    } else {
                        $('[data-product_id="' + product_id + '"]').parent('.quick-view')
                            .find('.addToWishlist').addClass('red');
                        // $('.compare_data').text(data.compare_count);
                        toastr.success(data.message, data.title);
                    }

                }
            });
        });
        $('body').on('click', '.removeToWishlist', function(event) {
            var wshlist_id = $(this).data("wshlist_id");
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{ URL::route('remove_to_wishlist') }}',
                data: {
                    wshlist_id: wshlist_id
                },
                success: function(data) {
                    $('[data-wshlist_id="' + wshlist_id + '"]').parents('.wishlistRow')
                        .addClass('hidden');
                    toastr.error(data.message, data.title);
                }
            });
        });
        // ----------review-------------
        // jQuery(document).ready(function () {
        //     jQuery('.ajaxReviewSubmit').click(function (e) {
        $('body').on('click', '.ajaxReviewSubmit', function(e) {
            e.preventDefault();
            $.ajax({
                method: 'get',
                dataType: "json",
                url: "{{ url('add_to_review') }}",
                data: {
                    product_id: $('.product_id').val(),
                    rating: $('.ajaxReviewForm input:checked').val(),
                    description: $('.description').val(),
                },
                success: function(data) {
                    if (data.check_reviewAuth == 1) {
                        toastr.error(data.error_message, data.error_title);
                    } else {
                        toastr.success(data.message, data.title);
                        $(".ajaxReviewForm")[0].reset();
                    }
                    //                    toastr.success(data.message, data.title);

                }
            });
        });
        // });

        $('body').on('click', '.removeToReview', function(event) {
            var review_id = $(this).data("review_id");
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{ URL::route('remove_to_review') }}',
                data: {
                    review_id: review_id
                },
                success: function(data) {
                    $('[data-review_id="' + review_id + '"]').parents('.reviewRow')
                        .addClass('hidden');
                    toastr.error(data.message, data.title);
                }
            });
        });
        // ---------------------------

    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        url = '{{ URL::route('product_search_data') }}';
        filter_data(url);
        $('body').on('click', '.pagination a', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            filter_data(url)
            //            getArticles(url);
            //            window.history.pushState("", "", url);
        });
        //            function getArticles(url) {
        //
        //            $.ajax({
        //            url: url
        //            }).done(function (data) {
        //            $('#ajax_view_product_list').html(data);
        //            }).fail(function () {
        //            alert('Articles could not be loaded.');
        //            });
        //            }

        // $('.orderByPrice').change(function (obj) {
        //     var orderByPrice = $(this).val();
        // });
        // filter_data();

        function filter_data(url) {
            $('#ajax_view_product_list').html('<div id="loading"></div>');
            var action = 'fetch_data';
            var minimum_price = $('#hidden_minimum_price').val();
            var maximum_price = $('#hidden_maximum_price').val();
            var brand = get_filter('brand');
            var category = get_filter('category');
            var size = get_filter('size');
            var color = get_filter('color');
            var orderByPrice = $('.orderByPrice').val();
            var limitProduct = $('.limitProduct').val();
            $.ajax({
                //            url: '{{ URL::route('product_search_data') }}',
                url: url,
                cache: false,
                timeout: 2000,
                method: "get",
                data: {
                    action: action,
                    minimum_price: minimum_price,
                    maximum_price: maximum_price,
                    brand: brand,
                    category: category,
                    size: size,
                    color: color,
                    orderByPrice: orderByPrice,
                    limitProduct: limitProduct,
                },
                success: function(data) {
                    $('#ajax_view_product_list').html(data);
                    // $('#defaultProductView').css('display', 'none');
                }
            });
        }

        function get_filter(class_name) {
            var filter = [];
            $('.' + class_name + ':checked').each(function() {
                filter.push($(this).val());
            });
            return filter;
        }

        $('.common_selector').click(function() {
            url = '{{ URL::route('product_search_data') }}';
            filter_data(url);
        });
        if ($('.common_selector').length > 0) {
            $('.common_selector').on('change', function() {
                var orderByPrice = $('.orderByPrice').val();
                var limitProduct = $('.limitProduct').val();
                url = '{{ URL::route('product_search_data') }}';
                filter_data(url);
            });
        }
        $('.slider-range-price').slider({
            range: true,
            min: <?php echo isset($min_price) ? $min_price : 0; ?>,
            max: <?php echo isset($max_price) ? $max_price : 10; ?>,
            values: [<?php echo isset($min_price) ? $min_price : 0; ?>, <?php echo isset($max_price) ? $max_price : 10; ?>],
            step: 100,
            stop: function(event, ui) {
                $('.amount-range-price').html(ui.values[0] + ' - ' + ui.values[1]);
                $('#hidden_minimum_price').val(ui.values[0]);
                $('#hidden_maximum_price').val(ui.values[1]);
                url = '{{ URL::route('product_search_data') }}';
                filter_data(url);
            }
        });
    });


    function search_on_nptl_search() {
        var search_text = $("#search_text").val();

        var _token = $('#table_csrf_token').val();
        if (search_text.length > 0) {

            $.ajax({
                url: '<?php echo url('main_search'); ?>',
                type: 'post',
                data: {
                    search_text: search_text,
                    _token: _token
                },
                success: function(response) {
                    $('.search-html').html(response);
                    // $("#searchbtn").html('<i class="fa fa-search"></i>');
                },
                error: function(errors) {
                    var errorRes = errors.responseJSON.errors;
                    // console.log(errorRes);
                    $("#search-html").html('');
                }
            });
        } else {
            $("#search-html").html('Write Something');
        }
    }

    if ($("#main_search").length > 0) {
        $("#search_text").on("keyup", function() {
            search_on_nptl_search();
        });
        $("#search_text").on("change", function() {
            search_on_nptl_search();
        });
    }
    $('body').on('click', '.common_selector', function() {
        $(this).parents('.sub-cat').siblings('input').prop("checked", false);
    });
    $(document).ready(function(e) {
        $('.search-panel .dropdown-menu').find('a').click(function(e) {
            e.preventDefault();
            var param = $(this).attr("href").replace("#", "");
            var concept = $(this).text();
            $('.search-panel span#search_concept').text(concept);
            $('.input-group #search_param').val(param);
        });
    });
    //     $(".").hover(
    //  function() {
    //     $('.main-collaspe').collapse('show');
    //   }, function() {
    //     $('.main-collaspe').collapse('hide');
    //   }
    // );
    $(".custom-main-menu").mouseenter(function() {
        $(".main-collaspe").collapse('show');
    });
    $(".main-collaspe").mouseleave(function() {
        $(".main-collaspe").collapse('hide');
    });
</script>

<script>
    $(function() {

        $('.showButton').click(function() {

            $('#aitcg-control-panel').show();

        });

        $('.hideButton').click(function() {

            $('#aitcg-control-panel').hide();

        });

    });
</script>

@stack('script')
