<?php

namespace App\Http\Controllers\Admin\Common;

use App\SM\SM;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Common\Coupon;

class Coupons extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['rightButton']['iconClass'] = 'fa fa-plus';
        $data['rightButton']['text'] = 'Add Coupon';
        $data['rightButton']['link'] = 'coupons/create';
        return view("nptl-admin/common/coupon/index", $data);
    }

    public function dataProcessing(Request $request)
    {
        $edit_coupon = SM::check_this_method_access('coupons', 'edit') ? 1 : 0;
        $coupon_status_update = SM::check_this_method_access('coupons', 'coupon_status_update') ? 1 : 0;
        $delete_coupon = SM::check_this_method_access('coupons', 'destroy') ? 1 : 0;
        $per = $edit_coupon + $delete_coupon;

        $columns = array(
            0 => 'id',
            1 => 'title',
        );

        $totalData = Coupon::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $products = Coupon::offset($start)
                ->limit($limit)
                //->orderBy($order, $dir)
                ->orderBy('id', 'desc')
                ->get();
            $totalFiltered = Coupon::count();
        } else {
            $search = $request->input('search.value');

            $products = Coupon::where('title', 'like', "%{$search}%")
                ->orWhere('coupon_code', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                //->orderBy($order, $dir)
                ->orderBy('id', 'desc')
                ->get();
            $totalFiltered = Coupon::where('title', 'like', "%{$search}%")->orWhere('coupon_code', 'like', "%{$search}%")->count();
        }
        $data = array();

        if ($products) {
            foreach ($products as $v_data) {
                $nestedData['id'] = $v_data->id;
                $nestedData['title'] = '<strong>' . $v_data->title . '</strong>';
                $nestedData['coupon_code'] = $v_data->coupon_code;
                $nestedData['qty'] = $v_data->qty;
                $nestedData['balance_qty'] = $v_data->balance_qty;
                $nestedData['type'] = ($v_data->type == 1 ? SM::get_setting_value('currency') : "") . ' ' . $v_data->coupon_amount . ($v_data->type == 2 ? "%" : "");
                $nestedData['validity'] = SM::showDateTime($v_data->validity);

                if ($v_data->status == 1) {
                    $selected1 = "Selected";
                } else {
                    $selected1 = '';
                }
                if ($v_data->status == 2) {
                    $selected2 = "Selected";
                } else {
                    $selected2 = "";
                }
                if ($v_data->status == 3) {
                    $selected3 = "Selected";
                } else {
                    $selected3 = "";
                }
                if ($coupon_status_update != 0) {
                    $nestedData['status'] = '<select class="form-control change_status"
                                            route="' . config('constant.smAdminSlug') . '/coupon_status_update' . '"
                                            post_id="' . $v_data->id . '">
                                        <option value="1" ' . $selected1 . '>Published </option>
                                        <option value="2" ' . $selected2 . '>Pending </option>
                                        <option value="3" ' . $selected3 . '>Canceled </option>
                                        </select>';
                }
                if ($per != 0) {
                    if ($edit_coupon != 0) {
                        $edit_data = '<a href="' . url(config('constant.smAdminSlug') . '/coupons') . '/' . $v_data->id . '/edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';
                    } else {
                        $edit_data = '';
                    }
                    if ($delete_coupon != 0) {
                        $delete_data = '<a href="' . url(config('constant.smAdminSlug') . '/coupons/destroy') . '/' . $v_data->id . '" 
                  title="Delete" class="btn btn-xs btn-default delete_data_row" delete_message="Are you sure to delete this data?" delete_row="tr_' . $v_data->id . '">
                     <i class="fa fa-times"></i>
                    </a> ';
                    } else {
                        $delete_data = '';
                    }
                    $nestedData['action'] = $edit_data . ' ' . $delete_data;
                } else {
                    $nestedData['action'] = '';
                }
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['rightButton']['iconClass'] = 'fa fa-thumbs-up';
        $data['rightButton']['text'] = 'Coupon List';
        $data['rightButton']['link'] = 'coupons';
        $data['suggestion_coupon_code'] = SM::generateCouponCode();

        return view("nptl-admin/common/coupon/add_coupon", $data);
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
        $rules = [
            'title' => 'required',
            "validity" => "required",
            "type" => "required|integer",
            "discount_type" => "required|integer",
        ];
        if ($request->input('discount_type', 2) == 2) {
            $rules['coupon_code'] = 'required|unique:coupons';
            $rules['qty'] = 'required|numeric';
            $rules['balance_qty'] = 'required|numeric';
            if ($request->input('type', 1) == 1) {
                $rules['coupon_amount'] = 'required|numeric';
            } else {
                $rules['coupon_amount'] = 'required|numeric|max:100';
            }
        }
        $this->validate($request, $rules);
        $coupon = new Coupon();
        $coupon->title = $request->title;
        $coupon->discount_type = $request->discount_type;
        $coupon->coupon_code = $request->coupon_code;
        $coupon->validity = $request->validity;
        $coupon->qty = $request->qty;
        $coupon->balance_qty = $request->balance_qty;
        $coupon->coupon_amount = $request->coupon_amount;
        $coupon->type = $request->type;
        $permission = SM::current_user_permission_array();
        if (SM::is_admin() || isset($permission) &&
            isset($permission['coupons']['coupon_status_update'])
            && $permission['coupons']['coupon_status_update'] == 1) {
            $coupon->status = $request->status;
        }
        $coupon->created_by = SM::current_user_id();
        if ($coupon->save()) {
            return redirect(SM::smAdminSlug("coupons/$coupon->id/edit"))
                ->with('s_message', 'Coupon Saved Successfully!');
        } else {
            return redirect(SM::smAdminSlug("coupons"))
                ->with('s_message', 'Coupon Save Failed!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
//	public function show( $id ) {
//		//
//	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data["coupon_info"] = Coupon::find($id);
        if (count((array)$data["coupon_info"]) > 0) {
            $data['rightButton']['iconClass'] = 'fa fa-thumbs-up';
            $data['rightButton']['text'] = 'Coupon List';
            $data['rightButton']['link'] = 'coupons';
            $data['suggestion_coupon_code'] = SM::generateCouponCode();

            return view("nptl-admin/common/coupon/edit_coupon", $data);
        } else {
            return redirect(SM::smAdminSlug('coupons'))
                ->with('s_message', 'Coupon not found!');
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
    public function update(Request $request, $id)
    {

        $rules = [
            'title' => 'required',
            "validity" => "required",
            "type" => "required|integer",
            "discount_type" => "required|integer",
        ];
        if ($request->input('discount_type', 2) == 2) {
            $rules['coupon_code'] = 'required|unique:coupons';
            $rules['qty'] = 'required|numeric';
            $rules['balance_qty'] = 'required|numeric';
            if ($request->input('type', 1) == 1) {
                $rules['coupon_amount'] = 'required|numeric';
            } else {
                $rules['coupon_amount'] = 'required|numeric|max:100';
            }
        }

        $this->validate($request, $rules);
        $coupon = Coupon::find($id);
        if (count((array)$coupon) > 0) {
            $coupon->title = $request->title;
            $coupon->discount_type = $request->discount_type;
            $coupon->coupon_code = $request->coupon_code;
            $coupon->validity = $request->validity;
            $coupon->coupon_amount = $request->coupon_amount;
            $coupon->qty = $request->qty;
            $coupon->balance_qty = $request->balance_qty;
            $coupon->type = $request->type;
            $permission = SM::current_user_permission_array();
            if (SM::is_admin() || isset($permission) &&
                isset($permission['coupons']['coupon_status_update'])
                && $permission['coupons']['coupon_status_update'] == 1) {
                $coupon->status = $request->status;
            }
            $coupon->modified_by = SM::current_user_id();
            if ($coupon->update() > 0) {
                return redirect(SM::smAdminSlug("coupons/$coupon->id/edit"))
                    ->with('s_message', 'Coupon Update Successfully!');
            } else {
                return redirect(SM::smAdminSlug("coupons/$coupon->id/edit"))
                    ->with('s_message', 'Coupon Update Failed!');
            }
        } else {
            return redirect(SM::smAdminSlug('coupons'))
                ->with('w_message', 'Coupon not found!');
        }
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
        $coupon = Coupon::find($id);
        if (count((array)$coupon) > 0) {
            if ($coupon->delete() > 0) {
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
    public function coupon_status_update(Request $request)
    {
        $this->validate($request, [
            "post_id" => "required",
            "status" => "required",
        ]);

        $coupon = Coupon::find($request->post_id);
        if (count((array)$coupon) > 0) {
            $coupon->status = $request->status;
            $coupon->update();
        }
        exit;
    }
}
