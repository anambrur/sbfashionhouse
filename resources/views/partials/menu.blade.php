<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 8/10/17
 * Time: 1:02 PM
 */
?>
<!--HEADER START-->
<header class="main-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-2">
                <div class="logo">
                    <a href="{{url("/")}}"><img
                                src="<?php echo SM::sm_get_the_src(SM::sm_get_site_logo(), 193, 78); ?>"
                                alt="<?php echo SM::get_setting_value('site_name'); ?>"> </a>
                </div>
            </div>
            <div class="col-lg-10 col-md-10">
                <nav class="main-menu text-right">
                    <div class="mobile-menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <?php
                    $menu = array(
                        'nav_wrapper' => 'ul',
                        'start_class' => 'menu',
                        'link_wrapper' => 'li',
                        'dropdown_class' => 'sub-menu',
                        'has_dropdown_wrapper_class' => 'has-menu-items',
                        'show' => TRUE
                    );
                    SM::sm_get_menu($menu);
                    ?>
                </nav>
            </div>
        </div>
    </div>
</header>
<!--HEADER END-->