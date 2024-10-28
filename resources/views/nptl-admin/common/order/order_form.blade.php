<!-- NEW WIDGET START -->
<article class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget" id="wid-add-package-main" data-widget-editbutton="false"
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
            <span class="widget-icon"> <i class="fa fa-building"></i> </span>
            <h2>{{ $f_name }} Package</h2>

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
                        @include("nptl-admin.common.common.title_n_slug", ['isEnabledSlug'=>true, 'table'=>'packages'])
                    </div>
                    <div class="col-sm-12">
                        <div class="sm-form{{ $errors->has('subtitle') ? ' has-error' : '' }}">
                            {!! Form::label('subtitle','Subtitle') !!}
                            {!! Form::text('subtitle', null,['required'=>'','class'=>'form-control', 'placeholder'=>'Write your subtitle here']) !!}
                            @if ($errors->has('subtitle'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('subtitle') }}</strong>
                                 </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            {!! Form::label('description','Package Description')!!}
                            {!! Form::textarea('description', null,['class'=>'form-control ckeditor']) !!}
                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                 </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group{{ $errors->has('requirements') ? ' has-error' : '' }}">
                            {!! Form::label('requirements','Package Requirements')!!}
                            {!! Form::textarea('requirements', null,['class'=>'form-control ckeditor']) !!}
                            @if ($errors->has('requirements'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('requirements') }}</strong>
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
    <div class="jarviswidget" id="wid-id-package-publish" data-widget-editbutton="false"
         data-widget-deletebutton="false">

        <header>
            <span class="widget-icon"> <i class="fa fa-save"></i> </span>
            <h2>Package Publish</h2>
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
				if (SM::is_admin() || isset( $permission ) && isset( $permission['packages']['status_update'] ) && $permission['Packages']['status_update'] == 1)
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
                    <button class="btn btn-success btn-block sm_post_save_process" type="submit">
                        <i class="fa fa-save"></i>
                        {{ $btn_name }} Package
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
} elseif ( isset( $package_info->image ) ) {
	$image = $package_info->image;
} else {
	$image = '';
}
?>
@include('nptl-admin/common/common/image_form',['header_name'=>'Package Banner',
'image'=>$image])
<!-- NEW WIDGET START -->
<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget" id="wid-add-package-extra-main" data-widget-editbutton="false"
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
            <span class="widget-icon"> <i class="fa fa-building"></i> </span>
            <h2>{{ $f_name }} Package Extra</h2>

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

                    <div class=" smthemeoptionfield">
                        <div class="col-md-2">
                            {!! Form::label('type', 'Package Type') !!}
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        {!! Form::select('type',['1'=>'Pricing Plan','2'=>'Content Writing', '3'=>'Advertisement'], null, ['required'=>'','class'=>'form-control']) !!}

                                    </div>
                                    <div class="col-md-12">
                                        @if ($errors->has('type'))
                                            <span class="help-block">
                                                 <strong>{{ $errors->first('type') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="div_package_1">
						<?php
						$price_type = ( isset( $package_info ) && $package_info->type == 1 ) ? $package_info->price_type : 2;
						$option = [
							"label"  => "Price Types",
							"fields" => [
								1 => 'Weekly',
								2 => 'Monthly',
								3 => 'Quarterly',
								4 => 'Yearly'
							]
						];
						SM::smSelect( $option, "price_type", "Price Type", $price_type, "pricing_detail_1", 1 );


						$pricing_detail = ( isset( $package_info ) && $package_info->type == 1 && $package_info->pricing_detail != '' ) ? SM::sm_unserialize( $package_info->pricing_detail ) : array();

						$basic_pricing_title = ( isset( $pricing_detail['basic_pricing_title'] ) ) ? $pricing_detail['basic_pricing_title'] : "BASIC PLAN";
						SM::smText( [ "label" => "Basic Pricing Title" ], "basic_pricing_title", "Basic Pricing Title", $basic_pricing_title, "pricing_detail_1", 1 );
						$basicPrice = ( isset( $package_info ) && $package_info->type == 1 ) ? $package_info->price_basic : 0;
						SM::smNumber( [ "label" => "Basic Price in USD" ], "price_basic", "Basic Price in USD", $basicPrice, "pricing_detail_1", 1 );


						$recommended_pricing_title = ( isset( $pricing_detail['recommended_pricing_title'] ) ) ? $pricing_detail['recommended_pricing_title'] : "RECOMMENDED";
						SM::smText( [ "label" => "Recommended Pricing Title" ], "recommended_pricing_title", "Recommended Pricing Title", $recommended_pricing_title, "pricing_detail_1", 1 );
						$price_recommended = ( isset( $package_info->price_recommended ) ) ? $package_info->price_recommended : 0;
						SM::smNumber( [ "label" => "Recommended Price in USD" ], "price_recommended", "Recommended Price in USD", $price_recommended, "pricing_detail_1", 1 );



						$professional_pricing_title = ( isset( $pricing_detail['professional_pricing_title'] ) ) ? $pricing_detail['professional_pricing_title'] : "PROFESSIONAL PLAN";
						SM::smText( [ "label" => "Professional Pricing Title" ], "professional_pricing_title", "Professional Pricing Title", $professional_pricing_title, "pricing_detail_1", 1 );
						$price_professional = ( isset( $package_info->price_professional ) ) ? $package_info->price_professional : 0;
						SM::smNumber( [ "label" => "Professional Price in USD" ], "price_professional", "Professional Price in USD", $price_professional, "pricing_detail_1", 1 );
						$options = [
							"type"           => "addable-popup",
							"label"          => "Features",
							"desc"           => "Add your feature by clicking here",
							"single_title"   => "Feature",
							"add_more_title" => "Add more Feature",
							"template"       => "feature_title",
							"fields"         => [
								"feature_title" => [
									"label" => "Feature Title",
									"type"  => "textarea",
								],
								"basic"         => [
									"label" => "Basic Plan Description",
									"type"  => "text",
								],
								"recommended"   => [
									"label" => "Recommended Plan Description",
									"type"  => "text",
								],
								"professional"  => [
									"label" => "Professional Plan Description",
									"type"  => "text",
								],
							]
						];
						$features = ( isset( $pricing_detail['features'] ) ) ? $pricing_detail['features'] : array();
						SM::smAddablePopup( $options, "features", "Features", $features, "pricing_detail_1", 1 );
						?>
                    </div>
                    <div class="div_package_2">
						<?php
						$pricing_detail = ( isset( $package_info ) && $package_info->type == 2 && $package_info->pricing_detail != '' ) ? SM::sm_unserialize( $package_info->pricing_detail ) : array();
						$pricing_title = ( isset( $pricing_detail['pricing_title'] ) ) ? $pricing_detail['pricing_title'] : "";
						SM::smText( [ "label" => "Pricing Title" ], "pricing_title", "Pricing Title", $pricing_title, "pricing_detail_2", 1 );
						$options = [
							"type"           => "addable-popup",
							"label"          => "Pricing Info",
							"desc"           => "Add your Pricing Info by clicking here",
							"single_title"   => "Pricing Info",
							"add_more_title" => "Add more  Pricing Info",
							"template"       => "pricing_title",
							"fields"         => [
								"pd_id"         => [
									"label"   => "Pricing Title",
									"type"    => "hidden",
									"default" => "0"
								],
								"pricing_title" => [
									"label" => "Pricing Title",
									"type"  => "textarea",
								],
								"price"         => [
									"label" => "Price",
									"type"  => "number",
								],
								"isIncluded"    => [
									"label"   => "Is Included?",
									"type"    => "radio",
									"default" => 1,
									"fields"  => [
										1 => "Yes",
										0 => "No"
									]
								]
							]
						];
						$pricing_content = array();
						if ( isset( $package_info->package_detail2 ) && count( $package_info->package_detail2 ) > 0 ) {
							$loop = 0;
							foreach ( $package_info->package_detail2 as $pd2 ) {
								$pricing_content[ $loop ]["pd_id"]         = $pd2->id;
								$pricing_content[ $loop ]["pricing_title"] = $pd2->title;
								$pricing_content[ $loop ]["price"]         = $pd2->price;
								$pricing_content[ $loop ]["isIncluded"]    = $pd2->isIncluded;
								$loop ++;
							}
						}
						SM::smAddablePopup( $options, "pricing_content", "Pricing Detail", $pricing_content, "pricing_detail_2", 1 );
						?>
                    </div>
                    <div class="div_package_3">
						<?php
						$pricing_detail = ( isset( $package_info ) && $package_info->type == 3 && $package_info->pricing_detail != '' ) ? SM::sm_unserialize( $package_info->pricing_detail ) : array();

						$pricing_title = ( isset( $pricing_detail['pricing_title'] ) ) ? $pricing_detail['pricing_title'] : "";
						$add_pricing_content = ( isset( $pricing_detail['add_pricing_content'] ) ) ? $pricing_detail['add_pricing_content'] : array();
						SM::smText( [ "label" => "Pricing Title" ], "pricing_title", "Pricing Title", $pricing_title, "pricing_detail_3", 1 );


						$price_type = ( isset( $package_info ) && $package_info->type == 3 ) ? $package_info->price_type : 2;
						$option = [
							"label"  => "Price Types",
							"fields" => [
								1 => 'Weekly',
								2 => 'Monthly',
								3 => 'Quarterly',
								4 => 'Yearly'
							]
						];
						SM::smSelect( $option, "price_type", "Price Type", $price_type, "pricing_detail_3", 1 );

						$basicPrice = ( isset( $package_info ) && $package_info->type == 3 ) ? $package_info->price_basic : 0;
						SM::smNumber( [ "label" => "Price" ], "ad_price", "Price", $basicPrice, "pricing_detail_3", 1 );


						$options = [
							"type"           => "addable-popup",
							"label"          => "Pricing Info",
							"desc"           => "Add your Pricing Info by clicking here",
							"single_title"   => "Pricing Info",
							"add_more_title" => "Add more  Pricing Info",
							"template"       => "pricing_description",
							"fields"         => [
								"pricing_description" => [
									"label" => "Pricing Title",
									"type"  => "textarea"
								]
							]
						];
						SM::smAddablePopup( $options, "add_pricing_content", "Pricing Detail", $add_pricing_content, "pricing_detail_3", 1 );
						?>
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
@include('nptl-admin/common/common/meta_info',['header_name'=>'Package',
'width'=>'col-lg-12'])