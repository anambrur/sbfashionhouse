@push('style')
<style>
    .sku-prop-content .sku-variable-size, .sku-prop-content .sku-variable-size, .sku-prop-content .sku-variable-size-selected {
        /* box-sizing: border-box; */
        display: inline-flex;
        /* align-items: center; */
        justify-content: center;
        /* cursor: pointer; */
        /* -webkit-user-select: none; */
        -moz-user-select: none;
        -ms-user-select: none;
        /* user-select: none; */
        /* font-size: 12px; */
        /* text-align: center; */
        /* overflow: hidden; */
        min-width: 68px;
        max-width: 388px;
        /* height: 32px; */
        padding-right: 8px;
        padding-left: 8px;
        /* margin-top: 8px; */
        margin-right: 8px;
        background: #fff;
        border: 1px solid #dadada;
        /* border-radius: 2px; */
    }
</style>

<style>
    input[type=radio] {
        border: 0px;
        width: 9%;
        height: 24px;
        margin-top: 4px;
        vertical-align: middle;
    }

    .check-box_inr_size {
        background: orange;
        color: #303837;
        border-radius: 5px;
        display: inline-flex;
        justify-content: center;
        -moz-user-select: none;
        -ms-user-select: none;
        min-width: 40px;
        max-width: 388px;
        padding-right: 8px;
        padding-left: 8px;
        margin-right: 8px;
        border: 1px solid #dadada;

    }

    .size.size_active {
        color: #fff;
        /*background: green;*/
    }

    .check-box_inr_color {
        background: orange;
        color: #303837;
        border-radius: 5px;
        display: inline-flex;
        justify-content: center;

        -moz-user-select: none;
        -ms-user-select: none;

        min-width: 68px;
        max-width: 388px;

        padding-right: 8px;
        padding-left: 8px;

        margin-right: 8px;
        border: 1px solid #dadada;

    }

    .color.color_active {
        color: #fff;
    }
</style>
@endpush
<p class="form-option-title">Available Options:</p>
<?php
$colors = SM::productAttributeColor($product->id);
?>
@if(count($colors)>0)
<div class="attributes">
    <div class="attribute-label">Color:</div>
    {!! Form::hidden('colorname',null, ['class'=>'colorname']) !!}
    <div class="attribute-list product_attribute_color">
        @foreach($colors as $cKey=> $color)
        <label for="color_{{$cKey}}" class="click_color">
            <div class="check-box_inr_color">
                <div class="color {!! $cKey==0 ? 'color_active': '' !!}">
                    <span class="value"><b>{{ $color->title }}  </b></span>
                    <input data-price="{{ $color->attribute_price }}" data-product_id="{{ $product->id }}"
                           data-color_id="{{ $color->color_id }}" data-colorname="{{ $color->title }}"
                           value="{{$color->color_id}}" {!! $cKey==0 ? 'checked': '' !!}
                           class="click_color hidden" id="color_{{$cKey}}" name="product_attribute_color"
                           type="radio">
                </div>
            </div>
        </label>
        @endforeach
    </div>
</div>
@endif
<?php
$sizes = SM::productAttributeSize($product->id);
?>
@if(count($sizes)>0)
<div class="attributes">
    <div class="attribute-label">Size:</div>
    {!! Form::hidden('sizename',null, ['class'=>'sizename']) !!}
    <div class="sku-prop-content product_attribute_size">

    </div>
</div>
@endif
<div class="attributes">
    <div class="attribute-label">Measurement:</div>
    <div class="sku-prop-content product_attribute_measurement">

    </div>
</div>
@push('script')
<script type="text/javascript">
    $(document).ready(function () {

    var getColorID = $('#color_0').val();
    var product_id = $('#color_0').data('product_id');
    $.ajax({
    type: 'get',
            url: '{{ URL::route('product_color_by_size')}}',
            data: {
            product_id: product_id,
                    color_id: getColorID,
            },
            success: function (data) {
            if (data.attribute_image != ''){
            $('.product-full').html(data.attribute_image);
            }

            $('.product_attribute_size').html(data.attribute_label);
            $('.product_price').html(data.product_price);
            $('.product_attribute_measurement').html(data.attribute_measurement);
            }
    })
    });
    jQuery(function ($) {

    // $(document).ready(function () {
    //----------product_size_by_color------
    // $('.click_size').on('click', function () {
    $('body').on('click', '.click_size', function (event) {
    event.preventDefault();
    // $(this).children("div").children('.size').removeClass("size_active");
    $('.size').removeClass("size_active");
    $(this).children("div").children('.size').addClass('size_active');
    $(this).children("div").find('input').prop("checked", true);
    var activeColor = $('.click_color:checked').val();
    var value = $(this).children("div").find('input').data("price");
    var sizename = $(this).children("div").find('input').data("sizename");
    var size_id = $(this).children("div").find('input').data("size_id");
    var product_id = $(this).children("div").find('input').data("product_id");
    $('.product_price').html(value);
    $('.product_price').val(value);
    $('.sizename').val(sizename);
    $(this).children("div").find('input').prop("checked", true);
    $.ajax({
    type: 'get',
            url: '{{ URL::route('product_size_by_color')}}',
            data: {
            product_id: product_id,
                    size_id: size_id,
                    activeColor: activeColor,
            },
            success: function (data) {

            $('.product_attribute_color').empty().html(data.attribute_label);
             if (data.attribute_image != ''){
            $('.product-full').html(data.attribute_image);
            }
            $('.product_attribute_measurement').html(data.attribute_measurement);
            reloadElevateZoom();
            }
    })
    });
    /**
     * Comment
     */
    function reloadElevateZoom() {

    $('#product-zoom').elevateZoom({
    zoomType: "inner",
            cursor: "crosshair",
            zoomWindowFadeIn: 500,
            zoomWindowFadeOut: 750,
            gallery:'gallery_01'
    });
    }
    //----------product_size_by_color------
    $('body').on('click', '.click_color', function (event) {
    event.preventDefault();
    $('.color').removeClass("color_active");
    $(this).children("div").find('.color').addClass('color_active');
    $(this).children("div").find('input').prop("checked", true);
    var value = $(this).children("div").find('input').data("price");
    var colorname = $(this).children("div").find('input').data("colorname");
    var product_id = $(this).children("div").find('input').data("product_id");
    var color_id = $(this).children("div").find('input').data("color_id");
    var price = $(this).children("div").find('input').data("price");
    var activeSize = $('.click_size:checked').val();
    $('.product_price').html(price);
    $('.product_price').val(price);
    $('.colorname').val(colorname);
    $.ajax({
    type: 'get',
            dataType: 'json',
            url: '{{ URL::route('product_color_by_size')}}',
            data: {
            product_id: product_id,
                    color_id: color_id,
                    activeSize: activeSize,
            },
            success: function (data) {
            $('.product_attribute_size').html(data.attribute_label);
            if (data.attribute_image != ''){
            $('.product-full').html(data.attribute_image);
            }
            $('.product_attribute_measurement').html(data.attribute_measurement);
            reloadElevateZoom();
            }
    })
    });
    });
</script>
@endpush