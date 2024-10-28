<?php

namespace App\Http\Controllers\Front;

use App\Model\Common\Product;
use App\Model\Common\Review;
use App\Model\Common\Wishlist;
use App\SM\SM;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cart;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Http\Controllers\Front\Session;
use App\Model\Common\AttributeProduct;

class CartController extends Controller
{

    public function cart()
    {
        $data["cart"] = Cart::instance('cart')->content();
        if (count($data["cart"]) > 0) {
            return view('frontend.products.cart', $data);
        } else {
            return redirect('/shop')->with('s_message', "Please Order First...!");
        }
    }

    public function add_to_cart(Request $request)
    {
        if ($request->ajax()) {
            $output = array();
            $id = $request->product_id;
            $qty = $request->qty;
            $product_attribute_size = $request->product_attribute_size;
            $product_attribute_color = $request->product_attribute_color;
            $sizename = $request->sizename;
            $colorname = $request->colorname;
            $product_info = Product::find($id);

            if ($product_info->product_type == 2) {
                $attribute_product = AttributeProduct::where('product_id', $id)->where('attribute_id', $product_attribute_size)->where('color_id', $product_attribute_color)->first();
                if (!empty($attribute_product->attribute_image)) {
                    $attribute_image = $attribute_product->attribute_image;
                } else {
                    $attribute_image = $product_info->image;
                }
                Cart::instance('cart')->add(array(
                    array(
                        'id' => $id,
                        'name' => $product_info->title,
                        'price' => $attribute_product->attribute_price,
                        'qty' => $qty,
                        'options' => array(
                            'image' => $attribute_image,
                            'slug' => $product_info->slug,
                            'sku' => $product_info->sku,
                            'size' => $product_attribute_size,
                            'color' => $product_attribute_color,
                            'sizename' => $sizename,
                            'colorname' => $colorname,
                        )
                    ),
                ));
            } else {
                if ($product_info->sale_price > 0) {
                    $product_price = $product_info->sale_price;
                } else {
                    $product_price = $product_info->regular_price;
                }
                Cart::instance('cart')->add(array(
                    array(
                        'id' => $id,
                        'name' => $product_info->title,
                        'price' => $product_price,
                        'qty' => $qty,
                        'options' => array(
                            'image' => $product_info->image,
                            'slug' => $product_info->slug,
                            'sku' => $product_info->sku,
                        )
                    ),
                ));
            }


            $output['header_cart_html'] = $this->header_cart_html();
            $output['cart_icon'] = $this->cart_icon();
            $output['title'] = 'Product is added';
            $output['message'] = 'thank you for your order';
            echo json_encode($output);
        }
    }

    public function add_to_compare(Request $request)
    {
        if ($request->ajax()) {
            $output = array();
            $id = $request->product_id;
            $exists_compare = Cart::instance('compare')->content()->where('id', $id)->first();
            if (!empty($exists_compare)) {
                $output['exists_compare'] = 1;
                $output['error_title'] = 'This Product Already compare';
                $output['error_message'] = 'This Product Already compare';
                echo json_encode($output);
            } else {
                $product_info = Product::find($id);
                $brand_name = $product_info->brand->title;
                Cart::instance('compare')->add(array(
                    array(
                        'id' => $id,
                        'name' => $product_info->title,
                        'price' => $product_info->regular_price,
                        'qty' => 1
                    ),
                ));
                $output['compare_count'] = Cart::instance('compare')->count();
                $output['title'] = 'Product added to compare';
                $output['message'] = 'thank you for compare';
                echo json_encode($output);
                //        }
            }
        }
    }

    public
    function update_to_cart(Request $request)
    {
        if ($request->ajax()) {
            $rowId = $request->row_id;
            $qty = $request->qty;
            Cart::instance('cart')->update($rowId, $qty);
            $output['header_cart_html'] = $this->header_cart_html();
            $output['cart_icon'] = $this->cart_icon();
            $output['cart_table'] = $this->cart_table();
            $output['title'] = 'Product is Update';
            $output['message'] = 'thank you';
            echo json_encode($output);
        }
    }

    public
    function remove_to_cart(Request $request)
    {
        if ($request->ajax()) {
            $output = array();
            $id = $request->product_id;
            $cat = Cart::instance('cart')->content()->where('rowId', $id)->first();
            if (!empty($cat)) {
                Cart::instance('cart')->remove($id);
                $output['cart_count'] = Cart::instance('cart')->count();
                $output['header_cart_html'] = $this->header_cart_html();
                $output['cart_icon'] = $this->cart_icon();
                $output['cart_table'] = $this->cart_table();
                $output['title'] = 'This Product remove';
                $output['message'] = 'thank you';
                echo json_encode($output);
            }
        }
    }

