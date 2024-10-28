<?php

namespace App\Http\Controllers\Admin\Common;

use App\Model\Common\Categoryable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Common\Category as Category_model;
use App\SM\SM;
use Illuminate\Support\Facades\Cache;

class Categories extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['rightButton']['iconClass'] = 'fa fa-plus';
        $data['rightButton']['text'] = 'Add Category';
        $data['rightButton']['link'] = 'categories/create';

        $data['all_category'] = Category_model::where("parent_id", 0)
            ->orderBy("id", "desc")
            ->paginate(config("constant.smPagination"));
        if (\request()->ajax()) {
            $json['data'] = view('nptl-admin/common/category/categories', $data)->render();
            $json['smPagination'] = view('nptl-admin/common/common/pagination_links', [
                'smPagination' => $data['all_category']
            ])->render();

            return response()->json($json);
        }

        return view("nptl-admin/common/category/manage_category", $data);
    }
    public
    function dataProcessingCategory(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'title',
        );

        $totalData = Category::where('parent_id', 0)->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $medicines = Category::where('parent_id', 0)->offset($start)
                ->limit($limit)
                //->orderBy($order, $dir)
                ->orderBy('id', 'desc')
                ->get();
            $totalFiltered = Category::where('parent_id', 0)->count();
        } else {
            $search = $request->input('search.value');

            $medicines = Category::where('title', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                //->orderBy($order, $dir)
                ->orderBy('id', 'desc')
                ->get();

            $totalFiltered = count((array)$medicines);
        }
        $data = array();

        if ($medicines) {
            foreach ($medicines as $v_data) {
                $nestedData['title'] = '<strong>' . $v_data->title . '</strong>';
                $nestedData['color_code'] = $v_data->color_code;
                $nestedData['priority'] = $v_data->priority;
                $nestedData['image'] = SM::sm_get_the_src($v_data->image, 45, 45);
                $nestedData['fav_icon'] = SM::sm_get_the_src($v_data->fav_icon, 20, 24);
                $nestedData['action'] = '
                 <a href="' . url(config('constant.smAdminSlug') . '/transactions/tc_edit') . '/' . $v_data->id . '" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                 <a href="' . url(config('constant.smAdminSlug') . '/transactions/tc_destroy') . '/' . $v_data->id . '" delete_message="Are you sure to delete this Customer? This Customer all data will be delete"  class="btn btn-xs btn-default delete_data_row" delete_row="tr_' . $v_data->id . '">
                 <i class="fa fa-times"></i>
                 </a> 
                ';
                $data[] = $nestedData;
                $tcategory_datas = Category::where('parent_id', $v_data->id)->get();
                if ($tcategory_datas) {
                    foreach ($tcategory_datas as $tcategory_data) {
                        $nestedData['title'] = '__<strong>' . $tcategory_data->title . '</strong>';
                        $nestedData['color_code'] = $tcategory_data->color_code;
                        $nestedData['priority'] = $tcategory_data->priority;
                        $nestedData['image'] = SM::sm_get_the_src($tcategory_data->image, 45, 45);
                        $nestedData['fav_icon'] = SM::sm_get_the_src($tcategory_data->fav_icon, 20, 24);
                        $nestedData['action'] = '
                           <a href="' . url(config('constant.smAdminSlug') . '/transactions/tc_edit') . '/' . $tcategory_data->id . '" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                           <a href="' . url(config('constant.smAdminSlug') . '/transactions/tc_destroy') . '/' . $tcategory_data->id . '" delete_message="Are you sure to delete this Customer? This Customer all data will be delete"  class="btn btn-xs btn-default delete_data_row" delete_row="tr_' . $tcategory_data->id . '">
                           <i class="fa fa-times"></i>
                           </a>
                             ';
                        $data[] = $nestedData;
                    }
                }

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
        $data['rightButton']['iconClass'] = 'fa fa-list-alt';
        $data['rightButton']['text'] = 'Category List';
        $data['rightButton']['link'] = 'categories';
        $data["categories"] = Category_model::where("parent_id", 0)
            ->orderBy("id", "desc")
            ->paginate(config("constant.smPagination"));

        return view("nptl-admin/common/category/add_category", $data);
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
            'title' => 'required|max:100',
            "parent_id" => "required",
            'seo_title' => 'max:70',
            'meta_description' => 'max:215'
        ]);
        $category = $request->all();
        $permission = SM::current_user_permission_array();
        if (SM::is_admin() || isset($permission) &&
            isset($permission['categories']['category_status_update'])
            && $permission['categories']['category_status_update'] == 1) {
            $category['status'] = $request->status;
        }
        if (isset($request->image) && $request->image != '') {
            $category['image'] = $request->image;
        }

        $slug = (trim($request->slug) != '') ? $request->slug : $request->title;
        $category['slug'] = SM::create_uri('categories', $slug);
        $category['created_by'] = SM::current_user_id();
        $category['seo_title'] = $request->input("seo_title", "");
        $category['meta_key'] = $request->input("meta_key", "");
        $category['meta_description'] = $request->input("meta_description", "");
        $cat = Category_model::create($category);
        if ($cat) {
            $this->removeThisCache();

            return redirect(SM::smAdminSlug("categories/$cat->id/edit"))
                ->with('s_message', 'Category Saved Successfully!');
        } else {
            return redirect(SM::smAdminSlug("categories"))
                ->with('s_message', 'Category Save Failed!');
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
        $data["category_info"] = Category_model::find($id);
        if ($data["category_info"] !== null) {
            $data['rightButton']['iconClass'] = 'fa fa-list-alt';
            $data['rightButton']['text'] = 'Category List';
            $data['rightButton']['link'] = 'categories';
            $data['rightButton2']['iconClass'] = 'fa fa-eye';
            $data['rightButton2']['text'] = 'View';
            $data['rightButton2']['link'] = "category/" . $data['category_info']->slug;

            $data["categories"] = Category_model::where("parent_id", 0)
                ->orderBy("id", "desc")
                ->paginate(config("constant.smPagination"));

            return view("nptl-admin/common/category/edit_category", $data);
        } else {
            return redirect(SM::smAdminSlug('categories'))
                ->with('s_message', 'Category not found!');
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
            'title' => 'required|max:100',
            "parent_id" => "required",
            'seo_title' => 'max:70',
            'meta_description' => 'max:215'
        ]);
        $category = Category_model::find($id);
        if ($category !== null) {
            $this->removeThisCache($category->slug);
            $category->title = $request->title;
            $category->parent_id = $request->parent_id;
            $category->color_code = $request->color_code;
            $category->priority = $request->priority;
            $category->description = $request->description;
            $category->seo_title = $request->input("seo_title", "");
            $category->meta_key = $request->input("meta_key", "");
            $category->meta_description = $request->input("meta_description", "");
            $permission = SM::current_user_permission_array();
            if (SM::is_admin() || isset($permission) &&
                isset($permission['categories']['category_status_update'])
                && $permission['categories']['category_status_update'] == 1) {
                $category->status = $request->status;
            }
            if (isset($request->image) && $request->image != '') {
                $category->image = $request->image;
            }
            if (isset($request->fav_icon) && $request->fav_icon != '') {
                $category->fav_icon = $request->fav_icon;
            }

            $slug = (trim($request->slug) != '') ? $request->slug : $request->title;
            $category->slug = SM::create_uri('categories', $slug, $id);
            $category->modified_by = SM::current_user_id();

            if ($category->update() > 0) {
                $this->removeThisCache();

                return redirect(SM::smAdminSlug("categories/$category->id/edit"))
                    ->with('s_message', 'Category Update Successfully!');
            } else {
                return redirect(SM::smAdminSlug("categories/$category->id/edit"))
                    ->with('s_message', 'Category Update Failed!');
            }
        } else {
            return redirect(SM::smAdminSlug('categories'))
                ->with('w_message', 'Category not found!');
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
        $cat = Category_model::find($id);
        if (count((array)$cat) > 0) {
            $catgoryables = Categoryable::where('category_id', $id)->get();
            if (count((array)$catgoryables) > 0) {
                foreach ($catgoryables as $catgoryable) {
                    $catgoryable->delete();
                }
            }

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
    public function category_status_update(Request $request)
    {
        $this->validate($request, [
            "post_id" => "required",
            "status" => "required",
        ]);

        $cat = Category_model::find($request->post_id);
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
            SM::removeCache('category_' . $slug);
        }
        SM::removeCache('categories_have_posts');
        SM::removeCache('categories_have_not_post');
        SM::removeCache(['category'], 1);
        SM::removeCache(['categoryBlogs'], 1);
    }
}
