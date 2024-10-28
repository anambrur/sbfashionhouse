<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 8/12/17
 * Time: 9:59 AM
 */
?>
<article class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget" id="wid-add-slider-main" data-widget-editbutton="false" data-widget-deletebutton="false">
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
            <span class="widget-icon"> <i class="fa fa-sliders"></i> </span>
            <h2>{{ $f_name }} {{__("common.slider")}}</h2>

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
                    @include("nptl-admin.common.common.title_n_slug", ['isEnabledSlug'=>false, "table"=>"sliders"])

                    <div class="sm-form{{ $errors->has('status') ? ' has-error' : '' }}">
                        {!! Form::label('style', 'Slider Style') !!}
                        {!! Form::select('style',[
                        'slide1'=>'Slide 1','slide2'=>'Slide 2', 'slide3'=>'Slide 3', 'slide4'=>'Slide 4', 'slide5'=>'Slide 5'
                        ],
                        null,['required'=>'','class'=>'form-control']) !!}
                        @if ($errors->has('style'))
                            <span class="help-block">
                     <strong>{{ $errors->first('style') }}</strong>
                  </span>
                        @endif
                    </div>
                    <div class="sm-form{{ $errors->has('description') ? ' has-error' : '' }}">
                        {!! Form::label('description',__("common.description"))!!}
                        {!! Form::textarea('description', null,['class'=>'form-control', 'placeholder'=>__("common.description")]) !!}
                        @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="slider_btn_row">
                        @if(isset($slider->extra) && count($slider->extra)>0)
                            @foreach($slider->extra["button_label"] as $key=>$value)
								<?php
								$buttonLink = isset( $slider->extra["button_link"][ $key ] ) ? $slider->extra["button_link"][ $key ] : "";
								?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="sm-form{{ $errors->has('buttion[button_label][]') ? ' has-error' : '' }}">
                                            {!! Form::label('buttion[button_label][]',__("common.buttonLabel"))!!}
                                            {!! Form::text('buttion[button_label][]', $value,['class'=>'form-control', 'placeholder'=>__("common.buttonLabel")]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="sm-form{{ $errors->has('buttion[button_link][]') ? ' has-error' : '' }}">
                                            {!! Form::label('buttion[button_link][]',__("common.buttonLink"))!!}
                                            {!! Form::text('buttion[button_link][]', $buttonLink,['class'=>'form-control', 'placeholder'=>__("common.buttonLink")]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        @if($loop->first)
                                            <a class="btn btn-primary slider_btn add_more_btn"><i
                                                        class="fa fa-plus"></i></a>
                                        @else
                                            <a class="btn btn-danger slider_btn remove_btn"><i class="fa fa-times"></i></a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="sm-form{{ $errors->has('buttion[button_label][]') ? ' has-error' : '' }}">
                                        {!! Form::label('buttion[button_label][]',__("common.buttonLabel"))!!}
                                        {!! Form::text('buttion[button_label][]', null,['class'=>'form-control', 'placeholder'=>__("common.buttonLabel")]) !!}
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="sm-form{{ $errors->has('buttion[button_link][]') ? ' has-error' : '' }}">
                                        {!! Form::label('buttion[button_link][]',__("common.buttonLink"))!!}
                                        {!! Form::text('buttion[button_link][]', null,['class'=>'form-control', 'placeholder'=>__("common.buttonLink")]) !!}
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <a class="btn btn-primary slider_btn add_more_btn"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                        @endif
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
    <div class="jarviswidget" id="wid-add-user-publish" data-widget-editbutton="false" data-widget-deletebutton="false">

        <header>
            <span class="widget-icon"> <i class="fa fa-save"></i> </span>
            <h2>{{__("common.slider")}} {{__("common.publish")}}</h2>

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
				if (SM::is_admin() || isset( $permission ) && isset( $permission['sliders']['slider_status_update'] ) && $permission['sliders']['slider_status_update'] == 1)
				{
				?>
                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                    {!! Form::label('status', __("common.slider")." ".__("common.publicationStatus")) !!}
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
                        {{ $btn_name }} {{__("common.slider")}}
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
} elseif ( isset( $slider->image ) ) {
	$image = $slider->image;
} else {
	$image = '';
}
?>
@include('nptl-admin/common/common/image_form',['header_name'=>'Slider', 'image'=>$image])