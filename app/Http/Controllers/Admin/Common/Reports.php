<?php

namespace App\Http\Controllers\Admin\Common;

use App\Model\Common\Order;
use App\Model\Common\Package;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\SM\SM;
use Maatwebsite\Excel\Facades\Excel;

class Reports extends Controller
{
    public function orders(Request $request)
    {
        $order_id = $request->input('order_id', '');
        $sdate = $request->input('sdate');
        $edate = $request->input('edate');
        $package = $request->input('package', '');
        $pid = $request->input('pid', '');
        $order_status = $request->input('order_status', '');
        $payment_status = $request->input('payment_status', '');

        $customer = $request->input('customer', '');
        $cid = $request->input('customer', '');

//        $query = DB::table('orders')
//            ->select(
//                'orders.*',
//                DB::raw("CONCAT(users.firstname,' ', users.lastname) as fullname"),
//                'users.username'
//            )
//            ->join('users', 'orders.user_id', '=', 'users.id')
////            ->join('products', 'orders.product_id', '=', 'products.id')
        $all_order = Order::latest()
            ->when($order_id, function ($query) use ($order_id) {
                if ($order_id != "") {
                    if (preg_match('/-/', $order_id)) {
                        $order_id = SM::getOriginalOrderId($order_id);
                    }
                    return $query->where('id', '=', $order_id);
                }
            })
            ->when($sdate, function ($query) use ($sdate) {
                if ($sdate != "") {
                    return $query->whereDate('created_at', '=', $sdate);
                }
            })
            ->when($edate, function ($query) use ($edate) {
                if ($edate != "") {
                    return $query->whereDate('created_at', '=', $edate);
                }
            })
            ->when($payment_status, function ($query) use ($payment_status) {
                if ($payment_status != "") {
                    return $query->where('payment_status', '=', $payment_status);
                }
            })
            ->when($order_status, function ($query) use ($order_status) {
                if ($order_status != "") {
                    return $query->where('order_status', '=', $order_status);
                }
            })
            ->when($cid, function ($query) use ($cid) {
                if ($cid != "") {
                    return $query->where('customer_name', '=', $cid);
                }
            })
            ->get();


//        if ($order_id != '') {
//            $orderId = $data['order_id'];
//            if (preg_match('/-/', $orderId)) {
//                $orderId = SM::getOriginalOrderId($orderId);
//            }
//            $query->where('id', '=', $orderId);
//        }
//        if ($data['sdate'] != '') {
//            $query->whereDate('created_at', '<=', $data['edate']);
//        }
//        if ($data['edate'] != '') {
//            $query->whereDate('created_at', '>=', $data['sdate']);
//        }
////        if ($data['pid'] != '') {
////            $query->where('product_id', '=', $data['pid']);
////        } else {
////            $data['package'] = '';
////        }
//        if ($data['payment_status'] != '') {
//            $query->where('payment_status', '=', $data['payment_status']);
//        }
//        if ($data['order_status'] != '') {
//            $query->where('order_status', '=', $data['order_status']);
//        }
//        if ($data['cid'] != '') {
//            $query->where('user_id', '=', $data['cid']);
//        } else {
//            $data['customer'] = '';
//        }
//        $data['all_order'] = $query;

//        $data['all_order'] = Order::all();
        if ($request->has('excel') && $request->excel == 'excel') {
            $orders = $all_order->toArray();
            if (count((array)$orders) > 0) {
                Excel::create('doodle_digital_orders_' . date('YmdHis'), function ($excel) use ($orders) {

                    $excel->sheet('Order Report ' . date('Y-m-d'), function ($sheet) use ($orders) {
                        $loop = 1;
                        $sheet->mergeCells("A$loop:I$loop");
                        $sheet->cells("A$loop:I$loop", function ($cells) {
                            $cells->setBackground('#1d2d5d');
                            $cells->setFontColor('#ffffff');
                            $cells->setFontSize(18);
                            $cells->setAlignment('center');
                            $cells->setValignment('center');
                            // Set all borders (top, right, bottom, left)
                            $cells->setBorder('none', 'none', 'solid', 'none');

// Set borders with array
                            $cells->setBorder(array(
                                'bottom' => array(
                                    'style' => 'solid'
                                ),
                            ));
                        });
                        $single = [];
                        $single[] = 'Doodle Digital Order Report Excel';
                        $sheet->row($loop, $single);
                        $sheet->getRowDimension($loop)->setRowHeight(40);
                        $loop++;
                        $dueArray = [];
                        $netTotalArray = [];
                        $paidArray = [];

                        $single = [];
                        $single[] = 'Order ID';
                        $single[] = 'Created Date';
                        $single[] = 'Customer';
                        $single[] = 'Package Title';
                        $single[] = 'Order Status';
                        $single[] = 'Payment Status';
                        $single[] = 'Total';
                        $single[] = 'Paid';
                        $single[] = 'Due';
                        $sheet->row($loop, $single);
                        $sheet->cells("A$loop:I$loop", function ($cells) {
                            $cells->setBackground('#1d2d5d');
                            $cells->setFontColor('#ffffff');
                            $cells->setFontSize(12);
                            $cells->setAlignment('center');
                            $cells->setValignment('center');
                        });
                        $sheet->getRowDimension($loop)->setRowHeight(20);
                        $loop++;
                        $loop++;
                        foreach ($orders as $order) {
                            $single = [];
                            $single[] = SM::orderNumberFormat($order);
                            $single[] = date('Y-m-d H:i:s', strtotime($order->created_at));
                            $single[] = $order->fullname != '' ? $order->fullname : $order->username;
                            $single[] = $order->fullname;
                            if ($order->order_status == 1) {
                                $single[] = 'Completed';
                            } else if ($order->order_status == 2) {
                                $single[] = 'Progress';
                            } else if ($order->order_status == 3) {
                                $single[] = 'Pending';
                            } else {
                                $single[] = 'Canceled';
                            }
                            if ($order->payment_status == 1) {
                                $single[] = 'Completed';
                            } else if ($order->payment_status == 3) {
                                $single[] = 'Pending';
                            } else {
                                $single[] = 'Canceled';
                            }
                            $due = $order->paid - $order->net_total;
                            $dueSign = $due < 0 ? "-" : "+";
                            $dueSign = $due == 0 ? "" : $dueSign;

                            $dueArray[] = $due;
                            $netTotalArray[] = $order->net_total;
                            $paidArray[] = $order->paid;
                            $single[] = number_format($order->net_total, 2);
                            $single[] = number_format($order->paid, 2);
                            $single[] = $dueSign . number_format($due, 2);

                            $sheet->row($loop, $single);
                            $loop++;
                        }
                        $loop++;


                        $single = [];
                        $sheet->mergeCells("A$loop:E$loop");
                        $sheet->cells("A$loop:E$loop", function ($cells) {
                            $cells->setBackground('#1d2d5d');
                            $cells->setFontColor('#ffffff');
                            $cells->setFontSize(12);
                            $cells->setAlignment('left');
                        });
                        $sheet->cells("F$loop:I$loop", function ($cells) {
                            $cells->setBackground('#1d2d5d');
                            $cells->setFontColor('#ffffff');
                            $cells->setFontSize(12);
                            $cells->setAlignment('right');
                        });
                        $single[0] = 'Developed by Engr. Mizanur Rahman Khan';
                        $single[1] = "Total";
                        $single[2] = "Total";
                        $single[3] = "Total";
                        $single[4] = "Total";
                        $single[5] = "Total";
                        $single[6] = number_format(array_sum($netTotalArray), 2);
                        $single[7] = number_format(array_sum($paidArray), 2);
                        $single[8] = number_format(array_sum($dueArray), 2);
                        $sheet->row($loop, $single);


                    });

                })->download('xlsx');
            } else {
                return view("nptl-admin/common/reports/orders_report", compact('order_id', 'sdate', 'edate', 'package', 'pid', 'payment_status', 'customer', 'cid', 'all_order', 'order_status'));
            }
        } else {
            return view("nptl-admin/common/reports/orders_report", compact('order_id', 'sdate', 'edate', 'package', 'pid', 'payment_status', 'customer', 'cid', 'all_order', 'order_status'));
        }
    }
}
