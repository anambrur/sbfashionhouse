<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 1/6/18
 * Time: 10:06 AM
 */
?>
@if(count($services)>0)
	<?php $sl = 1; ?>
    @foreach($services as $service)
        @if($loop->index==0)
            <div class="single-service single-service-big" style="background: {{$service->background}}">
                <div class="col-lg-12">
                    <h2 class="service-title">
                        <a href="{!! url("/services/".$service->slug) !!}">{!! $service->title !!}
                        </a>
                    </h2>
                </div>
                <div class="clearfix"></div>
                <a href="{!! url("/services/".$service->slug) !!}">
                    <div class="col-lg-4">
                        <div class="service-img">
                            <img src="{!! SM::sm_get_the_src(  $service->image ) !!}"
                                 alt="{{ $service_seo_title }}">
                        </div>
                    </div>
                </a>
                <div class="col-lg-8">
                    <div class="ab_single-service_cont">
                        {!! stripslashes($service->short_description) !!}
                        <a href="{!! url("/services/".$service->slug) !!}" class="service-read-more">
                            <img src="{{ asset('images/arrow-right.png') }}" alt=""> Read More
                        </a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        @else
            <div class="col-lg-4 col-sm-6">
                <div class="single-service" style="background: {{$service->background}}">
                    @empty(!$service->image)
                        <a href="{!! url("/services/".$service->slug) !!}">
                            <div class="service-img">
                                <img src="{!! SM::sm_get_the_src( $service->image , 358, 263) !!}"
                                     alt="{{$service->title}}">
                            </div>
                        </a>
                    @endempty
                    <h2 class="service-title">
                        <a href="{!! url("/services/".$service->slug) !!}">
                            {!! $service->title !!}
                        </a>
                    </h2>
                    {!! stripslashes($service->short_description) !!}
                    <a href="{!! url("/services/".$service->slug) !!}" class="service-read-more"><img
                                src="images/arrow-right.png" alt="read more"> Read More</a>
                </div>
            </div>
            @if($sl % 2 ==0)
                <div class="clearfix hidden-lg"></div>
            @endif
            @if($sl % 3 ==0)
                <div class="clearfix hidden-sm"></div>
            @endif
			<?php $sl ++; ?>
        @endif
    @endforeach
    <div class="col-lg-12">
        {!! $services->links('common.pagination') !!}
    </div>
@else
    <div class="alert alert-info"><i class="fa fa-info"></i> No Service Post Found!</div>
@endif
