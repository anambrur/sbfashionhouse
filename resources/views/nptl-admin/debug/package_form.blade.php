@extends(('nptl-admin/master'))
@section('title','Add Package')
@section('content')
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            {!! Form::open(["method"=>"post","action"=>"Debug\Debug@optionsRequest"]) !!}
			<?php
                $value = '{"advanced":"Advanced Plan Description","features":["{\"feature_title\":\"Feature Title01\",\"feature_description\":\"Feature Description 01\",\"feature_link\":\"#01\",\"feature_image\":\"\"}","{\"feature_title\":\"Feature Title02\",\"feature_description\":\"Feature Description 02\",\"feature_link\":\"#02\",\"feature_image\":\"\"}"]}';
	        echo "<pre>";
	        print_r(json_decode($value));
	        echo "</pre>";
                $formatted = "[{'advanced':{'id':'advanced','type':'text','name':'pricing_detail_1[features][advanced]','value':'Advanced Plan Description','selector':'pricing_detail_1_features__advanced_'}},{'features':{'id':'features','type':'addable-popup','name':'pricing_detail_1[features][features]','value':['{\'feature_title\':\'Feature Title01\',\'feature_description\':\'Feature Description 01\',\'feature_link\':\'#01\',\'feature_image\':\'\'}','{\'feature_title\':\'Feature Title02\',\'feature_description\':\'Feature Description 02\',\'feature_link\':\'#02\',\'feature_image\':\'\'}'],'selector':'pricing_detail_1_features___features_'}}]";
	        SM::smNumber( [ "label" => "Professional Price in USD" ], "price_professional", "Professional Price in USD", null, "pricing_detail_1", 1 );
			$options = [
				"type"           => "addable-popup",
				"label"          => "Features",
				"desc"           => "Add your feature by clicking here",
				"single_title"   => "Main Feature",
				"add_more_title" => "Add more Main Feature",
				"template"       => "advanced",
				"fields"         => [
					"advanced" => [
						"label"   => "Advanced Plan Description",
						"type"    => "text",
						"default" => "Advanced Plan Description"
					],
					"features"                        => [
						"type"           => "addable-popup",
						"label"          => "Features",
						"desc"           => "Add your feature by clicking here",
						"single_title"   => "Feature",
						"add_more_title" => "Add more Feature",
						"template"       => "feature_title",
						"fields"         => [
							"feature_title"       => [
								"label"   => "Feature Title",
								"default" => "Feature Title",
								"type"    => "text"
							],
							"feature_description" => [
								"label" => "Feature Description",
								"type"  => "textarea"
							],
							"feature_link"        => [
								"label"   => "Feature Link",
								"type"    => "text",
								"default" => "#"
							],
							"feature_image"       => [
								"type"    => "upload",
								"label"   => "Feature Images",
								"desc"    => "Select or upload your feature image from here.",
								"default" => ""
							]
						]
					],
				]
			];
			$features = ( isset( $pricing_detail['features'] ) ) ? $pricing_detail['features'] : array();
			SM::smAddablePopup( $options, "main_features", "Features", $features, "pricing_detail_1", 1 );
			?>
            <input type="submit" value="submit" name="test">
            {!! Form::close() !!}
        </div>
        <!-- end row -->
    </section>
@endsection
