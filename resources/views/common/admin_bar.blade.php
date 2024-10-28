<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 1/22/18
 * Time: 11:04 AM
 */
?>
@if(Auth::guard('admins')->check())
    <div class="header-top nptl-admin-bar">
        <div class="container">
            <div class="row">
                <div class="admin-top-bar clearfix">
                    <div class="col-lg-6 col-sm-6">
                        <ul class="header-top-phone admin-top-menu">
                            @if($method=='index' && SM::check_this_method_access( 'appearance', 'appearance' ))
                                <li>
                                    <a href="{{ SM::smAdminUrl("appearance/smthemeoptions")  }}"><i
                                                class="fa fa-pencil"></i> Edit Home</a>
                                </li>
                            @elseif($method=='blog' && SM::check_this_method_access( 'blogs', 'index' ))
                                <li>
                                    <a href="{{ SM::smAdminUrl("blogs")  }}"><i class="fa fa-list"></i> Blog
                                        List</a>
                                </li>
                            @elseif(isset($smAdminBarId) && $method=='blogdetail' && SM::check_this_method_access( 'blogs', 'edit' ))
                                <li>
                                    <a href="{{ SM::smAdminUrl("blogs/$smAdminBarId/edit")  }}"><i
                                                class="fa fa-pencil"></i> Edit Blog</a>
                                </li>

                            @elseif($method=='services' && SM::check_this_method_access( 'services', 'index' ))
                                <li>
                                    <a href="{{ SM::smAdminUrl("services")  }}"><i class="fa fa-list"></i> Service
                                        List</a>
                                </li>
                            @elseif(isset($smAdminBarId) && $method=='servicedetail' && SM::check_this_method_access( 'services', 'edit' ))
                                <li>
                                    <a href="{{ SM::smAdminUrl("services/$smAdminBarId/edit")  }}"><i
                                                class="fa fa-pencil"></i> Edit Service</a>
                                </li>
                            @elseif($method=='caselist' && SM::check_this_method_access( 'cases', 'index' ))
                                <li>
                                    <a href="{{ SM::smAdminUrl("cases")  }}"><i class="fa fa-list"></i> Case
                                        List</a>
                                </li>
                            @elseif(isset($smAdminBarId) && $method=='casedetail' && SM::check_this_method_access( 'cases', 'edit' ))
                                <li>
                                    <a href="{{ SM::smAdminUrl("cases/$smAdminBarId/edit")  }}"><i
                                                class="fa fa-pencil"></i> Edit Case</a>
                                </li>
                            @elseif($method=='packages' && SM::check_this_method_access( 'packages', 'index' ))
                                <li>
                                    <a href="{{ SM::smAdminUrl("packages")  }}"><i class="fa fa-list"></i> Package
                                        List</a>
                                </li>
                            @elseif(isset($smAdminBarId) && $method=='packagedetail' && SM::check_this_method_access( 'packages', 'index' ))
                                <li>
                                    <a href="{{ SM::smAdminUrl("packages/$smAdminBarId/edit")  }}"><i
                                                class="fa fa-pencil"></i> Edit Package</a>
                                </li>
                            @elseif(isset($smAdminBarId) && $method=='page' && SM::check_this_method_access( 'page', 'index' ))
                                <li>
                                    <a href="{{ SM::smAdminUrl("pages/edit_page/$smAdminBarId")  }}"><i
                                                class="fa fa-pencil"></i> Edit Page</a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ SM::smAdminUrl("/")  }}"><i class="fa fa-tachometer"></i> Admin
                                        Dashboard</a>
                                </li>
                            @endif
                            <li>
                                <a href="{{SM::smAdminUrl("flush-cache") }}"><i class="fa fa-trash-o"></i> Flush
                                    Cache</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <ul class="header-top-account text-right ">
                            <li><a href="{{ SM::smAdminUrl("/")  }}"
                                   class="profile-img">{{ SM::current_user_first_lastname() }}</a>
                            </li>
                            <li><a href="{{SM::smAdminUrl("logout") }}"><i class="fa fa-sign-in"></i>Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
