<?php

namespace App\Http\Controllers\Front;

use DB;
use Cart;
use App\SM\SM;
use App\Model\Common\Review;
use Illuminate\Http\Request;
use App\Model\Common\Payment;
use App\Model\Common\Product;
use App\Model\Common\Wishlist;
use App\Http\Controllers\Controller;
use App\Model\Common\ShippingMethod;
use App\Model\Common\Payment_method;
use Illuminate\Support\Facades\Auth;
use App\Model\Common\AttributeProduct;
use App\Http\Controllers\Front\Session;

class CartController extends Controller
{

    public function cart()
    {
        $data["cart"] = Cart::instance('cart')->content();
        $data['shippingMethods'] = ShippingMethod::Published()->get();
        $data['paymentMethods'] = Payment_method::Published()->get();
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
                        //                        'qty' => $qty,
                        'qty' => 1,
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
                        'qty' => 1,
                        'options' => array(
                            'image' => $product_info->image,
                            'slug' => $product_info->slug,
                            'sku' => $product_info->sku,
                        )
                    ),
                ));
            }


            $output['header_cart_html'] = $this->header_cart_html();
            $output['right_cart_html'] = $this->right_cart_html();
            $output['cart_icon'] = $this->cart_icon();
            $output['title'] = 'Product is added';
            $output['message'] = 'thank you for your order';
            $output['cart_icon_pop'] = $this->cart_icon_cart_pop();
            $output['popup_top_total'] = $this->popup_top_total();
            $output['sub_total'] = SM::currency_price_value(Cart::instance('cart')->subTotal());
            $item = Cart::instance('cart')->content()->where('id', $id)->first();
            $output['added_success'] = '<div class="input-group">
                        <input type="button" data-row_id="' . $item->rowId . '" value="-" class="button-minus dec">
                        <input type="text" id="' . $item->rowId . '" value="' . $item->qty . '" name="qty" class="quantity-field qty-inc-dc">
                        <input type="button" data-row_id="' . $item->rowId . '" value="+" class="button-plus inc">
                    </div>';
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

    public function update_to_cart(Request $request)
    {
        if ($request->ajax()) {
            $rowId = $request->row_id;
            $qty = $request->qty;
            $product_cart = Cart::instance('cart')->get($request->row_id);
            $product = Product::find($product_cart->id);
            $cart_qty = $product_cart->qty + 1;

            if ($product->product_type == 2) {
                $attributeProduct_id = AttributeProduct::where('product_id', $product_cart->id)
                    ->where('attribute_id', $product_cart->options->size)
                    ->where('color_id', $product_cart->options->color)->first();
                if ($attributeProduct_id->attribute_qty >= $cart_qty) {
                    Cart::instance('cart')->update($rowId, $qty);
                    $output['header_cart_html'] = $this->header_cart_html();
                    $output['right_cart_html'] = $this->right_cart_html();
                    $output['cart_icon'] = $this->cart_icon();
                    $output['cart_table'] = $this->cart_table();
                    $output['cart_icon_pop'] = $this->cart_icon_cart_pop();
                    $output['popup_top_total'] = $this->popup_top_total();
                    $output['sub_total'] = SM::currency_price_value(Cart::instance('cart')->subTotal());
                    $item = Cart::instance('cart')->content()->where('rowId', $rowId)->first();
                    $output['added_success'] = '<div class="input-group">
                                      <input type="button" data-row_id="' . $item->rowId . '" value="-" class="button-minus dec">
                                      <input type="text" id="' . $item->rowId . '" value="' . $item->qty . '" name="qty" class="quantity-field qty-inc-dc">
                                      <input type="button" data-row_id="' . $item->rowId . '" value="+" class="button-plus inc">
                                    </div>';
                    $output['title'] = 'Product is Update';
                    $output['message'] = 'thank you';
                    echo json_encode($output);
                } elseif ($attributeProduct_id->attribute_qty > $request->qty) {
                    Cart::instance('cart')->update($rowId, $qty);
                    $output['header_cart_html'] = $this->header_cart_html();
                    $output['right_cart_html'] = $this->right_cart_html();
                    $output['cart_icon'] = $this->cart_icon();
                    $output['cart_table'] = $this->cart_table();
                    $output['cart_icon_pop'] = $this->cart_icon_cart_pop();
                    $output['popup_top_total'] = $this->popup_top_total();
                    $output['sub_total'] = SM::currency_price_value(Cart::instance('cart')->subTotal());
                    $output['title'] = 'Product is Update';
                    $output['message'] = 'thank you';
                    echo json_encode($output);
                } else {
                    $output['header_cart_html'] = $this->header_cart_html();
                    $output['right_cart_html'] = $this->right_cart_html();
                    $output['cart_icon'] = $this->cart_icon();
                    $output['cart_table'] = $this->cart_table();
                    $output['cart_icon_pop'] = $this->cart_icon_cart_pop();
                    $output['popup_top_total'] = $this->popup_top_total();
                    $output['sub_total'] = SM::currency_price_value(Cart::instance('cart')->subTotal());
                    $output['title'] = 'Max Quantity Available ' . $attributeProduct_id->attribute_qty;
                    $output['message'] = 'Try Again...';
                    $output['exists_cart'] = 1;
                    echo json_encode($output);
                }
            } else {
                if ($product->product_qty >= $cart_qty) {
                    Cart::instance('cart')->update($rowId, $qty);
                    $output['header_cart_html'] = $this->header_cart_html();
                    $output['right_cart_html'] = $this->right_cart_html();
                    $output['cart_icon'] = $this->cart_icon();
                    $output['cart_table'] = $this->cart_table();
                    $output['title'] = 'Product is Update';
                    $output['message'] = 'thank you';
                    echo json_encode($output);
                } elseif ($product->product_qty > $request->qty) {
                    Cart::instance('cart')->update($rowId, $qty);
                    $output['header_cart_html'] = $this->header_cart_html();
                    $output['right_cart_html'] = $this->right_cart_html();
                    $output['cart_icon'] = $this->cart_icon();
                    $output['cart_table'] = $this->cart_table();
                    $output['title'] = 'Product is Update';
                    $output['message'] = 'thank you';
                    echo json_encode($output);
                } else {
                    $output['header_cart_html'] = $this->header_cart_html();
                    $output['right_cart_html'] = $this->right_cart_html();
                    $output['cart_icon'] = $this->cart_icon();
                    $output['cart_table'] = $this->cart_table();
                    $output['title'] = 'Max Quantity Available ' . $product->product_qty;
                    $output['message'] = 'Try Again...';
                    $output['exists_cart'] = 1;
                    echo json_encode($output);
                }
            }
        }
    }

    public function remove_to_cart(Request $request)
    {
        if ($request->ajax()) {
            $output = array();
            $id = $request->product_id;
            $cat = Cart::instance('cart')->content()->where('rowId', $id)->first();
            if (!empty($cat)) {
                Cart::instance('cart')->remove($id);
                $output['cart_count'] = Cart::instance('cart')->count();
                $output['header_cart_html'] = $this->header_cart_html();
                $output['right_cart_html'] = $this->right_cart_html();
                $output['cart_icon'] = $this->cart_icon();
                $output['cart_table'] = $this->cart_table();
                $output['title'] = 'This Product remove';
                $output['popup_top_total'] = $this->popup_top_total();
                $output['sub_total'] = SM::currency_price_value(Cart::instance('cart')->subTotal());
                $output['message'] = 'thank you';
                echo json_encode($output);
            }
        }
    }

    public function header_cart_html()
    {
        $html = '<a title="My cart" href="' . url('/cart') . '"  style="display: flex;">
                <div class="card_view">
                    <img src="' . url('frontend/images/favorite-cart.gif') . '" alt="">
                </div>
                <div class="shoping_cart_text">
                    <p>Shopping Cart</p>
                    <span>' . Cart::instance('cart')->count() . ' items</span>
                        <span>- ৳ ' . Cart::total() . '</span>
                </div>
                
                </a>


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
                                             src="' . SM::sm_get_the_src($item->options->image, 100, 100) . '"
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

    public function right_cart_html()
    {
        $items = Cart::instance('cart')->content();
        $html = '';

        if ($items->isEmpty()) {
            $html .= '<div class="empty_img image-emty">';
            $html .= '<img src="' . url('frontend/images/favorite-cart.gif') . '" alt="">';
            $html .= '</div>';
            $html .= '<div class="text-center">';
            $html .= '<span>Empty Cart</span>';
            $html .= '</div>';
        } else {
            foreach ($items as $id => $item) {
                $html .= '<div class="add-pro-liner">';
                $html .= '<div class="counting">';
                $html .= '<i class="fa fa-plus inc" data-row_id="' . $item->rowId . '" style="color: green;"></i>';
                $html .= '<input type="hidden" name="qty" class="form-control input-sm qty-inc-dc" id="' . $item->rowId . '" value="' . $item->qty . '">';
                $html .= '<h3 class="itemqty"><span>' . $item->qty . '</span></h3>';
                $html .= '<i class="fa fa-minus dec" data-row_id="' . $item->rowId . '" style="color: green;"></i>';
                $html .= '</div>';
                $html .= '<img src="' . SM::sm_get_the_src($item->options->image, 100, 122) . '" alt="' . $item->name . '">';
                $html .= '<div class="pro-head">';
                $html .= '<h3>' . $item->name . '</h3>';
                $html .= '<h3 class="ammount">' . SM::currency_price_value($item->price) . '</h3>';
                $html .= '</div>';
                $html .= '<span class="pro-close removeToCart" data-product_id="' . $id . '" onclick="delete_cart_product(' . $id . ')"><i class="fa fa-times-circle"></i></span>';
                $html .= '</div>';
                $html .= '<hr>';
            }
        }

        return $html;
    }

    public function cart_icon()
    {
        $html = '<i class="fa fa-shopping-cart"></i>
                <span class="notify notify-right">' . Cart::instance('cart')->count() . '</span>
                <div class="shopping-cart-box-ontop-content"></div>';
        return $html;
    }

    public function cart_icon_cart_pop()
    {
        $html = '<img src="' . url('frontend/images/favorite-cart.gif') . '">
                    <p>' . Cart::instance('cart')->count() . ' Item(s)</p>
        <p> <span>' . SM::currency_price_value(Cart::instance('cart')->subTotal()) . '</span></p>';
        return $html;
    }

    public function popup_top_total()
    {
        $html = '<i class="fa fa-shopping-bag"></i>' . Cart::instance('cart')->count() . ' Items in my cart';
        return $html;
    }

    public function cart_table()
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
                                    <img src="' . SM::sm_get_the_src($item->options->image, 100, 100) . '"
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
    public function compare()
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

    public function add_to_wishlist(Request $request)
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

    public function remove_to_wishlist(Request $request)
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