    public
    function header_cart_html()
    {
        $html = '<a title="My cart" href="' . url('/cart') . '">Cart</a>
        <span class="notify notify-right">' . Cart::instance('cart')->count() . '</span>
        <div class="cart-block">
            <div class="cart-block-content">
                <h5 class="cart-title">' . Cart::instance('cart')->count() . ' Items in my cart</h5>
                <div class="cart-block-list">
                    <ul>';
        $items = Cart::instance('cart')->content();
        foreach ($items as $id => $item) {
            $html .= '<li class="product-info">
                                <div class="p-left"> 
                                    <a data-product_id="' . $item->rowId . '" class="remove_link removeToCart"
                                       title="Delete item"
                                       href="javascript:void(0)"></a>
                                    <a href="' . url('product/' . $item->options->slug) . '">
                                        <img class="img-responsive"
                                             src="' . SM::sm_get_the_src($item->options->image, 100, 122) . '"
                                             alt="' . $item->name . '">
                                    </a> 
                                </div>
                                <div class="p-right">
                                    <p class="p-name">' . $item->name . '</p>
                                    <p class="p-rice">' . SM::get_setting_value('currency') . ' ' . number_format($item->price, 2) . '</p>
                                    <p>Qty: ' . $item->qty . '</p>';
            if ($item->options->colorname != '') {
                $html .= '<p>Color: ' . $item->options->colorname . '</p>';
            }
            if ($item->options->sizename != '') {
                $html .= '<p>Size: ' . $item->options->sizename . '</p>';
            }
            $html .= '</div>
                            </li>';
        }
        $html .= ' </ul>
                </div>
                <div class="toal-cart">
                    <span>Total</span>
                    <span class="toal-price pull-right">' . SM::get_setting_value('currency') . ' ' . number_format(Cart::instance('cart')->subTotal(), 2) . '</span>
                </div>
                <div class="cart-buttons">
                    <a href="' . url('/cart') . '" class="btn-check-out">Checkout</a>
                </div>
            </div>
        </div>';
        return $html;
    }

    public
    function cart_icon()
    {
        $html = '<i class="fa fa-shopping-cart"></i>
                <span class="notify notify-right">' . Cart::instance('cart')->count() . '</span>
                <div class="shopping-cart-box-ontop-content"></div>';
        return $html;
    }

    public
    function cart_table()
    {
        $html = '';
        $html .= '
                    <thead>
                        <tr>
                            <th class="cart_product">Product</th>
                            <th>Description</th>
                            <th>Unit price</th>
                          
                            <th>Qty</th>
                            <th>Total</th>
                            <th class="action"><i class="fa fa-trash-o"></i></th>
                        </tr>
                    </thead>
                    <tbody>';
        $cart = Cart::instance('cart')->content();
        foreach ($cart as $id => $item) {
            $html .= '<tr id="tr_' . $item->rowId . '" class="removeCartTrLi">
                            <td class="cart_product">
                                <a href="' . url('product/' . $item->options->slug) . '">
                                    <img src="' . SM::sm_get_the_src($item->options->image, 100, 122) . '"
                                         alt="' . $item->name . '"></a>
                            </td>
                            <td class="cart_description">
                                <p class="product-name">
                                    <a href="' . url('product/' . $item->slug) . '">' . $item->name . ' </a></p>
                                <br>
                           
                                    <small class="cart_ref">SKU : ' . $item->options->sku . '</small>
                                          <br>
                                <small><a href="#">Color : ' . $item->options->colorname . '</a></small>
                                <br>
                                <small><a href="#">Size : ' . $item->options->sizename . '</a></small>
                            </td>
                            
                             <td class="price"><span>' . SM::currency_price_value($item->price) . '</span></td>
                            <td class="qty">
                                <style>
                                    .input-group-btn {
                                        font-size: unset;
                                    }
                                </style>
                                <div class="input-group">
                                    <span id="" class="input-group-btn dec"  data-row_id="' . $item->rowId . '"><i  class="fa fa-minus" aria-hidden="true"></i></span>
                                        <input id="' . $item->rowId . '" class="form-control" name="qty" type="text" value="' . $item->qty . '">
                                   <span class="input-group-btn inc" data-row_id="' . $item->rowId . '" id=""><i  class="fa fa-plus" aria-hidden="true"></i></span> 
                                </div>
                            </td>
                            <td class="price">
                                <span>' . SM::currency_price_value($item->price * $item->qty) . '</span>
                            </td>
                            <td class="action">
                                <a data-product_id="' . $item->rowId . '" class="remove_link removeToCart" title="Delete item"
                                   href="javascript:void(0)"><i class="fa fa-trash-o"></i></a>
                             
                            </td>
                        </tr>';
        }
        $html .= '</tbody>
                    <tfoot class="tfoot_class">
                    <div>
                        <tr>
                            <td colspan="2" rowspan="3"></td>
                            <td colspan="3">Sub Total</td>
                            <td colspan="2">' . SM::currency_price_value(Cart::instance('cart')->subTotal()) . '</td>
                        </tr>
                        <tr>
                            <td colspan="3"><strong>Tex</strong></td>
                            <td colspan="2"><strong>' . SM::currency_price_value(Cart::instance('cart')->tax()) . '</strong></td>
                        </tr>
                        <tr>
                            <td colspan="3"><strong>Total</strong></td>
                            <td colspan="2"><strong>' . SM::currency_price_value(Cart::instance('cart')->total()) . '</strong></td>
                        </tr>
                      
                    </div>
                    </tfoot>
               ';
        return $html;
    }

//    ----------Compare--------------------------
    public
    function compare()
    {
        $data['activeMenu'] = 'compare';
        $data["compares"] = Cart::instance('compare')->content();

        return view("frontend.products.compare", $data);
    }


