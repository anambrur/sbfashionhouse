<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 11/11/17
 * Time: 3:30 PM
 */
?>
<div class="row border-bottom padd-marg-bottom30">
    @empty(!$image)
        <div class="col-md-4 col-sm-6">
            <a href="{!! $url !!}">
                <div class="single-search-result-thimb">
                    <img src="{!!$image !!}" alt="{{ $info->title }}">
                </div>
            </a>
        </div>
    @endempty
    <div class="{!! (empty(!$image) ? "col-md-8 col-sm-6" : "col-md-12") !!} ">
        <div class="single-search-result-content">
            <a href="{!! $url !!}"><h2 class="search-result-title">{{ $info->title }}</h2></a>
            <ul class="search-blog-date-info">
                <li>
                    <a href="#"> {{ date('F d, Y', strtotime($info->created_at)) }}</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-eye"></i> {{ $info->views }}</a>
                </li>
            </ul>
            <p>
				<?php
				$str = strip_tags( stripslashes( $description ) );
				?>
                {!! substr($str, 0, 250) . (strlen($str)>250 ? "...": "") !!}
            </p>
            <a class="doddle-btn fill" href="{!! $url !!}"><span></span><b></b>READ MORE</a>
        </div>
    </div>
</div>
