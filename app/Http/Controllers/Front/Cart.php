<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SM\SM_Front;
use App\SM\SM_Admin;
use Auth;
use Session;
use App\Model\Product_category;
use App\Model\Product_categoryable;
use App\User;
use App\Model\Users_meta;
use App\Model\Product;
use App\Model\Shipping;
use App\Model\Order;
use App\Model\Order_detail;
use App\Model\Payment as SM_payment;
use App\Http\Requests\Order_validation;
use Illuminate\Support\Facades\Redirect;
//use Libraries\paypal\vendor\composer\ComposerAutoloaderInit35468560aeddd9da66bd8ebcb81e52fat;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\ShippingAddress;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Api\PaymentExecution;
use PayPal\Api\CreditCard;
use PayPal\Api\FundingInstrument;

class Cart extends Controller {

	function cart()
	{
		$data = SM_Front::cart_info();
		return view('Front.Products.cart', $data);
	}

	function add_to_cart()
	{
		if (isset($_GET['id']) && SM_Front::sm_string($_GET['id']))
		{
			$op = array();
			$product_id = trim($_GET['id']);
			$qty = (isset($_GET['qty']) && SM_Front::sm_string($_GET['qty'])) ? $_GET['qty'] : 1;

			$url = \Request::fullUrl();
			if ($pos = strpos($url, '?'))
			{
				$url = substr($url, $pos + 1);
			}
			parse_str($url, $url_array);
			unset($url_array['qty']);

			$cart['cart'] = (Session::has('cart')) ? session('cart') : array();
			if (isset($cart['cart']['products'][$product_id]))
			{
				$cart['cart']['products'][$product_id]['qty'] += $qty;
			}
			else
			{
				$cart['cart']['products'][$product_id]['qty'] = $qty;
				$product = Product::find($product_id);
				$pc = count($product);
				if ($pc > 0)
				{
					$qty = (isset($cart['cart']['products'][$product->id]['qty'])) ? $cart['cart']['products'][$product->id]['qty'] : 1;
					$price = (isset($product->sell_price) && $product->sell_price != '') ? $product->sell_price : $product->regular_price;
					$item_price_single = $qty * $price;

					$item = '<li class="clearfix" id="cart_item_' . $product->id . '">';
					$item.='<a class="remove_cart_item" data-id="' . $product->id . '" data-item_price="' . $item_price_single . '" href="' . url('remove_from_cart') . '"><i class="fa fa-times-circle"></i></a>';
					$item.='<img src="' . SM_Front::sm_get_gallery_first_image($product->image, 74, 93) . '" alt="">';
					$item.='<div class="content">';
					$item.='<a href="' . url('products/detail/' . $product->slug) . '"><h4>' . $product->title . '</h4></a>';

					$rating = ceil($product->avg_rating);
					if ($product->review_enable == 'on')
					{
						$blank = 5 - $rating;
						$item.='<span class="stars">';
						$item.=str_repeat('<i class="fa fa-star"></i>', $rating);
						$item.=str_repeat('<i class="fa fa-star blank"></i>', $blank);
						$item.='</span>';
					}
					$item.='<span class="cart_qty" >Quantity: <span id="qty_' . $product->id . '">' . $qty . '</span></span>';
					$item.='<div class="price-box">';
					if ($product->regular_price != '')
					{
						$item.='<span class="regular-price">' . SM_Front::sm_get_currency_with_price($product->regular_price) . '</span>';
					}
					if ($product->sell_price != '')
					{
						$item.='<span class="sales-price">$' . SM_Front::sm_get_currency_with_price($product->sell_price) . '</span>';
					}
					$item.='</div>';
					$item.='</div>';
					$item.='</li>';
					$op['price'] = $item_price_single;
					$op['item'] = $item;
				}
			}
			if (SM_Front::sm_array($url_array))
			{
				foreach ($url_array as $key => $value)
				{
					$cart['cart']['products'][$product_id][$key] = $value;
				}
			}
			session($cart);
			if (\Request::ajax())
			{
				if (count($op) > 0)
				{
					echo json_encode($op);
				}
				else
				{
					echo 1;
				}
			}
			else
			{
				return back()->with('s_message', 'Product added in cart successfully! <a href="' . url('cart') . '"> View Cart</a>');
			}
		}
	}

