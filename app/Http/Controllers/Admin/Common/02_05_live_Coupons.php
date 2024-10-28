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
        $data['all_coupon'] = Coupon::orderBy("id", "desc")
            ->paginate(config("constant.smPagination"));
        if (\request()->ajax()) {
            $json['data'] = view('nptl-admin/common/coupon/coupons', $data)->render();
            $json['smPagination'] = view('nptl-admin/common/common/pagination_links', [
                'smPagination' => $data['all_coupon']
            ])->render();

            return response()->json($json);
        }

        return view("nptl-admin/common/coupon/manage_coupon", $data);
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
            "coupon_code" => "required|unique:coupons",
            "validity" => "required",
            "qty" => "required",
            "type" => "required|integer",
        ];
        if ($request->input('type', 1) == 1) {
            $rules['coupon_amount'] = 'required|numeric';
        } else {
            $rules['coupon_amount'] = 'required|numeric|max:100';
        }

        $this->validate($request, $rules);
        $coupon = new Coupon();
        $coupon->title = $request->title;
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
            "coupon_code" => "required|unique:coupons,coupon_code," . $id,
            "validity" => "required",
            "qty" => "required",
            "type" => "required|integer",
        ];
        if ($request->input('type', 1) == 1) {
            $rules['coupon_amount'] = 'required|numeric';
        } else {
            $rules['coupon_amount'] = 'required|numeric|max:100';
        }

        $this->validate($request, $rules);
        $coupon = Coupon::find($id);
        if (count((array)$coupon) > 0) {
            $coupon->title = $request->title;
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
