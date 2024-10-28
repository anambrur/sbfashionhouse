<?php

namespace App\Http\Controllers\Admin\Common;

use App\Mail\Offer;
use App\Model\Common\Attribute;
use App\Model\Common\AttributeProduct;
use App\Model\Common\Brand;
use App\Model\Common\Comment;
use App\Model\Common\Review;
use App\Model\Common\Subscriber;
use App\Model\Common\Tag;
use App\Model\Common\Unit;
use App\Notifications\NewProductNotify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SM\SM;
use App\Model\Common\Product as Product;
use App\Model\Common\Category;
use Maatwebsite\Excel\Facades\Excel;
use Notification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Products extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['rightButton']['iconClass'] = 'fa fa-plus';
        $data['rightButton']['text'] = 'Add Product';
        $data['rightButton']['link'] = 'products/create';

        $data['rightButton2']['iconClass'] = 'fa fa-file-excel-o';
        $data['rightButton2']['text'] = 'Export Product';
        $data['rightButton2']['link'] = 'products/export';

        $data['rightButton3']['iconClass'] = 'fa fa-file-excel-o';
        $data['rightButton3']['text'] = 'Import Product';
        $data['rightButton3']['link'] = 'products/importproducts';

        return view("nptl-admin/common/product/index", $data);
    }

    public function dataProcessing(Request $request) {
        $edit_product = SM::check_this_method_access('products', 'edit') ? 1 : 0;
        $product_status_update = SM::check_this_method_access('products', 'product_status_update') ? 1 : 0;
        $delete_product = SM::check_this_method_access('products', 'delete') ? 1 : 0;
        $per = $edit_product + $delete_product;

        $columns = array(
            0 => 'id',
            1 => 'title',
        );

        $totalData = Product::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $products = Product::offset($start)
                    ->limit($limit)
                    //->orderBy($order, $dir)
                    ->orderBy('id', 'desc')
                    ->get();
            $totalFiltered = Product::count();
        } else {
            $search = $request->input('search.value');

            $products = Product::where('title', 'like', "%{$search}%")
//                ->orWhere('branch', 'like', "%{$search}%")
//                ->orWhere('account_no', 'like', "%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    //->orderBy($order, $dir)
                    ->orderBy('id', 'desc')
                    ->get();
            $totalFiltered = Product::where('title', 'like', "%{$search}%")->count();
        }
        $data = array();

        if ($products) {
            foreach ($products as $v_data) {
                $nestedData['id'] = $v_data->id;
                $nestedData['title'] = '<strong>' . $v_data->title . '</strong>';
                if (count((array)$v_data->categories) > 0) {
                    $cat_title = '';
                    foreach ($v_data->categories as $i => $cat) {
                        $cat_title .= $cat->title . ', ';
                    }
                    $cat_title_val = rtrim($cat_title, ', ');
                } else {
                    $cat_title_val = '';
                }
                $nestedData['categories'] = $cat_title_val;
                if (count((array)$v_data->attributes) > 0) {
                    $attribute_title = '';
                    foreach ($v_data->attributes as $attribute) {
                        $attribute_title .= $attribute->title . ', ';
                    }
                    $attribute_title_val = rtrim($attribute_title, ', ');
                } else {
                    $attribute_title_val = 'Simple Product';
                }

                $nestedData['attributes'] = $attribute_title_val;
                $nestedData['brand'] = $v_data->brand->title;
                $nestedData['image'] = '<img class="img-product" src="' . SM::sm_get_the_src($v_data->image, 80, 80) . '">';
                $nestedData['reviews'] = count((array)$v_data->reviews);

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
                if ($product_status_update != 0) {
                    $nestedData['status'] = '<select class="form-control change_status"
                                            route="' . config('constant.smAdminSlug') . '/product_status_update' . '"
                                            post_id="' . $v_data->id . '">
                                        <option value="1" ' . $selected1 . '>Published </option>
                                        <option value="2" ' . $selected2 . '>Pending </option>
                                        <option value="3" ' . $selected3 . '>Canceled </option>
                                        </select>';
                }
                if ($per != 0) {
                    $view_data = '<a target="_blank" href="' . url('/product') . '/' . $v_data->slug . '" title="View"
                                       class="btn btn-xs btn-success" id="">
                                        <i class="fa fa-eye"></i>
                                    </a>';
                    if ($edit_product != 0) {
                        $edit_data = '<a href="' . url(config('constant.smAdminSlug') . '/products') . '/' . $v_data->id . '/edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';
                    } else {
                        $edit_data = '';
                    }
                    if ($delete_product != 0) {
                        $delete_data = '<a href="' . url(config('constant.smAdminSlug') . '/products/delete') . '/' . $v_data->id . '" 
                  title="Delete" class="btn btn-xs btn-default delete_data_row" delete_message="Are you sure to delete this product post?" delete_row="tr_' . $v_data->id . '">
                     <i class="fa fa-times"></i>
                    </a> ';
                    } else {
                        $delete_data = '';
                    }
                    $nestedData['action'] = $view_data . ' ' . $edit_data . ' ' . $delete_data;
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

    public function importproducts() {
        $data['rightButton']['iconClass'] = 'fa fa-list';
        $data['rightButton']['text'] = 'Product List';
        $data['rightButton']['link'] = 'products';
        return view("nptl-admin/common/product/import_product", $data);
    }

    public function import_csv(Request $request) {
        ini_set('max_execution_time', 0);
        $request->validate([
            'import_file' => 'required'
        ]);
        $path = $request->file('import_file')->getRealPath();

        if (($handle = fopen($path, "r")) !== FALSE) {
            fgetcsv($handle); // remove first row of excelfile or csv
            while (($product_val = fgetcsv($handle, 100000, ",")) !== FALSE) {
                $product = new Product();
                if ($product_val[24] == 'Published') {
                    $status = 1;
                } elseif ($product_val[24] == 'Pending') {
                    $status = 2;
                } else {
                    $status = 3;
                }
                $slug = trim($product_val[0]);
                $slug = SM::create_uri('products', $slug);
                $product->created_by = SM::current_user_id();
                $product_type = $product_val[11];
                if ($product_type == 'Simple') {
                    $product_type = 1;
                } elseif ($product_type == 'Variable') {
                    $product_type = 2;
                } else {
                    $product_type = 0;
                }
                $request_unit_title = $product_val[18];
                $pro_unit_check = Unit::where('title', $request_unit_title)->first();
                if (count((array)$pro_unit_check) > 0) {
                    $pro_units_id = $pro_unit_check->id;
                } else {
                    $pro_unit_check['title'] = $request_unit_title;
                    $pro_unit_check['actual_name'] = $request_unit_title;
                    $unit_slug = (trim($request_unit_title));
                    $pro_unit_check['slug'] = SM::create_uri('units', $unit_slug);
                    $pro_att_id = Unit::create($pro_unit_check);
                    $pro_units_id = $pro_att_id->id;
                }
                $request_brand_title = $product_val[13];
                $pro_brand_check = Brand::where('title', $request_brand_title)->first();
                if (count((array)$pro_brand_check) > 0) {
                    $pro_brands_id = $pro_brand_check->id;
                } else {
                    $pro_brand_check['title'] = $request_brand_title;
                    $brand_slug = (trim($request_brand_title));
                    $pro_brand_check['slug'] = SM::create_uri('brands', $brand_slug);
                    $pro_att_id = Brand::create($pro_brand_check);
                    $pro_brands_id = $pro_att_id->id;
                }

//                $units = Unit::where('title', $product_val[18])->first();
//                $brand = Brand::where('title', $product_val[13])->first();

                $product->title = $product_val[0];
                $product->slug = $slug;
                $product->short_description = $product_val[1];
                $product->long_description = $product_val[2];
                $product->image = $product_val[3];
                $product->image_gallery = $product_val[4];
                $product->sku = $product_val[5];
                $product->stock_status = $product_val[6];
                $product->tax_class = $product_val[7];

                $product->regular_price = $product_val[8];
                $product->sale_price = $product_val[9];
//                $product->category = $product_val[10];
                $product->product_type = $product_type;
//                $product->size = $product_val[12];
                $product->brand_id = $pro_brands_id;
                $product->product_qty = $product_val[14];
                $product->alert_quantity = $product_val[15];
                $product->product_weight = $product_val[16];
                $product->product_model = $product_val[17];
                $product->unit_id = $pro_units_id;
                $product->views = $product_val[19];
                $product->seo_title = $product_val[21];
                $product->meta_key = $product_val[22];
                $product->meta_description = $product_val[23];
                $product->status = $status;
                $product->created_by = SM::current_user_id();
                $product->save();
                $inserted_id = $product->id;
                //category section
                $myArrayCat = explode(',', $product_val[10]);
                foreach ($myArrayCat as $category_name) {
                    $categories = array();
                    $category = Category::where('title', $category_name)->first();
                    if (count((array)$category) > 0) {
                        $categories[] = $category->id;
                    } else {
                        $category['title'] = $category_name;
                        $slug = (trim($category_name));
                        $category['slug'] = SM::create_uri('categories', $slug);
                        $cat = Category::create($category);
                        $categories[] = $cat->id;
                    }
                    $product->categories()->attach($categories);
                }
                //Tag section
                $myArrayTag = explode(',', $product_val[20]);
                foreach ($myArrayTag as $tag_name) {

                    $tags = array();
                    $tag = Tag::where('title', $tag_name)->first();
                    if (count((array)$tag) > 0) {
                        $tags[] = $tag->id;
                    } else {
                        $tag['title'] = $tag_name;
                        $slug = (trim($tag_name));
                        $tag['slug'] = SM::create_uri('tags', $slug);
                        $tg = Tag::create($tag);
                        $tags[] = $tg->id;
                    }
                    $product->tags()->attach($tags);
                }
                //attribute section
                if ($product_type == 2) {
                    $product_attribute = explode('|', $product_val[12]);
                    foreach ($product_attribute as $item) {
                        $chest = '';
                        $back = '';
                        $front = '';
                        $legnth = '';
                        $attribute = explode(',', $item);
                        $color = $attribute[0];
                        $att_qty = $attribute[2];
                        $att_price = $attribute[3];
                        $att_image = $attribute[4];
                        $attribute = explode(',', $item);
                        $size_seperate = explode('!', $attribute[1]);
                        $size = $size_seperate[0];
                        $size_m = explode('&', $size_seperate[1]);
                        foreach ($size_m as $size_m_val) {
                            $size_m_seperate = explode('_', $size_m_val);
                            if (str_replace(' ', '', $size_m_seperate[0]) == 'Legnth') {
                                $legnth = $size_m_seperate[1];
                            }
                            if (str_replace(' ', '', $size_m_seperate[0]) == 'Front') {
                                $front = $size_m_seperate[1];
                            }
                            if (str_replace(' ', '', $size_m_seperate[0]) == 'Back') {
                                $back = $size_m_seperate[1];
                            }
                            if (str_replace(' ', '', $size_m_seperate[0]) == 'Chest') {
                                $chest = $size_m_seperate[1];
                            }
                        }
                        $att_sizes = '';
                        $att_size = Attribute::where('title', $size)->first();
                        if (count((array)$att_size) > 0) {
                            $att_sizes = $att_size->id;
                        } else {
                            $att_size['attributetitle_id'] = 2;
                            $att_size['title'] = $size;
                            $att_size['type'] = 'Size';
                            $att_size_id = Attribute::create($att_size);
                            $att_sizes = $att_size_id->id;
                        }
                        $att_color = Attribute::where('title', $color)->first();
                        if (count((array)$att_color) > 0) {
                            $att_colors = $att_color->id;
                        } else {
                            $att_color['attributetitle_id'] = 1;
                            $att_color['title'] = $color;
                            $att_color['type'] = 'Color';
                            $att_color_id = Attribute::create($att_color);
                            $att_colors = $att_color_id->id;
                        }
                        $data = array(
                            'product_id' => $inserted_id,
                            'color_id' => $att_colors,
                            'attribute_id' => $att_sizes,
                            'attribute_legnth' => $legnth,
                            'attribute_front' => $front,
                            'attribute_back' => $back,
                            'attribute_chest' => $chest,
                            'attribute_qty' => $att_qty,
                            'attribute_price' => $att_price,
                            'attribute_image' => $att_image,
                        );
                        AttributeProduct::insert($data);
                    }
                }
            }
        }
        return back()->with("s_message", "Product Imported Successfully");
    }

    public
            function export($type = 'csv') {

        $i = -1;
        $products = Product::all();
        if (count((array)$products) > 0) {
            foreach ($products as $key => $product) {
                $status = '';
                $categories = '';
                $attributes = '';
                $i++;
//            $product_arr[$i]['Product Id'] = $product->id;
                $product_arr[$i]['Title'] = $product->title;
                $product_arr[$i]['Short Description'] = $product->short_description;
                $product_arr[$i]['Long Description'] = $product->long_description;
                $product_arr[$i]['Feature Image'] = $product->image;
                $product_arr[$i]['Image Gallery'] = $product->image_gallery;
                $product_arr[$i]['SKU'] = $product->sku;
                $product_arr[$i]['Stock Status'] = $product->stock_status;
                $product_arr[$i]['Tax Class'] = $product->tax_class;
                $product_arr[$i]['Regular Price'] = $product->regular_price;
                $product_arr[$i]['Sale Price'] = $product->sale_price;
                if (count((array)$product->categories) > 0) {
                    $cat_title = '';
                    foreach ($product->categories as $cat_key => $cat) {
                        $cat_title .= $cat->title . ',';
                    }
                    $categories = rtrim($cat_title, ',');
                } else {
                    $categories = '';
                }
                $product_arr[$i]['Product Categories'] = $categories;
                if (count((array)$product->tags) > 0) {
                    $tag_title = '';
                    foreach ($product->tags as $tag_key => $tag) {
                        $tag_title .= $tag->title . ',';
                    }
                    $tags = rtrim($tag_title, ',');
                } else {
                    $tags = '';
                }

                if ($product->product_type == 1) {
                    $product_type = 'Simple';
                } elseif ($product->product_type == 2) {
                    $product_type = 'Variable';
                } else {
                    $product_type = '';
                }
                $product_arr[$i]['Product Type'] = $product_type;

                if (count((array)$product->attributeProduct) > 0) {
                    foreach ($product->attributeProduct as $attributes_key => $attributeProduct) {
                        $attr_mesurment = '';
                        $Legnth = '';
                        $Front = '';
                        $Back = '';
                        $Chest = '';
                        if (!empty($attributeProduct->attribute_legnth)) {
                            $Legnth = 'Legnth_ ' . $attributeProduct->attribute_legnth . '&';
                        }
                        if (!empty($attributeProduct->attribute_front)) {
                            $Front = ' Front_ ' . $attributeProduct->attribute_front . '&';
                        }
                        if (!empty($attributeProduct->attribute_back)) {
                            $Back = ' Back_ ' . $attributeProduct->attribute_back . '&';
                        }
                        if (!empty($attributeProduct->attribute_chest)) {
                            $Chest = ' Chest_ ' . $attributeProduct->attribute_chest;
                        }
                        $attr_mesurment .= $Legnth . $Front . $Back . $Chest;

                        if (!empty($attributeProduct->attribute_image)) {
                            $attribute_image = $attributeProduct->attribute_image;
                        } else {
                            $attribute_image = '';
                        }
                        $attributes .= $attributeProduct->colorName->title . ',' . $attributeProduct->attribute->title . '!' . $attr_mesurment . ',' . $attributeProduct->attribute_qty . ',' . $attributeProduct->attribute_price . ',' . $attribute_image . '|';
                    }
                }
                $product_arr[$i]['Size Measurement'] = rtrim($attributes, '|');
                $product_arr[$i]['Brand'] = $product->brand->title;
                $product_arr[$i]['Product Qty'] = $product->product_qty;
                $product_arr[$i]['Alert Quantity'] = $product->alert_quantity;
                $product_arr[$i]['Product Weight'] = $product->product_weight;
                $product_arr[$i]['Product Model'] = $product->product_model;
                $product_arr[$i]['Unit'] = $product->unit->title;
                $product_arr[$i]['Total views'] = $product->views;
                $product_arr[$i]['Product Tag'] = $tags;
                $product_arr[$i]['Seo Title'] = $product->seo_title;
                $product_arr[$i]['Meta Key'] = $product->meta_key;
                $product_arr[$i]['Meta Description'] = $product->meta_description;
                if ($product->status == 1) {
                    $status = 'Published';
                } elseif ($product->status == 2) {
                    $status = 'Pending';
                } else {
                    $status = 'Canceled';
                }
                $product_arr[$i]['Status'] = $status;
                $product_arr[$i]['Meta Description'] = $product->meta_description;
                $product_arr[$i]['Meta Description'] = $product->meta_description;
            }
            return Excel::create('product_export', function ($excel) use ($product_arr) {
                        $excel->sheet('mySheet', function ($sheet) use ($product_arr) {
                            $sheet->fromArray($product_arr);
                        });
                    })->download($type);
        } else {
            echo "No data found!";
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data['rightButton']['iconClass'] = 'fa fa-list';
        $data['rightButton']['text'] = 'Product List';
        $data['rightButton']['link'] = 'products';
        $data["all_categories"] = Category::where("parent_id", 0)->get();
        $data["size_lists"] = Attribute::Size()->orderBy('title')->pluck('title', 'id');
        $data["color_lists"] = Attribute::Color()->orderBy('title')->pluck('title', 'id');
        $data["all_brands"] = Brand::orderBy('title')->pluck('title', 'id');
        $data["all_units"] = Unit::orderBy('title')->pluck('title', 'id');

        return view("nptl-admin/common/product/add_product", $data);
    }

    public function productAttributeAddMore(Request $request) {
        $image2 = rand(1000, 99999);
        if ($request->ajax()) {
            $output = '';
            $size_lists = Attribute::Size()->orderBy('title')->pluck('title', 'id');
            $color_lists = Attribute::Color()->orderBy('title')->pluck('title', 'id');

            $input_holder = 'attribute_image' . rand(500, 99999);
            $input_name = 'attribute_image[]';
            $img_holder = 'first_ph2' . rand(500, 99999);
//            @include("nptl-admin.common.common.small_image_form", array('header_name' => 'Product', 'image' => '', 'input_holder' => $input_holder, 'img_holder' => $img_holder))


            $importform = view("nptl-admin.common.common.small_image_form", array('header_name' => 'Product', 'image' => '', 'input_name' => $input_name, 'input_holder' => $input_holder, 'img_holder' => $img_holder));
            $output .= '<tr> 
                                <td>
                                     <input type="hidden" value="0" name="detail_id[]">
                                       ' . \Form::select('attribute_id[]', $size_lists, null, ['required', 'id' => 'attribute_id', 'class' => 'select2', 'placeholder' => 'Please select...']) . '
                                    </td>
                                    <td>
                                       ' . \Form::select('color_id[]', $color_lists, null, ['required', 'id' => 'color_id', 'class' => 'select2', 'placeholder' => 'Please select...']) . '
                                    </td>
                                    <td>
                                       ' . \Form::text('attribute_legnth[]', null, array('autocomplete' => 'off', 'class' => 'form-control attribute_legnth', 'placeholder' => 'Legnth')) . '&nbsp;
                                       ' . \Form::text('attribute_front[]', null, array('autocomplete' => 'off', 'class' => 'form-control attribute_front', 'placeholder' => 'Front')) . '&nbsp;
                                       ' . \Form::text('attribute_back[]', null, array('autocomplete' => 'off', 'class' => 'form-control attribute_back', 'placeholder' => 'Back')) . '&nbsp;
                                       ' . \Form::text('attribute_chest[]', null, array('autocomplete' => 'off', 'class' => 'form-control attribute_chest', 'placeholder' => 'Chest')) . '&nbsp;
                                    </td>
                                    <td>
                                       ' . \Form::number('attribute_qty[]', null, array('autocomplete' => 'off', 'class' => 'form-control attribute_qty', 'placeholder' => 'Qty')) . '
                                    </td>
                                    <td>
                                       ' . \Form::number('attribute_price[]', null, array('autocomplete' => 'off', 'class' => 'form-control attribute_price', 'placeholder' => 'Price')) . '
                                    </td>
                                    <td>' . $importform . '</td>
                                    <td>
                                        <button type="button" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove"></i></button>
                                    </td>
                                </tr>';

            return response()->json($output);
//            echo $output;
            // exit;
        } else {
            return Response()->json(['no' => 'Not found']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required',
//            'image' => "required",
            'sku' => 'required | max:150 | unique:products',
            'categories' => 'required | array',
            'regular_price' => 'required',
//            'attributes123' => 'required | array',
//            'seo_title' => 'max:70',
//            'meta_description' => 'max:215'
        ]);
//        var_dump($request->attribute_id);
//        exit();
        if (!empty($request->input("sale_price"))) {
            $sale_price = $request->input("sale_price");
        } else {
            $sale_price = 0;
        }
        $product = new Product();
        $product->title = $request->input("title");
        $product->short_description = $request->input("short_description", "");
        $product->long_description = $request->input("long_description", "");
//        ---------------
        $product->sku = $request->input("sku", "");
        $product->stock_status = $request->input("stock_status", "");
//        $product->is_special = $request->input("is_special", "");
        $product->tax_class = $request->input("tax_class", "");
        $product->regular_price = $request->input("regular_price", "");
        $product->sale_price = $sale_price;
        $product->brand_id = $request->input("brand_id", "");
        $product->product_qty = $request->input("product_qty", "");
        $product->alert_quantity = $request->input("alert_quantity", "");
        $product->product_weight = $request->input("product_weight", "");
        $product->unit_id = $request->input("unit_id", "");
        $product->product_model = $request->input("product_model", "");
        $product->product_type = $request->input("product_type", "");
//        --------------
        $product->seo_title = $request->input("seo_title", "");
        $product->meta_key = $request->input("meta_key", "");
        $product->meta_description = $request->input("meta_description", "");
        $permission = SM::current_user_permission_array();
        if (SM::is_admin() || isset($permission) &&
                isset($permission['products']['product_status_update']) && $permission['products']['product_status_update'] == 1) {
            $product->status = $request->status;
        }

        if (isset($request->image) && $request->image != '') {
            $product->image = $request->image;
        }

        if (isset($request->image_gallery) && $request->image_gallery != '') {
            $product->image_gallery = $request->image_gallery;
        }
        $slug = (trim($request->slug) != '') ? $request->slug : $request->title;
        $product->slug = SM::create_uri('products', $slug);
        $product->created_by = SM::current_user_id();
//        $product->save();
        if ($product->save()) {
            $productId = $product->id;

            if (!empty($request->attribute_id[0])) {
                $data = [];
                foreach ($request->attribute_id as $key => $v) {
                    $data = array(
                        'attribute_id' => $v,
                        'product_id' => $productId,
                        'color_id' => $request->color_id [$key],
                        'attribute_legnth' => $request->attribute_legnth [$key],
                        'attribute_front' => $request->attribute_front [$key],
                        'attribute_back' => $request->attribute_back [$key],
                        'attribute_chest' => $request->attribute_chest [$key],
                        'attribute_qty' => $request->attribute_qty [$key],
                        'attribute_price' => $request->attribute_price [$key],
                        'attribute_image' => $request->attribute_image [$key],
                    );
                    AttributeProduct::insert($data);
                }
//            $product->attributes()->attach($request->attributes123);
            }
            foreach ($request->categories as $cat) {
                $categories[$cat]['created_at'] = date("Y-m-d H:i:s");
                $categories[$cat]['updated_at'] = date("Y-m-d H:i:s");
                $catInfo = Category::find($cat);
                if ($catInfo) {
                    $catInfo->increment("total_products");
                }
            }
            $product->categories()->attach($categories);

            $tags = SM::insertTag($request->input("tags", ""));
            if ($tags) {
                foreach ($tags as $tag) {
                    $insTags[$tag]['created_at'] = date("Y-m-d H:i:s");
                    $insTags[$tag]['updated_at'] = date("Y-m-d H:i:s");
                    $tagInfo = Tag::find($tag);
                    if ($tagInfo) {
                        $tagInfo->increment("total_products");
                    }
                }
                if ($insTags) {
                    $product->tags()->attach($insTags);
                }
            }
            $this->removeThisCache();
            $subscribers = Subscriber::all();
            foreach ($subscribers as $subscriber) {
                Notification::route('mail', $subscriber->email)
                        ->notify(new NewProductNotify($product));
            }

//            $subscriber_email= Subscriber::select('email')->get();
//            if (count($subscriber_email) > 0) {
//                foreach ($subscriber_email as $email) {
//                    $info = $request->except('email');
//                    Mail::to($email->email)
//                        ->queue(new Offer((object)$info));
//                }
//
//                return response('All mail successfully send.');
//            } else {
//                return response()->json(['errors' => ['email[]' => ['Email Not Found']]], 422);
//            }
            return redirect(SM::smAdminSlug("products/$product->id/edit"))->with("s_message", "Product successfully saved!");
        } else {
            return redirect(SM::smAdminSlug("products"))->with("w_message", "Product save failed!");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data["product_info"] = Product::with("categories", "tags")->find($id);
        if ($data["product_info"] !== null) {
            $data['rightButton']['iconClass'] = 'fa fa - list';
            $data['rightButton']['text'] = 'Product List';
            $data['rightButton']['link'] = 'products';
            $data['rightButton2']['iconClass'] = 'fa fa - eye';
            $data['rightButton2']['text'] = 'View';
            $data['rightButton2']['link'] = "product/" . $data['product_info']->slug;

            $data['product_info']->categories = SM::get_ids_from_data($data['product_info']->categories);
            $data['product_info']->tags = SM::sm_get_product_tags($data['product_info']->tags);
            $data['all_categories'] = Category::where('parent_id', 0)->get();
            $data["size_lists"] = Attribute::Size()->orderBy('title')->pluck('title', 'id');
            $data["color_lists"] = Attribute::Color()->orderBy('title')->pluck('title', 'id');
            $data["all_brands"] = Brand::orderBy('title')->pluck('title', 'id');
            $data["all_units"] = Unit::orderBy('title')->pluck('title', 'id');

            return view("nptl-admin.common.product.edit_product", $data);
        } else {
            return redirect(SM::smAdminSlug("categories"))->with("w_message", "Product Not Found!");
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
    public function update(Request $request, $id) {
        $this->validate($request, [
            'title' => 'required | max:100',
//            'image' => "required",
            'categories' => 'required | array',
//            'attributes123' => 'required | array',
//            'seo_title' => 'max:70',
//            'meta_description' => 'max:215'
        ]);
        if (!empty($request->input("sale_price"))) {
            $sale_price = $request->input("sale_price");
        } else {
            $sale_price = 0;
        }
        $product = Product::find($id);
        if ($product !==null) {
            $this->removeThisCache($product->slug, $product->id);
            $product->title = $request->input("title");
            $product->short_description = $request->input("short_description", "");
            $product->long_description = $request->input("long_description", "");
            //        ---------------
            $product->sku = $request->input("sku", "");
            $product->stock_status = $request->input("stock_status", "");
//            $product->is_special = $request->input("is_special", "");
            $product->tax_class = $request->input("tax_class", "");
            $product->regular_price = $request->input("regular_price", "");
            $product->sale_price = $sale_price;
            $product->brand_id = $request->input("brand_id", "");
            $product->product_qty = $request->input("product_qty", "");
            $product->alert_quantity = $request->input("alert_quantity", "");
            $product->product_weight = $request->input("product_weight", "");
            $product->unit_id = $request->input("unit_id", "");
            $product->product_model = $request->input("product_model", "");
            $product->product_type = $request->input("product_type", "");
//        --------------
            $product->seo_title = $request->input("seo_title", "");
            $product->meta_key = $request->input("meta_key", "");
            $product->meta_description = $request->input("meta_description", "");
//            $product->is_featured = isset($request->is_featured) && $request->is_featured == 'on' ? 1 : 0;
//            $product->is_sticky = isset($request->is_sticky) && $request->is_sticky == 'on' ? 1 : 0;
//            $product->comment_enable = isset($request->comment_enable) && $request->comment_enable == 'on' ? 1 : 0;
            $permission = SM::current_user_permission_array();
            if (SM::is_admin() || isset($permission) &&
                    isset($permission['products']['product_status_update']) && $permission['products']['product_status_update'] == 1) {
                $product->status = $request->status;
            }
            if (isset($request->image) && $request->image != '') {
                $product->image = $request->image;
            }
            if (isset($request->image_gallery) && $request->image_gallery != '') {
                $product->image_gallery = $request->image_gallery;
            }
            $slug = (trim($request->slug) != '') ? $request->slug : $request->title;
            $product->slug = SM::create_uri('products', $slug, $id);
            $product->modified_by = SM::current_user_id();
            $product->update();
            $updateCount = $product->id;

            $productId = $updateCount;
            $total_qty=0;

            if (!empty($request->attribute_id[0])) {
                $data = [];
                $row11 = AttributeProduct::where('product_id', $productId)->get();

                if (count((array)$row11) > 0) {
                    foreach ($row11 as $data12) {
                        $array_id[] = $data12->id;
                    }
                    foreach ($request->attribute_id as $key => $v) {
                        $detail_id[] = $request->detail_id [$key];
                    }
                    $remove_data = array_diff($array_id, $detail_id);
                    AttributeProduct::whereIn('id', $remove_data)->delete();
                }


                foreach ($request->attribute_id as $key => $v) {
                    $total_qty += $request->attribute_qty [$key];
                    $data = array(
                        'attribute_id' => $v,
                        'product_id' => $productId,
                        'color_id' => $request->color_id [$key],
                        'attribute_legnth' => $request->attribute_legnth [$key],
                        'attribute_front' => $request->attribute_front [$key],
                        'attribute_back' => $request->attribute_back [$key],
                        'attribute_chest' => $request->attribute_chest [$key],
                        'attribute_qty' => $request->attribute_qty [$key],
                        'attribute_price' => $request->attribute_price [$key],
                        'attribute_image' => $request->attribute_image [$key],
                    );
                    $row = AttributeProduct::find($request->detail_id [$key]);
                    if (!empty($row)) {
                        AttributeProduct::where('id', $request->detail_id [$key])->update($data);
                    } else {
                        AttributeProduct::insert($data);
                    }
                }
                $product_up = Product::find($productId);
                 $product_up->product_qty=$total_qty;
                $product_up->update();
            } else {
                AttributeProduct::where('product_id', $productId)->delete();
            }

            if ($updateCount > 0) {
                $oldCatIds = SM::get_ids_from_data($product->categories);
                foreach ($request->categories as $cat) {
                    $categories[$cat]['created_at'] = date("Y-m-d H:i:s");
                    $categories[$cat]['updated_at'] = date("Y-m-d H:i:s");
                    if (!in_array($cat, $oldCatIds)) {
                        $catInfo = Category::find($cat);
                        if ($catInfo) {
                            $catInfo->increment("total_products");
                        }
                    }
                }
                $product->categories()->sync($categories);
//                $product->attributes()->sync($request->attributes123);

                $tags = SM::insertTag($request->input("tags", ""));
                $oldTagIds = SM::get_ids_from_data($product->tags);
                if ($tags) {
                    foreach ($tags as $tag) {
                        $insTags[$tag]['created_at'] = date("Y-m-d H:i:s");
                        $insTags[$tag]['updated_at'] = date("Y-m-d H:i:s");
                        $tagInfo = Tag::find($tag);
                        if (!in_array($tag, $oldTagIds)) {
                            if (count((array)$tagInfo) > 0) {
                                $tagInfo->increment("total_products");
                            }
                        }
                    }
                    if ($insTags) {
                        $product->tags()->sync($insTags);
                    }
                }

                return redirect(SM::smAdminSlug("products/$id/edit"))->with("s_message", "Product Updated Successfully!");
            } else {
                return redirect(SM::smAdminSlug("products/$id/edit"))->with("s_message", "Product Update Failed!");
            }
        } else {
            return redirect(SM::smAdminSlug("products"))->with("w_message", "Product Not Found!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $product = Product::with('categories', 'tags', 'attributes')->find($id);
        if (count((array)$product) > 0) {
            if (count((array)$product->categories) > 0) {
                foreach ($product->categories as $category) {
                    if ($category->total_products > 0) {
                        $category->decrement('total_products');
                    }
                }
            }
            $product->attributes()->detach();
            if (count((array)$product->tags) > 0) {
                foreach ($product->tags as $tag) {
                    if ($tag->total_products > 0) {
                        $tag->decrement('total_products');
                    }
                }
            }
            $this->removeThisCache($product->slug, $product->id);

            if ($product->delete() > 0) {
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
    public function product_status_update(Request $request) {
        $this->validate($request, [
            "post_id" => "required",
            "status" => "required",
        ]);

        $product = Product::find($request->post_id);
        if (count((array)$product) > 0) {
            $this->removeThisCache($product->slug, $product->id);
            $product->status = $request->status;
            $product->update();
        }
        exit;
    }

    /**
     * Get all comment info
     */
    public function reviews() {
        $data["reviews"] = Review::latest()
                ->paginate(config("constant.smPagination"));

        if (\request()->ajax()) {
            $json['data'] = view('sm-admin/common/product/reviews', $data)->render();
            $json['smPagination'] = view('sm-admin/common/common/pagination_links', [
                'smPagination' => $data['reviews']
                    ])->render();

            return response()->json($json);
        }

        return view("nptl-admin/common/product/manage_reviews", $data);
    }

    public function edit_comment($id) {
        $data['comment'] = Comment::leftJoin("products", function ($query) {
                    $query->on("products.id", "=", "comments.commentable_id")
                    ->where("comments.commentable_type", "=", 'App\Model\Common\Product');
                })
                ->where("comments.id", $id)
                ->select('comments .*', 'products . title as product_title')
                ->first();

        return view("nptl-admin/common/product/edit_comment", $data);
    }

    public function update_comment(Request $request, $id) {
        $this->validate($request, ["comments" => "required"]);
        $comment = Comment::find($id);
        if (count((array)$comment) > 0) {
            $comment->comments = $request->comments;
            $comment->modified_by = SM::current_user_id();
            if (SM::is_admin() || isset($permission) &&
                    isset($permission['products']['comment_status_update']) && $permission['products']['comment_status_update'] == 1) {

                if ($comment->commentable_type == Product::class) {
                    $product = Product::find($comment->commentable_id);
                    if ($product) {
                        if ($comment->status == 1 && ($request->status == 2 || $request->status == 3)) {
                            $product->decrement("comments");
                        }
                        if ($request->status == 1 && ($comment->status == 2 || $comment->status == 3)) {
                            $product->increment("comments");
                        }
                        $this->removeThisCache($product->slug, $comment->commentable_id);
                    } else {
                        $this->removeThisCache(null, $comment->commentable_id);
                    }
                } else {
                    $this->removeThisCache(null, $comment->commentable_id);
                }


                $comment->status = $request->status;
            } else {
                $this->removeThisCache(null, $comment->commentable_id);
            }
            $comment->update();

            return redirect(SM::smAdminSlug("products/comments"))->with("s_message", "Comment updated successfully!");
        }

        return redirect(SM::smAdminSlug("products/comments"))->with("w_message", "Comment not found!");
    }

    public function reply_comment($id) {
        $data['comment'] = Comment::leftJoin("products", function ($query) {
                    $query->on("products.id", "=", "comments.commentable_id")
                    ->where("comments.commentable_type", "=", 'App\Model\Common\Product');
                })
                ->where("comments.id", $id)
                ->select('comments .*', 'products . title as product_title')
                ->first();

        return view("nptl-admin/common/product/reply_comment", $data);
    }

    public function save_reply(Request $request) {
        $this->validate($request, [
            "p_c_id" => "required",
            "commentable_id" => "required",
            "commentable_type" => "required",
            "reply" => "required",
        ]);
        $product = Product::find($request->commentable_id);
        if ($product) {
            $product->increment("comments");

            $comment = new Comment();
            $comment->p_c_id = $request->p_c_id;
            $comment->commentable_id = $request->commentable_id;
            $comment->commentable_type = $request->commentable_type;
            $comment->comments = $request->reply;
            $comment->created_by = 1;
            $comment->modified_by = 1;
            if (SM::is_admin() || isset($permission) &&
                    isset($permission['products']['reply_comment']) && $permission['products']['reply_comment'] == 1) {
                $comment->status = $request->status;
            }
            $comment->save();
            $this->removeThisCache(null, $request->commentable_id);

            return redirect(SM::smAdminSlug("products/comments"))->with("s_message", "Comment reply saved successfully!");
        } else {
            return response("Product Not Found!", 404);
        }
    }

    /**
     * delete comment
     *
     * @param $id integer
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete_review($id) {
        $review = Review::find($id);
        if (count((array)$review) > 0) {
            if ($review->delete() > 0) {
                return response(1);
            }
        }

        return response(0);
    }

    /**
     * update comment status
     *
     * @param Request $request
     */
    public function review_status_update(Request $request) {
        $this->validate($request, [
            "post_id" => "required",
            "status" => "required",
        ]);

        $review = Review::find($request->post_id);
        if (count((array)$review) > 0) {
            $review->status = $request->status;
            $review->update();
        }
        exit;
    }

    public function removeThisCache($slug = null, $id = null) {
        SM::removeCache('homeLatestDealsProducts');
        SM::removeCache('homeRecommendedProducts');
        SM::removeCache('sidebar_popular_product');
        if ($slug != null) {
            SM::removeCache('product_' . $slug);
            SM::removeCache('product_related_product_' . $slug);
        }
        if ($id != null) {
            SM::removeCache(['product_comments_count_' . $id], 1);
            SM::removeCache(['product_comments_' . $id], 1);
        }
        SM::removeCache(['categoryProducts'], 1);
        SM::removeCache(['tagProducts'], 1);
        SM::removeCache(['products'], 1);
        SM::removeCache(['stickyProducts'], 1);
    }

}