	function update_cart(Request $data)
	{
		$this->validate($data, [
			'product_id' => 'required',
			'qty' => 'required'
		]);
		if (count($data['product_id']) > 0)
		{
			$p_c = count($data['product_id']);
			for ($i = 0; $i < $p_c; $i++)
			{
				$pid = $data['product_id'][$i];
				$qty = $data['qty'][$i];
				$session['cart']['products'][$pid]['id'] = $pid;
				$session['cart']['products'][$pid]['qty'] = $qty;

				$cart=session('cart');
				if(isset($cart['products'][$pid]['color']))
				{
					$session['cart']['products'][$pid]['color'] = $cart['products'][$pid]['color'];
				}
				if(isset($cart['products'][$pid]['size']))
				{
					$session['cart']['products'][$pid]['size'] = $cart['products'][$pid]['size'];
				}
			}
			if (isset($data['coupon_code']) && $data['coupon_code'] != '')
			{
				$session['cart']['coupon_code'] = $data['coupon_code'];
			}
			if (isset($data['coupon_less']) && $data['coupon_less'] != '')
			{
				$session['cart']['coupon_less'] = $data['coupon_less'];
			}
			session($session);

			if (isset($data['update']) && $data['update'] != '')
			{
				return back()->with('s_message', 'Cart Successfully Updated!');
			}
			else
			{
				return redirect('checkout');
			}
		}
	}

	function remove_from_cart()
	{
		if (isset($_GET['id']) && SM_Front::sm_string($_GET['id']))
		{
			$product_id = trim($_GET['id']);

			$cart['cart'] = (Session::has('cart')) ? session('cart') : array();
			if (isset($cart['cart']['products'][$product_id]))
			{
				unset($cart['cart']['products'][$product_id]);
			}
			session($cart);
			if (\Request::ajax())
			{
				echo 1;
			}
			else
			{
				return back();
			}
		}
	}

	function add_to_wishlist()
	{
		if (isset($_GET['id']) && SM_Front::sm_string($_GET['id']))
		{
			$product_id = trim($_GET['id']);
			$qty = (isset($_GET['qty']) && SM_Front::sm_string($_GET['qty'])) ? $_GET['qty'] : 1;

			$wishlist['wishlist'] = (Session::has('wishlist')) ? session('wishlist') : array();
			if (isset($wishlist['wishlist'][$product_id]))
			{
				$wishlist['wishlist'][$product_id]['qty'] += $qty;
			}
			else
			{
				$wishlist['wishlist'][$product_id]['qty'] = $qty;
			}
			$wishlist['wishlist'][$product_id]['id'] = $product_id;
			session($wishlist);
			echo 1;
		}
	}

	function clear_cart()
	{
		session::forget('cart');
	}

	function clear_wishlist()
	{
		session::forget('wishlist');
	}

	function checkout()
	{
		$data = SM_Front::cart_info();
		if (Auth::check())
		{
			$data['user'] = Auth::user();
			$data['user_meta'] = Users_meta::where('user_id', $data['user']->id)->get();
		}
		return view('Front.Products.checkout', $data);
	}

