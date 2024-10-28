@if(!isset($width))
    <?php $width = "col-md-8 col-lg-8"; ?>
@endif
<!-- NEW WIDGET START -->
<article class="col-xs-12 col-sm-12 {{$width}}">
<?php
//var_dump($product_type);
if(!empty($product_type)&&$product_type==2){
    $attribute_active='';
    $attribute_style='attribute_style';
}else{
     $attribute_active='hidden';
     $attribute_style='';
     
}
?>
    <style>
        .attribute_style{
            display: block !important;
        }
    </style>
    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget {{$attribute_active}} {{$attribute_style}}" style="" id="wid-id-add-prod-attributes" data-widget-editbutton="false"
         data-widget-deletebutton="false">

        <header>
            <span class="widget-icon"> <i class="fa fa-search"></i> </span>
            <h2>{{ $header_name }} Attributes</h2>

        </header>

        <!-- widget div-->
        <div>

            <!-- widget edit box -->
            <div class="jarviswidget-editbox">
                <!-- This area used as dropdown edit box -->
                <input class="form-control" type="text">
            </div>
            <!-- end widget edit box -->

            <!-- widget content -->
            <div class="widget-body padding-10">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-responsive table-hover" id="dynamic_field">
                            <thead>
                            <th style="width:15%">Size</th>
                            <th style="width:15%">Color</th>
                            <th style="width:25%">Measurement</th>
                            <th style="width:10%">Qty</th>
                            <th style="width:10%">Price</th>
                            <th style="width:15%">Image</th>
                            <th style="width:5%">
                                <button type="button" class="btn btn-success addRow"><i
                                            class="glyphicon glyphicon-plus"></i></button>
                            </th>
                            </thead>
                            <tbody id="customersDataShow">
                            <?php

                            $input_holder = 'attribute_image[]';
                            $img_holder = 'first_ph2' . rand(500, 99999);
                            ?>
                            @if(isset($product_info->attributeProduct))
                                @foreach($product_info->attributeProduct as $attKey=> $attribute)
                                    <?php
                                    if (old('attribute_image')) {
                                        $attribute_image = old('attribute_image');
                                    } elseif (isset($attribute->attribute_image)) {
                                        $attribute_image = $attribute->attribute_image;
                                    } else {
                                        $attribute_image = '';
                                    }

                                    $input_name = 'attribute_image[]';
                                    $input_holder = 'attribute_image_'.$attKey;
                                    $img_holder = 'first_ph2' . rand(500, 99999);
                                    ?>
                                    <tr>
                                        <td>
                                            {!! Form::hidden('detail_id[]', $attribute->id,array('class' => 'detail_id')) !!}
                                            {!! Form::select('attribute_id[]', $size_lists, $attribute->attribute_id,['id' =>'attribute_id', 'class'=>'select2', 'placeholder'=>'Please select...']) !!}
                                        </td>
                                        <td>
                                            {!! Form::select('color_id[]', $color_lists, $attribute->color_id,['required', 'id' =>'color_id', 'class'=>'select2', 'placeholder'=>'Please select...']) !!}
                                        </td>
                                         <td>
                                         {!! Form::text('attribute_legnth[]', $attribute->attribute_legnth,array('autocomplete'=>'off', 'class' => 'form-control attribute_legnth', 'placeholder'=>'Legnth')) !!}&nbsp;
                                      {!! Form::text('attribute_front[]', $attribute->attribute_front,array('autocomplete'=>'off', 'class' => 'form-control attribute_front', 'placeholder'=>'Front')) !!}&nbsp;
                                      {!! Form::text('attribute_back[]', $attribute->attribute_back,array('autocomplete'=>'off', 'class' => 'form-control attribute_back', 'placeholder'=>'Back')) !!}&nbsp;
                                      {!! Form::text('attribute_chest[]', $attribute->attribute_chest,array('autocomplete'=>'off', 'class' => 'form-control attribute_chest', 'placeholder'=>'Chest')) !!}
                                    </td>
                                        <td>
                                            {!! Form::number('attribute_qty[]', $attribute->attribute_qty,array('autocomplete'=>'off', 'class' => 'form-control attribute_qty', 'placeholder'=>'Qty')) !!}
                                        </td>
                                        <td>
                                            {!! Form::number('attribute_price[]', $attribute->attribute_price,array('autocomplete'=>'off', 'class' => 'form-control attribute_price', 'placeholder'=>'Price')) !!}
                                        </td>
                                        <td>
                                            @include("nptl-admin.common.common.small_image_form", array('header_name' => 'Product', 'image' =>$attribute_image, 'input_name' => $input_name,  'input_holder' => $input_holder, 'img_holder' => $img_holder))
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger remove"><i
                                                        class="glyphicon glyphicon-remove"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else

                                <tr>
                                    <td>
                                        {!! Form::select('attribute_id[]', $size_lists, null,['id' =>'attribute_id', 'class'=>'select2', 'placeholder'=>'Please select...']) !!}
                                    </td>
                                    <td>
                                        {!! Form::select('color_id[]', $color_lists,null,['id' =>'color_id', 'class'=>'select2', 'placeholder'=>'Please select...']) !!}
                                    </td>
                                     <td>
                                         {!! Form::text('attribute_legnth[]', null,array('autocomplete'=>'off', 'class' => 'form-control attribute_legnth', 'placeholder'=>'Legnth')) !!}&nbsp;
                                      {!! Form::text('attribute_front[]', null,array('autocomplete'=>'off', 'class' => 'form-control attribute_front', 'placeholder'=>'Front')) !!}&nbsp;
                                      {!! Form::text('attribute_back[]', null,array('autocomplete'=>'off', 'class' => 'form-control attribute_back', 'placeholder'=>'Back')) !!}&nbsp;
                                      {!! Form::text('attribute_chest[]', null,array('autocomplete'=>'off', 'class' => 'form-control attribute_chest', 'placeholder'=>'Chest')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('attribute_qty[]', null,array('autocomplete'=>'off', 'class' => 'form-control attribute_qty', 'placeholder'=>'Qty')) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('attribute_price[]', null,array('autocomplete'=>'off', 'class' => 'form-control attribute_price', 'placeholder'=>'Price')) !!}
                                    </td>
                                    <td>
                                        @include("nptl-admin.common.common.small_image_form", array('header_name' => 'Product', 'image' => '',  'input_name' => $input_holder,  'input_holder' => $input_holder, 'img_holder' => $img_holder))
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger remove"><i
                                                    class="glyphicon glyphicon-remove"></i></button>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="6">
                                    <button type="button" class="btn btn-success addRow"><i
                                                class="glyphicon glyphicon-plus"></i></button>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end widget content -->

        </div>
        <!-- end widget div -->

    </div>
    <!-- end widget -->

</article>
<!-- WIDGET END -->