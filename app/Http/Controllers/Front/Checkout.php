<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\Auth\RegisterController;
use App\Http\Requests\OrderValidation;
use App\Mail\InvoiceMail;
use App\Model\Common\Coupon;
use App\Model\Common\Order;
use App\Model\Common\Order_detail;
use App\Model\Common\Payment_method;
use App\Model\Common\Tax;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function MongoDB\BSON\toJSON;
use PayPal\Api\Amount;
use PayPal\Api\CreditCard;
use PayPal\Api\Details;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;
use PayPal\Api\Payment;
use Session;
use App\Model\Common\Package;
use App\Model\Common\Package_detail;
use App\SM\SM;
use Auth;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;
use Cart;
use PayPal\Api\Agreement;
use PayPal\Api\ShippingAddress;

class Checkout extends Controller {

    public function index($id = 10) {

        // if ( Session::has( "smPackageUrl" ) ) {
        // 	Session::save();
        // }
        // if (
        // 	\request()->input( "paypalPayment", "no" ) == 'cancel' &&
        // 	Session::has( 'checkout.order_id' )
        // ) {
        // 	$orderId = Session::get( 'checkout.order_id' );
        // 	Session::forget( "checkout" );
        // 	Session::save();
        // 	return redirect( "dashboard/orders/detail/$orderId" )->with( "w_message", "Payment Cancel. Pay again if you like this package." );
        // }
        // if ( Session::has( "checkout" ) ) {
        // 	Session::forget( "checkout" );
        // 	Session::save();
        // }
        // $packageInfo = Package::find( $id );
        // if ( count( $packageInfo ) > 0 ) {
        // if ( $packageInfo->type == 4 ) {
        // 	$selectedPackageDetailIds = request()->input( 'detail_id', array() );
        // } else {
        // 	$selectedPackageDetailIds = [ $detailId ];
        // }
// 			$packageInfo->detail  = Package_detail::whereIn( "id", $selectedPackageDetailIds )
// 			                                      ->orderBy( 'sorting_position', 'asc' )
// 			                                      ->get();
        $data["package_name"] = 'hello';
        $data["amount"] = 0;
// 			if ( $packageInfo->type == 4 ) {
// 				$pricing_title        = '';
// 				$data["amount"]       = 0;
// 				$selectedPackageQty   = request()->input( 'qty', array() );
// 				$selectedPackageWords = request()->input( 'words', array() );
// 				$loop2                = 0;
// 				if ( count( $packageInfo->detail ) > 0 ) {
// 					$selectionLoop = 0;
// 					foreach ( $packageInfo->detail as $pcd ) {
// 						$pcd->qty            = isset( $selectedPackageQty[ $pcd->id ] ) ? $selectedPackageQty[ $pcd->id ] : 1;
// 						$pcd->required_words = isset( $selectedPackageWords[ $pcd->id ] ) ? $selectedPackageWords[ $pcd->id ] : 100;
// 						$data["amount"]      += ( $pcd->required_words / $pcd->words ) * (float) $pcd->price * $pcd->qty;
// 						if ( $loop2 > 0 ) {
// 							$pricing_title .= ", ";
// 						}
// 						$pricing_title .= $pcd->title;
// //							$pricing_title .= $pcd->title . ", Words: " . $pcd->required_words . ", Quantity: " . $pcd->qty;
// 						$loop2 ++;
// 					}
// 				}
// 				$data["package_name"] .= " ( " . $pricing_title . " )";
// 			} else {
// 				$data["amount"] = 0;
// 				if ( count( $packageInfo->detail ) > 0 ) {
// 					$data["amount"]       = $packageInfo->detail[0]->price;
// 					$data["package_name"] .= " ( " . $packageInfo->detail[0]->title . " Plan )";
// 					$packageInfo->detail[0]->qty            = 1;
// 					$packageInfo->detail[0]->required_words = 0;
// 				}
// 			}
// 			$data["package_name"] = title_case( $data["package_name"] );

        $data['is_tax_enable'] = SM::get_setting_value("is_tax_enable", 1);
        $data['default_tax'] = SM::get_setting_value("default_tax", 1);
        $data['default_tax_type'] = SM::get_setting_value("default_tax_type", 1);
        $data['packageInfo'] = array();


         if ( $data['is_tax_enable'] == 1 && Auth::check() && Auth::user()->country != '' ) {
         	$taxInfo = Tax::where( "country", Auth::user()->country )->first();
         	if ( count( $taxInfo ) > 0 ) {
         		if ( $taxInfo->type == 1 ) {
         			$tax = $taxInfo->tax;
         		} else {
         			$tax = $data["amount"] * $taxInfo->tax / 100;
         		}
         	} else {
         		if ( $data['default_tax_type'] == 1 ) {
         			$tax = (float) $data['default_tax'];
         		} else {
         			$tax = (float) $data['default_tax'] * $taxInfo->tax / 100;
         		}
         	}
         	$data['tax'] = $tax;
         } else {
         	$data['tax'] = 0;
         }
        $data['tax'] = 0;
        $data["total_checkout"] = 100;
        // Session::put( "checkout", $data );
        // Session::save();
        $data['payment_methods'] = Payment_method::where("status", 1)->get();

        $data['isPaymentCancelled'] = \request()->input("paypalPayment", "no");

        return view('frontend.checkout', $data);
        // } else {
        // 	return abort( 404 );
        // }
    }

