<?php

namespace App\Http\Controllers\Admin\Common;

use App\Admin;
use App\Mail\Offer;
use App\Model\Common\Admins_meta;
use App\Model\Common\Order;
use App\Model\Common\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SM\SM;
use App\Model\Common\Visitor;
use Illuminate\Support\Facades\Cache;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class Dashboard extends Controller
{
    public function index()
    {

        $data['views'] = Visitor::orderBy('id', 'desc')
            ->take('50')
            ->get()
            ->reverse();
        $data['viewsReformatted'] = [];
        $data['viewsInfo'] = [];
        if (isset($data['views']) && count((array)$data['views']) > 0) {
            $loop = 0;
            foreach ($data['views'] as $view) {
                $data['viewsReformatted'][$loop][] = $loop;
                $data['viewsReformatted'][$loop][] = $view->views;
                $data['viewsInfo'][$loop] = $view->views . ($view->views > 1 ? " views on " : " view on ") . date('dS F, Y', strtotime($view->date));
                $loop++;
            }
        }
        $date = date('Y-m-d');
        $visitor = Visitor::where('date', '=', $date)->first();
        $data['today_visitor'] = $visitor ? (int)$visitor->views : 0;
        $data['max_visitor'] = (int)Visitor::max('views');

        return view('nptl-admin/common/dashboard/dashboard', $data);
    }

    public function access_denied()
    {
        return view('nptl-admin/common/dashboard/access_denied');
    }

    public function getSlug(Request $request)
    {
        $this->validate($request, [
            'slug' => 'required',
            'table' => 'required'
        ]);

        if (isset($request->current_info_id) && $request->current_info_id != '') {
            echo SM::create_uri($request->table, $request->slug, (int)$request->current_info_id);
        } else {
            echo SM::create_uri($request->table, $request->slug);
        }
        exit();

    }

    public function get_image_src()
    {
        $is_upload = (int)$_POST["is_upload"];
        if ($is_upload == 1) {
            $ids = $_POST["ids"];
            ?>
            <img class="media_img" src="<?php echo SM::sm_get_the_src($ids, 112, 112) ?>"
                 width="100px"/>
            <?php
            exit();
        } else {
            $ids = $_POST["ids"];
            $filedId = (int)$_POST["filedId"];
            $image_array = [];
            if (!$image_array = explode(',', $ids)) {
                $image_array = array($ids);
            }
            if (is_array($image_array) && count((array)$image_array) > 0) {
                foreach ($image_array as $img_id) {
                    if (!SM::sm_string($img_id)) {
                        continue;
                    }
                    ?>
                    <span class="gl_img">
                                 <img class="" src="<?php echo SM::sm_get_the_src($img_id, 112, 112) ?>"
                                      width="100px"/>
                                 <span class="displayNone remove">
                                     <i class="fa fa-times-circle remove_img"
                                        data-img="<?php echo $img_id; ?>"
                                        data-input_holder="<?php echo $filedId; ?>"
                                     ></i>
                                 </span>
                              </span>
                    <?php
                }
            }
            exit();
        }
    }

    public function flashCache()
    {
        Cache::flush();

        return back()->with("s_message", "Cache flush done successfully!");
    }

    public function flashSession(Request $request)
    {
        Session::flush();

        return back()->with("s_message", "Session flush done successfully!");
    }

    public function searchPackage(Request $request)
    {
        $this->validate($request, [
            'package' => 'required'
        ]);
        $packages = Package::select('id', 'title')
            ->where('title', 'like', "%$request->package%")
            ->limit(10)
            ->get();
        if (count((array)$packages) > 0) {
            return response()->json($packages);
        }

        return response('Package Not Found!', 404);
    }

    public function searchUser(Request $request)
    {
        $this->validate($request, [
            'customer' => 'required'
        ]);
        $users = User::select(
            'id',
            'username',
            DB::raw("CONCAT(firstname, ' ', lastname) as fullname")
        )
            ->where('firstname', 'like', "%$request->customer%")
            ->orWhere('lastname', 'like', "%$request->customer%")
            ->orWhere('username', 'like', "%$request->customer%")
            ->orWhere('mobile', 'like', "%$request->customer%")
            ->limit(10)
            ->get();
        if (count((array)$users) > 0) {
            return response()->json($users);
        }

        return response('User Not Found!', 404);
    }

    public function offerMail(Request $request)
    {
        $this->validate($request, [
            "email.*" => "required|email",
            "discount_title" => "required",
            "available_title" => "required",
            "message" => "required",
            "btn_title" => "required",
            "btn_link" => "required",
            "image" => "required",
        ]);
        if (is_array($request->email) && count((array)$request->email) > 0) {
            foreach ($request->email as $email) {
                $info = $request->except('email');
                Mail::to($email)
                    ->queue(new Offer((object)$info));
            }

            return response('All mail successfully send.');
        } else {
            return response()->json(['errors' => ['email[]' => ['Email Not Found']]], 422);
        }
    }

    public function edit_profile()
    {
        $id = SM::current_user_id();
        $data['roles'] = Role::where("status", 1)->get();
        $data['user'] = Admin::find($id);
        $user_meta = Admins_meta::where('admin_id', $id)->get();
        if (count((array)$user_meta)) {
            foreach ($user_meta as $meta) {
                $key = $meta->meta_key;
                $data['user']->$key = $meta->meta_value;
            }
        }
        unset($data['user']->password);

        return view('nptl-admin/common/dashboard/edit_user', $data);
    }

    public function update_profile(Request $data)
    {
        $this->validate($data, [
            'password' => 'confirmed'
        ]);
        $user_id = SM::current_user_id();

        $user = Admin::find($user_id);

        if ($user) {
            if (isset($data['image']) && $data['image'] != '') {
                $user->image = $data['image'];
            }
            if (isset($data['password']) && $data['password'] != '' && $data['password'] == $data['password_confirmation']) {
                $user->password = bcrypt($data['password']);
            }

            $user->firstname = isset($data['firstname']) ? $data['firstname'] : null;
            $user->lastname = isset($data['lastname']) ? $data['lastname'] : null;
            $user->update();

            $value = isset($data['mobile']) ? $data['mobile'] : null;
            SM::update_user_meta($user_id, 'mobile', $value);


            $value = isset($data['gender']) ? $data['gender'] : null;
            SM::update_user_meta($user_id, 'gender', $value);


            $value = isset($data['skype']) ? $data['skype'] : null;
            SM::update_user_meta($user_id, 'skype', $value);


            $value = isset($data['whats_app']) ? $data['whats_app'] : null;
            SM::update_user_meta($user_id, 'whats_app', $value);


            $value = isset($data['street']) ? $data['street'] : null;
            SM::update_user_meta($user_id, 'street', $value);


            $value = isset($data['city']) ? $data['city'] : null;
            SM::update_user_meta($user_id, 'city', $value);

            $value = isset($data['state']) ? $data['state'] : null;
            SM::update_user_meta($user_id, 'state', $value);

            $value = isset($data['zip']) ? $data['zip'] : null;
            SM::update_user_meta($user_id, 'zip', $value);


            $value = isset($data['country']) ? $data['country'] : null;
            SM::update_user_meta($user_id, 'country', $value);


            $value = isset($data['extra_note']) ? $data['extra_note'] : null;
            SM::update_user_meta($user_id, 'extra_note', $value);

            return redirect(config('constant.smAdminSlug') . '/profile')->with('s_message', 'User updated successfully!');
        } else {
            return back()->with('w_message', 'User not found!');
        }
    }

    function profile()
    {
        return view('nptl-admin/common/dashboard/profile');
    }
}
