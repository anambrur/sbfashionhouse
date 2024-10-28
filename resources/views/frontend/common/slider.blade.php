@if (isset($sliders) && count($sliders) > 0)
    <?php
        $slider_change_autoplay = (int) SM::smGetThemeOption('slider_change_autoplay', 4);
        $slider_change_autoplay *= 3000;
    ?>
    <div id="home-slider">
        <div class="container">
            <div class="bg-white">
                <div class="row">
                    <div class="col-md-12">
                        <div id="myCarousel" class="carousel slide" data-ride="carousel">
                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                                @forelse($sliders as $key=> $slider)
                                    <li data-target="#myCarousel" data-slide-to="<?php $slider->created_by; ?>" class="active">
                                    </li>
                                @empty
                                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                @endforelse
                            </ol>
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                                @forelse($sliders as $key=> $slider)
                                    <?php
                                    if ($key == 0) {
                                        $active = 'active';
                                    } else {
                                        $active = '';
                                    }
                                    ?>
                                    <div class="item {{ $active }}">
                                        <?php
                                        $property = SM::sm_unserialize($slider->extra);
                                        $button_link = $property['button_link'][0];
                                        ?>
                                        <a href="{{ $button_link }}" target="_blank">
                                            <img src="{{ SM::sm_get_the_src($slider->image) }}"
                                                alt="{!! $slider->title !!}">
                                        </a>
                                    </div>
                                @empty
                                    <div class="item active">
                                        <img src="{{ asset('/frontend/') }}/img/slider/slider-1.png" alt="1">
                                    </div>
                                    <div class="item">
                                        <img src="{{ asset('/frontend/') }}/img/slider/slider-2.png" alt="2">
                                    </div>
                                    <div class="item">
                                        <img src="{{ asset('/frontend/') }}/img/slider/slider-3.png" alt="3">
                                    </div>
                                @endforelse
                            </div>
                            <!-- Left and right controls -->
                            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
<script type="text/javascript">
    < script >
        $(document).ready(function() {
            $('.nav-pills > li > a').hover(function() {
                $(this).tab('show');
            });
        })
</script>
</script>
