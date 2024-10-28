<?php

namespace App\Http\Controllers\Admin\Common;

use App\Model\Common\Attribute;
use App\Model\Common\AttributeProduct;
use App\Model\Common\Brand;
use App\Model\Common\Comment;
use App\Model\Common\Review;
use App\Model\Common\Tag;
use App\Model\Common\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SM\SM;
use App\Model\Common\Product as Product;
use App\Model\Common\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Products extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['rightButton']['iconClass'] = 'fa fa-plus';
        $data['rightButton']['text'] = 'Add Product';
        $data['rightButton']['link'] = 'products/create';
        $data['all_product'] = Product::orderBy("id", "desc")
                ->paginate(config("constant.smPagination"));
        if (\request()->ajax()) {
            $json['data'] = view('nptl-admin/common/product/products', $data)->render();
            $json['smPagination'] = view('nptl-admin/common/common/pagination_links', [
                'smPagination' => $data['all_product']
                    ])->render();

            return response()->json($json);
        }

        return view("nptl-admin/common/product/manage_product", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data['rightButton']['iconClass'] = 'fa fa-list';
        $data['rightButton']['text'] = 'Product List';
        $data['rightButton']['link'] = 'products';
        $data["all_categories"] = Category::where("parent_id", 0)->get();
        $data["size_lists"] = Attribute::Size()->orderBy('title')->pluck('title', 'id');
        $data["color_lists"] = Attribute::Color()->orderBy('title')->pluck('title', 'id');
        $data["all_brands"] = Brand::orderBy('title')->pluck('title', 'id');
        $data["all_units"] = Unit::orderBy('title')->pluck('title', 'id');

        return view("nptl-admin/common/product/add_product", $data);
    }

    public function productAttributeAddMore(Request $request) {
        $image2 = rand(1000, 99999);
        if ($request->ajax()) {
            $output = '';
            $size_lists = Attribute::Size()->orderBy('title')->pluck('title', 'id');
            $color_lists = Attribute::Color()->orderBy('title')->pluck('title', 'id');

            $input_holder = 'attribute_image' . rand(500, 99999);
            $input_name = 'attribute_image[]';
            $img_holder = 'first_ph2' . rand(500, 99999);
//            @include("nptl-admin.common.common.small_image_form", array('header_name' => 'Product', 'image' => '', 'input_holder' => $input_holder, 'img_holder' => $img_holder))


            $importform = view("nptl-admin.common.common.small_image_form", array('header_name' => 'Product', 'image' => '', 'input_name' => $input_name, 'input_holder' => $input_holder, 'img_holder' => $img_holder));
            $output .= '<tr> 
                                <td>
                                     <input type="hidden" value="0" name="detail_id[]">
                                       ' . \Form::select('attribute_id[]', $size_lists, null, ['required', 'id' => 'attribute_id', 'class' => 'select2', 'placeholder' => 'Please select...']) . '
                                    </td>
                                    <td>
                                       ' . \Form::select('color_id[]', $color_lists, null, ['required', 'id' => 'color_id', 'class' => 'select2', 'placeholder' => 'Please select...']) . '
                                    </td>
                                    <td>
                                       ' . \Form::text('attribute_legnth[]', null, array('autocomplete' => 'off', 'class' => 'form-control attribute_legnth', 'placeholder' => 'Legnth')) . '&nbsp;
                                       ' . \Form::text('attribute_front[]', null, array('autocomplete' => 'off', 'class' => 'form-control attribute_front', 'placeholder' => 'Front')) . '&nbsp;
                                       ' . \Form::text('attribute_back[]', null, array('autocomplete' => 'off', 'class' => 'form-control attribute_back', 'placeholder' => 'Back')) . '&nbsp;
                                       ' . \Form::text('attribute_chest[]', null, array('autocomplete' => 'off', 'class' => 'form-control attribute_chest', 'placeholder' => 'Chest')) . '&nbsp;
                                    </td>
                                    <td>
                                       ' . \Form::number('attribute_qty[]', null, array('autocomplete' => 'off', 'class' => 'form-control attribute_qty', 'placeholder' => 'Qty')) . '
                                    </td>
                                    <td>
                                       ' . \Form::number('attribute_price[]', null, array('autocomplete' => 'off', 'class' => 'form-control attribute_price', 'placeholder' => 'Price')) . '
                                    </td>
                                    <td>' . $importform . '</td>
                                    <td>
                                        <button type="button" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove"></i></button>
                                    </td>
                                </tr>';

            return response()->json($output);
//            echo $output;
            // exit;
        } else {
            return Response()->json(['no' => 'Not found']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required',
//            'image' => "required",
            'sku' => 'required | max:150 | unique:products',
            'categories' => 'required | array',
            'regular_price' => 'required',
//            'attributes123' => 'required | array',
//            'seo_title' => 'max:70',
//            'meta_description' => 'max:215'
        ]);
//        var_dump($request->attribute_id);
//        exit();
        if (!empty($request->input("sale_price"))) {
            $sale_price = $request->input("sale_price");
        } else {
            $sale_price = 0;
        }
        $product = new Product();
        $product->title = $request->input("title");
        $product->short_description = $request->input("short_description", "");
        $product->long_description = $request->input("long_description", "");
//        ---------------
        $product->sku = $request->input("sku", "");
        $product->stock_status = $request->input("stock_status", "");
//        $product->is_special = $request->input("is_special", "");
        $product->tax_class = $request->input("tax_class", "");
        $product->regular_price = $request->input("regular_price", "");
        $product->sale_price = $sale_price;
        $product->brand_id = $request->input("brand_id", "");
        $product->product_qty = $request->input("product_qty", "");
        $product->alert_quantity = $request->input("alert_quantity", "");
        $product->product_weight = $request->input("product_weight", "");
        $product->unit_id = $request->input("unit_id", "");
        $product->product_model = $request->input("product_model", "");
        $product->product_type = $request->input("product_type", "");
//        --------------
        $product->seo_title = $request->input("seo_title", "");
        $product->meta_key = $request->input("meta_key", "");
        $product->meta_description = $request->input("meta_description", "");
        $permission = SM::current_user_permission_array();
        if (SM::is_admin() || isset($permission) &&
                isset($permission['products']['product_status_update']) && $permission['products']['product_status_update'] == 1) {
            $product->status = $request->status;
        }

        if (isset($request->image) && $request->image != '') {
            $product->image = $request->image;
        }

        if (isset($request->image_gallery) && $request->image_gallery != '') {
            $product->image_gallery = $request->image_gallery;
        }
        $slug = (trim($request->slug) != '') ? $request->slug : $request->title;
        $product->slug = SM::create_uri('products', $slug);
        $product->created_by = SM::current_user_id();
//        $product->save();
        if ($product->save()) {
            $productId = $product->id;

            if (!empty($request->attribute_id[0])) {
                $data = [];
                foreach ($request->attribute_id as $key => $v) {
                    $data = array(
                        'attribute_id' => $v,
                        'product_id' => $productId,
                        'color_id' => $request->color_id [$key],
                        'attribute_legnth' => $request->attribute_legnth [$key],
                        'attribute_front' => $request->attribute_front [$key],
                        'attribute_back' => $request->attribute_back [$key],
                        'attribute_chest' => $request->attribute_chest [$key],
                        'attribute_qty' => $request->attribute_qty [$key],
                        'attribute_price' => $request->attribute_price [$key],
                        'attribute_image' => $request->attribute_image [$key],
                    );
                    AttributeProduct::insert($data);
                }
//            $product->attributes()->attach($request->attributes123);
            }
            foreach ($request->categories as $cat) {
                $categories[$cat]['created_at'] = date("Y-m-d H:i:s");
                $categories[$cat]['updated_at'] = date("Y-m-d H:i:s");
                $catInfo = Category::find($cat);
                if (count($catInfo) > 0) {
                    $catInfo->increment("total_products");
                }
            }
            $product->categories()->attach($categories);

            $tags = SM::insertTag($request->input("tags", ""));
            if ($tags) {
                foreach ($tags as $tag) {
                    $insTags[$tag]['created_at'] = date("Y-m-d H:i:s");
                    $insTags[$tag]['updated_at'] = date("Y-m-d H:i:s");
                    $tagInfo = Tag::find($tag);
                    if ($tagInfo) {
                        $tagInfo->increment("total_products");
                    }
                }
                if ($insTags) {
                    $product->tags()->attach($insTags);
                }
            }
            $this->removeThisCache();

            return redirect(SM::smAdminSlug("products/$product->id/edit"))->with("s_message", "Product successfully saved!");
        } else {
            return redirect(SM::smAdminSlug("products"))->with("w_message", "Product save failed!");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data["product_info"] = Product::with("categories", "tags")->find($id);
        if (count($data["product_info"]) > 0) {
            $data['rightButton']['iconClass'] = 'fa fa - list';
            $data['rightButton']['text'] = 'Product List';
            $data['rightButton']['link'] = 'products';
            $data['rightButton2']['iconClass'] = 'fa fa - eye';
            $data['rightButton2']['text'] = 'View';
            $data['rightButton2']['link'] = "product/" . $data['product_info']->slug;

            $data['product_info']->categories = SM::get_ids_from_data($data['product_info']->categories);
            $data['product_info']->tags = SM::sm_get_product_tags($data['product_info']->tags);
            $data['all_categories'] = Category::where('parent_id', 0)->get();
            $data["size_lists"] = Attribute::Size()->orderBy('title')->pluck('title', 'id');
            $data["color_lists"] = Attribute::Color()->orderBy('title')->pluck('title', 'id');
            $data["all_brands"] = Brand::orderBy('title')->pluck('title', 'id');
            $data["all_units"] = Unit::orderBy('title')->pluck('title', 'id');

            return view("nptl-admin.common.product.edit_product", $data);
        } else {
            return redirect(SM::smAdminSlug("categories"))->with("w_message", "Product Not Found!");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'title' => 'required | max:100',
//            'image' => "required",
            'categories' => 'required | array',
//            'attributes123' => 'required | array',
//            'seo_title' => 'max:70',
//            'meta_description' => 'max:215'
        ]);
        if (!empty($request->input("sale_price"))) {
            $sale_price = $request->input("sale_price");
        } else {
            $sale_price = 0;
        }
        $product = Product::find($id);
        if (count($product) > 0) {
            $this->removeThisCache($product->slug, $product->id);
            $product->title = $request->input("title");
            $product->short_description = $request->input("short_description", "");
            $product->long_description = $request->input("long_description", "");
            //        ---------------
            $product->sku = $request->input("sku", "");
            $product->stock_status = $request->input("stock_status", "");
//            $product->is_special = $request->input("is_special", "");
            $product->tax_class = $request->input("tax_class", "");
            $product->regular_price = $request->input("regular_price", "");
            $product->sale_price = $sale_price;
            $product->brand_id = $request->input("brand_id", "");
            $product->product_qty = $request->input("product_qty", "");
            $product->alert_quantity = $request->input("alert_quantity", "");
            $product->product_weight = $request->input("product_weight", "");
            $product->unit_id = $request->input("unit_id", "");
            $product->product_model = $request->input("product_model", "");
            $product->product_type = $request->input("product_type", "");
//        --------------
            $product->seo_title = $request->input("seo_title", "");
            $product->meta_key = $request->input("meta_key", "");
            $product->meta_description = $request->input("meta_description", "");
//            $product->is_featured = isset($request->is_featured) && $request->is_featured == 'on' ? 1 : 0;
//            $product->is_sticky = isset($request->is_sticky) && $request->is_sticky == 'on' ? 1 : 0;
//            $product->comment_enable = isset($request->comment_enable) && $request->comment_enable == 'on' ? 1 : 0;
            $permission = SM::current_user_permission_array();
            if (SM::is_admin() || isset($permission) &&
                    isset($permission['products']['product_status_update']) && $permission['products']['product_status_update'] == 1) {
                $product->status = $request->status;
            }
            if (isset($request->image) && $request->image != '') {
                $product->image = $request->image;
            }
            if (isset($request->image_gallery) && $request->image_gallery != '') {
                $product->image_gallery = $request->image_gallery;
            }
            $slug = (trim($request->slug) != '') ? $request->slug : $request->title;
            $product->slug = SM::create_uri('products', $slug, $id);
            $product->modified_by = SM::current_user_id();
            $product->update();
            $updateCount = $product->id;

            $productId = $updateCount;
            if (!empty($request->attribute_id[0])) {
                $data = [];
                $row11 = AttributeProduct::where('product_id', $productId)->get();

                if (count($row11) > 0) {
                    foreach ($row11 as $data12) {
                        $array_id[] = $data12->id;
                    }
                    foreach ($request->attribute_id as $key => $v) {
                        $detail_id[] = $request->detail_id [$key];
                    }
                    $remove_data = array_diff($array_id, $detail_id);
                    AttributeProduct::whereIn('id', $remove_data)->delete();
                }


                foreach ($request->attribute_id as $key => $v) {
                    $data = array(
                        'attribute_id' => $v,
                        'product_id' => $productId,
                        'color_id' => $request->color_id [$key],
                        'attribute_legnth' => $request->attribute_legnth [$key],
                        'attribute_front' => $request->attribute_front [$key],
                        'attribute_back' => $request->attribute_back [$key],
                        'attribute_chest' => $request->attribute_chest [$key],
                        'attribute_qty' => $request->attribute_qty [$key],
                        'attribute_price' => $request->attribute_price [$key],
                        'attribute_image' => $request->attribute_image [$key],
                    );
                    $row = AttributeProduct::find($request->detail_id [$key]);
                    if (!empty($row)) {
                        AttributeProduct::where('id', $request->detail_id [$key])->update($data);
                    } else {
                        AttributeProduct::insert($data);
                    }
                }
            }

            if ($updateCount > 0) {
                $oldCatIds = SM::get_ids_from_data($product->categories);
                foreach ($request->categories as $cat) {
                    $categories[$cat]['created_at'] = date("Y-m-d H:i:s");
                    $categories[$cat]['updated_at'] = date("Y-m-d H:i:s");
                    if (!in_array($cat, $oldCatIds)) {
                        $catInfo = Category::find($cat);
                        if (count($catInfo) > 0) {
                            $catInfo->increment("total_products");
                        }
                    }
                }
                $product->categories()->sync($categories);
//                $product->attributes()->sync($request->attributes123);

                $tags = SM::insertTag($request->input("tags", ""));
                $oldTagIds = SM::get_ids_from_data($product->tags);
                if ($tags) {
                    foreach ($tags as $tag) {
                        $insTags[$tag]['created_at'] = date("Y-m-d H:i:s");
                        $insTags[$tag]['updated_at'] = date("Y-m-d H:i:s");
                        $tagInfo = Tag::find($tag);
                        if (!in_array($tag, $oldTagIds)) {
                            if (count($tagInfo) > 0) {
                                $tagInfo->increment("total_products");
                            }
                        }
                    }
                    if ($insTags) {
                        $product->tags()->sync($insTags);
                    }
                }

                return redirect(SM::smAdminSlug("products/$id/edit"))->with("s_message", "Product Updated Successfully!");
            } else {
                return redirect(SM::smAdminSlug("products/$id/edit"))->with("s_message", "Product Update Failed!");
            }
        } else {
            return redirect(SM::smAdminSlug("products"))->with("w_message", "Product Not Found!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $product = Product::with('categories', 'tags', 'attributes')->find($id);
        if (count($product) > 0) {
            if (count($product->categories) > 0) {
                foreach ($product->categories as $category) {
                    if ($category->total_products > 0) {
                        $category->decrement('total_products');
                    }
                }
            }
            $product->attributes()->detach();
            if (count($product->tags) > 0) {
                foreach ($product->tags as $tag) {
                    if ($tag->total_products > 0) {
                        $tag->decrement('total_products');
                    }
                }
            }
            $this->removeThisCache($product->slug, $product->id);

            if ($product->delete() > 0) {
                return response(1);
            }
        }

        return response(0);
    }

    /**
     * status change the specified resource from storage.
     *
     * @param  Request $request
     *
     * @return null
     */
    public function product_status_update(Request $request) {
        $this->validate($request, [
            "post_id" => "required",
            "status" => "required",
        ]);

        $product = Product::find($request->post_id);
        if (count($product) > 0) {
            $this->removeThisCache($product->slug, $product->id);
            $product->status = $request->status;
            $product->update();
        }
        exit;
    }

    /**
     * Get all comment info
     */
    public function reviews() {
        $data["reviews"] = Review::latest()
                ->paginate(config("constant.smPagination"));

        if (\request()->ajax()) {
            $json['data'] = view('sm-admin/common/product/reviews',$data)->render();
            $json['smPagination'] = view('sm-admin/common/common/pagination_links', [
                'smPagination' => $data['reviews']
                    ])->render();

            return response()->json($json);
        }

        return view("nptl-admin/common/product/manage_reviews", $data);
    }

    public function edit_comment($id) {
        $data['comment'] = Comment::leftJoin("products", function ($query) {
                    $query->on("products.id", "=", "comments.commentable_id")
                    ->where("comments.commentable_type", "=", 'App\Model\Common\Product');
                })
                ->where("comments.id", $id)
                ->select('comments .*', 'products . title as product_title')
                ->first();

        return view("nptl-admin/common/product/edit_comment", $data);
    }

    public function update_comment(Request $request, $id) {
        $this->validate($request, ["comments" => "required"]);
        $comment = Comment::find($id);
        if (count($comment) > 0) {
            $comment->comments = $request->comments;
            $comment->modified_by = SM::current_user_id();
            if (SM::is_admin() || isset($permission) &&
                    isset($permission['products']['comment_status_update']) && $permission['products']['comment_status_update'] == 1) {

                if ($comment->commentable_type == Product::class) {
                    $product = Product::find($comment->commentable_id);
                    if ($product) {
                        if ($comment->status == 1 && ($request->status == 2 || $request->status == 3)) {
                            $product->decrement("comments");
                        }
                        if ($request->status == 1 && ($comment->status == 2 || $comment->status == 3)) {
                            $product->increment("comments");
                        }
                        $this->removeThisCache($product->slug, $comment->commentable_id);
                    } else {
                        $this->removeThisCache(null, $comment->commentable_id);
                    }
                } else {
                    $this->removeThisCache(null, $comment->commentable_id);
                }


                $comment->status = $request->status;
            } else {
                $this->removeThisCache(null, $comment->commentable_id);
            }
            $comment->update();

            return redirect(SM::smAdminSlug("products/comments"))->with("s_message", "Comment updated successfully!");
        }

        return redirect(SM::smAdminSlug("products/comments"))->with("w_message", "Comment not found!");
    }

    public function reply_comment($id) {
        $data['comment'] = Comment::leftJoin("products", function ($query) {
                    $query->on("products.id", "=", "comments.commentable_id")
                    ->where("comments.commentable_type", "=", 'App\Model\Common\Product');
                })
                ->where("comments.id", $id)
                ->select('comments .*', 'products . title as product_title')
                ->first();

        return view("nptl-admin/common/product/reply_comment", $data);
    }

    public function save_reply(Request $request) {
        $this->validate($request, [
            "p_c_id" => "required",
            "commentable_id" => "required",
            "commentable_type" => "required",
            "reply" => "required",
        ]);
        $product = Product::find($request->commentable_id);
        if ($product) {
            $product->increment("comments");

            $comment = new Comment();
            $comment->p_c_id = $request->p_c_id;
            $comment->commentable_id = $request->commentable_id;
            $comment->commentable_type = $request->commentable_type;
            $comment->comments = $request->reply;
            $comment->created_by = 1;
            $comment->modified_by = 1;
            if (SM::is_admin() || isset($permission) &&
                    isset($permission['products']['reply_comment']) && $permission['products']['reply_comment'] == 1) {
                $comment->status = $request->status;
            }
            $comment->save();
            $this->removeThisCache(null, $request->commentable_id);

            return redirect(SM::smAdminSlug("products/comments"))->with("s_message", "Comment reply saved successfully!");
        } else {
            return response("Product Not Found!", 404);
        }
    }

    /**
     * delete comment
     *
     * @param $id integer
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete_review($id) {
        $review = Review::find($id);
        if (count($review) > 0) {
            if ($review->delete() > 0) {
                return response(1);
            }
        }

        return response(0);
    }

    /**
     * update comment status
     *
     * @param Request $request
     */
    public function review_status_update(Request $request) {
        $this->validate($request, [
            "post_id" => "required",
            "status" => "required",
        ]);

        $review = Review::find($request->post_id);
        if (count($review) > 0) {
            $review->status = $request->status;
            $review->update();
        }
        exit;
    }

    public function removeThisCache($slug = null, $id = null) {
        SM::removeCache('homeProducts');
        SM::removeCache('sidebar_popular_product');
        if ($slug != null) {
            SM::removeCache('product_' . $slug);
            SM::removeCache('product_related_product_' . $slug);
        }
        if ($id != null) {
            SM::removeCache(['product_comments_count_' . $id], 1);
            SM::removeCache(['product_comments_' . $id], 1);
        }
        SM::removeCache(['categoryProducts'], 1);
        SM::removeCache(['tagProducts'], 1);
        SM::removeCache(['products'], 1);
        SM::removeCache(['stickyProducts'], 1);
    }

}