    public function couponCheck(Request $request) {
        $this->validate($request, ['couponCode' => 'required']);

        $coupon = Coupon::where("coupon_code", $request->couponCode)->first();
        if (count($coupon) > 0) {
            $validity = strtotime($coupon->validity);
            $response["couponCode"] = $request->couponCode;
            if ($validity > time()) {
                $response["isSuccess"] = 1;
                $response["id"] = $coupon->id;
                $response["coupon_code"] = $coupon->coupon_code;
                $response["discount"] = $coupon->discount;
                $response["type"] = $coupon->type;
                $response["message"] = "Coupon Successfully Applied!";
                Session::put("checkout.coupon", $response);
                Session::save();
                unset($response["id"]);
            } else {
                $response["isSuccess"] = 0;
                $response["message"] = "Coupon Validity Expired!";
            }

            return response()->json($response, 200);
        } else {
            return response()->json(["message" => "Coupon Not Found!"], 404);
        }
    }

    public function taxCalculate(Request $request) {
        $this->validate($request, ['country' => 'required']);

        $data['is_tax_enable'] = SM::get_setting_value("is_tax_enable", 1);
        $default_tax = SM::get_setting_value("default_tax", 1);
        $default_tax_type = SM::get_setting_value("default_tax_type", 1);


        if ($request->country != '' && $data['is_tax_enable'] == 1) {
            $taxInfo = Tax::where("country", $request->country)->first();
            $data["isSuccess"] = 1;
            if (count($taxInfo) > 0) {
                $data['tax_type'] = $taxInfo->type;
                $data['tax'] = $taxInfo->tax;
            } else {
                $data['tax'] = (float) $default_tax;
                $data['tax_type'] = $default_tax_type;
            }
        } else {
            $data["isSuccess"] = 0;
            $data['tax'] = 0;
        }

        return response()->json($data, 200);
    }

    public function paypalInit($paymentMethodId) {
        $paymentMethod = Payment_method::find($paymentMethodId);
        if (count($paymentMethod) < 1) {
            return back()->with("w_message", "Payment Method Not Found!");
        }
        Session::put("checkout.payment_method_name", $paymentMethod->title);
        Session::save();
        $clientId = 'Abk1x3VRtXC53tpqWObi85U47_p1Lijc-OIH1wy6HC2yRt1ghvv-kW_KjLBvKUnomQxJ9oRg9WTI87-n';
        $clientId = $paymentMethod->api_key;
//			$clientSecret = 'EF93DMB6AV5MIizVektFJMG9dvBDqBOsdjc4JPE4D_xFLYWKuqQYoUClnUhllnTkS7LsL5r1uA5b3dbE';
        $clientSecret = $paymentMethod->api_secret;
        if ($clientId == '' || $clientSecret == '') {
            if (Auth::check()) {
                return redirect("dashboard/orders")->with("w_message", "Please contact to admin about this invoice. API Key Error.");
            } else {
                return redirect("dashboard")->with("w_message", "Please contact to admin about this invoice. API Key Error.");
            }
        }

        $api = new ApiContext(
                new OAuthTokenCredential($clientId, $clientSecret)
        );

        $api->setConfig([
            'mode' => $paymentMethod->mode,
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path('logs/paypal.log'),
            'log.LogLevel' => 'FINE',
            'validation.level' => 'log',
            'cache.enabled' => false
        ]);

        return $api;
    }

