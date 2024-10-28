<?php

namespace App\Http\Controllers\Front;

use App\Model\Common\Attribute;
use App\Model\Common\Brand;
use App\Model\Common\Category;
use App\Model\Common\Product;
use App\Model\Common\Tag;
use App\SM\SM;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Model\Common\AttributeProduct;

class ProductController extends Controller
{

    public function shop(Request $request, $slug = null)
    {
        if ($slug != null) {
            return $this->productDetail($slug);
        }
        $page = \request()->input('page', 0);
        $key = 'products_page_' . $page;

        $data["productLists"] = SM::getCache($key, function () {
            $shop_page_per_product = SM::smGetThemeOption(
                "shop_page_per_product", config("constant.smFrontPagination"
            ));
            return Product::with('user')
                ->where("status", 1)
                ->orderBy("id", "desc")
                ->paginate($shop_page_per_product);
        }, ['products']);

        if ($request->ajax()) {
            return view('frontend.products.product_list_item', $data);
//            $html = view("frontend.products.product_list_item", $data)->render();
//            return response($html);
        } else {
            $data["stickyProductPost"] = SM::getCache('stickyProducts', function () {

                return Product::where("status", 1)
                    ->orderBy("id", "desc")
                    ->limit(5)
                    ->get();
            });

            $data['seo_title'] = SM::smGetThemeOption("product_seo_title");
            $data['meta_key'] = SM::smGetThemeOption("product_meta_keywords");
            $data['meta_description'] = SM::smGetThemeOption("product_meta_description");

            return view('frontend.products.shop', $data);
        }
    }

