<!-- NEW WIDGET START -->
<article class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget" id="wid-add-tag-main" data-widget-editbutton="false"
         data-widget-deletebutton="false">
        <!-- widget options:
           usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

           data-widget-colorbutton="false"
           data-widget-editbutton="false"
           data-widget-togglebutton="false"
           data-widget-deletebutton="false"
           data-widget-fullscreenbutton="false"
           data-widget-custombutton="false"
           data-widget-collapsed="true"
           data-widget-sortable="false"

        -->
        <header>
            <span class="widget-icon"> <i class="fa fa-credit-card"></i> </span>
            <h2>{{ $f_name }} Payment Method</h2>

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
                    <div class="col-sm-12">
                        @include("nptl-admin.common.common.title_n_slug", ['isEnabledSlug'=>false, 'table'=>'payment_methods'])
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            {!! Form::label('paymentMethodType', 'Payment Type') !!}
                            {!! Form::select('type',['1'=>'Offline','2'=>'Online without Card', '3'=>'Online With Card'], null, ['required'=>'','class'=>'form-control', 'id'=>'paymentMethodType']) !!}
                            @if ($errors->has('type'))
                                <span class="help-block">
                             <strong>{{ $errors->first('type') }}</strong>
                          </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            {!! Form::label('paymentMethodMode', 'Payment Mode') !!}
                            {!! Form::select('mode',['sandbox'=>'Demo','live'=>'Live'], null, ['required'=>'','class'=>'form-control', 'id'=>'paymentMethodMode']) !!}
                            @if ($errors->has('mode'))
                                <span class="help-block">
                             <strong>{{ $errors->first('mode') }}</strong>
                          </span>
                            @endif
                        </div>
                    </div>
                    <div id="paymentMethodTypeApi">
                        <div class="col-sm-12">
                            <div class="form-group{{ $errors->has('api_key') ? ' has-error' : '' }}">
                                {!! Form::label('api_key', 'API Key') !!}
                                {!! Form::text('api_key', null, ['class'=>'form-control']) !!}
                                @if ($errors->has('api_key'))
                                    <span class="help-block">
                             <strong>{{ $errors->first('api_key') }}</strong>
                          </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group{{ $errors->has('api_secret') ? ' has-error' : '' }}">
                                {!! Form::label('api_secret', 'API Secret') !!}
                                {!! Form::text('api_secret', null, ['class'=>'form-control']) !!}
                                @if ($errors->has('api_secret'))
                                    <span class="help-block">
                             <strong>{{ $errors->first('api_secret') }}</strong>
                          </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            {!! Form::label('description','Payment Method Description')!!}
                            {!! Form::textarea('description', null,['class'=>'form-control ckeditor']) !!}
                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
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
    <div class="jarviswidget" id="wid-id-tag-publish" data-widget-editbutton="false"
         data-widget-deletebutton="false">

        <header>
            <span class="widget-icon"> <i class="fa fa-save"></i> </span>
            <h2>Payment Method Publish</h2>

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
				if (SM::is_admin() || isset( $permission ) && isset( $permission['PaymentMethods']['status_update'] ) && $permission['PaymentMethods']['status_update'] == 1)
				{
				?>
                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                    {!! Form::label('status', 'Publication Status') !!}
                    {!! Form::select('status',['1'=>'Publish','2'=>'Pending / Draft', '3'=>'Cancel'], null, ['required'=>'','class'=>'form-control']) !!}
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
                        {{ $btn_name }} Payment Method
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


<?php
if ( old( 'image' ) ) {
	$image = old( 'image' );
} elseif ( isset( $payment_method_info->image ) ) {
	$image = $payment_method_info->image;
} else {
	$image = '';
}
?>
@include('nptl-admin/common/common/image_form',['header_name'=>'Payment Method',
'image'=>$image])