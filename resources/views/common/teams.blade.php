<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 10/12/17
 * Time: 11:21 AM
 */
$teamTitle    = SM::smGetThemeOption( "team_title" );
$teamSubtitle = SM::smGetThemeOption( "team_subtitle" );
$teams        = SM::smGetThemeOption( "teams" );
$teamCount    = count( $teams );
$class        = isset( $class ) ? $class : '';
$is_home      = isset( $is_home ) ? $is_home : 0;
?>
@if($teamCount>0)
    <section class="common-section team-section {{ $class }}">
        <div class="container">
            @empty(!$teamTitle || !$teamSubtitle)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title-4 text-center">
                            @empty(!$teamTitle)
                                <h3>{{ $teamTitle }}</h3>
                            @endif
                            @empty(!$teamSubtitle)
                                <p>{{ $teamSubtitle }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                @if($is_home==1)
                    <div class="swiper-container team-slider">
                        <div class="swiper-wrapper">
                            @foreach($teams as $team)
                                <div class="swiper-slide" data-swiper-autoplay="2500">
                                    <div class="col-lg-12">
                                        <div class="single-team">
                                            <div class="team-img">
                                                <img src="{!! SM::sm_get_the_src($team["team_image"], 263, 365) !!}"
                                                     alt="{{ $team["title"] }}">
                                            </div>
                                            <div class="team-hover-item">
                                                <h3 class="team-member-name">{{ $team["title"] }}</h3>
                                                @empty(!$team["designation"])
                                                    <p class="team-member-deg">{{ $team["designation"] }}</p>
                                                @endif
                                            </div>
                                            <div class="team-hover-item team-hover-items text-right">
                                                <h3 class="team-member-names">{{ $team["title"] }}</h3>
                                                @empty(!$team["designation"])
                                                    <p class="team-member-degs">{{ $team["designation"] }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    @foreach($teams as $team)
                        <div class="col-lg-3 col-sm-6">
                            <div class="single-team">
                                <div class="team-img">
                                    <img src="{!! SM::sm_get_the_src($team["team_image"], 263, 365) !!}"
                                         alt="{{ $team["title"] }}">
                                </div>
                                <div class="team-hover-item">
                                    <h3 class="team-member-name">{{ $team["title"] }}</h3>
                                    @empty(!$team["designation"])
                                        <p class="team-member-deg">{{ $team["designation"] }}</p>
                                    @endif
                                </div>
                                <div class="team-hover-item team-hover-items text-right">
                                    <h3 class="team-member-names">{{ $team["title"] }}</h3>
                                    @empty(!$team["designation"])
                                        <p class="team-member-degs">{{ $team["designation"] }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if($loop->iteration %2 ==0)
                            <div class="clearfix hidden-lg"></div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </section>
@endif