	function save_order(Order_validation $data)
	{
		$user_id = Auth::user()->id;

		$billing['firstname'] = $data->input('firstname');
		$billing['lastname'] = $data->input('lastname');
		$billing['company_name'] = $data->input('company_name', null);
		$billing['country'] = $data->input('country');
		$billing['state'] = $data->input('state');
		$billing['city'] = $data->input('city');
		$billing['zip'] = $data->input('zip');
		$billing['mobile'] = $data->input('mobile');
		$billing['address1'] = $data->input('address1');
		$billing['address2'] = $data->input('address2', NULL);

		foreach ($billing as $id => $value)
		{
			if (SM_Front::sm_string($value))
			{
				SM_Front::update_front_user_meta($user_id, $id, $value);
			}
		}

		$shipping['message'] = $data->input('message', NULL);

		$ship_to_different_address = $data->input('ship_to_different_address');
		if ($ship_to_different_address && $ship_to_different_address == 1)
		{
			$shipping['firstname'] = $data->input('shipping_firstname');
			$shipping['lastname'] = $data->input('shipping_lastname');
			$shipping['company_name'] = $data->input('shipping_company_name', null);
			$shipping['country'] = $data->input('shipping_country');
			$shipping['state'] = $data->input('shipping_state');
			$shipping['city'] = $data->input('shipping_city');
			$shipping['zip'] = $data->input('shipping_zip');
			$shipping['mobile'] = $data->input('shipping_mobile');
			$shipping['address1'] = $data->input('shipping_address1');
			$shipping['address2'] = $data->input('shipping_address2', NULL);
			foreach ($shipping as $id => $value)
			{
				if (SM_Front::sm_string($value))
				{
					SM_Front::update_front_user_meta($user_id, 'shipping_' . $id, $value);
				}
			}
		}
		else
		{
			if (count($billing) > 0)
			{
				foreach ($billing as $key => $val)
				{
					$shipping[$key] = $val;
				}
			}
		}
		$order['customer_id'] = $user_id;

		$sp = Shipping::create($shipping);
		$order['shipping_id'] = $sp->id;


		$payment['type'] = $data->input('payment_method');
		$pm = SM_payment::create($payment);
		$order['payment_id'] = $sp->id;

		$cart = (Session::has('cart')) ? session('cart') : array();

		$order['coupon_less'] = (isset($cart['coupon_less'])) ? $cart['coupon_less'] : 0;
		$order['shipping_charge'] = (isset($cart['shipping_charge'])) ? $cart['shipping_charge'] : 0;
		$order['tax'] = (isset($cart['tax'])) ? $cart['tax'] : 0;
		$order['order_total'] = (isset($cart['order_total'])) ? $cart['order_total'] : 0;
		$order['note'] = $data->input('note');

		$odr = Order::create($order);

		$order['id'] = $odr->id;
		$order_detail['order_id'] = $odr->id;
		if (isset($cart['products']) && count($cart['products']) > 0)
		{
			foreach ($cart['products'] as $product_info)
			{
				$order_detail['product_id'] = $product_info['id'];
				$order_detail['product_price'] = $product_info['product_price'];
				$order_detail['qty'] = $product_info['qty'];
				$meta = array();
				if (isset($product_info['color']))
				{
					$meta['color'] = $product_info['color'];
				}
				if (isset($product_info['size']))
				{
					$meta['size'] = $product_info['size'];
				}
				$order_detail['metas'] = SM_Front::sm_serialize($meta);
				Order_detail::create($order_detail);
			}
		}
		if ($payment['type'] != 'cash_on_delivery')
		{
			$cart['payment_method'] = $payment['type'];
			if ($payment['type'] == 'visa')
			{
				$cart['c_number'] = $data->input('visa_number');
				$cart['c_expire'] = $data->input('visa_expire');
				$cart['c_cvv2'] = $data->input('visa_cvv2');
				$cart['c_first_neme'] = $data->input('visa_first_neme');
				$cart['c_last_neme'] = $data->input('visa_last_neme');
			}
			elseif ($payment['type'] == 'mastercard')
			{
				$cart['c_number'] = $data->input('mc_number');
				$cart['c_expire'] = $data->input('mc_expire');
				$cart['c_cvv2'] = $data->input('mc_cvv2');
				$cart['c_first_neme'] = $data->input('mc_first_neme');
				$cart['c_last_neme'] = $data->input('mc_last_neme');
			}
			$session['is_new'] = 1;
			$session['cart'] = $cart;
			$session['cart']['order_id'] = $order_detail['order_id'];
			$session['cart']['payment_id'] = $order['payment_id'];
			session($session);
			return self::paypal($cart, $shipping, $order, 1);
		}
		else
		{
			Session::forget('cart');
			return redirect("dashboard/orders/detail/" . $order_detail['order_id'])->with('s_message', 'Order added Successfully!');
		}
	}

	private static function paypal_init()
	{
		$clientId = 'AU_jkAMDVLxTBT4MAPdbZ_8AfpHCUAdtCYzgcNKA0sFHVW6XhVG7Owsh1MZMdvyxxoQ9fDEbldLDidIk';
		$secret = 'ELdshkjdc3C52M1jDfD56j0Szz6KBd96xQtIW1Cn9LRT3Z4oyAcohfaG3_ISzMGnLZJ2YwYNdWj_Tvi9';

//         $clientId = 'AYv8YOHHEI5SbgLpYerdhL3E9wAXrXpMpLAP61Hvlza86AMHKDKckTIIbSxUXukZY9MYVPM9zwaJhXfZ';
//         $secret = 'EO5rQxrRDpEnbY1caO7WKWmJSlnNDV-0WTMrufSB5Rt-ojvVHIVjmxMrulbzNL39Behd2O3YOXgOuv1Z';
		$api = new ApiContext(
			new OAuthTokenCredential($clientId, $secret)
		);

		$api->setConfig([
			'mode' => 'sandbox',
			'http.ConnectionTimeOut' => 30,
			'log.LogEnabled' => TRUE,
			'log.FileName' => 'PayPal.log',
			'log.LogLevel' => 'FINE',
			'validation.level' => 'log',
			'cache.enabled' => FALSE
		]);
		return $api;
	}

