<?php

namespace App\Http\Controllers\Admin\Common;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Common\Brand as Brand_model;
use App\SM\SM;
use Illuminate\Support\Facades\Cache;

class Brands extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['rightButton']['iconClass'] = 'fa fa-plus';
        $data['rightButton']['text'] = 'Add Brand';
        $data['rightButton']['link'] = 'brands/create';

        $data['all_brand'] = Brand_model::orderBy("id", "desc")
            ->paginate(config("constant.smPagination"));
        if (\request()->ajax()) {
            $json['data'] = view('nptl-admin/common/brand/brands', $data)->render();
            $json['smPagination'] = view('nptl-admin/common/common/pagination_links', [
                'smPagination' => $data['all_brand']
            ])->render();

            return response()->json($json);
        }

        return view("nptl-admin/common/brand/manage_brand", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['rightButton']['iconClass'] = 'fa fa-list-alt';
        $data['rightButton']['text'] = 'Brand List';
        $data['rightButton']['link'] = 'brands';
        return view("nptl-admin/common/brand/add_brand", $data);
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
        $this->validate($request, [
            'title' => 'required|max:150',
            'seo_title' => 'max:70',
            'meta_description' => 'max:215'
        ]);
        $brand = $request->all();
        $permission = SM::current_user_permission_array();
        if (SM::is_admin() || isset($permission) &&
            isset($permission['brands']['brand_status_update'])
            && $permission['brands']['brand_status_update'] == 1) {
            $brand['status'] = $request->status;
        }
        if (isset($request->image) && $request->image != '') {
            $brand['image'] = $request->image;
        }

        $slug = (trim($request->slug) != '') ? $request->slug : $request->title;
        $brand['slug'] = SM::create_uri('brands', $slug);
        $brand['website'] = $request->input("website", "");
        $brand['created_by'] = SM::current_user_id();
        $brand['seo_title'] = $request->input("seo_title", "");
        $brand['meta_key'] = $request->input("meta_key", "");
        $brand['meta_description'] = $request->input("meta_description", "");
        $cat = Brand_model::create($brand);
        if ($cat) {
            $this->removeThisCache();

            Toastr::success('Brand Saved Successfully!', 'Success');
            return redirect(SM::smAdminSlug("brands"))
                ->with('s_message', 'Brand Saved Successfully!');
        } else {
            Toastr::error('Brand Save Failed!', 'Error');
            return redirect(SM::smAdminSlug("brands"))
                ->with('s_message', 'Brand Save Failed!');
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
        $data["brand_info"] = Brand_model::find($id);
        if ($data["brand_info"]) {
            $data['rightButton']['iconClass'] = 'fa fa-list-alt';
            $data['rightButton']['text'] = 'Brand List';
            $data['rightButton']['link'] = 'brands';
            $data['rightButton2']['iconClass'] = 'fa fa-eye';
            $data['rightButton2']['text'] = 'View';
            $data['rightButton2']['link'] = "blog/brand/" . $data['brand_info']->slug;


            return view("nptl-admin/common/brand/edit_brand", $data);
        } else {
            return redirect(SM::smAdminSlug('brands'))
                ->with('s_message', 'Brand not found!');
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
        $this->validate($request, [
            'title' => 'required|max:150',
            'seo_title' => 'max:70',
            'meta_description' => 'max:215'
        ]);
        $brand = Brand_model::find($id);
        if ($brand) {
            $this->removeThisCache($brand->slug);
            $brand->title = $request->title;
            $brand->website = $request->website;
            $brand->description = $request->description;
            $brand->seo_title = $request->input("seo_title", "");
            $brand->meta_key = $request->input("meta_key", "");
            $brand->meta_description = $request->input("meta_description", "");
            $permission = SM::current_user_permission_array();
            if (SM::is_admin() || isset($permission) &&
                isset($permission['brands']['brand_status_update'])
                && $permission['brands']['brand_status_update'] == 1) {
                $brand->status = $request->status;
            }
            if (isset($request->image) && $request->image != '') {
                $brand->image = $request->image;
            }

            $slug = (trim($request->slug) != '') ? $request->slug : $request->title;
            $brand->slug = SM::create_uri('brands', $slug, $id);
            $brand->modified_by = SM::current_user_id();

            if ($brand->update() > 0) {
                $this->removeThisCache();

                return redirect(SM::smAdminSlug("brands/$brand->id/edit"))
                    ->with('s_message', 'Brand Update Successfully!');
            } else {
                return redirect(SM::smAdminSlug("brands/$brand->id/edit"))
                    ->with('s_message', 'Brand Update Failed!');
            }
        } else {
            return redirect(SM::smAdminSlug('brands'))
                ->with('w_message', 'Brand not found!');
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
        $cat = Brand_model::find($id);
        if (count((array)$cat) > 0) {
            if ($cat->delete() > 0) {
                $this->removeThisCache($cat->slug);
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
    public function brand_status_update(Request $request)
    {
        $this->validate($request, [
            "post_id" => "required",
            "status" => "required",
        ]);

        $cat = Brand_model::find($request->post_id);
        if (count((array)$cat) > 0) {
            $cat->status = $request->status;
            $cat->update();
            $this->removeThisCache($cat->slug);
        }
        exit;
    }

    private function removeThisCache($slug = null)
    {
        if ($slug != null) {
            SM::removeCache('brand_' . $slug);
        }
        SM::removeCache('brands_have_posts');
        SM::removeCache('brands_have_not_post');
        SM::removeCache(['brand'], 1);
        SM::removeCache(['brandBlogs'], 1);
    }
}
