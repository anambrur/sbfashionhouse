<?php

namespace App\Http\Controllers\Admin\Common;

use App\Mail\InvoiceMail;
use App\Mail\NormalMail;
use App\Model\Common\Media_permissions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Common\Order;
use App\Model\Common\Payment;
use Barryvdh\DomPDF\Facade as PDF;
use App\SM\SM;
use App\Model\Common\Media;

class Orders extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['all_order'] = Order::with('payment')
            ->orderBy("id", 'desc')
            ->paginate(config("constant.smPagination"));
        if (\request()->ajax()) {
            $json['data'] = view('nptl-admin/common/order/orders', $data)->render();
            $json['smPagination'] = view('nptl-admin/common/common/pagination_links', [
                'smPagination' => $data['all_order']
            ])->render();

            return response()->json($json);
        }

        return view("nptl-admin/common/order/manage_order", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $data["order"] = Order::with('payment', 'user', 'detail')->find($id);
//        if ( count( $data["order"] ) > 0 ) {
        if (!empty($data["order"])) {
            $data["payment"] = Payment::find($data["order"]->payment_id);

            return view("customer/order_detail", $data);
        } else {
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if ($order) {
            $error = 0;
            $message = '';
            if ($order->payment_status == 1) {
                $error++;
                $message = " Order payment status is completed";
            }
            if ($order->order_status == 1) {
                $error++;
                $message = ($message != '') ? ' and ' . $message : $message;
                $message .= " Order is Completed";
            }


            if ($error == 0) {
                $order->delete();
            } else {
                return response('We cannot delete order because ' . $message . "!", 422);
            }
            echo 1;
            exit;
        } else {
            echo 0;
            exit;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        $data["order"] = Order::with('payment', 'user', 'detail')->find($id);
       
//        if ( count( $data["order"] ) > 0 ) {
        if (!empty($data["order"])) {
            $data["payment"] = Payment::find($data["order"]->payment_id);

//                return view( "pdf/invoice", $data );
            $view = view("pdf/invoice", $data);
            
            return PDF::loadHTML($view)
                ->download('kz_international_invoice_'. SM::orderNumberFormat($data["order"]).'.pdf');
        } else {
            return abort(404);
        }
    }


    /**
     * Order payment status update
     */
    public function payment_status_update(Request $request)
    {
        $this->validate($request, [
            'post_id' => 'required|integer',
            'payment_status' => 'required|integer'
        ]);
        $order = Order::find($request->post_id);
        if ($order) {
            if (!($request->payment_status == 1 && $order->grand_total > $order->paid)) {
                $order->payment_status = $request->payment_status;
                $order->update();

                return response(1, 200);
            } else {
                return response()->json(['errors' => ['payment_status' => ['Order Payment Can not complete because you have a due.']]], 422);
            }
        } else {
            return response()->json(['errors' => ['payment_status' => ['Order Not Found']]], 404);
        }
    }

    /**
     * Order payment info update
     */
    public function payment_info_update(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required|integer',
            'payment_status' => 'required|integer',
            'pay' => 'required|numeric'
        ]);
        $order = Order::find($request->order_id);
        if ($order) {
            $order->paid += (float)$request->pay;
            $due = $order->grand_total - $order->paid;
            if ($due <= 0) {
                $order->payment_status = $request->payment_status;
                $info['hasError'] = 0;
                $info['message'] = 'Payment status update completed.';
            } else {
                $order->payment_status = 2;
                $info['hasError'] = 1;
                $info['message'] = 'Payment status cannot update to complete because you have a due $' . $due .
                    '\nYou paid total $' . $order->paid;
            }
            $due *= (-1);
            $dueSign = $due < 0 ? "-" : "+";
            $dueSign = $due == 0 ? "" : $dueSign;
            $info['due'] = $dueSign . " $" . abs(number_format($due, 2));
            $order->update();
            $info['order'] = $order;

            return response($info, 200);

        } else {
            return response()->json(['errors' => ['payment_status' => ['Order Not Found']]], 404);
        }
    }

    /**
     * Order payment status update
     */
    public function order_status_update(Request $request)
    {
        $this->validate($request, [
            'post_id' => 'required|integer',
            'order_status' => 'required|integer'
        ]);
        $order = Order::find($request->post_id);
        if ($order) {
            if (!($request->order_status == 1 && $order->grand_total > $order->paid)) {
                $order->order_status = $request->order_status;
                $order->update();

                return response(1, 200);
            } else {
                return response()->json(['errors' => ['order_status' => ['Order Payment Can not complete because you have a due.']]], 422);
            }
        } else {
            return response()->json(['errors' => ['order_status' => ['Order Not Found.']]], 404);
        }
    }

    /**
     * Order payment status update
     */
    public function order_info_update(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required|integer',
            'order_status' => 'required|integer',
            'pay' => 'required|numeric',
            'message' => 'required'
        ]);

        $order = Order::find($request->order_id);

        if ($order) {
            $info['filesHtml'] = '';
            if (trim($request->image) != '') {
                if (trim($order->completed_files) != '') {
                    $order->completed_files .= ',' . $request->image;
                } else {
                    $order->completed_files = $request->image;
                }
                $filesArray = explode(',', $order->completed_files);
                $files = Media::whereIn('slug', $filesArray)->get();

                if (count((array)$files) > 0) {
                    foreach ($files as $fl) {
                        $img = SM::sm_get_galary_src_data_img($fl->slug, $fl->is_private == 1 ? true : false);
                        $src = $img['src'];
                        $info['filesHtml'] .= '<a href="' . url(SM::smAdminSlug('media/download/' . $fl->id)) . '" title="Download ' . $fl->title . '">
													<img src="' . $src . '"
                                                     caption="' . $fl->caption . '" description="' . $fl->description . '"
                                                     class="orderFile" width="50"></a>';

                        $permission = Media_permissions::where('media_id', $fl->id)->where('user_id', $order->user_id)->first();
                        if (!$permission) {
                            $permission = new Media_permissions();
                            $permission->media_id = $fl->id;
                            $permission->user_id = $order->user_id;
                            $permission->save();
                        }
                    }
                }
            }

            $order->paid += (float)$request->pay;
            $due = $order->grand_total - $order->paid;
            if ($due <= 0) {
                $order->order_status = $request->order_status;
                $info['hasError'] = 0;
                $info['message'] = 'Order completed successfully';
            } else {
                $order->payment_status = 2;
                $info['hasError'] = 1;
                $info['message'] = 'Order status cannot update to complete because you have a due $' . $due .
                    '\nYou paid total $' . $order->paid;
            }
            $due *= (-1);
            $dueSign = $due < 0 ? "-" : "+";
            $dueSign = $due == 0 ? "" : $dueSign;
            $info['due'] = $dueSign . " $" . abs(number_format($due, 2));
            $order->update();
            $info['order'] = $order;


            //mail
            $contact_email = $order->contact_email;

            if (filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
                $extra = new \stdClass();
                $extra->message = $request->message;
                \Mail::to($contact_email)->queue(new InvoiceMail($order->id, $extra));
                $info['message'] .= 'And Mail Successfully Send';
            }
            $info['message'] .= '!';

            return response()->json($info, 200);
        } else {
            return response()->json(['errors' => ['order_status' => ['Order Not Found.']]], 404);
        }
    }

    /**
     * Order Mail
     */
    public function order_mail(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required|integer',
            'message' => 'required'
        ]);
        $order = Order::with('user')
            ->find($request->order_id);
        if ($order) {
            $info['filesHtml'] = '';

            $extra = new \stdClass();
            if (trim($request->order_image) != '') {
                if (trim($order->completed_files) != '') {
                    $order->completed_files .= ',' . $request->order_image;
                } else {
                    $order->completed_files = $request->order_image;
                }
                $filesArray = explode(',', $order->completed_files);
                $files = Media::whereIn('slug', $filesArray)->get();

                if (count((array)$files) > 0) {
                    $extra->files = $files;
                    foreach ($files as $fl) {
                        $img = SM::sm_get_galary_src_data_img($fl->slug, $fl->is_private == 1 ? true : false);
                        $src = $img['src'];
                        $info['filesHtml'] .= '<a href="' . url(SM::smAdminSlug('media/download/' . $fl->id)) . '" title="Download ' . $fl->title . '">
													<img src="' . $src . '"
                                                     caption="' . $fl->caption . '" description="' . $fl->description . '"
                                                     class="orderFile" width="50"></a>';

                        if ($fl->is_private == 1) {
                            $permission = Media_permissions::where('media_id', $fl->id)
                                ->where('user_id', $order->user_id)
                                ->first();
                            if (!$permission) {
                                $permission = new Media_permissions();
                                $permission->media_id = $fl->id;
                                $permission->user_id = $order->user_id;
                                $permission->save();
                            }
                        }
                    }
                }
            }

            //mail
            $contact_email = $order->contact_email;
            if (filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
                $extra->subject = "Order Invoice id # " . SM::orderNumberFormat($order) . " Mail";
                $extra->message = $request->message;
                \Mail::to($contact_email)->queue(new NormalMail($extra));
                $info['message'] = 'Mail Successfully Send';
            }
            $info['message'] .= '!';

            return response()->json($info, 200);
        } else {
            return response()->json(['errors' => ['order_status' => ['Order Not Found.']]], 404);
        }
    }
}
