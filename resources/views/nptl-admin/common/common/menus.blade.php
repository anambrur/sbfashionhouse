<!-- NAVIGATION : This navigation is also responsive

  To make this navigation dynamic please make sure to link the node
  (the reference to the nav > ul) after page load. Or the navigation
  will not initialize.
-->
<nav id="admin_main_nav">
    <!-- NOTE: Notice the gaps after each icon usage <i></i>..
    Please note that these links work a bit different than
    traditional href="" links. See documentation for details.
    -->

    <ul>
        <li ctrl="dashboard">
            <a href="{{url(url(SM::smAdminSlug()))}}" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i>
                <span class="menu-item-parent">Dashboard</span>
            </a>
        </li>
        <li ctrl="media">
            <a href="{{url(url(SM::smAdminSlug('media')))}}" title="Media"><i class="fa fa-lg fa-fw fa-picture-o"></i>
                <span class="menu-item-parent">Media Gallery</span>
            </a>
        </li>
        <?php if (SM::check_this_contoller_access('sliders')): ?>
            <li ctrl="sliders">
                <a href="#"><i class="fa fa-lg fa-fw fa-sliders"></i> <span class="menu-item-parent">
                        Sliders
                    </span></a>
                <ul>
                    <?php if (SM::check_this_method_access('sliders', 'add_slider')): ?>
                        <li mtd="add_slider">
                            <a href="{{url(SM::smAdminSlug('sliders/add_slider'))}}">
                                {{__("menu.addSlider")}}
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (SM::check_this_method_access('sliders', 'sliders')): ?>
                        <li mtd="sliders">
                            <a href="{{url(SM::smAdminSlug('sliders'))}}">
                                {{__("menu.sliders")}}
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php
        endif;
        ?>
        <?php if (SM::check_this_contoller_access('categories')): ?>
            <li ctrl="categories">
                <a href="#"><i class="fa fa-lg fa-fw fa-list"></i> <span
                        class="menu-item-parent">Category Management</span></a>
                <ul>
                    <?php if (SM::check_this_method_access('categories', 'create')): ?>
                        <li mtd="create">
                            <a href="{{url(SM::smAdminSlug('categories/create'))}}">Add category</a>
                        </li>
                    <?php endif; ?>

                    <?php if (SM::check_this_method_access('categories', 'index')): ?>
                        <li mtd="index">
                            <a href="{{url(SM::smAdminSlug('categories'))}}">All Categories</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (SM::check_this_contoller_access('tags')): ?>
            <li ctrl="tags">
                <a href="#"><i class="fa fa-lg fa-fw fa-tags"></i> <span
                        class="menu-item-parent">Tag Management</span></a>
                <ul>
                    <?php if (SM::check_this_method_access('tags', 'create')): ?>
                        <li mtd="create">
                            <a href="{{url(SM::smAdminSlug('tags/create'))}}">Add Tag</a>
                        </li>
                    <?php endif; ?>

                    <?php if (SM::check_this_method_access('tags', 'index')): ?>
                        <li mtd="index">
                            <a href="{{url(SM::smAdminSlug('tags'))}}">All Tag</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (SM::check_this_contoller_access('brands')): ?>
            <li ctrl="brands">
                <a href="#"><i class="fa fa-lg fa-fw fa-tags"></i> <span
                        class="menu-item-parent">Brand Management</span></a>
                <ul>
                    <?php if (SM::check_this_method_access('brands', 'create')): ?>
                        <li mtd="create">
                            <a href="{{url(SM::smAdminSlug('brands/create'))}}">Add Brand</a>
                        </li>
                    <?php endif; ?>

                    <?php if (SM::check_this_method_access('brands', 'index')): ?>
                        <li mtd="index">
                            <a href="{{url(SM::smAdminSlug('brands'))}}">All Brand</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (SM::check_this_contoller_access('attributetitles')): ?>
            <li ctrl="attributetitles">
                <a href="#"><i class="fa fa-lg fa-fw fa-tags"></i> <span
                        class="menu-item-parent">Attribute Management</span></a>
                <ul>
                    <?php if (SM::check_this_method_access('attributetitles', 'create')): ?>
                        <li mtd="create">
                            <a href="{{url(SM::smAdminSlug('attributetitles/create'))}}">Add Attribute Title</a>
                        </li>
                    <?php endif; ?>
                    <?php if (SM::check_this_method_access('attributetitles', 'index')): ?>
                        <li mtd="index">
                            <a href="{{url(SM::smAdminSlug('attributetitles'))}}">All Attribute Title</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (SM::check_this_contoller_access('units')): ?>
            <li ctrl="units">
                <a href="#"><i class="fa fa-lg fa-fw fa-tags"></i> <span
                        class="menu-item-parent">Unit Management</span></a>
                <ul>
                    <?php if (SM::check_this_method_access('units', 'create')): ?>
                        <li mtd="create">
                            <a href="{{url(SM::smAdminSlug('units/create'))}}">Add Unit</a>
                        </li>
                    <?php endif; ?>
                    <?php if (SM::check_this_method_access('units', 'index')): ?>
                        <li mtd="index">
                            <a href="{{url(SM::smAdminSlug('units'))}}">All Unit</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>

        <?php if (SM::check_this_contoller_access('products')): ?>
            <li ctrl="products">
                <a href="#"><i class="fa fa-lg fa-fw fa-list-alt"></i> <span
                        class="menu-item-parent">Product Management</span></a>
                <ul>
                    <?php if (SM::check_this_method_access('products', 'create')): ?>
                        <li mtd="create">
                            <a href="{{url(SM::smAdminSlug('products/create'))}}">Add Product</a>
                        </li>
                    <?php endif; ?>
                    <?php if (SM::check_this_method_access('products', 'index')): ?>
                        <li mtd="index">
                            <a href="{{url(SM::smAdminSlug('products'))}}">All Product</a>
                        </li>
                    <?php endif; ?>
                         <?php if (SM::check_this_method_access('products', 'importproducts')): ?>
                        <li mtd="reviews">
                            <a href="{{url(SM::smAdminSlug('products/importproducts'))}}">Import Products</a>
                        </li>
                    <?php endif; ?>
                    <?php if (SM::check_this_method_access('products', 'reviews')): ?>
                        <li mtd="reviews">
                            <a href="{{url(SM::smAdminSlug('products/reviews'))}}">All Reviews</a>
                        </li>
                    <?php endif; ?>
                   
                </ul>
            </li>
        <?php endif; ?>

        <?php if (SM::check_this_contoller_access('coupons')): ?>
            <li ctrl="coupons">
                <a href="#"><i class="fa fa-lg fa-fw fa-thumbs-up"></i> <span
                        class="menu-item-parent">Coupon Management</span></a>
                <ul>
                    <?php if (SM::check_this_method_access('coupons', 'create')): ?>
                        <li mtd="create">
                            <a href="{{url(SM::smAdminSlug('coupons/create'))}}">Add Coupon</a>
                        </li>
                    <?php endif; ?>
                    <?php if (SM::check_this_method_access('coupons', 'index')): ?>
                        <li mtd="index">
                            <a href="{{url(SM::smAdminSlug('coupons'))}}">All Coupon</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>

        <?php if (SM::check_this_contoller_access('orders')): ?>
            <li ctrl="orders">
                <a href="{{url(url(SM::smAdminSlug('orders')))}}" title="Order Management"><i
                        class="fa fa-lg fa-fw fa-shopping-cart"></i>
                    <span class="menu-item-parent">Manage Orders <i
                            class="badge badge-primary">{{ SM::sm_get_count( 'orders', "order_status", 3 ) }}</i></span>
                </a>
            </li>
        <?php endif; ?>

        <?php if (SM::check_this_contoller_access('page')): ?>
            <li ctrl="page">
                <a href="#"><i class="fa fa-lg fa-fw fa-pagelines"></i> <span
                        class="menu-item-parent">Page Management</span></a>
                <ul>
                    <?php if (SM::check_this_method_access('page', 'add_page')): ?>
                        <li mtd="add_page">
                            <a href="{{url(SM::smAdminSlug('pages/add_page'))}}">Add Page</a>
                        </li>
                    <?php endif; ?>

                    <?php if (SM::check_this_method_access('page', 'index')): ?>
                        <li mtd="index">
                            <a href="{{url(SM::smAdminSlug('pages'))}}">All Page</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>

        <?php if (SM::check_this_contoller_access('blogs')): ?>
            <li ctrl="blogs">
                <a href="#"><i class="fa fa-lg fa-fw fa-list-alt"></i> <span
                        class="menu-item-parent">Blog Management</span></a>
                <ul>
                    <?php if (SM::check_this_method_access('blogs', 'create')): ?>
                        <li mtd="create">
                            <a href="{{url(SM::smAdminSlug('blogs/create'))}}">Add Blog</a>
                        </li>
                    <?php endif; ?>
                    <?php if (SM::check_this_method_access('blogs', 'index')): ?>
                        <li mtd="index">
                            <a href="{{url(SM::smAdminSlug('blogs'))}}">All Blog</a>
                        </li>
                    <?php endif; ?>
                    <?php if (SM::check_this_method_access('blogs', 'comments')): ?>
                        <li mtd="comments">
                            <a href="{{url(SM::smAdminSlug('blogs/comments'))}}">All Comments</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (SM::check_this_contoller_access('appearance')): ?>
            <li ctrl="appearance">
                <a href="#"><i class="fa fa-lg fa-fw fa-eye"></i> <span class="menu-item-parent">
                        {{__("menu.appearance")}}
                    </span></a>
                <ul>
                    <?php if (SM::check_this_method_access('appearance', 'smthemeoptions')): ?>
                        <li mtd="smthemeoptions">
                            <a href="{{url(SM::smAdminSlug('appearance/smthemeoptions'))}}">
                                {{__("menu.themeOption")}}
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (SM::check_this_method_access('appearance', 'menus')): ?>
                        <li mtd="menus">
                            <a href="{{url(SM::smAdminSlug('appearance/menus'))}}">
                                {{__("menu.menus")}}
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (SM::check_this_method_access('appearance', 'editor')): ?>
                        <li mtd="editor">
                            <a href="{{url(SM::smAdminSlug('appearance/editor'))}}">
                                <span class="menu-item-parent">Editor</span></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php
        endif;
        ?>


        <?php if (SM::check_this_contoller_access('users')): ?>
            <li ctrl="users">
                <a href="#"><i class="fa fa-lg fa-fw fa-user"></i> <span class="menu-item-parent">
                        Users
                    </span></a>
                <ul>
                    <?php if (SM::check_this_method_access('users', 'add_user')): ?>
                        <li mtd="add_user">
                            <a href="{{url(SM::smAdminSlug('users/add_user'))}}">
                                {{__("menu.addUser")}}
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (SM::check_this_method_access('users', 'index')): ?>
                        <li mtd="index">
                            <a href="{{url(SM::smAdminSlug('users'))}}">
                                {{__("menu.allUser")}}
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (SM::check_this_method_access('users', 'add_role')): ?>
                        <li mtd="add_role">
                            <a href="{{url(SM::smAdminSlug('users/add_role'))}}">
                                Add Role
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (SM::check_this_method_access('users', 'roles')): ?>
                        <li mtd="roles">
                            <a href="{{url(SM::smAdminSlug('users/roles'))}}">
                                User Roles
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (SM::check_this_contoller_access('customers')): ?>
            <li ctrl="customers">
                <a href="#"><i class="fa fa-lg fa-fw fa-users"></i> <span class="menu-item-parent">
                        Customers
                    </span></a>
                <ul>
                    <?php if (SM::check_this_method_access('customers', 'add_customer')): ?>
                        <li mtd="add_customer">
                            <a href="{{url(SM::smAdminSlug('customers/add_customer'))}}">
                                Add Customer
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (SM::check_this_method_access('customers', 'index')): ?>
                        <li mtd="index">
                            <a href="{{url(SM::smAdminSlug('customers'))}}">
                                Customer List
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (SM::check_this_contoller_access('subscribers')): ?>
            <li ctrl="subscribers">
                <a href="{{url(url(SM::smAdminSlug('subscribers')))}}" title="Media"><i class="fa fa-lg fa-fw fa-star"></i>
                    <span class="menu-item-parent">Subscribers</span>
                </a>
            </li>
        <?php endif; ?>
        <?php if (SM::check_this_contoller_access('ShippingMethods')): ?>
            <li ctrl="shippingmethods">
                <a href="#"><i class="fa fa-lg fa-fw fa-credit-card"></i> <span class="menu-item-parent">
                        Shipping Methods
                    </span></a>
                <ul>
                    <?php if (SM::check_this_method_access('ShippingMethods', 'create')): ?>
                        <li mtd="create">
                            <a href="{{url(SM::smAdminSlug('shipping_methods/create'))}}">
                                Add Shipping Method
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (SM::check_this_method_access('ShippingMethods', 'index')): ?>
                        <li mtd="index">
                            <a href="{{url(SM::smAdminSlug('shipping_methods'))}}">
                                Shipping Method List
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (SM::check_this_contoller_access('PaymentMethods')): ?>
            <li ctrl="paymentmethods">
                <a href="#"><i class="fa fa-lg fa-fw fa-credit-card"></i> <span class="menu-item-parent">
                        Payment Methods
                    </span></a>
                <ul>
                    <?php if (SM::check_this_method_access('PaymentMethods', 'create')): ?>
                        <li mtd="create">
                            <a href="{{url(SM::smAdminSlug('payment_methods/create'))}}">
                                Add Payment Method
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (SM::check_this_method_access('PaymentMethods', 'index')): ?>
                        <li mtd="index">
                            <a href="{{url(SM::smAdminSlug('payment_methods'))}}">
                                Payment Method List
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (SM::check_this_contoller_access('Taxes')): ?>
            <li ctrl="taxes">
                <a href="#"><i class="fa fa-lg fa-fw fa-money"></i> <span class="menu-item-parent">
                        Taxes
                    </span></a>
                <ul>
                    <?php if (SM::check_this_method_access('Taxes', 'create')): ?>
                        <li mtd="create">
                            <a href="{{url(SM::smAdminSlug('taxes/create'))}}">
                                Add Tax
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (SM::check_this_method_access('Taxes', 'index')): ?>
                        <li mtd="index">
                            <a href="{{url(SM::smAdminSlug('taxes'))}}">
                                Tax List
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (SM::check_this_contoller_access('reports')): ?>
            <li ctrl="reports">
                <a href="#"><i class="fa fa-lg fa-fw fa fa-file-text"></i> <span class="menu-item-parent">
                        Reports
                    </span></a>
                <ul>
                    <?php if (SM::check_this_method_access('reports', 'orders')): ?>
                        <li mtd="orders">
                            <a href="{{url(SM::smAdminSlug('reports/orders'))}}"><i class="fa fa-lg fa-fw fa-shopping-cart"></i>
                                <span class="menu-item-parent">Order Report</span></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <?php if (SM::check_this_contoller_access('setting')): ?>
            <li ctrl="setting">
                <a href="#"><i class="fa fa-lg fa-fw fa-cog"></i> <span class="menu-item-parent">
                        {{__("menu.setting")}}
                    </span></a>
                <ul>
                    <?php if (SM::check_this_method_access('setting', 'index')): ?>
                        <li mtd="index">
                            <a href="{{url(SM::smAdminSlug('setting'))}}"><i class="fa fa-lg fa-fw fa-cogs"></i>
                                <span class="menu-item-parent">{{__("menu.generalSetting")}}</span></a>
                        </li>
                    <?php endif; ?>
                    <?php if (SM::check_this_method_access('setting', 'social')): ?>
                        <li mtd="social">
                            <a href="{{url(SM::smAdminSlug('setting/social'))}}"><i class="fa fa-lg fa-fw fa-share"></i>
                                <span class="menu-item-parent">Social Setting</span></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
    </ul>
</nav>
<span class="minifyme" data-action="minifyMenu">
    <i class="fa fa-arrow-circle-left hit"></i>
</span>