    public function remove_to_compare(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->product_id;
            $cat = Cart::instance('compare')->content()->where('rowId', $id)->first();
            if (!empty($cat)) {
                Cart::instance('compare')->remove($id);
                $output['compare_count'] = Cart::instance('compare')->count();
                $output['title'] = 'Compare remove';
                $output['message'] = 'thank you';
                echo json_encode($output);
            }
        }
//        Cart::instance('compare')->remove($rowId);
//        return redirect()->back()->with('s_message', 'Product removed Compare!');
    }

//-----------wishlist---------

    public
    function add_to_wishlist(Request $request)
    {
        if ($request->ajax()) {
            $check_wishlist = Wishlist::where('product_id', $request->product_id)->where('user_id', Auth::id())->first();
            if (!empty($check_wishlist)) {
                $output['check_wishlist'] = 1;
                $output['error_title'] = 'This Product Already wishlist';
                $output['error_message'] = 'This Product Already wishlist';
                echo json_encode($output);
            } else {
                $wishlistModel = new Wishlist;
                $wishlistModel->product_id = $request->product_id;
                $wishlistModel->user_id = Auth::id();
                $wishlistModel->save();
//            $output['compare_count'] = Auth::user()->wishlists->count();
                $output['title'] = 'Product added to wishlist';
                $output['message'] = 'thank you for wishlists';
                echo json_encode($output);
            }
        }
    }

    public
    function remove_to_wishlist(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->wshlist_id;
            $wishlist = Wishlist::find($id);
            if (!empty($wishlist)) {
                Wishlist::destroy($id);
                $output['title'] = 'Wishlist remove';
                $output['message'] = 'thank you';
                echo json_encode($output);
            }
        }
    }

    //-----------review-------------------------

    public function add_to_review(Request $request)
    {
//
        if (Auth::check()) {
            $this->validate($request, [
                'description' => 'required',
                'rating' => 'required'
            ]);

            if ($request->ajax()) {
                $output = array();
                auth()->user()->reviews()->create($request->all());
//                $review = new Review;
//                $review->product_id = $request->product_id;
//                $review->rating = $request->rating;
//                $review->description = $request->description;
//                $review->user_id = Auth::id();
//                $review->save();
                $output['title'] = 'You review submitted admin approved then show!';
                $output['message'] = 'Description';
                $output['check_reviewAuth'] = 0;
                echo json_encode($output);
            }
        } else {
            $output['error_title'] = 'Please Login First...!';
            $output['error_message'] = '';
            $output['check_reviewAuth'] = 1;
            echo json_encode($output);
        }
    }

    function remove_to_review(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->review_id;
            $wishlist = Review::find($id);
            if (!empty($wishlist)) {
                Review::destroy($id);
                $output['title'] = 'Product Review remove';
                $output['message'] = 'thank you';
                echo json_encode($output);
            }
        }
        return back()->with('s_message', "Wishlist Remove Successfully!");
    }

}
