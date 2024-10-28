<div class="clearfix">



    @if(Route::current()->getName() != 'home')

        <nav aria-label="breadcrumb">

            <ol class="breadcrumb mt-2">

                {{--<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>--}}

                @php

                    $link = url('/');

                @endphp

                <a href="/">Home</a> >

                <?php $link = "" ?>

                @for($i = 1; $i <= count(Request::segments()); $i++)

                    @if($i < count(Request::segments()) & $i > 0)

                        <?php $link .= "/" . Request::segment($i); ?>

                        <a href="<?= $link ?>">{{ ucwords(str_replace('-',' ',Request::segment($i)))}}</a> >

                    @else {{ucwords(str_replace('-',' ',Request::segment($i)))}}

                    @endif

                @endfor

                {{--@foreach(request()->segments() as $segment)--}}

                    {{--@php--}}

                        {{--$link .= "/" . request()->segment($loop->iteration);--}}

                    {{--@endphp--}}

                    {{--@if(rtrim(request()->route()->getPrefix(), '/') != $segment && ! preg_match('/[0-9]/', $segment))--}}

                        {{--<li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">--}}

                            {{--@if($loop->last)--}}

                                {{--{{ title_case($segment) }}--}}

                            {{--@else--}}

                                {{--<a href="{{ $link }}">{{ title_case($segment) }}</a>--}}

                            {{--@endif--}}

                        {{--</li>--}}

                    {{--@endif--}}

                {{--@endforeach--}}

            </ol>

        </nav>

    @endif

</div>