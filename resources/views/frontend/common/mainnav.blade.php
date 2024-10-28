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
                                            @foreach ($categoriesWithSubcategories as $mainCategory)
                                                <li>
                                                    <a href="/category/{{ $mainCategory->slug }}" class="category_menu_text">
                                                        <img src="{{ SM::sm_get_the_src($mainCategory->fav_icon) }}" alt="">
                                                        <span>{{ $mainCategory->title }}</span>
                                                    </a>

                                                    {{-- Check if the main category has subcategories --}}
                                                    @if (!$mainCategory->subcategories->isEmpty())
                                                    <div class="sub-menu mega-menu mega-menu-column-4">
                                                        @include('frontend.common.partial_nav', [
                                                            'subcategories' => $mainCategory->subcategories,
                                                        ])
                                                    </div>
                                                    @endif
                                                </li>
                                            @endforeach
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
                            <a href="{{ url('/compare') }}" type="button" class="btn compare-button">
                                <i class="fa fa-compress" aria-hidden="true"></i> Compare
                             </a>
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
