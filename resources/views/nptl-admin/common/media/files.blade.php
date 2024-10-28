<?php
$countFiles = count($files);
$smPaginationMedia = config("constant.smPaginationMedia");
?>
<div>

    <input type="text" class="form-control media_search pull-left" style="width: 200px;" placeholder="Search...">
    Total Media = <strong><span class="" id="media_count">{{ $countFiles }}</span></strong>
</div>
<div class="row">
    <!-- SuperBox -->
    <div class="superbox col-sm-12 media_search_data">
        @if($countFiles>0)
            @foreach($files as $file)
                <?php
                $filename = $file->slug;
                $img = \App\SM\SM::sm_get_galary_src_data_img($filename, $file->is_private == 1 ? true : false);
                $src = $img['src'];
                $data_img = $img['data_img'];
                $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                ?>
                <div class="superbox-list sm_file_{{ $file->id }}">
                    @if($file->is_private == 1)
                        <span class="private_media" title="Private File"><i class="fa fa-lock"></i></span>
                    @endif
                    <img title="{{ $file->title }}" src="{{ $src }}" data-img="{{ $data_img }}" img_id="{{ $file->id }}"
                         is_private="{{ $file->is_private }}"
                         img_slug="{{$filename}}" alt="{{ $file->alt }}"
                         ftype="{{ $extension }}"
                         caption="{{ $file->caption }}" description="{{ $file->description }}"
                         class="superbox-img">
                </div>

            @endforeach
        @else
            <div class="alert alert-warning fade in">
                <button class="close" data-dismiss="alert"><i class="fa fa-times"></i></button>
                <i class="fa-fw fa fa-warning"></i>
                <strong>{{__("media.warning")}}</strong>
                {{__("media.noMediaFileFound")}}
            </div>
        @endif
        <div class="superbox-float"></div>
    </div>
    <div class="col-sm-12 text-center" style="{{ $countFiles >= $smPaginationMedia ? '': 'display:none;' }}">
        <button class="btn btn-block btn-primary" id="sm_media_load_more"
                data-need_to_load="{{  $smPaginationMedia }}"
                data-loaded="{{ $countFiles }}"><i class="fa fa-refresh"></i> Load More
        </button>
    </div>
    <!-- /SuperBox -->
    <div class="superbox-show" style="height:300px; display: none">
    </div>
</div>
@section('footer_script')
    <script type="text/javascript">
        $('.media_search').on('keyup', function () {
            var search = $(this).val();
            $.ajax({
                type: 'get',
                url: '{{URL::route('media_search')}}',
                data: {'search': search},
                success: function (data) {
                    $('.media_search_data').html(data.media_output_data);
                    $('#media_count').html(data.total_media_data);
                }
            });
        })
    </script>
@endsection