    public
    function categoryType_filter_by_product(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $type = $request->type;
            $category_id = $request->category_id;
            $subcat_id[] = $category_id;
            $subcategory_id = Category::where('parent_id', $category_id)->get();
            if (!empty($subcategory_id)) {
                foreach ($subcategory_id as $item) {
                    $subcat_id[] = $item->id;
                }
            }

            if ($type == 'specials') {
                $get_products = DB::table('products')
                    ->join('categoryables', 'products.id', 'categoryables.categoryable_id')
                    ->leftJoin('reviews', 'products.id', 'reviews.product_id')
                    ->where('categoryables.categoryable_type', 'App\Model\Common\Product')
                    ->where('products.sale_price', '>', 0)
                    ->whereIn('categoryables.category_id', $subcat_id)
                    ->groupBy('products.id')
                    ->select('products.*')
                    ->take(7)
                    ->get();
            } elseif ($type == 'best_sales') {
                $get_products = DB::table('products')
                    ->join('categoryables', 'products.id', 'categoryables.categoryable_id')
                    ->leftJoin('order_details', 'products.id', 'order_details.product_id')
                    ->where('categoryables.categoryable_type', 'App\Model\Common\Product')
                    ->whereIn('categoryables.category_id', $subcat_id)
                    ->select('products.*', DB::raw('COUNT(order_details.product_id) as count'))
                    ->groupBy('products.id')
                    ->orderBy('count', 'desc')
                    ->take(7)
                    ->get();
            } elseif ($type == 'most_reviews') {
                $get_products = DB::table('products')
                    ->join('categoryables', 'products.id', 'categoryables.categoryable_id')
                    ->leftJoin('reviews', 'products.id', 'reviews.product_id')
                    ->where('categoryables.categoryable_type', 'App\Model\Common\Product')
                    ->where('reviews.status', 1)
                    ->whereIn('categoryables.category_id', $subcat_id)
                    ->groupBy('products.id')
                    ->selectRaw('products.*, sum(reviews.rating) as totalRating')
                    ->orderBy('totalRating', 'desc')
                    ->take(7)
                    ->get();
            } else {
                $get_products = DB::table('products')
                    ->join('categoryables', 'products.id', 'categoryables.categoryable_id')
                    ->where('categoryables.categoryable_type', 'App\Model\Common\Product')
                    ->whereIn('categoryables.category_id', $subcat_id)
                    ->select('products.*')
                    ->orderBy('products.id', 'desc')
                    ->groupBy('products.id')
                    ->take(7)
                    ->get();
            }


            if (count($get_products) > 0) {
                $output .= '<div class="box-left">';
                foreach ($get_products->take(1) as $first_product) {
                    $output .= '<div class="banner-img">
                                                <a title="' . $first_product->title . '"
                                                   href="' . url('product/' . $first_product->slug) . '"><img
                                                            src="' . SM::sm_get_the_src($first_product->image, 450, 650) . '"
                                                            alt="' . $first_product->title . '"></a>
                                            </div>';
                }
                $output .= ' </div>
                                                <div class="box-right">
                                                    <ul class="product-list row">';
                foreach ($get_products as $pKey => $product) {
                    if ($pKey > 0) {
                        if ($product->product_type == 2) {
                            $att_data = SM::getAttributeByProductId($product->id);
                            if (!empty($att_data->attribute_image)) {
                                $attribute_image = $att_data->attribute_image;
                            } else {
                                $attribute_image = $product->image;
                            }
                            $output .= ' <li class="col-sm-4">
                                                <div class="left-block">
                                                    <a href="' . url('product/' . $product->slug) . '">
                                                        <img title="' . $product->title . '"
                                                             class="img-responsive"
                                                             alt="' . $product->title . '"
                                                             src="' . SM::sm_get_the_src($attribute_image, 206, 251) . '"/>
                                                    </a>
                                                    <div class="quick-view">';
                            $output .= SM::quickViewHtml($product->id, $product->slug) . '
                                                    </div>
                                                    <div class="add-to-cart">
                                                   ' . SM::addToCartButton($product->id, $product->regular_price, $product->sale_price) . '
                                                    </div>
                                                </div>
                                                <div class="right-block">
                                                    <h5 class="product-name">
                                                        <a href="' . url('product/' . $product->slug) . '">
                                                            ' . $product->title . '
                                                        </a>
                                                    </h5>
                                                    <div class="content_price">
                                                        <span class="price product-price">' . SM::currency_price_value($att_data->attribute_price) . '</span>

                                                    </div>
                                                </div>
                                            </li>';
                        } else {
                            $output .= ' <li class="col-sm-4">
                                                <div class="left-block">
                                                    <a href="' . url('product/' . $product->slug) . '">
                                                        <img title="' . $product->title . '"
                                                             class="img-responsive"
                                                             alt="' . $product->title . '"
                                                             src="' . SM::sm_get_the_src($product->image, 206, 251) . '"/>
                                                    </a>
                                                    <div class="quick-view">';
                            $output .= SM::quickViewHtml($product->id, $product->slug) . '
                                                    </div>
                                                    <div class="add-to-cart">
                                                   ' . SM::addToCartButton($product->id, $product->regular_price, $product->sale_price) . '
                                                    </div>
                                                </div>
                                                <div class="right-block">
                                                    <h5 class="product-name">
                                                        <a href="' . url('product/' . $product->slug) . '">
                                                            ' . $product->title . '
                                                        </a>
                                                    </h5>
                                                    <div class="content_price">';
                            if ($product->sale_price > 0) {
                                $output .= '<span class="price product-price">' . SM::currency_price_value($product->sale_price) . '</span>
                                                            <span class="price old-price">' . SM::currency_price_value($product->regular_price) . '</span>
                                                            <input type="hidden" id="price"  value="' . $product->sale_price . '"/>';
                            } else {
                                $output .= ' <span class="price product-price">' . SM::currency_price_value($product->regular_price) . '</span>
                                                            <input type="hidden" id="price" value="' . $product->regular_price . '"/>';
                            }

                            $output .= '</div>
                                                </div>
                                            </li>';
                        }
                    }
                }
                $output .= ' </ul>
                                                </div>';


                return Response($output);
            } else {
                $output = '<p style="font-size:18px;color: red; padding: 5px; margin-top: 20px;">Not data found</p>';
                return Response($output);
//                return Response()->json([d => 'Not data found']);
            }
        }
    }

    function product_search_data(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $action = $request->action;
            $brand_filter = $request->brand;
            $size_filter = $request->size;
            $color_filter = $request->color;
            $category_id = $request->category;
            $category_filter=array();
            if ($category_id != '') {
                foreach ($category_id as $cat_id) {
                    $subcategory_id = Category::where('parent_id', $cat_id)->get();
                    if (count($subcategory_id)>0) {
                        foreach ($subcategory_id as $item) {
                            $category_filter[] = $item->id;
                        }
                    }else{
                        $category_filter[] = $cat_id;
                    }
                }

            } else {
                $category_filter = $request->category;
            }

            $orderByPrice_filter = $request->orderByPrice;
            if ($orderByPrice_filter == 1) {
                $orderBy = 'asc';
            } elseif ($orderByPrice_filter == 2) {
                $orderBy = 'desc';
            } else {
                $orderBy = 'desc';
            }

            $limit_filter = $request->limitProduct;
            if ($limit_filter == 10) {
                $limit = 10;
            } elseif ($limit_filter == 18) {
                $limit = 18;
            } elseif ($limit_filter == 20) {
                $limit = 20;
            } elseif ($limit_filter == 50) {
                $limit = 50;
            } elseif ($limit_filter == 100) {
                $limit = 100;
            } else {
                $limit = 5;
            }
            $shop_page_per_product = SM::smGetThemeOption(
                "shop_page_per_product", config("constant.smFrontPagination"
            ));
            if (isset($request["minimum_price"], $request["maximum_price"]) && !empty($request["minimum_price"]) && !empty($request["maximum_price"])) {
                $minimum_price = $request["minimum_price"];
                $maximum_price = $request["maximum_price"];
            } else {
                $minimum_price = '';
                $maximum_price = '';
            }
            if (isset($request["minimum_price"], $request["maximum_price"]) && !empty($request["minimum_price"]) && !empty($request["maximum_price"])) {
                $minimum_price = $request["minimum_price"];
                $maximum_price = $request["maximum_price"];
            } else {
                $minimum_price = '';
                $maximum_price = '';
            }
            $product_data = DB::table('products')
                ->join('categoryables', 'products.id', 'categoryables.categoryable_id')
                ->leftJoin('attribute_product', 'products.id', 'attribute_product.product_id')
                ->where('categoryables.categoryable_type', 'App\Model\Common\Product')
                ->select('products.*')
                ->when($brand_filter, function ($query) use ($brand_filter) {
                    if ($brand_filter != "") {
                        return $query->whereIn('products.brand_id', $brand_filter);
                    }
                })
                ->when($category_filter, function ($query) use ($category_filter) {
                    if ($category_filter != "") {
                        return $query->whereIn('categoryables.category_id', $category_filter);
                    }
                })
                ->when($minimum_price, function ($query) use ($minimum_price, $maximum_price) {
                    if ($minimum_price != "" && $maximum_price != "") {
                        return $query->whereBetween('products.regular_price', array($minimum_price, $maximum_price));
                    }
                })
                ->when($size_filter, function ($query) use ($size_filter) {
                    if ($size_filter != "") {
                        return $query->whereIn('attribute_product.attribute_id', $size_filter);
                    }
                })
                ->when($color_filter, function ($query) use ($color_filter) {
                    if ($color_filter != "") {
                        return $query->whereIn('attribute_product.color_id', $color_filter);
                    }
                })
                ->when($orderBy, function ($query) use ($orderBy) {
                    if ($orderBy != "") {
                        return $query->orderBy('products.regular_price', $orderBy);
                    } else {
                         return $query->orderBy('products.id','desc');
                    }
                })
            
                ->groupBy('products.id')
                ->paginate($shop_page_per_product);
//            var_dump($product_data);
//            exit();
            if (!empty($product_data)) {
                foreach ($product_data as $product) {
                    if ($product->product_type == 2) {
                        $att_data = SM::getAttributeByProductId($product->id);
                        if (!empty($att_data->attribute_image)) {
                            $attribute_image = $att_data->attribute_image;
                        } else {
                            $attribute_image = $product->image;
                        }
                        $output .= '   
                          <li class="col-sx-12 col-sm-4">
                            <div class="product-container">
                                <div class="left-block">
                                    <a href="' . url('product/' . $product->slug) . '">
                                        <img class="img-responsive" alt="product" src="' . SM::sm_get_the_src($attribute_image, 268, 327) . '" />
                                    </a>
                                    <div class="quick-view">';
                        $output .= SM::quickViewHtml($product->id, $product->slug) . '
                                    </div>
                                  
                                    <div class="add-to-cart">';
                        $output .= SM::addToCartButton($product->id, $product->regular_price, $product->sale_price) . '  
                                    </div>
                                </div>
                                <div class="right-block">
                                    <h5 class="product-name">
                                    <a href="' . url('product/' . $product->slug) . '">' . $product->title . '</a>
                                    </h5>
                                     <div class="product-star">
                                     ' . SM::product_review($product->id) . '
                                    </div>
                                    <div class="content_price">';
                        $output .= '  <span class="price product-price">' . SM::currency_price_value($att_data->attribute_price) . '</span>';
                        $output .= ' 
                                  </div>
                                    <div class="info-orther">
                                        <p>SKU: '.$product->sku.'</p>
                                        <p class="availability">Availability: <span>' . $product->stock_status . '</span></p>
                                        <div class="product-desc">
                                            ' . $product->short_description . '
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li> 
                         ';
                    } else {
                        $output .= '  
                          <li class="col-sx-12 col-sm-4">
                            <div class="product-container">
                                <div class="left-block">
                                    <a href="' . url('product/' . $product->slug) . '">
                                        <img class="img-responsive" alt="product" src="' . SM::sm_get_the_src($product->image, 268, 327) . '" />
                                    </a>
                                    <div class="quick-view">';
                        $output .= SM::quickViewHtml($product->id, $product->slug) . '
                                    </div>
                                  
                                    <div class="add-to-cart">';
                        $output .= SM::addToCartButton($product->id, $product->regular_price, $product->sale_price) . '  
                                    </div>
                                </div>
                                <div class="right-block">
                                    <h5 class="product-name">
                                    <a href="' . url('product/' . $product->slug) . '">' . $product->title . '</a>
                                    </h5>
                                     <div class="product-star">
                                     ' . SM::product_review($product->id) . '
                                        
                                    </div>
                                    <div class="content_price">';
                        if ($product->sale_price > 0) {
                            $output .= ' <span class="price product-price">' . SM::currency_price_value($product->sale_price) . '</span>
                                 <span class="price old-price">' . SM::currency_price_value($product->regular_price) . '</span>';
                        } else {
                            $output .= '  <span class="price product-price">' . SM::currency_price_value($product->regular_price) . '</span>';
                        }
                        $output .= ' 
                                  </div>
                                    <div class="info-orther">
                                        <p>SKU: '.$product->sku.'</p>
                                        <p class="availability">Availability: <span>' . $product->stock_status . '</span></p>
                                        <div class="product-desc">
                                            ' . $product->short_description . '
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li> 
                         ';
                    }
                }
                $output .= '<div class="col-md-12" style="margin-top: 25px;">
                                ' . $product_data->links() . '
                            </div> ';
            } else {
                $output = '<h3>No Data Found</h3>';
            }
            echo $output;
        }
    }

    /**
     * Product detail page show by slug
     *
     * @param $slug string
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function productDetail($slug)
    {
        $data["product"] = SM::getCache('product_' . $slug, function () use ($slug) {
            return Product::with("categories", "user")
                ->where("slug", $slug)
                ->where("status", 1)
                ->first();
        });
//        if (count($data["product"]) > 0) {
        if (!empty($data["product"])) {
            $data['smAdminBarId'] = $data["product"]->id;

            $data["product"]->increment("views");

            $data["relatedProduct"] = SM::getCache('product_related_product_' . $slug, function () use ($data) {
                $product_related_per_page = SM::smGetThemeOption("product_related_per_page", 6);
                $cats = SM::get_ids_from_data($data['product']->categories);

                return DB::table("products")
                    ->select('products.*')
                    ->join("categoryables", function ($join) {
                        $join->on("categoryables.categoryable_id", "=", "products.id")
                            ->where("categoryables.categoryable_type", '=', 'App\Model\Common\Product');
                    })
                    ->whereIn("categoryables.category_id", $cats)
                    ->where("products.id", '!=', $data["product"]->id)
                    ->where("products.status", 1)
                    ->orderBy("products.id", "desc")
                    ->limit($product_related_per_page)
                    ->get();
            });
            $product_related_per_page = SM::smGetThemeOption("product_related_per_page", 5);
            $cats = SM::get_ids_from_data($data['product']->categories);


            /**
             * If related product not found then show post from all post
             */
            if (count($data["relatedProduct"]) < 1) {
                $data["relatedProduct"] = SM::getCache('product_related_all_product_' . $slug, function () use ($data) {
                    $product_related_per_page = SM::smGetThemeOption("product_related_per_page", 2);

                    return DB::table("products")
                        ->select('products.*')
                        ->join("users", 'products.created_by', '=', 'users.id')
                        ->where("products.id", '!=', $data["product"]->id)
                        ->where("products.status", 1)
                        ->orderBy("products.id", "desc")
                        ->limit($product_related_per_page)
                        ->get();
                });
                $product_related_per_page = SM::smGetThemeOption("product_related_per_page", 5);
            }


            $data['seo_title'] = $data['product']->seo_title;
            $data["meta_key"] = $data["product"]->meta_key;
            $data["meta_description"] = $data["product"]->meta_description;
            $data["image"] = asset(SM::sm_get_the_src($data["product"]->image, 750, 560));

            return view('frontend.products.product_detail', $data);
        } else {
            return abort(404);
        }
    }

    public function product_color_by_size(Request $request)
    {
        if ($request->ajax()) {
            $product_id = $request->product_id;
            $color_id = $request->color_id;
            $activeSize = $request->activeSize;
            $output = "";

            $attribute_product = DB::table('attribute_product')
                ->join('attributes', 'attribute_product.attribute_id', 'attributes.id')
                ->where('product_id', $product_id)
                ->where('color_id', $color_id)
                ->groupBy('attribute_id')
                ->get();
//            $numbderofSize = count($customers);
            $attribute_legnth = '';
            $attribute_front = '';
            $attribute_back = '';
            $attribute_chest = '';
            if ($attribute_product) {
                foreach ($attribute_product as $sKey => $size) {

                    $checked = "";
                    $activeClass = '';
                    if ($activeSize == $size->attribute_id) {
                        $activeClass = 'size_active';
                        $checked = "checked";
                        $image = $size->attribute_image;
                        $activeSize = $size->attribute_id;
                        $product_price = $size->attribute_price;
                        if (!empty($size->attribute_legnth)) {
                            $attribute_legnth = 'Legnth: ' . $size->attribute_legnth;
                        }
                        if (!empty($size->attribute_front)) {
                            $attribute_front = ', Front: ' . $size->attribute_front;
                        }
                        if (!empty($size->attribute_back)) {
                            $attribute_back = ', Back: ' . $size->attribute_back;
                        }
                        if (!empty($size->attribute_chest)) {
                            $attribute_chest = ', Chest: ' . $size->attribute_chest;
                        }
                    }
//                        $activeClass = '';
                    if (empty($activeSize) && $sKey == 0) {

                        $activeClass = 'size_active';
                        $checked = "checked";
                        $image = $size->attribute_image;
                        $activeSize = $size->attribute_id;
                        $product_price = $size->attribute_price;
                        if (!empty($size->attribute_legnth)) {
                            $attribute_legnth = 'Legnth: ' . $size->attribute_legnth;
                        }
                        if (!empty($size->attribute_front)) {
                            $attribute_front = ', Front: ' . $size->attribute_front;
                        }
                        if (!empty($size->attribute_back)) {
                            $attribute_back = ', Back: ' . $size->attribute_back;
                        }
                        if (!empty($size->attribute_chest)) {
                            $attribute_chest = ', Chest: ' . $size->attribute_chest;
                        }
                    }
//                   
                    $output .= '<label for="size_' . $sKey . '" class="click_size">
                    <div class="check-box_inr_size">
                        <div class="size ' . $activeClass . '">
                            <span class="value"><b>' . $size->title . '</b></span>
                            <input ' . $checked . ' data-sizename="' . $size->title . '" data-price="' . $size->attribute_price . '"
                                   data-size_id="' . $size->attribute_id . '" data-product_id="' . $product_id . '"
                                     class="click_size hidden" id="size_' . $sKey . '"
                                   name="product_attribute_size" type="radio" value="' . $size->attribute_id . '">
                        </div>
                    </div>
                </label>
                     ';
                }
//                var_dump($attribute_legnth);
//                exit;
                if (!empty($image)) {
                    $image_path = pathinfo($image);
                    $final_imagename = $image_path['filename'];
                    $final_extension = $image_path['extension'];
                    $data['attribute_image'] = '<img id="product-zoom" src="' . url('/storage/uploads/' . $final_imagename . '_472x575.' . $final_extension) . '" data-zoom-image="' . url('/storage/uploads/' . $final_imagename . '_1000x1500.' . $final_extension) . '" class="image-style" alt="Product-11">';
                } else {
                    $final_imagename = '';
                    $final_extension = '';
                    $data['attribute_image'] = '';
                }


                $data['attribute_measurement'] = $attribute_legnth . $attribute_front . $attribute_back . $attribute_chest;
                $data['product_price'] = $product_price;
                $data['attribute_label'] = $output;
                return Response()->json($data);
//                return Response($output);
            } else {
                return Response()->json(['no' => 'Not found']);
            }
        }
    }

    public function product_size_by_color(Request $request)
    {
        if ($request->ajax()) {
            $product_id = $request->product_id;
            $size_id = $request->size_id;
            $activeColor = $request->activeColor;
            $output = "";
            $customers = DB::table('attribute_product')
                ->join('attributes', 'attribute_product.color_id', 'attributes.id')
                ->where('product_id', $product_id)
                ->where('attribute_id', $size_id)
                ->groupBy('color_id')
                ->get();
            $attribute_legnth = '';
            $attribute_front = '';
            $attribute_back = '';
            $attribute_chest = '';

            if ($customers) {
                foreach ($customers as $cKey => $color) {
                    $activeClass = '';
                    $checked = "";
                    if ($activeColor == $color->color_id) {
                        $activeClass = 'color_active';
                        $checked = "checked";
                        $image = $color->attribute_image;
                        if (!empty($color->attribute_legnth)) {
                            $attribute_legnth = 'Legnth: ' . $color->attribute_legnth;
                        }
                        if (!empty($color->attribute_front)) {
                            $attribute_front = ', Front: ' . $color->attribute_front;
                        }
                        if (!empty($color->attribute_back)) {
                            $attribute_back = ', Back: ' . $color->attribute_back;
                        }
                        if (!empty($color->attribute_chest)) {
                            $attribute_chest = ', Chest: ' . $color->attribute_chest;
                        }
                    }

                    $output .= '<label for="color_' . $cKey . '" class="click_color">
                    <div class="check-box_inr_color">
                        <div class="color ' . $activeClass . '">
                            <span class="value"><b>' . $color->title . '</b></span>
                            <input ' . $checked . ' data-price="' . $color->attribute_price . '" data-product_id="' . $product_id . '"
                                   data-color_id="' . $color->color_id . '" data-colorname="' . $color->title . '"
                                   value="' . $color->color_id . '"  class="click_color hidden" id="color_' . $cKey . '"
                                    name="product_attribute_color" type="radio">
                        </div>
                    </div>
                </label> 
                ';
                }

                if (!empty($image)) {
                    $image_path = pathinfo($image);
                    $final_imagename = $image_path['filename'];
                    $final_extension = $image_path['extension'];
                    $data['attribute_image'] = '<img id="product-zoom" src="' . url('/storage/uploads/' . $final_imagename . '_472x575.' . $final_extension) . '" data-zoom-image="' . url('/storage/uploads/' . $final_imagename . '_1000x1500.' . $final_extension) . '" class="image-style" alt="Product-11">';
                } else {
                    $final_imagename = '';
                    $final_extension = '';
                    $data['attribute_image'] = '';
                }

                $data['attribute_measurement'] = $attribute_legnth . $attribute_front . $attribute_back . $attribute_chest;
                $data['attribute_label'] = $output;
                return Response()->json($data);
            } else {
                return Response()->json(['no' => 'Not found']);
            }
        }
    }

    public function categoryByProduct($slug)
    {
        $data["brands"] = Brand::Published()->get();
        $data["colors"] = Attribute::Published()->Color()->get();
        $data["sizes"] = Attribute::Published()->Size()->get();
        $data["categories"] = Category::Published()
            ->get();
        $data["categoryInfo"] = SM::getCache('category_' . $slug, function () use ($slug) {
            return Category::with("products")
                ->where("slug", $slug)
                ->where('status', 1)
                ->first();
        });
        if (count($data["categoryInfo"]) > 0) {
            $page = \request()->input('page', 0);
            $key = 'categoryProducts_' . $data["categoryInfo"]->id . '_' . $page;
            $data["products"] = SM::getCache(
                $key, function () use ($data) {
                $product_posts_per_page = SM::smGetThemeOption(
                    "shop_page_per_product", config("constant.smFrontPagination")
                );
                return $data["categoryInfo"]->products()
                    ->where("status", 1)
                    ->paginate($product_posts_per_page);
            }, ['categoryProducts']
            );

            $data['seo_title'] = $data['categoryInfo']->seo_title;
            $data["meta_key"] = $data["categoryInfo"]->meta_key;
            $data["meta_description"] = $data["categoryInfo"]->meta_description;
            $data["image"] = $data["categoryInfo"]->image != '' ? asset(SM::sm_get_the_src($data["categoryInfo"]->image, 750, 560)) : '';
            $data["category"] = Category::where('slug', $slug)->first();
            return view('frontend.products.category_by_product', $data);
        } else {
            return abort(404);
        }
    }

    public function tagByProduct($slug)
    {
        $data["tagInfo"] = SM::getCache('tag_' . $slug, function () use ($slug) {
            return Tag::with("products")
                ->where("slug", $slug)
                ->where('status', 1)
                ->first();
        });
        if (count($data["tagInfo"]) > 0) {
            $page = \request()->input('page', 0);
            $key = 'tagProducts_' . $data["tagInfo"]->id . '_' . $page;
            $data["products"] = SM::getCache($key, function () use ($data) {

                $blog_posts_per_page = SM::smGetThemeOption(
                    "shop_page_per_product",
                    config("constant.smFrontPagination")
                );

                return $data["tagInfo"]->products()
                    ->where("status", 1)
                    ->paginate($blog_posts_per_page);
            }, ['tagProducts']);
            $data['key'] = $key;
            $data['seo_title'] = $data['tagInfo']->seo_title;
            $data["meta_key"] = $data["tagInfo"]->meta_key;
            $data["meta_description"] = $data["tagInfo"]->meta_description;
            return view('frontend.products.tag_by_product', $data);
        } else {
            return abort(404);
        }
    }

    public function shopDetails()
    {
        return view('frontend.page.shopDetails');
    }

    public function main_search(Request $request)
    {
        $search_text = $request->input('search_text');
        $list = $this->getProductSearchData($search_text);
        echo $list;
        exit();
    }

    private function getProductSearchData($text)
    {
        $output = '';
        $product_data = Product::where("title", "like", "%" . $text . "%")
            ->orWhere("short_description", "like", "%" . $text . "%")
            ->orWhere("long_description", "like", "%" . $text . "%")
            ->orWhere("sku", "like", "%" . $text . "%")
            ->latest()
            ->paginate(config("constant.smPagination"));
        if (count($product_data) > 0) {
            $output .= '<div class="container">
                           <div class="countData"> Product found: ' . count($product_data) . ' to search for "' . $text . '" </div>
                           <ul class="row product-list grid"> ';
            foreach ($product_data as $product) {
                if ($product->product_type == 2) {
                    $att_data = SM::getAttributeByProductId($product->id);
                    if (!empty($att_data->attribute_image)) {
                        $attribute_image = $att_data->attribute_image;
                    } else {
                        $attribute_image = $product->image;
                    }
                    $output .= ' <li class="col-sx-12 col-sm-4 col-md-3">
                            <div class="product-container">
                                <div class="left-block">
                                    <a href="' . url('product/' . $product->slug) . '">
                                        <img class="img-responsive" alt="product" src="' . SM::sm_get_the_src($attribute_image, 268, 327) . '" />
                                    </a>
                                    <div class="quick-view">';
                    $output .= SM::quickViewHtml($product->id, $product->slug) . '
                                    </div>
                                  
                                    <div class="add-to-cart">';
                    $output .= SM::addToCartButton($product->id, $product->regular_price, $product->sale_price) . '  
                                    </div>
                                </div>
                                <div class="right-block">
                                    <h5 class="product-name">
                                    <a href="' . url('product/' . $product->slug) . '">' . $product->title . '</a>
                                    </h5>
                                     <div class="product-star">
                    ' . SM::product_review($product->id) . '
                                    </div>
                                    <div class="content_price">';
                    $output .= '  <span class="price product-price">' . SM::currency_price_value($att_data->attribute_price) . '</span>';
                    $output .= ' 
                                  </div>
                                    <div class="info-orther">
                                        <p>Item Code: #453217907</p>
                                        <p class="availability">Availability: <span>' . $product->stock_status . '</span></p>
                                        <div class="product-desc">
                    ' . $product->short_description . '
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    ';
                } else {
                    $output .= '  
                          <li class="col-sx-12 col-sm-4 col-md-3">
                            <div class="product-container">
                                <div class="left-block">
                                    <a href="' . url('product/' . $product->slug) . '">
                                        <img class="img-responsive" alt="product" src="' . SM::sm_get_the_src($product->image, 268, 327) . '" />
                                    </a>
                                    <div class="quick-view">';
                    $output .= SM::quickViewHtml($product->id, $product->slug) . '
                                    </div>
                                  
                                    <div class="add-to-cart">';
                    $output .= SM::addToCartButton($product->id, $product->regular_price, $product->sale_price) . '  
                                    </div>
                                </div>
                                <div class="right-block">
                                    <h5 class="product-name">
                                    <a href="' . url('product/' . $product->slug) . '">' . $product->title . '</a>
                                    </h5>
                                     <div class="product-star">
                    ' . SM::product_review($product->id) . '
                                        
                                    </div>
                                    <div class="content_price">';
                    if ($product->sale_price > 0) {
                        $output .= ' <span class="price product-price">' . SM::currency_price_value($product->sale_price) . '</span>
                                 <span class="price old-price">' . SM::currency_price_value($product->regular_price) . '</span>';
                    } else {
                        $output .= '  <span class="price product-price">' . SM::currency_price_value($product->regular_price) . '</span>';
                    }
                    $output .= ' 
                                  </div>
                                    <div class="info-orther">
                                        <p>Item Code: #453217907</p>
                                        <p class="availability">Availability: <span>' . $product->stock_status . '</span></p>
                                        <div class="product-desc">
                    ' . $product->short_description . '
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li> 
                         ';
                }
            }
            $output .= '<div>';
             return $output;
        } else {
            $output = '<div class="container">
                            <ul class="row product-list grid">
                            No data found!
                            </ul>
                        </div>';
            return $output;
        }

       
    }

}
