<style>
    /*----------------home page category by color-----*/
    .option5 .category-featured.{{ $title }} .navbar-brand {
        background: {{ $color }};
    }

    .option5 .category-featured.{{ $title }} .nav-menu .nav > li:hover a,
    .option5 .category-featured.{{ $title }} .nav-menu .nav > li.active a {
        color: {{ $color }};
    }

    .option5 .category-featured.{{ $title }} .nav-menu .navbar-collapse {
        background: #fff;
        border-bottom: 2px solid{{ $color }};
    }

    .option5 .category-featured.{{ $title }} .nav-menu .nav > li > a:before {
        background: {{ $color }};
    }

    .option5 .category-featured.{{ $title }} .nav-menu .nav > li:hover a,
    .option5 .category-featured.{{ $title }} .nav-menu .nav > li.active a {
        color: {{ $color }};
    }

    .option5 .category-featured.{{ $title }} .nav-menu .nav > li:hover a:after,
    .option5 .category-featured.{{ $title }} .nav-menu .nav > li.active a:after {
        color: {{ $color }};
    }

    .option5 .category-featured.{{ $title }} .product-list li .add-to-cart {
        /*background-color: rgba(102, 153, 0, 0.7);*/
        background: {{ $color }};
        /*color: rgba(102, 153, 0, 0.7);*/
    }

    .option5 .category-featured.{{ $title }} .product-list li .add-to-cart:hover {
        background-color: {{ $color }};
    }
</style>
