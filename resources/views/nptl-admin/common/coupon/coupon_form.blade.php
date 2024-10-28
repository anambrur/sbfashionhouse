<!-- NEW WIDGET START -->
<article class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget" id="wid-add-coupon-main" data-widget-editbutton="false"
         data-widget-deletebutton="false">

        <header>
            <span class="widget-icon"> <i class="fa fa-building"></i> </span>
            <h2>{{ $f_name }} Coupon</h2>

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
                    <div class="col-sm-6">
                        @include("nptl-admin.common.common.title_n_slug", ['isEnabledSlug'=>false, 'table'=>'coupons'])
                        <div class="form-group">
                            {!! Form::label('discount_type','Discount Type')!!}
                            {{ Form::select('discount_type', ['1'=>'Normal discount', '2'=>'Coupon discount'], null, array('class'=>'form-control discount_type')) }}
                            @if ($errors->has('discount_type'))
                                <span class="help-block">
                                     <strong>{{ $errors->first('discount_type') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="coupon_option form-group{{ $errors->has('coupon_code') ? ' has-error' : '' }}">
                            {!! Form::label('coupon_code','Coupon Code')!!}
                            {!! Form::text('coupon_code', null,['class'=>'form-control', 'placeholder'=>'Write your unique coupon code']) !!}
                            <span>Suggested coupon code: <a id="suggestion_coupon_code"
                                                            onclick="document.getElementById('coupon_code').value=this.text"></a> Add this by clicking here.</span>
                            @if ($errors->has('coupon_code'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('coupon_code') }}</strong>
                                 </span>
                            @endif
                        </div>
                        <script>
                            document.getElementById("suggestion_coupon_code").text = "<?php echo $suggestion_coupon_code; ?>";
                        </script>

                        <div class="form-group{{ $errors->has('validity') ? ' has-error' : '' }}">
                            {!! Form::label('validity','Validity Date')!!}
                            {!! Form::text('validity', null,['class'=>'form-control datepicker', 'required'=>'', 'placeholder'=>'Pick your validity date']) !!}
                            @if ($errors->has('validity'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('validity') }}</strong>
                                 </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            {!! Form::label('type','Type')!!}
                            {!! Form::select('type', ['1'=>'Fixed','2'=>'Percentage'], null,['class'=>'form-control', 'required'=>'' ]) !!}
                            @if ($errors->has('type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('type') }}</strong>
                                 </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group{{ $errors->has('coupon_amount') ? ' has-error' : '' }}">
                            {!! Form::label('coupon_amount','Discount')!!}
                            {!! Form::number('coupon_amount', null,['class'=>'form-control', 'required'=>'', 'placeholder'=>'Write your Discount Amount here']) !!}
                            @if ($errors->has('coupon_amount'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('coupon_amount') }}</strong>
                                 </span>
                            @endif
                        </div>
                        <div class="coupon_option form-group{{ $errors->has('qty') ? ' has-error' : '' }}">
                            {!! Form::label('qty','Qty')!!}
                            {!! Form::number('qty', null,['class'=>'form-control',  'placeholder'=>'Qty']) !!}
                            @if ($errors->has('qty'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('qty') }}</strong>
                                 </span>
                            @endif
                        </div>
                        <div class="coupon_option form-group{{ $errors->has('balance_qty') ? ' has-error' : '' }}">
                            {!! Form::label('balance_qty','Balance Qty')!!}
                            {!! Form::number('balance_qty', null,['class'=>'form-control', 'placeholder'=>'Balance Qty']) !!}
                            @if ($errors->has('balance_qty'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('balance_qty') }}</strong>
                                 </span>
                            @endif
                        </div>
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
<!-- NEW WIDGET START -->
<article class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget" id="wid-id-coupon-publish" data-widget-editbutton="false"
         data-widget-deletebutton="false">

        <header>
            <span class="widget-icon"> <i class="fa fa-save"></i> </span>
            <h2>Coupon Publish</h2>

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
                <?php
                $permission = SM::current_user_permission_array();
                if (SM::is_admin() || isset($permission) && isset($permission['coupons']['coupon_status_update']) && $permission['coupons']['coupon_status_update'] == 1)
                {
                ?>
                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                    {!! Form::label('status', 'Publication Status') !!}
                    {!! Form::select('status',['1'=>'Publish','2'=>'Pending / Draft', '3'=>'Cancel'],null,['required'=>'','class'=>'form-control']) !!}
                    @if ($errors->has('status'))
                        <span class="help-block">
                             <strong>{{ $errors->first('status') }}</strong>
                          </span>
                    @endif
                </div>
                <?php
                }
                ?>
                <div class="form-group">
                    <button class="btn btn-success btn-block" type="submit">
                        <i class="fa fa-save"></i>
                        {{ $btn_name }} Coupon
                    </button>
                </div>

            </div>
            <!-- end widget content -->

        </div>
        <!-- end widget div -->

    </div>
    <!-- end widget -->

</article>
<!-- WIDGET END -->
<script type="text/javascript">
    $(document).ready(function () {
        $(".coupon_option").addClass("hidden");
        $('.discount_type').on('change', function () {
            var product_type = $(this).val();
            if (product_type == 2) {
                $(".coupon_option").removeClass("hidden");
            } else {
                $(".coupon_option").addClass("hidden");
            }

        });
    });
</script>
