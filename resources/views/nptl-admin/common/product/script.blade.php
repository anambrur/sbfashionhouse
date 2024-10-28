<<<<<<< HEAD
@section("footer_script")
    <script type="text/javascript">
//        var product_type = $('.product_type').val();
//                alert(product_type);
//                if (product_type == 2) {
//                    $("#wid-id-add-prod-attributes").css("display: block;");
////                    $("#wid-id-add-prod-attributes").removeClass("hidden");
////                     $("#wid-id-add-prod-attributes").css("display: block;");
//                } else {
////                    $("#wid-id-add-prod-attributes").addClass("hidden");
//                }
////            
        $(document).ready(function () {
            $('.product_type').on('change', function () {
                var product_type = $(this).val();
                if (product_type == 2) {
                    $("#wid-id-add-prod-attributes").removeClass("hidden");
                } else {
                    $("#wid-id-add-prod-attributes").addClass("hidden");
                }

            });
        });
    </script>

    <script type="text/javascript">
        //==============Add Row============
        // $('body').on('.sm_media_modal_show').on('click', function(){
        //     //do some code here i.e
        //     alert("ok");
        // });
        // $('body').on('click', '.sm_media_modal_show', function () {
        //     $("#sm_media_modal").modal();
        //
        // });
        // $('body').delegate('.sm_media_modal_show', 'change', function () {
        // $(document).ready(function(){
        //     $(".sm_media_modal_show").click(function(){
        //         $("#sm_media_modal").modal();
        //     });
        // });
        $('.addRow').on('click', function () {
            var transactioncategory_id = 1;
            $.ajax({
                type: 'GET',
                url: '{!!URL::route('productAttributeAddMore')!!}',
                dataType: 'json',
                // data: dataId,
                data: {transactioncategory_id: transactioncategory_id},
                success: function (data) {
                    // alert('fasfd');
                    $('#customersDataShow').append(data);
                    $('select').select2();
                }

            });
            // addRow();
            // $('select').select2();
        });

        //==============End Format Number============
        function addRow() {
            var tr = '<tr>' +
                '<td>' +
                '<input type="hidden" value="0" name="detail_id[]">' +
                '{!! Form::select('attribute_id[]', $size_lists, null,['required', 'id' =>'attribute_id', 'class'=>'select2', 'placeholder'=>'Please select...']) !!}' +
                '</td>' +
                '<td>' +
                '{!! Form::select('color_id[]', $color_lists, null,['required', 'id' =>'color_id', 'class'=>'select2', 'placeholder'=>'Please select...']) !!}' +
                '</td>' +
                '<td>' +
                '{!! Form::number('attribute_qty[]', null,array('autocomplete'=>'off', 'class' => 'form-control attribute_qty', 'placeholder'=>'Qty')) !!}' +
                '</td>' +
                '<td>' +
                '{!! Form::number('attribute_price[]', null,array('autocomplete'=>'off', 'class' => 'form-control attribute_price', 'placeholder'=>'Price')) !!}' +
                '</td>' +
                '<td></td>' +
                '<td>' +
                '<button type="button" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove"></i></button>' +
                '</td>' +
                '</tr>';
            $('#customersDataShow').append(tr);
        };
        //==============End Create Function By User============
        $('body').on('click', '.remove', function () {
            var l = $('#customersDataShow tr').length;
            if (l == 1) {
                alert('You can not Remove last one');
            } else {
                $(this).parent().parent().remove();
            }
        });

    </script>
@endsection