	public static function paypal($cart, $shipping, $order, $is_new = 1)
	{
		$api = self::paypal_init();

		$payer = new Payer();
		if ($cart['payment_method'] == 'paypal')
		{
			$payer->setPaymentMethod('paypal');
		}
		else
		{
			if ($date = explode('-', $cart['c_expire']))
			{
				$cn = str_replace('-', '', $cart['c_number']);
				$cn = str_replace(' ', '', $cn);
				$card = new CreditCard();
				$card->setType($cart['payment_method'])
				     ->setNumber($cn)
				     ->setExpireMonth($date['1'])
				     ->setExpireYear($date['0'])
				     ->setCvv2($cart['c_cvv2'])
				     ->setFirstName($cart['c_first_neme'])
				     ->setLastName($cart['c_last_neme']);

				$fi = new FundingInstrument();
				$fi->setCreditCard($card);

				$payer->setPaymentMethod('credit_card');
				$payer->setFundingInstruments(array($fi));
			}
			else
			{
				self::cart_empty($is_new);
				return redirect("dashboard/orders/edit/" . $order['id'])->with("w_message", "Card expire date invalid!<br>Please try again.");
			}
		}

		$shippingAddress = new shippingAddress();
		$shippingAddress->setRecipientName($shipping['firstname'] . ' ' . $shipping['lastname'])
		                ->setLine1($shipping['address1'] . ' ' . $shipping['address1'])
		                ->setCity($shipping['city'])
		                ->setState($shipping['state'])
		                ->setPostalCode($shipping['zip'])
		                ->setCountryCode(SM_Front::sm_get_country_code($shipping['country']));

		$itemArray = array();

		if (isset($cart['products']) && count($cart['products']) > 0)
		{
			foreach ($cart['products'] as $product_info)
			{
				$item = new Item();
				$item->setName($product_info['product_title'])
				     ->setCurrency('USD')
				     ->setQuantity($product_info['qty'])
				     ->setPrice($product_info['product_price']);
				if (isset($product_info['sku']))
				{
					$item->setSku($product_info['sku']);
				}
				array_push($itemArray, $item);
			}
		}
		if ($cart['coupon_less'] > 0)
		{
			$item2 = new Item();
			$item2->setName('Discount')
			      ->setCurrency('USD')
			      ->setQuantity(1)
			      ->setPrice('-' . $cart['coupon_less']);
			array_push($itemArray, $item2);
			$cart['subtotal']-=$cart['coupon_less'];
		}
		$itemList = new ItemList();
		$itemList->setItems($itemArray);

		$itemList->setShippingAddress($shippingAddress);

		$details = new Details();
		$details->setShipping($cart['shipping_charge'])
		        ->setTax($cart['tax'])
		        ->setSubtotal($cart['subtotal']);


		$amount = new Amount();
		$amount->setCurrency('USD')
		       ->setTotal($cart['order_total'])
		       ->setDetails($details);


		$transaction = new Transaction();
		$transaction->setAmount($amount)
		            ->setItemList($itemList)
		            ->setDescription($order['note'])
		            ->setInvoiceNumber(uniqid());

		$redirectUrls = new RedirectUrls();
		$redirectUrls->setReturnUrl(url('paypal_payment?approved=true'))
		             ->setCancelUrl(url('paypal_payment?approved=false'));

		$payment = new Payment();
		$payment->setIntent('sale')
		        ->setPayer($payer)
		        ->setRedirectUrls($redirectUrls)
		        ->setTransactions(array($transaction));

		try {
			$payment->create($api);
		} catch (PayPalConnectionException $exc) {
			$code = $exc->getCode();
			self::cart_empty($is_new);
			return redirect("dashboard/orders/edit/" . $order['id'])->with("w_message", "PayPal Checkout Error! <br>Error code $code. Please inform admin about this error or try another payment method. <br>Thanks.");
		}
		if ($cart['payment_method'] == 'paypal')
		{
			$approvalUrl = $payment->getApprovalLink();
			return Redirect::to($approvalUrl);
		}
		else
		{
			$cart = self::cart_check();
			return self::online_payment_update($is_new, $cart, $payment->getId(), $payment);
		}
	}

	private static function cart_check()
	{
		$is_new = (Session::has('is_new')) ? session('is_new') : 1;
		if ($is_new == 0)
		{
			$cart = (Session::has('edit_cart')) ? session('edit_cart') : array();
		}
		else
		{
			$cart = (Session::has('cart')) ? session('cart') : array();
		}
		if (isset($cart['order_id']) && $cart['order_id'] != '')
		{
			$cart['is_new'] = $is_new;
			return $cart;
		}
		else
		{
			return redirect("dashboard/orders")->with("w_message", "Order added successfully, Payment processing error! Please try again!");
			exit('Order added successfully, Payment processing error! Please try again! Go back by <a href="' . url("dashboard/orders") . '">clicking here</a>');
		}
	}

