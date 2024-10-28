<?php

namespace App\Http\Controllers\Admin\Common;

use App\Model\Common\Attribute;
use App\Model\Common\Attributetitle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Common\Attributetitle as Attributetitle_model;
use App\SM\SM;
use Illuminate\Support\Facades\Cache;

class Attributetitles extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['rightButton']['iconClass'] = 'fa fa-plus';
        $data['rightButton']['text'] = 'Add Attributetitle';
        $data['rightButton']['link'] = 'attributetitles/create';

        $data['all_attributetitle'] = Attributetitle_model::orderBy("id", "desc")
            ->paginate(config("constant.smPagination"));
        if (\request()->ajax()) {
            $json['data'] = view('nptl-admin.common.attributetitle.attributetitles', $data)->render();
            $json['smPagination'] = view('nptl-admin.common.common.pagination_links', [
                'smPagination' => $data['all_attributetitle']
            ])->render();

            return response()->json($json);
        }

        return view("nptl-admin.common.attributetitle.manage_attributetitle", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['rightButton']['iconClass'] = 'fa fa-list-alt';
        $data['rightButton']['text'] = 'Attributetitle List';
        $data['rightButton']['link'] = 'attributetitles';
        return view("nptl-admin/common/attributetitle/add_attributetitle", $data);
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
//            'seo_title' => 'max:70',
//            'meta_description' => 'max:215'
        ]);
        $attribute = $request->all();
        $permission = SM::current_user_permission_array();
        if (SM::is_admin() || isset($permission) &&
            isset($permission['attributetitles']['attributetitle_status_update'])
            && $permission['attributetitles']['attributetitle_status_update'] == 1) {
            $attribute['status'] = $request->status;
        }
        if (isset($request->image) && $request->image != '') {
            $attribute['image'] = $request->image;
        }

        $slug = (trim($request->slug) != '') ? $request->slug : $request->title;
        $attribute['slug'] = SM::create_uri('attributetitles', $slug);
        $attribute['created_by'] = SM::current_user_id();
        $attribute['seo_title'] = $request->input("seo_title", "");
        $attribute['meta_key'] = $request->input("meta_key", "");
        $attribute['meta_description'] = $request->input("meta_description", "");
        $cat = Attributetitle_model::create($attribute);
        if ($cat) {
            $this->removeThisCache();

            return redirect(SM::smAdminSlug("attributetitles"))
                ->with('s_message', 'Attributetitle Saved Successfully!');
        } else {
            return redirect(SM::smAdminSlug("attributetitles"))
                ->with('s_message', 'Attributetitle Save Failed!');
        }

    }

    public function get_attribute_data(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $row = Attributetitle::find($request->attributetitle_id);
            if ($row) {
                $output .= '<div class="modal-header">
            
            <h4 class="modal-title"><strong>' . $row->title . '</strong><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></h4>
         </div>
          <form action="' . route('store_attribute_data') . '" method="POST" enctype="multipart/form-data">  
          <input type="hidden" name="_token" value="' . csrf_token() . '" > 
         <div class="modal-body"> 
               <div class="col-md-12">
                <div class="form-group row">  
                     <label class="col-md-4 col-form-label">Attribute Value</label>
                      <div class="col-md-8">
                         <input type="text" required="true" name="title" autocomplete="off"  placeholder="Attribute Value" class="form-control"> 
                    </div> 
               </div>   
            </div> 
            <input type="hidden" name="attributetitle_id" value="' . $row->id . '"> 
            <input type="hidden" name="type" value="' . $row->title . '"> 
         </div>
            <div class="modal-footer">
               <button type="button" id="close" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-success" id="btn">Submit</button>
            </div>
            </form> ';
            } else {
                $output .= 'false';
            }
            echo $output;


        }
    }

    public function edit_attribute_data(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $row = Attribute::find($request->attribute_id);
            if ($row) {
                $output .= '<div class="modal-header">
            
            <h4 class="modal-title"><strong>' . $row->title . '</strong>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </h4>
         </div>
          <form action="' . route('update_attribute_data') . '" method="POST">  
          <input type="hidden" name="_token" value="' . csrf_token() . '" > 
         <div class="modal-body"> 
               <div class="col-md-12">
                <div class="form-group row">  
                     <label class="col-md-4 col-form-label">Attribute Value</label>
                      <div class="col-md-8">
                         <input type="text" required="true" name="title" value="' . $row->title . '" autocomplete="off"  placeholder="Attribute" class="form-control"> 
                    </div> 
               </div>   
            </div> 
            <input type="hidden" name="attributetitle_id" value="' . $row->attributetitle_id . '"> 
            <input type="hidden" name="attribute_id" value="' . $row->id . '"> 
            <input type="hidden" name="type" value="' . $row->type . '"> 
         </div>
            <div class="modal-footer">
               <button type="button" id="close" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-success" id="btn">Update</button>
                <a class="btn btn-danger" href="delete_attribute_data/' . $row->id . '">Delete</a>
            </div>
            </form> 
                 ';
            } else {
                $output .= 'false';
            }
            echo $output;


        }
    }

    public function store_attribute_data(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:150',
//            'seo_title' => 'max:70',
//            'meta_description' => 'max:215'
        ]);
        $attribute = $request->all();
        $cat = Attribute::create($attribute);
        if ($cat) {
            $this->removeThisCache();
            return back()->with('s_message', 'Attribute Value Saved Successfully!');
        } else {
            return back()->with('s_message', 'Attribute Value Save Failed!');
        }

    }

    public function update_attribute_data(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:150',
//            'seo_title' => 'max:70',
//            'meta_description' => 'max:215'
        ]);
       
        $attribute = Attribute::find($request->attribute_id);
        $attribute->title = $request->title;
        $attribute->attributetitle_id = $request->attributetitle_id;
        $attribute->type = $request->type;
        $attribute->update();
        if ($attribute) {
            $this->removeThisCache();
            return back()->with('s_message', 'Attribute Value Updated Successfully!');
        } else {
            return back() > with('s_message', 'Attribute Value Updated Failed!');
        }

    }

    public function delete_attribute_data($id)
    { 
        Attribute::destroy($id);
        return back()->with('s_message', 'Attribute Value Delete Successfully!');
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
        $data["attributetitle_info"] = Attributetitle_model::find($id);
        if (count((array)$data["attributetitle_info"]) > 0) {
            $data['rightButton']['iconClass'] = 'fa fa-list-alt';
            $data['rightButton']['text'] = 'Attributetitle List';
            $data['rightButton']['link'] = 'attributetitles';
            $data['rightButton2']['iconClass'] = 'fa fa-eye';
            $data['rightButton2']['text'] = 'View';
            $data['rightButton2']['link'] = "attributetitle/attributetitle/" . $data['attributetitle_info']->slug;
            return view("nptl-admin/common/attributetitle/edit_attributetitle", $data);
        } else {
            return redirect(SM::smAdminSlug('attributetitles'))
                ->with('s_message', 'Attributetitle not found!');
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
//            'seo_title' => 'max:70',
//            'meta_description' => 'max:215'
        ]);
        $attribute = Attributetitle_model::find($id);
        if (count((array)$attribute) > 0) {
            $this->removeThisCache($attribute->slug);
            $attribute->title = $request->title;
            $attribute->description = $request->description;
            $attribute->seo_title = $request->input("seo_title", "");
            $attribute->meta_key = $request->input("meta_key", "");
            $attribute->meta_description = $request->input("meta_description", "");
            $permission = SM::current_user_permission_array();
            if (SM::is_admin() || isset($permission) &&
                isset($permission['attributetitles']['attributetitle_status_update'])
                && $permission['attributetitles']['attributetitle_status_update'] == 1) {
                $attribute->status = $request->status;
            }
            if (isset($request->image) && $request->image != '') {
                $attribute->image = $request->image;
            }

            $slug = (trim($request->slug) != '') ? $request->slug : $request->title;
            $attribute->slug = SM::create_uri('attributetitles', $slug, $id);
            $attribute->modified_by = SM::current_user_id();

            if ($attribute->update() > 0) {
                $this->removeThisCache();

                return redirect(SM::smAdminSlug("attributetitles/$attribute->id/edit"))
                    ->with('s_message', 'Attributetitle Update Successfully!');
            } else {
                return redirect(SM::smAdminSlug("attributetitles/$attribute->id/edit"))
                    ->with('s_message', 'Attributetitle Update Failed!');
            }
        } else {
            return redirect(SM::smAdminSlug('attributetitles'))
                ->with('w_message', 'Attributetitle not found!');
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
        $cat = Attributetitle_model::find($id);
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
    public function attributetitle_status_update(Request $request)
    {
        $this->validate($request, [
            "post_id" => "required",
            "status" => "required",
        ]);

        $cat = Attributetitle_model::find($request->post_id);
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
            SM::removeCache('attributetitle_' . $slug);
        }
        SM::removeCache('attributetitles_have_posts');
        SM::removeCache('attributetitles_have_not_post');
        SM::removeCache(['attribute'], 1);
        SM::removeCache(['attributeBlogs'], 1);
    }
}