    private function paypalOrder($isSaveOrder, $packageInfo, $session, $discount = 0, $request) {
        $paymentMethodId = $request->input('payment_method', 1);
        if (Auth::check() && !isset($session["order_id"])) {

            $order_id = $this->saveOrderInfo();
            if ($paymentMethodId == 4) {
                return redirect('/dashboard/orders/detail/'.$order_id)->with('s_message', 'Order Successfully Done.');
            }
        }

        if ($paymentMethodId == 1 || $paymentMethodId == 2 || $paymentMethodId == 3 || $paymentMethodId == 4) {
            if ($paymentMethodId == 4) {
                
            } else {
                $api = $this->paypalInit($paymentMethodId);
                $payer = new Payer();
                if ($paymentMethodId == 1) {
                    $payer->setPaymentMethod("paypal");
                } else {
                    $card = new CreditCard();
                    $card->setType($paymentMethodId == 2 ? "mastercard" : "visa" )
                            ->setExpireMonth($session["card_month"])
                            ->setExpireYear($session["card_year"])
                            ->setCvv2($session["card_cvv2"])
                            ->setNumber($session["card_number"]);

                    $fi = new FundingInstrument();
                    $fi->setCreditCard($card);
                    $payer->setPaymentMethod("credit_card")
                            ->setFundingInstruments(array($fi));
                }
                $itemList = new ItemList();
                $itemArray = array();
//			if ( $isSaveOrder == 1 && $packageInfo->type == 4 ) {
//				if ( count( $packageInfo->details ) > 0 ) {
//					foreach ( $packageInfo->details as $p_detail ) {
//						$item = new Item();
//
//						$pricing_title = $p_detail->title . " ( Words: " . $p_detail->required_words . " )";
//						$price         = ( $p_detail->required_words / $p_detail->words ) * $p_detail->price;
//						$item->setName( $pricing_title )
//						     ->setCurrency( 'USD' )
//						     ->setQuantity( $p_detail->qty )
//						     ->setPrice( $price );
//						array_push( $itemArray, $item );
//					}
//				}
//			} else {

                $item = new Item();
                $item->setName($session["package_name"])
                        ->setCurrency('USD')
                        ->setQuantity(1)
                        ->setPrice($session["amount"]);
                array_push($itemArray, $item);
//			}
                if ($discount > 0) {
                    $item2 = new Item();
                    $item2->setName('Discount')
                            ->setCurrency('USD')
                            ->setQuantity(1)
                            ->setPrice('-' . $discount);
                    array_push($itemArray, $item2);
                }
                $itemList->setItems($itemArray);

                $details = new Details();
                $details->setTax($session["tax"])
                        ->setSubtotal($session["subtotal"]);


                $amount = new Amount();
                $amount->setCurrency("USD")
                        ->setTotal($session["netTotal"])
                        ->setDetails($details);

                $transaction = new Transaction();
                $transaction->setAmount($amount)
                        ->setItemList($itemList)
                        ->setDescription($request->input("message", ""))
                        ->setInvoiceNumber(uniqid());

                SM::setPreviousUrl();
                $redirectUrls = new RedirectUrls();
                $redirectUrls->setReturnUrl(url("paypal-payment?isSuccess=true"));
                $redirectUrls->setCancelUrl(SM::prevUrlWithExtra("paypalPayment=cancel"));

                $payment = new Payment();
                $payment->setIntent('sale')
                        ->setPayer($payer)
                        ->setRedirectUrls($redirectUrls)
                        ->setTransactions(array($transaction));

                try {
                    $payment->create($api);
                } catch (PayPalConnectionException $exc) {
                    $code = $exc->getCode();
                    $error = json_decode($exc->getData());
                    $issue = "";
                    if (isset($error->details) && count($error->details) > 0) {
                        $loop = 0;
                        foreach ($error->details as $detail) {
                            if ($loop > 0) {
                                $issue .= ", ";
                            }
                            $issue .= $detail->issue;
                        }
                    }
//				echo "<pre>";
//				print_r($code);
//				print_r($issue);
//				echo "</pre>";
//				exit();
                    return back()->withInput()->with("w_message", "Error code $code. " . $issue);
                }
                if ($paymentMethodId == 1) {
                    $approvalUrl = $payment->getApprovalLink();

                    return \Redirect::to($approvalUrl);
                } else {
                    if (!Auth::check()) {
                        $register = new RegisterController();
                        $register->createGuestAccount();
                    }
                    if (!isset($session["order_id"])) {
                        $this->saveOrderInfo();
                    }

                    return $this->onlinePaymentUpdate($payment->getId(), $payment);
                }
            }
        } else {
            return back()->with("w_message", "No Payment Method Found!");
        }
    }

