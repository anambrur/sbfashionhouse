<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 11/13/17
 * Time: 5:00 PM
 */
?>
@extends('frontend.master')
@section("title", "Downloads")
@section("content")
    <section class="common-section bg-black">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    @include("customer.left-sidebar")
                </div>
                <div class="col-sm-9">
                    <div class="account-panel">
                        <h2>Downloads</h2>
                        <div class="account-panel-inner ab-download-innner">
                            <div class="download-content margin-bottom40">
								<?php
								$firstname = Auth::user()->firstname;
								$lastname = Auth::user()->lastname;
								?>
                                <h4>
                                    Hello {{ $firstname !='' || $lastname !='' ? $firstname." ".$lastname : Auth::user()->username }}</h4>
                                <p>Your all order downloadable files are here. You may download files from here.</p>
                            </div>
                            <div class="clearfix main-acc-download-img">
                                @if(count($medias)> 0)
                                    @foreach($medias as $file)
                                        <div class="acc-download-img">
											<?php
											$filename = $file->slug;
											$img = SM::sm_get_galary_src_data_img( $filename, $file->is_private == 1 ? true : false );
											$src = $img['src'];
											?>
                                            <img src="{!! $src !!}" alt="{{ $file->title }}">
                                            <div class="d-hover-content text-center"></div>
                                            <div class="hovercontent-item">
                                                <a href="{{ url( '/dashboard/media/download/' . $file->media_id ) }}"><i
                                                            class="fa fa-download"></i> </a>
                                                <p>Download {{ $file->title }}
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-warning"><i class="fa fa-info"></i> No Media Found!</div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
