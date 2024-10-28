<style type="text/css">
    .main-collaspe {
        position: absolute;
        z-index: 9;
        left: 15px;
        right: -2px;
    }
</style>

<div class="menu-bar" id="menu-bar">
    <div class="bg-opacity">
        <div class="container">
            <div class="col-md-12 col-sm-12 header-top-right">
                <div id="main-menu" class="main-menu">
                    <nav class="navbar navbar-default">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <i class="fa fa-bars"></i>
                            </button>
                            <a class="navbar-brand" href="#">MENU</a>
                        </div>
                        <div id="navbar" class="navbar-collapse collapse">
                            <div class="search-panel" style="width: 230px;">
                                <ul>
                                    <li>
                                        <a type="button" class="btn dropdown-toggle" data-toggle="dropdown"
                                            style="padding: 14px 20px; width: 100%;">
                                            <span id="search_concept"><i class="fa fa-th-list" aria-hidden="true"></i> All Categories <span class="caret"></span></span> 
                                        </a>
                                        <ul class="catgories-menu" role="menu">
                                            <li><a href="#contains" class="category_menu_text"><img
                                                        src="https://littleangelsbd.com/pub/media/wysiwyg/icon-categories/tshirt.png"
                                                        alt=""><span>Baby & Kids Fashion</span></a></li>
                                            <li><a href="#its_equal" class="category_menu_text"><img
                                                        src="	https://littleangelsbd.com/pub/media/wysiwyg/icon-categories/running.png"
                                                        alt=""><span>Footwear</span></a></li>
                                            <li><a href="#contains" class="category_menu_text"><img
                                                        src="https://littleangelsbd.com/pub/media/wysiwyg/icon-categories/tshirt.png"
                                                        alt=""><span>Baby & Kids Fashion</span></a></li>
                                            <li class="menu"><a href="#its_equal" class="category_menu_text"><img
                                                        src="	https://littleangelsbd.com/pub/media/wysiwyg/icon-categories/running.png"
                                                        alt=""><span>Footwear</span></a>
                                                <div class="sub-menu mega-menu mega-menu-column-4">
                                                    <div class="list-item">
                                                        <h4 class="title">Men's Fashion</h4>
                                                        <ul>
                                                            <li><a href="#">T-Shirts</a></li>
                                                            <li><a href="#">Jeans</a></li>
                                                            <li><a href="#">Suit</a></li>
                                                            <li><a href="#">Kurta</a></li>
                                                            <li><a href="#">Watch</a></li>
                                                        </ul>
                                                        <h4 class="title">Beauty</h4>
                                                        <ul>
                                                            <li><a href="#">Moisturizer</a></li>
                                                            <li><a href="#">Face powder</a></li>
                                                            <li><a href="#">Lipstick</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="list-item">
                                                        <h4 class="title">Women's Fashion</h4>
                                                        <ul>
                                                            <li><a href="#">Sarees</a></li>
                                                            <li><a href="#">Sandals</a></li>
                                                            <li><a href="#">Watchs</a></li>
                                                            <li><a href="#">Shoes</a></li>
                                                        </ul>
                                                        <h4 class="title">Furniture</h4>
                                                        <ul>
                                                            <li><a href="#">Chairs</a></li>
                                                            <li><a href="#">Tables</a></li>
                                                            <li><a href="#">Doors</a></li>
                                                            <li><a href="#">Bed</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="list-item">
                                                        <h4 class="title">Home, Kitchen</h4>
                                                        <ul>
                                                            <li><a href="#">Kettle</a></li>
                                                            <li><a href="#">Toaster</a></li>
                                                            <li><a href="#">Dishwasher</a></li>
                                                            <li><a href="#">Microwave oven</a></li>
                                                            <li><a href="#">Pitcher</a></li>
                                                            <li><a href="#">Blender</a></li>
                                                            <li><a href="#">Colander</a></li>
                                                            <li><a href="#">Tureen</a></li>
                                                            <li><a href="#">Cookware</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                            <li><a href="#contains" class="category_menu_text"><img
                                                        src="https://littleangelsbd.com/pub/media/wysiwyg/icon-categories/tshirt.png"
                                                        alt=""><span>Baby & Kids Fashion</span></a></li>
                                            <li><a href="#its_equal" class="category_menu_text"><img
                                                        src="	https://littleangelsbd.com/pub/media/wysiwyg/icon-categories/running.png"
                                                        alt=""><span>Footwear</span></a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <?php
                            $menu = [
                                'nav_wrapper' => 'ul',
                                'start_class' => 'nav navbar-nav nav-justify',
                                'link_wrapper' => 'li',
                                'dropdown_class' => '',
                                'subNavUlClass' => 'dropdown-menu mega_dropdown',
                                'has_dropdown_wrapper_class' => 'dropdown',
                                'show' => true,
                            ];
                            SM::sm_get_menu($menu);
                            ?>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener("scroll", function() {
        const menuBar = document.getElementById("menu-bar");
        const scrollPosition = window.scrollY;

        // Adjust the scroll value as needed
        if (scrollPosition > 100) {
            menuBar.classList.add("fixed");
        } else {
            menuBar.classList.remove("fixed");
        }
    });
</script>
<div class="clearfix"></div>
