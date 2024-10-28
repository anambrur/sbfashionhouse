<?php
$product_title = SM::smGetThemeOption("product_title", "");
$product_subtitle = SM::smGetThemeOption("product_subtitle", "");
$productsCount = count($latestDeals);
?>
@if($productsCount>0)
<div class="page-top">
    <div class="container">
        <div class="row">
            <?php
                $features = SM::smGetThemeOption("features", array());
            ?>
            @if(count($features)>0)
                @foreach($features as $feature)
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12" style="margin: 15px 0">
                        @isset($feature["feature_image"])
                        <div class="banner-bottom">
                            <div class="banner-boder-zoom">
                                <a href="{{ $feature["feature_link"] }}">
                                    <img alt="{{ $feature["feature_title"] }}" class="img-responsive ads-style"
                                    src="{!! SM::sm_get_the_src($feature["feature_image"], 683,300) !!}"/>
                                </a>
                            </div>
                        </div>
                        @endisset
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endif