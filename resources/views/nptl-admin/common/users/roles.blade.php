{{csrf_field()}}
<fieldset>
    <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
        <label class="label control-label" for="role">Role name</label>
        <div class="input">
            <input name="role" id="role" class="form-control" placeholder="Role Name" type="text" required=""
                   value="{{ old('role')!=''? old('role'): isset($role->name)? $role->name : ""}}" autocomplete="off">
            <input name="id" id="id" type="hidden" value="{{ isset($role->id)? $role->id : ""}}">
            @if ($errors->has('role'))
                <span class="help-block">
            <strong>{{ $errors->first('role') }}</strong>
         </span>
            @endif
        </div>
    </div>
</fieldset>
<fieldset>
    <section>
		<?php
		$permission = ( isset( $role->permission ) ) ? SM::sm_unserialize( $role->permission ) : array();
		?>
        <div class="row">
			<?php
			$blogs = isset( $permission['blogs'] ) ? $permission['blogs'] : array();
			?>
            <div class="col col-3 user_role">
                <label class="label"><b>Blog Management</b></label>
                <label class="checkbox">
                    <input type="checkbox" name="permission[blogs][blogs]" <?php
					echo is_array( $blogs ) && isset( $blogs['blogs'] ) && $blogs['blogs'] == 1 ? 'checked="checked"' : '';
					?> value="1">
                    <i></i>Blog Management</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[blogs][index]" <?php
					echo is_array( $blogs ) && isset( $blogs['index'] ) && $blogs['index'] == 1 ? 'checked="checked"' : '';
					?> value="1">
                    <i></i>All Blog List</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[blogs][create]" <?php
					echo is_array( $blogs ) && isset( $blogs['create'] ) && $blogs['create'] == 1 ? 'checked="checked"' : '';
					?> value="1">
                    <i></i>Add Blog</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[blogs][edit]" <?php
					echo is_array( $blogs ) && isset( $blogs['edit'] ) && $blogs['edit'] == 1 ? 'checked="checked"' : '';
					?>  value="1">
                    <i></i>Edit Blog</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[blogs][blog_status_update]" <?php
					echo is_array( $blogs ) && isset( $blogs['blog_status_update'] ) && $blogs['blog_status_update'] == 1 ? 'checked="checked"' : '';
					?> value="1">
                    <i></i>Blog Status Change</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[blogs][destroy]" <?php
					echo is_array( $blogs ) && isset( $blogs['destroy'] ) && $blogs['destroy'] == 1 ? 'checked="checked"' : '';
					?>  value="1">
                    <i></i>Delete Blog</label>
            </div>


            <div class="col col-3 user_role">
                <label class="label"><b>Comments Management</b></label>
                <label class="checkbox">
                    <input type="checkbox" name="permission[blogs][blog_comment]" <?php
					echo is_array( $blogs ) && isset( $blogs['blog_comment'] ) && $blogs['blog_comment'] == 1 ? 'checked="checked"' : '';
					?>   value="1">
                    <i></i>Comments Management</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[blogs][index]" <?php
					echo is_array( $blogs ) && isset( $blogs['index'] ) && $blogs['index'] == 1 ? 'checked="checked"' : '';
					?>   value="1">
                    <i></i>All Comment List</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[blogs][reply_comment]" <?php
					echo is_array( $blogs ) && isset( $blogs['reply_comment'] ) && $blogs['reply_comment'] == 1 ? 'checked="checked"' : '';
					?>    value="1">
                    <i></i>Reply Comment</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[blogs][edit_comment]" <?php
					echo is_array( $blogs ) && isset( $blogs['edit_comment'] ) && $blogs['edit_comment'] == 1 ? 'checked="checked"' : '';
					?>   value="1">
                    <i></i>Edit Comment</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[blogs][comment_status_update]" <?php
					echo is_array( $blogs ) && isset( $blogs['comment_status_update'] ) && $blogs['comment_status_update'] == 1 ? 'checked="checked"' : '';
					?>   value="1">
                    <i></i>Comment Status Change</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[blogs][delete_comment]" <?php
					echo is_array( $blogs ) && isset( $blogs['delete_comment'] ) && $blogs['delete_comment'] == 1 ? 'checked="checked"' : '';
					?> value="1">
                    <i></i>Delete Comment</label>
            </div>
			<?php
			$categories = isset( $permission['categories'] ) ? $permission['categories'] : array();
			?>
            <div class="col col-3 user_role">
                <label class="label"><b>Category Management</b></label>
                <label class="checkbox">
                    <input type="checkbox" name="permission[categories][categories]" <?php
					echo is_array( $categories ) && isset( $categories['categories'] ) && $categories['categories'] == 1 ? 'checked="checked"' : '';
					?>  value="1">
                    <i></i>Category Management</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[categories][index]" <?php
					echo is_array( $categories ) && isset( $categories['index'] ) && $categories['index'] == 1 ? 'checked="checked"' : '';
					?>  value="1">
                    <i></i>All Category List</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[categories][create]" <?php
					echo is_array( $categories ) && isset( $categories['create'] ) && $categories['create'] == 1 ? 'checked="checked"' : '';
					?>  value="1">
                    <i></i>Add Category</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[categories][edit]" <?php
					echo is_array( $categories ) && isset( $categories['edit'] ) && $categories['edit'] == 1 ? 'checked="checked"' : '';
					?>  value="1">
                    <i></i>Edit Category</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[categories][category_status_update]" <?php
					echo is_array( $categories ) && isset( $categories['category_status_update'] ) && $categories['category_status_update'] == 1 ? 'checked="checked"' : '';
					?>  value="1">
                    <i></i>Category Status Change</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[categories][destroy]" <?php
					echo is_array( $categories ) && isset( $categories['destroy'] ) && $categories['destroy'] == 1 ? 'checked="checked"' : '';
					?>  value="1">
                    <i></i>Delete Category</label>
            </div>
			<?php
			$tags = isset( $permission['tags'] ) ? $permission['tags'] : array();
			$methods = [
				'tags'              => 'Manage Tags',
				'index'             => 'All Tag',
				'create'            => 'Add Tag',
				'edit'              => '',
				'tag_status_update' => 'Tag Status Update',
				'destroy'           => 'Delete Tag',
			];
			echo SM::generateRoleHtml( 'Tag', 'tags', $methods, $tags );
			?>

            <div class="clearfix"></div>
			<?php
			$sliders = isset( $permission['sliders'] ) ? $permission['sliders'] : array();
			?>
            <div class="col col-3 user_role">
                <label class="label"><b>Slider Management</b></label>
                <label class="checkbox">
                    <input type="checkbox" name="permission[sliders][sliders]" <?php
					echo is_array( $sliders ) && isset( $sliders['sliders'] ) && $sliders['sliders'] == 1 ? 'checked="checked"' : '';
					?> value="1">
                    <i></i>Manage Sliders</label>
                <label class="checkbox">
                    <input type="checkbox" name="permission[sliders][index]" <?php
					echo is_array( $sliders ) && isset( $sliders['index'] ) && $sliders['index'] == 1 ? 'checked="checked"' : '';
					?> value="1">
                    <i></i>Sliders List</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[sliders][add_slider]" <?php
					echo is_array( $sliders ) && isset( $sliders['add_slider'] ) && $sliders['add_slider'] == 1 ? 'checked="checked"' : '';
					?> value="1">
                    <i></i>Add Slider</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[sliders][edit_slider]" <?php
					echo is_array( $sliders ) && isset( $sliders['edit_slider'] ) && $sliders['edit_slider'] == 1 ? 'checked="checked"' : '';
					?> value="1">
                    <i></i>Edit Slider</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[sliders][slider_status_update]" <?php
					echo is_array( $sliders ) && isset( $sliders['slider_status_update'] ) && $sliders['slider_status_update'] == 1 ? 'checked="checked"' : '';
					?> value="1">
                    <i></i>Slider Status Change</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[sliders][delete_slider]" <?php
					echo is_array( $sliders ) && isset( $sliders['delete_slider'] ) && $sliders['delete_slider'] == 1 ? 'checked="checked"' : '';
					?> value="1">
                    <i></i>Delete Slider</label>
            </div>
			<?php
			$cases = isset( $permission['cases'] ) ? $permission['cases'] : array();
			$methods = [
				'cases'              => 'Manage Cases',
				'index'              => 'All Case',
				'create'             => 'Add Case',
				'edit'               => '',
				'case_status_update' => 'Case Status Update',
				'destroy'            => 'Delete Case',
			];
			echo SM::generateRoleHtml( 'Case', 'cases', $methods, $cases );
			?>

			<?php
			$services = isset( $permission['services'] ) ? $permission['services'] : array();
			$methods = [
				'services'              => 'Manage Services',
				'index'                 => 'All Service',
				'create'                => 'Add Service',
				'edit'                  => '',
				'service_status_update' => 'Service Status Update',
				'destroy'               => 'Delete Service',
			];
			echo SM::generateRoleHtml( 'Service', 'services', $methods, $services );
			?>

			<?php
			$packages = isset( $permission['packages'] ) ? $permission['packages'] : array();
			$methods = [
				'packages'              => 'Manage Packages',
				'index'                 => 'All Package',
				'create'                => 'Add Package',
				'edit'                  => '',
				'package_status_update' => 'Package Status Update',
				'destroy'               => 'Delete Package',
			];
			echo SM::generateRoleHtml( 'Package', 'packages', $methods, $packages );
			?>

			<?php
			$coupons = isset( $permission['coupons'] ) ? $permission['coupons'] : array();
			$methods = [
				'coupons'              => 'Manage Coupons',
				'index'                => 'All Coupon',
				'create'               => 'Add Coupon',
				'edit'                 => '',
				'coupon_status_update' => 'Coupon Status Update',
				'destroy'              => 'Delete Coupon',
			];
			echo SM::generateRoleHtml( 'Coupons', 'coupons', $methods, $coupons );
			?>


			<?php
			$page = isset( $permission['page'] ) ? $permission['page'] : array();
			?>
            <div class="col col-3 user_role">
                <label class="label"><b>Page Management</b></label>
                <label class="checkbox">
                    <input type="checkbox" name="permission[page][page]" <?php
					echo is_array( $page ) && isset( $page['page'] ) && $page['page'] == 1 ? 'checked="checked"' : '';
					?>  value="1">
                    <i></i>Page Management</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[page][index]" <?php
					echo is_array( $page ) && isset( $page['index'] ) && $page['index'] == 1 ? 'checked="checked"' : '';
					?>   value="1">
                    <i></i>All Page List</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[page][add_page]" <?php
					echo is_array( $page ) && isset( $page['add_page'] ) && $page['add_page'] == 1 ? 'checked="checked"' : '';
					?>   value="1">
                    <i></i>Add Page</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[page][edit_page]" <?php
					echo is_array( $page ) && isset( $page['edit_page'] ) && $page['edit_page'] == 1 ? 'checked="checked"' : '';
					?>   value="1">
                    <i></i>Edit Page</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[page][page_status_update]" <?php
					echo is_array( $page ) && isset( $page['page_status_update'] ) && $page['page_status_update'] == 1 ? 'checked="checked"' : '';
					?>   value="1">
                    <i></i>Page Status Change</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[page][delete_page]" <?php
					echo is_array( $page ) && isset( $page['delete_page'] ) && $page['delete_page'] == 1 ? 'checked="checked"' : '';
					?>   value="1">
                    <i></i>Delete Page</label>
            </div>

			<?php
			$orders = isset( $permission['orders'] ) ? $permission['orders'] : array();
			$methods = [
				'orders'                => 'Manage Orders',
				'index'                 => 'All Order',
				'show'                  => 'View Order Invoice',
				'download'              => 'Download Order Invoice',
				'order_status_update'   => 'Order Status Update',
				'payment_status_update' => 'Payment Status Update',
				'destroy'               => 'Delete Order',
			];
			echo SM::generateRoleHtml( 'Orders', 'orders', $methods, $orders );
			?>
			<?php
			$media = isset( $permission['media'] ) ? $permission['media'] : array();
			?>
            <div class="col col-3 user_role">
                <label class="label"><b>Media Management</b></label>
                <label class="checkbox">
                    <input type="checkbox" name="permission[media][upload]" <?php
					echo is_array( $media ) && isset( $media['upload'] ) && $media['upload'] == 1 ? 'checked="checked"' : '';
					?> value="1">
                    <i></i>Upload File</label>
                <span class="role_helper_text">Upload any kind of file from media library. Without selecting this user can upload image from upload section.</span>

                <label class="checkbox">
                    <input type="checkbox" name="permission[media][view]" <?php
					echo is_array( $media ) && isset( $media['view'] ) && $media['view'] == 1 ? 'checked="checked"' : '';
					?> value="1">
                    <i></i>View All User Files</label>
                <span class="role_helper_text">User can view personal image Without selecting this.</span>
            </div>
            <div class="clearfix"></div>
			<?php
			$appearance = isset( $permission['appearance'] ) ? $permission['appearance'] : array();
			?>
            <div class="col col-3 user_role">
                <label class="label"><b>Appearance Management</b></label>
                <label class="checkbox">
                    <input type="checkbox" name="permission[appearance][appearance]" <?php
					echo is_array( $appearance ) && isset( $appearance['appearance'] ) && $appearance['appearance'] == 1 ? 'checked="checked"' : '';
					?> value="1">
                    <i></i>Appearance Management</label>
                <label class="checkbox">
                    <input type="checkbox" name="permission[appearance][smthemeoptions]" <?php
		            echo is_array( $appearance ) && isset( $appearance['smthemeoptions'] ) && $appearance['smthemeoptions'] == 1 ? 'checked="checked"' : '';
		            ?> value="1">
                    <i></i>Theme Options</label>
                <label class="checkbox">
                    <input type="checkbox" name="permission[appearance][menus]" <?php
					echo is_array( $appearance ) && isset( $appearance['menus'] ) && $appearance['menus'] == 1 ? 'checked="checked"' : '';
					?> value="1">
                    <i></i>Menus</label>
                <label class="checkbox">
                    <input type="checkbox" name="permission[appearance][editor]" <?php
		            echo is_array( $appearance ) && isset( $appearance['editor'] ) && $appearance['editor'] == 1 ? 'checked="checked"' : '';
		            ?> value="1">
                    <i></i>View Editor File</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[appearance][updatefile]" <?php
		            echo is_array( $appearance ) && isset( $appearance['updatefile'] ) && $appearance['updatefile'] == 1 ? 'checked="checked"' : '';
		            ?> value="1">
                    <i></i>Update Editor File</label>
            </div>

			<?php
			$subscribers = isset( $permission['subscribers'] ) ? $permission['subscribers'] : array();
			$methods = [
				'subscribers'              => 'Manage Subscribers',
				'index'                    => 'All Subscribers',
				'edit'                     => '',
				'subscriber_status_update' => 'Subscriber Status Update',
				'destroy'                  => 'Delete Subscriber',
			];
			echo SM::generateRoleHtml( 'Subscribers', 'subscribers', $methods, $subscribers );
			?>
			<?php
			$customers = isset( $permission['customers'] ) ? $permission['customers'] : array();
			?>
            <div class="col col-3 user_role">
                <label class="label"><b>Customer Management</b></label>
                <label class="checkbox">
                    <input type="checkbox" name="permission[customers][customers]" <?php
					echo is_array( $customers ) && isset( $customers['customers'] ) && $customers['customers'] == 1 ? 'checked="checked"' : '';
					?>  value="1">
                    <i></i>Customer Management</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[customers][index]" <?php
					echo is_array( $customers ) && isset( $customers['index'] ) && $customers['index'] == 1 ? 'checked="checked"' : '';
					?>  value="1">
                    <i></i>All Customer List</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[customers][add_customer]" <?php
					echo is_array( $customers ) && isset( $customers['add_customer'] ) && $customers['add_customer'] == 1 ? 'checked="checked"' : '';
					?>  value="1">
                    <i></i>Add Customer</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[customers][edit_customer]" <?php
					echo is_array( $customers ) && isset( $customers['edit_customer'] ) && $customers['edit_customer'] == 1 ? 'checked="checked"' : '';
					?>  value="1">
                    <i></i>Edit Customer</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[customers][customer_status_update]" <?php
					echo is_array( $customers ) && isset( $customers['customer_status_update'] ) && $customers['customer_status_update'] == 1 ? 'checked="checked"' : '';
					?>  value="1">
                    <i></i>Customer Status Change</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[customers][delete_customer]" <?php
					echo is_array( $customers ) && isset( $customers['delete_customer'] ) && $customers['delete_customer'] == 1 ? 'checked="checked"' : '';
					?>  value="1">
                    <i></i>Delete Customer</label>
            </div>
			<?php
			$user = isset( $permission['users'] ) ? $permission['users'] : array();
			?>
            <div class="col col-3 user_role">
                <label class="label"><b>User Management</b></label>
                <label class="checkbox">
                    <input type="checkbox" name="permission[users][users]" <?php
					echo is_array( $user ) && isset( $user['users'] ) && $user['users'] == 1 ? 'checked="checked"' : '';
					?>  value="1">
                    <i></i>User Management</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[users][index]" <?php
					echo is_array( $user ) && isset( $user['index'] ) && $user['index'] == 1 ? 'checked="checked"' : '';
					?>  value="1">
                    <i></i>All User List</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[users][add_user]" <?php
					echo is_array( $user ) && isset( $user['add_user'] ) && $user['add_user'] == 1 ? 'checked="checked"' : '';
					?>  value="1">
                    <i></i>Add User</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[users][edit_user]" <?php
					echo is_array( $user ) && isset( $user['edit_user'] ) && $user['edit_user'] == 1 ? 'checked="checked"' : '';
					?>  value="1">
                    <i></i>Edit User</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[users][user_status_update]" <?php
					echo is_array( $user ) && isset( $user['user_status_update'] ) && $user['user_status_update'] == 1 ? 'checked="checked"' : '';
					?>  value="1">
                    <i></i>User Status Change</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[users][delete_user]" <?php
					echo is_array( $user ) && isset( $user['delete_user'] ) && $user['delete_user'] == 1 ? 'checked="checked"' : '';
					?>  value="1">
                    <i></i>Delete User</label>
            </div>
            <div class="col col-3 user_role">
                <label class="label"><b>User Role Management</b></label>
                <label class="checkbox">
                    <input type="checkbox" name="permission[users][users]" <?php
					echo is_array( $user ) && isset( $user['users'] ) && $user['users'] == 1 ? 'checked="checked"' : '';
					?>   value="1">
                    <i></i>User Role Management</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[users][roles]" <?php
					echo is_array( $user ) && isset( $user['roles'] ) && $user['roles'] == 1 ? 'checked="checked"' : '';
					?>   value="1">
                    <i></i>All roles List</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[users][add_role]" <?php
					echo is_array( $user ) && isset( $user['add_role'] ) && $user['add_role'] == 1 ? 'checked="checked"' : '';
					?>   value="1">
                    <i></i>Add Role</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[users][edit_role]" <?php
					echo is_array( $user ) && isset( $user['edit_role'] ) && $user['edit_role'] == 1 ? 'checked="checked"' : '';
					?>   value="1">
                    <i></i>Edit Role</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[users][delete_role]" <?php
					echo is_array( $user ) && isset( $user['delete_role'] ) && $user['delete_role'] == 1 ? 'checked="checked"' : '';
					?>   value="1">
                    <i></i>Delete Role</label>
            </div>
			<?php
			$paymentmethods = isset( $permission['paymentmethods'] ) ? $permission['paymentmethods'] : array();
			?>
            <div class="col col-3 user_role">
                <label class="label"><b>Payment Method Management</b></label>
                <label class="checkbox">
                    <input type="checkbox" name="permission[paymentmethods][payment_methods]" <?php
					echo is_array( $paymentmethods ) && isset( $paymentmethods['payment_methods'] ) && $paymentmethods['payment_methods'] == 1 ? 'checked="checked"' : '';
					?>    value="1">
                    <i></i> Manage Payment Methods</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[paymentmethods][index]" <?php
					echo is_array( $paymentmethods ) && isset( $paymentmethods['index'] ) && $paymentmethods['index'] == 1 ? 'checked="checked"' : '';
					?>    value="1">
                    <i></i>Payment Method List</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[paymentmethods][create]" <?php
					echo is_array( $paymentmethods ) && isset( $paymentmethods['create'] ) && $paymentmethods['create'] == 1 ? 'checked="checked"' : '';
					?>    value="1">
                    <i></i>Add Payment Method</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[paymentmethods][edit]" <?php
					echo is_array( $paymentmethods ) && isset( $paymentmethods['edit'] ) && $paymentmethods['edit'] == 1 ? 'checked="checked"' : '';
					?>    value="1">
                    <i></i> Edit Payment Method</label>


                <label class="checkbox">
                    <input type="checkbox" name="permission[paymentmethods][payment_method_status_update]" <?php
					echo is_array( $paymentmethods ) && isset( $paymentmethods['payment_method_status_update'] ) && $paymentmethods['payment_method_status_update'] == 1 ? 'checked="checked"' : '';
					?>    value="1">
                    <i></i>Payment Method Status Update</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[paymentmethods][destroy]" <?php
					echo is_array( $paymentmethods ) && isset( $paymentmethods['destroy'] ) && $paymentmethods['destroy'] == 1 ? 'checked="checked"' : '';
					?>    value="1">
                    <i></i>Delete Payment Method</label>
            </div>
			<?php
			$taxes = isset( $permission['taxes'] ) ? $permission['taxes'] : array();
			$methods = [
				'taxes'             => 'Manage Taxes',
				'index'             => 'All Tax',
				'create'            => 'Add Tax',
				'edit'              => '',
				'tax_status_update' => 'Tax Status Update',
				'destroy'           => 'Delete Tax',
			];
			echo SM::generateRoleHtml( 'Taxes', 'taxes', $methods, $taxes );
			?>

			<?php
			$setting = isset( $permission['setting'] ) ? $permission['setting'] : array();
			?>
            <div class="col col-3 user_role">
                <label class="label"><b>Setting Management</b></label>
                <label class="checkbox">
                    <input type="checkbox" name="permission[setting][setting]" <?php
					echo is_array( $setting ) && isset( $setting['setting'] ) && $setting['setting'] == 1 ? 'checked="checked"' : '';
					?> value="1">
                    <i></i>Setting Management</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[setting][index]" <?php
					echo is_array( $setting ) && isset( $setting['index'] ) && $setting['index'] == 1 ? 'checked="checked"' : '';
					?>    value="1">
                    <i></i>Company General settings</label>

                <label class="checkbox">
                    <input type="checkbox" name="permission[setting][social]" <?php
					echo is_array( $setting ) && isset( $setting['social'] ) && $setting['social'] == 1 ? 'checked="checked"' : '';
					?>    value="1">
                    <i></i>Social settings</label>
            </div>
			<?php
			$reports = isset( $permission['reports'] ) ? $permission['reports'] : array();
			$methods = [
				'reports' => 'Manage Reports',
				'orders'  => 'Order Report'
			];
			echo SM::generateRoleHtml( 'Report', 'orders', $methods, $reports );
			?>
        </div>
    </section>
</fieldset>


<footer class="text-center">
    <button class="btn btn-primary" type="submit" id="add_user_btn">
        <i class="fa fa-save"></i>
        {{$btn_text}} Role
    </button>
</footer>