    private function paypalAgreement($isSaveOrder, $packageInfo, $session, $discount = 0, $requestHttp) {
        $plan = new Plan();
        $plan->setName($session["package_name"])
                ->setDescription($session["package_name"] . ' Agreement!')
                ->setType('INFINITE');

        $paymentDefinition = new PaymentDefinition();


        $monthlyPayment = $session["netTotal"];
        if ($discount > 0) {
            $monthlyPayment += $discount;
        }
        $packageDetail = $packageInfo->detail[0];

        $priceFrequencyInfo = SM::getPriceFrequeryInfo($packageDetail->price_type);

        $paymentDefinition->setName($session["package_name"])
                ->setType('REGULAR')
                ->setFrequency($priceFrequencyInfo['month'])
                ->setFrequencyInterval($priceFrequencyInfo['interval'])
                ->setCycles(0)
                ->setAmount(new Currency(array('value' => $monthlyPayment, 'currency' => 'USD')));


        $merchantPreferences = new MerchantPreferences();


        $merchantPreferences->setReturnUrl(url("paypal-agreement?success=true"))
                ->setCancelUrl(url("paypal-agreement?success=false"))
                ->setAutoBillAmount("yes")
                ->setInitialFailAmountAction("CONTINUE")
                ->setMaxFailAttempts("0")
                ->setSetupFee(new Currency(array(
                    'value' => $session["netTotal"],
                    'currency' => 'USD'
        )));


        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);

        $request = clone $plan;
        $apiContext = $this->paypalInit(1);

        try {
            $output = $plan->create($apiContext);
        } catch (Exception $ex) {
            $message = 'PayPal Agreement error on plan create. Error code ' . $ex->getCode();
            $message .= $ex->getData() . toJSON();
            Log::emergency($message);

            return redirect('/')->with('s_message', 'PayPal payment error. Please contact to admin by error code PayPal#' . $ex->getCode());
        }

        try {
            $patch = new Patch();

            $value = new PayPalModel('{
		       "state":"ACTIVE"
		     }');

            $patch->setOp('replace')
                    ->setPath('/')
                    ->setValue($value);
            $patchRequest = new PatchRequest();
            $patchRequest->addPatch($patch);

            $output->update($patchRequest, $apiContext);

            $plan = Plan::get($output->getId(), $apiContext);
        } catch (Exception $ex) {
            $message = 'PayPal Agreement error on plan activation. Error code ' . $ex->getCode();
            $message .= $ex->getData() . toJSON();
            Log::emergency($message);

            return redirect('/')->with('s_message', 'PayPal payment error. Please contact to admin by error code PayPal#' . $ex->getCode());
        }

        $agreement = new Agreement();

        $agreement->setName($session["package_name"])
                ->setDescription($session["package_name"] . ' Agreement!')
                ->setStartDate(gmdate("Y-m-d\TH:i:s\Z", strtotime($priceFrequencyInfo['next'])));
        $plan = new Plan();
        $plan->setId($output->getId());
        $agreement->setPlan($plan);

        $paymentMethodId = $requestHttp->input('payment_method', 1);
        $payer = new Payer();
        if ($paymentMethodId == 1) {
            $payer->setPaymentMethod("paypal");
        } else {
            $card = new CreditCard();
            $card->setType($paymentMethodId == 2 ? "mastercard" : "visa" )
                    ->setExpireMonth($session["card_month"])
                    ->setExpireYear($session["card_year"])
                    ->setCvv2($session["card_cvv2"])
                    ->setNumber($session["card_number"]);

            $fi = new FundingInstrument();
            $fi->setCreditCard($card);
            $payer->setPaymentMethod("credit_card")
                    ->setFundingInstruments(array($fi));
        }

        $agreement->setPayer($payer);

