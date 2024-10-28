<?php
    $product_best_sale_is_enable = SM::smGetThemeOption("product_best_sale_is_enable", 1);
    $product_show_category = SM::smGetThemeOption("product_show_category", 1);
    $product_show_tag = SM::smGetThemeOption("product_show_tag", 1);
    $product_show_brand = SM::smGetThemeOption("product_show_brand", 1);
    $product_show_size = SM::smGetThemeOption("product_show_size", 1);
    $product_show_color = SM::smGetThemeOption("product_show_color", 1);
    $product_detail_add = SM::smGetThemeOption("product_detail_add", 1);
?>
<div class="column col-xs-12 col-sm-3" id="left_column">
    <!-- block category -->
    @if($product_show_category==1)
    <?php
    $getMainCategories = SM::getMainCategories(0);
    ?>
    @if(count($getMainCategories)>0)
    <div class="block left-module product-details-sidebar">
        <p class="title_block">CATEGORIES</p>
        <div class="block_content">
            <!-- layered -->
            <div class="layered layered-category">
                <div class="layered-content">
                    <ul class="tree-menu">
                        @foreach($getMainCategories as $cat)
                        <li class="active">
                            <span></span>
                            <a href="{!! url("category/".$cat->slug) !!}">{{$cat->title}}</a>
                            <?php
                            $getSubCategories = \App\Model\Common\Category::where('parent_id', $cat->id)->get();
                            //                                            SM::getSubCategories($cat->id);
                            ?>
                            @empty(!$getSubCategories)
                            <ul>
                                @foreach($getSubCategories as $getSubCategory)
                                <li><span></span>
                                    <a href="{!! url("category/".$getSubCategory->slug) !!}">{{ $getSubCategory->title }}</a>
                                    <?php
                                    echo SM::category_tree_for_select_cat_id($getSubCategory->id);
                                    ?>
                                </li>
                                @endforeach
                            </ul>
                            @endempty
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- ./layered -->
        </div>
    </div>
    @endif
    @endif
    
    <?php
    $product_detail_add_link = SM::smGetThemeOption("product_detail_add_link", "#");
    $product_detail_add = SM::smGetThemeOption("product_detail_add");
    ?>
    @empty(!$product_detail_add)
    <div class="col-left-slide left-module text-center">
        <div class="banner-opacity">
            <a href="{!! $product_detail_add_link !!}">
                <img src="{!! SM::sm_get_the_src( $product_detail_add, 319,319 ) !!}" alt="ads-banner"
                class="image-style">
            </a>
        </div>
    </div>
    @endempty
</div>