	function paypal_payment()
	{
		$cart = self::cart_check();
		$order_id = $cart['order_id'];
		$is_new = $cart['is_new'];

		$api = self::paypal_init();

		$approved = $_GET['approved'];
		if (isset($_GET['approved']) && $_GET['approved'] == 'true' && $_GET['paymentId'] !== '')
		{
			$PayerID = $_GET['PayerID'];
			$paypal_paymentId = $_GET['paymentId'];
			$payment = Payment::get($paypal_paymentId, $api);
			$execution = new PaymentExecution();
			$execution->setPayerId($PayerID);
			$payment->execute($execution, $api);
			return self::online_payment_update($is_new, $cart, $paypal_paymentId, $payment);
		}
		else
		{
			self::cart_empty($is_new);
			return redirect("dashboard/orders/edit/" . $order_id)->with("w_message", "PayPal payment cancelled but order added successfully! You can pay again!");
		}
	}

	private static function online_payment_update($is_new, $cart, $paypal_paymentId, $payment)
	{
		$order_id = $cart['order_id'];
		$payment_id = (isset($cart['payment_id'])) ? $cart['payment_id'] : '';
		if ($payment_id == '')
		{
			self::cart_empty($is_new);
			return redirect("dashboard/orders/edit/" . $order_id)->with("w_message", "PayPal Checkout Error! Error code #PIDNF. <br>Please inform admin about this error or try another payment method. <br>Thanks.");
		}

//logging paypal payment info
		self::sm_online_payments_log($order_id, $payment_id, $paypal_paymentId, $payment);


		$sm_payment = SM_payment::find($payment_id);
		$sm_order = Order::find($order_id);
		if (count($sm_payment) > 0)
		{
			$related_resources = (isset($payment->transactions['0']) &&
			                      isset($payment->transactions['0']->related_resources)) ? $payment->transactions['0']->related_resources : array();
			$c_related_resources = count($related_resources);

			$message = ucfirst($sm_payment->type) . ' Payment Created and Pending!';
			if ($c_related_resources > 0)
			{
				$r_sale = isset($related_resources['0']->sale) ? $related_resources['0']->sale : array();
				if (isset($r_sale->state) && $r_sale->state == 'completed')
				{
					$sm_payment->refund_link = isset($r_sale->links) &&
					                           count($r_sale->links) > 2 &&
					                           isset($r_sale->links['1']->href) ? $r_sale->links['1']->href : '';
					$sm_payment->paid += (isset($cart['order_total'])) ? (float) $cart['order_total'] : 0;
					$message = ucfirst($sm_payment->type) . ' Payment Completed!';
				}
				elseif (isset($r_sale->state) && $r_sale->state == 'created')
				{
					$message = ucfirst($sm_payment->type) . ' Payment Created and Pending!';
				}
				else
				{
					$message = ucfirst($sm_payment->type) . ' Payment Creation failed. Plese contct to admin!';
				}
			}

			$sm_payment->transection_id = $paypal_paymentId;
			if (count($sm_order) > 0 && $sm_order->order_total == $sm_payment->paid)
			{
				$sm_payment->status = 1;
			}
			else
			{
				$sm_payment->status = 2;
			}
			$sm_payment->save();
			self::cart_empty($is_new);
			return redirect("dashboard/orders/detail/$order_id")->with('s_message', 'Order saved Successfully and ' . $message);
		}
	}

	private static function sm_online_payments_log($order_id, $payment_id, $paypal_paymentId, $payment)
	{
		if ($sm_online_payments_log = fopen('sm_online_payments_log.php', 'a+'))
		{
			$sm_p_data = "<?php \n";
			$sm_p_data .="echo 'Oreder id # $order_id <br>'; \n";
			$sm_p_data .="echo 'Payment id # $payment_id <br>'; \n";
			$sm_p_data .="echo 'online Payment id # $paypal_paymentId <br>'; \n";
			$sm_p_data .="echo 'Payment detail: <br>'; \n";
			$sm_p_data .="echo '<pre>'; \n";
			$sm_p_data .='$payment=json_decode(\'' . $payment . '\');' . "\n";
			$sm_p_data .='print_r($payment); ' . "\n";
			$sm_p_data .="echo '</pre><br><br>'; \n ?> \n\n";
			fwrite($sm_online_payments_log, $sm_p_data);
			fclose($sm_online_payments_log);
		}
	}

	private static function cart_empty($is_new)
	{
		if ($is_new == 1)
		{
			Session::forget('cart');
		}
		else
		{
			Session::forget('edit_cart');
		}
	}

}