        try {
            $agreement = $agreement->create($apiContext);
            $approvalUrl = $agreement->getApprovalLink();
        } catch (Exception $ex) {
            $message = 'PayPal Agreement error on Agreement Create. Error code ' . $ex->getCode();
            $message .= $ex->getData() . toJSON();
            Log::emergency($message);

            return redirect('/')->with('s_message', 'PayPal payment error. Please contact to admin by error code PayPal#' . $ex->getCode());
        }

        return \Redirect::to($approvalUrl);
    }

    public function saveOrder(OrderValidation $request) {
//		if ( ! Session::has( "checkout" ) ) {
//			return back()->with( "w_message", "No Checkout Option Found!" );
//		}
//
        $session = Session::get("checkout");
//	 
//
        $cart_total = str_replace(',', '', Cart::instance('cart')->total());
        $total = $cart_total;
        $netTotal = 0;
        $discount = 0;

        /**
         * Coupon discount
         */
        if (isset($session["coupon"]["isSuccess"]) && $session["coupon"]["isSuccess"] == 1) {
            $coupon = (object) $session["coupon"];
            $discount = (float) $coupon->discount;
            $session["coupon_id"] = $coupon->id;
            if ($coupon->type == 2) {
                $discount = $total * $discount / 100;
            }
        }
        /**
         * Tax calculation
         */
        $data['is_tax_enable'] = SM::get_setting_value("is_tax_enable", 1);
        $default_tax = SM::get_setting_value("default_tax", 1);
        $default_tax_type = SM::get_setting_value("default_tax_type", 1);


        if ($request->country != '' && $data['is_tax_enable'] == 1) {
            $taxInfo = Tax::where("country", $request->country)->first();
            $data["isSuccess"] = 1;
            if (count($taxInfo) > 0) {
                $tax = $taxInfo->tax;
                if ($taxInfo->type == 2) {
                    $tax = $total * $tax / 100;
                }
            } else {
                $tax = (float) $default_tax;
                if ($default_tax_type == 2) {
                    $tax = $total * $tax / 100;
                }
            }
        } else {
            $tax = 0;
        }
        $netTotal = $total + $tax - $discount;
        $session["total"] = $total;
        $session["tax"] = $tax;
        $session["subtotal"] = $total - $discount;
        $session["discount"] = $discount;
        $session["netTotal"] = $netTotal;

        $session = array_merge($request->except("_token"), $session);
        $payment_method = $request->payment_method;
        if ($payment_method == 2 || $payment_method == 3) {
            $date = explode('/', $request->card_expire);
            $session["card_month"] = (int) $date[0];
            $session["card_year"] = (int) $date[1];
        }

        Session::put("checkout", $session);
        Session::save();
        $product_info = '';



        return $this->paypalOrder(1, $product_info, $session, $discount, $request);
    }

    public function reorder($id) {
        $oldOrder = Order::with('package', 'payment', 'user', 'detail')
                ->where("user_id", \Auth::user()->id)
                ->find($id);
        if (count($oldOrder) > 0) {
            $packageInfo = $oldOrder->package;
            $order = new Order();
            $order->user_id = $order->created_by = $order->modified_by = $oldOrder->created_by;
            $order->package_id = $packageInfo->id;
            $order->package_type = $packageInfo->type;
            $order->package_detail_type = $oldOrder->package_detail_type;
            $order->rate = $oldOrder->rate;
            $order->total = $oldOrder->total;
            $order->discount = $oldOrder->discount;
            $order->coupon_id = $oldOrder->coupon_id;
            $order->tax = $oldOrder->tax;
            $order->net_total = $oldOrder->net_total;
            $order->contact_email = $oldOrder->contact_email;
            $order->message = $oldOrder->message;
            $order->attachments = "";
            $order->save();
            $newOrderId = $order->id;
            if (count($oldOrder->detail) > 0) {
                foreach ($oldOrder->detail as $o_detail) {
                    $orderDetail = new Order_detail();
                    $orderDetail->order_id = $newOrderId;
                    $orderDetail->package_detail_id = $o_detail->package_detail_id;
                    $orderDetail->words = $o_detail->words;
                    $orderDetail->qty = $o_detail->qty;
                    $orderDetail->rate = $o_detail->rate;
                    $orderDetail->save();
                }
            }

            return redirect("dashboard/orders/detail/$newOrderId")
                            ->with("s_message", "Order Created Successfully. Pay now your due.");
        } else {
            return abort(404);
        }
    }

    private function saveOrderInfo() {

        if (Session::has("checkout")) {
            $session = Session::get("checkout");
            $payment_method_id = isset($session["payment_method"]) ? $session["payment_method"] : 1;

            Auth::user()->firstname = session('shipping_address')->firstname;
            Auth::user()->lastname = session('shipping_address')->lastname;
            Auth::user()->street = session('shipping_address')->street;
            Auth::user()->city = session('shipping_address')->city;
            Auth::user()->zip = session('shipping_address')->postcode;
            Auth::user()->country = session('shipping_address')->countries_id;
            Auth::user()->state = session('shipping_address')->zone_id;
            Auth::user()->update();

            if (( $payment_method_id == 2 || $payment_method_id == 3 ) && isset($session["remember_card"]) && $session["remember_card"] == 1) {
                $user_id = Auth::user()->id;
                if (isset($data['card_number'])) {
                    SM::update_user_meta($user_id, 'card_number', $session['card_number']);
                }
                if (isset($data['card_cvv2'])) {
                    SM::update_user_meta($user_id, 'card_cvv2', $session['card_cvv2']);
                }
                if (isset($data['card_year'])) {
                    SM::update_user_meta($user_id, 'card_year', $session['card_year']);
                }
                if (isset($data['card_month'])) {
                    SM::update_user_meta($user_id, 'card_month', $session['card_month']);
                }
            }


            $order = new Order();
            $order->user_id = $order->created_by = $order->modified_by = Auth::user()->id;
            $cart = Cart::instance('cart')->content();
            $order->total = Cart::total();
            $order->discount = isset($session["discount"]) ? $session["discount"] : 0;
            $order->coupon_id = isset($session["coupon_id"]) ? $session["coupon_id"] : 0;
            $order->tax = isset($session["tax"]) ? $session["tax"] : 0;
            $order->net_total = isset($session["netTotal"]) ? $session["netTotal"] : 0;
            $order->message = isset($session["message"]) ? $session["message"] : "";

            $order->save();
            $data["order_id"] = $order->id;
//
            if (count($cart) > 0) {
                foreach ($cart as $p_detail) {

                    $orderDetail = new Order_detail();
                    $orderDetail->order_id = $order->id;
                    $orderDetail->product_id = $p_detail->id;
//					$orderDetail->words             = $p_detail->required_words;
                    $orderDetail->qty = $p_detail->qty;
                    $orderDetail->rate = $p_detail->price;
                    $orderDetail->save();
                }
            }
            
//
//			Session::put( "checkout.order_id", $data["order_id"] );
//			Session::save();

            return $data["order_id"];
        }

        return false;
    }

    public function paypalPayment() {
        $isSuccess = \request()->input("isSuccess", false);
        $ppPaymentId = \request()->input("paymentId");
        $ppPayerID = \request()->input("PayerID");

        if ($isSuccess && $ppPaymentId && $ppPayerID) {
            $session = Session::has("checkout") ? Session::get("checkout") : array();
            if (!Auth::check()) {
                $contact_email = isset($session["contact_email"]) ? $session["contact_email"] : "";
                $register = new RegisterController();
                $register->createGuestAccount($contact_email);
            }
            if (!isset($session["order_id"])) {
                $this->saveOrderInfo();
            }

            $payment_method = isset($session["payment_method"]) ? $session["payment_method"] : false;
            if ($payment_method) {
                $api = $this->paypalInit($payment_method);
                $payment = Payment::get($ppPaymentId, $api);
                $execution = new PaymentExecution();
                $execution->setPayerId($ppPayerID);
                $payment->execute($execution, $api);

                return $this->onlinePaymentUpdate($ppPaymentId, $payment);
            } else {
                return redirect("/dashboard/orders")
                                ->with("w_message", "Order Payment Cancelled. Payment Method Not Found!");
            }
        } else {
            return redirect("/dashboard/orders")
                            ->with("w_message", "Order Payment Cancelled. Please pay first.");
        }
    }

    public function paypalAgreePayment() {
        if (isset($_GET['success']) && $_GET['success'] == 'true') {
            $session = Session::has("checkout") ? Session::get("checkout") : array();
            if (!Auth::check()) {
                $contact_email = isset($session["contact_email"]) ? $session["contact_email"] : "";
                $register = new RegisterController();
                $register->createGuestAccount($contact_email);
            }
            if (!isset($session["order_id"])) {
                $this->saveOrderInfo();
            }


            $token = $_GET['token'];
            $agreement = new \PayPal\Api\Agreement();
            $apiContext = $this->paypalInit(1);
            try {
                $agreement->execute($token, $apiContext);
            } catch (Exception $ex) {
                $message = 'PayPal Agreement error on Agreement Execution. Error code ' . $ex->getCode();
                $message .= $ex->getData() . toJSON();
                Log::emergency($message);

                return redirect('/dashboard/orders')->with('s_message', 'PayPal payment error. Please contact to admin by error code PayPal#' . $ex->getCode());
            }
            try {
                $agreement = \PayPal\Api\Agreement::get($agreement->getId(), $apiContext);
            } catch (Exception $ex) {
                $message = 'PayPal Agreement error on Agreement Execution. Error code ' . $ex->getCode();
                $message .= $ex->getData() . toJSON();
                Log::emergency($message);

                return redirect('/dashboard/orders')->with('s_message', 'PayPal Agreement Not Found!' . $ex->getCode());
            }

            return $this->agreePaymentUpdate($agreement->getId(), $agreement);
        } else {
            return redirect("/dashboard/orders")
                            ->with("w_message", "Order Payment Cancelled. Please pay first.");
        }
    }

    private function onlinePaymentUpdate($ppPaymentId, $payment) {
        if (Session::has("checkout")) {
            $session = Session::get("checkout");
            $order_id = $session["order_id"];
            $payment_method_id = isset($session["payment_method"]) ? $session["payment_method"] : 1;

            $paymentInfo = new \App\Model\Common\Payment();
            $paymentInfo->order_id = $order_id;
            $paymentInfo->payment_method_id = $payment_method_id;

            $payment_method_name = $session["payment_method_name"];
            $order = Order::find($order_id);

            if (count($order) > 0) {
                $related_resources = ( isset($payment->transactions['0']) &&
                        isset($payment->transactions['0']->related_resources) ) ? $payment->transactions['0']->related_resources : array();
                $c_related_resources = count($related_resources);

                $message = ucfirst($payment_method_name) . ' Payment Created and Pending!';
                if ($c_related_resources > 0) {
                    $r_sale = isset($related_resources['0']->sale) ? $related_resources['0']->sale : array();
                    if (isset($r_sale->state) && $r_sale->state == 'completed') {

                        $links = ( isset($r_sale->links) ) ? $r_sale->links : array();
                        if (count($links) > 0) {
                            foreach ($links as $link) {
                                if ($link->rel == "refund") {
                                    $paymentInfo->return_url = $link->href;
                                }
                            }
                        }
                        $amountPaid = (float) ( isset($r_sale->amount) && isset($r_sale->amount->total) ) ?
                                $r_sale->amount->total : 0;

                        // update package information
                        $package = Package::find($order->package_id);
                        if ($package) {
                            if ($order->paid == 0 && $amountPaid > 0) {
                                $package->increment("sale_qty");
                            }
                            $package->increment("sale_amount", $amountPaid);
                        }
                        //update user payment information
                        Auth::user()->increment("total_paid", $amountPaid);

                        $order->paid += $amountPaid;

                        $paymentInfo->paid = $amountPaid;
                        $paymentInfo->status = 1;


                        $message = ucfirst($payment_method_name) . ' Payment Received!';
                    } elseif (isset($r_sale->state) && $r_sale->state == 'created') {
                        $message = ucfirst($payment_method_name) . ' Payment Created and Pending!';
                        $paymentInfo->status = 2;
                    } else {
                        $message = ucfirst($payment_method_name) . ' Payment Creation failed. Please contact to admin!';
                        $paymentInfo->status = 3;
                    }
                }
                $paymentInfo->transaction_id = $ppPaymentId;
                if (isset($order->net_total) && $order->net_total == $order->paid) {
                    $order->payment_status = 1;
                } else {
                    $order->payment_status = 2;
                }
                $paymentInfo->save();
                $order->update();
                if (url('/') != 'http://localhost:8000') {
                    $contact_email = isset($session["contact_email"]) ? $session["contact_email"] : "";
                    if (filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
                        \Mail::to($contact_email)->queue(new InvoiceMail($order_id));
                    }
                }
                Session::forget("checkout");
                Session::save();

                return redirect("dashboard/orders/detail/$order_id")->with('orderSuccessMessage', $message);
            } else {
                Session::forget("checkout");
                Session::save();

                return redirect("dashboard/orders")->with("w_message", "Payment and Order info not Found!");
            }
        } else {
            return redirect("dashboard/orders")->with("w_message", "Session Checkout Info Not Found!");
        }
    }

    private function agreePaymentUpdate($agreementId, $agreement) {
        if (Session::has("checkout")) {
            $session = Session::get("checkout");
            $order_id = $session["order_id"];
            $payment_method_id = isset($session["payment_method"]) ? $session["payment_method"] : 1;

            $paymentInfo = new \App\Model\Common\Payment();
            $paymentInfo->order_id = $order_id;
            $paymentInfo->payment_method_id = $payment_method_id;

            $payment_method_name = $session["payment_method_name"];
            $order = Order::find($order_id);

            if (count($order) > 0) {
                $agreement_details = ( isset($agreement->agreement_details) ) ? $agreement->agreement_details : array();


                $message = ucfirst($payment_method_name) . ' Payment Created and Pending!';
                $amountPaid = 0;
                if (count($agreement_details) > 0) {

                    $amountPaid = isset($agreement_details->last_payment_amount->value) ? $agreement_details->last_payment_amount->value : 0;
                    $order->paid += $amountPaid;

                    $paymentInfo->paid = $amountPaid;
                    $paymentInfo->status = 1;
                }
                $paymentInfo->transaction_id = $agreementId;
                if (isset($order->net_total) && $order->net_total == $order->paid) {
                    $order->payment_status = 1;
                    $message = ucfirst($payment_method_name) . ' Payment Successfully Completed!';
                } else {
                    $order->payment_status = 2;
                    $message = "You have due $" . ( $order->net_total - $order->paid ) . ". Please pay now!";
                }
                if ($amountPaid > 0) {
                    $paymentInfo->save();
                    $order->update();
                }
                $contact_email = isset($session["contact_email"]) ? $session["contact_email"] : "";
                if (filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
                    \Mail::to($contact_email)->queue(new InvoiceMail($order_id));
                }
                Session::forget("checkout");
                Session::save();

                return redirect("dashboard/orders/detail/$order_id")->with('orderSuccessMessage', 'Order saved Successfully and ' . $message);
            } else {
                Session::forget("checkout");
                Session::save();

                return redirect("dashboard/orders")->with("w_message", "Payment and Order info not Found!");
            }
        } else {
            return redirect("dashboard/orders")->with("w_message", "Session Checkout Info Not Found!");
        }
    }

    public function pay($id) {
        if (Session::has("smPackageUrl")) {
            Session::forget("smPackageUrl");
            Session::save();
        }
        if (Session::has("checkout")) {
            Session::forget("checkout");
            Session::save();
        }
        $order = Order::with('payment', 'user', 'detail')
                ->find($id);
        if (count($order) > 0) {
            $packageInfo = $order->package;

            $data["order_id"] = $id;
            $data["order"] = $order;
            $data["total_checkout"] = $order->net_total - $order->paid;
            if ($data["total_checkout"] > 0) {
                $data["package_name"] = $packageInfo->title . " Bill due";
                Session::put("checkout", $data);
                Session::save();
                $data['payment_methods'] = Payment_method::where("status", 1)->get();

                $data['isPaymentCancelled'] = \request()->input("paypalPayment", "no");

                return view('page.due_checkout', $data);
            } else {
                return redirect("dashboard/orders/detail/$id")->with('s_message', "You don't have any due to play. Thanks");
            }
        } else {
            return abort(404);
        }
    }

    public function payDue(Request $request) {
        if (!Session::has("checkout")) {
            return back()->with("w_message", "No Checkout Option Found!");
        }

        $session = Session::get("checkout");

        $netTotal = (float) $session["total_checkout"];
        $session["total"] = $session["netTotal"] = $session["subtotal"] = $session["amount"] = $netTotal;
        $session["tax"] = $session["discount"] = 0;


        $session = array_merge($request->except("_token"), $session);
        Session::put("checkout", $session);
        Session::save();
        $packageInfo = isset($session['packageInfo']) ? $session['packageInfo'] : new \stdClass();

        return $this->paypalOrder(0, $packageInfo, $session, 0, $request);
    }

}
