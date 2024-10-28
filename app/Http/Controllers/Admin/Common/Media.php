<?php

namespace App\Http\Controllers\Admin\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\SM\SM;
use App\Model\Common\Media as Media_model;
use Response;
use Illuminate\Support\Facades\Auth;

class Media extends Controller
{
    function index()
    {
        $data['files'] = SM::sm_get_media_files(config("constant.smPaginationMedia"));

        return view('nptl-admin/common/media/Media', $data);
    }

    function update(Request $data)
    {
        $media = Media_model::find($data['id']);
        if (count((array)$media) > 0) {
            if (SM::check_this_method_access('media', 'view') || $media->created_by == SM::current_user_id()) {
                $media->modified_by = SM::current_user_id();
                $media->title = $data['title'];
                $media->caption = $data['caption'];
                $media->alt = $data['alt'];
                $media->description = $data['description'];
                $media->save();
            }
        }
    }

    function delete(Request $data)
    {
        $media = Media_model::find($data['id']);
        if (count((array)$media) > 0) {
            if (SM::check_this_method_access('media', 'view') || $media->created_by == SM::current_user_id()) {
                SM::sm_file_delete($media->slug, $media->is_private == 1 ? true : false);
                $media->delete();
            }
        }
    }

    function download($id)
    {
        $media = Media_model::find($id);
        if (count((array)$media) > 0) {
            $path = config('constant.smUploadsDir');
            $fileWithDir = storage_path("app/" .
                ($media->is_private == 1 ? "private" : "public") .
                "/" . $path . $media->slug);
            $explode = explode('.', $fileWithDir);
            $file_mrks = '';
            if (count((array)$explode) > 1) {
                $file_mrks = $explode[0] . '_mrks.' . $explode[1];
            }
            if ($file_mrks && file_exists($file_mrks)) {
                return Response::download($file_mrks);
            } elseif (file_exists($fileWithDir)) {
                return Response::download($fileWithDir);
            }

            return;
        }
    }

    function upload(Request $data)
    {
        if (Input::hasFile('file')) {
            $isPrivate = $data->input('is_private', 0);
            $isPrivate = ($isPrivate == 1) ? true : false;
            if (SM::check_this_method_access('media', 'upload')) {
                $img = SM::sm_image_upload('file', 'required', $isPrivate);
            } else {
                $img = SM::sm_image_upload('file', 'required|mimes:png,gif,jpeg', $isPrivate);
            }
            if (is_array($img) && isset($img['insert_id'])) {
                $insert_id = $img['insert_id'];
                $src = $img['src'];
                $data_img = $img['data_img'];
                $title = $img['title'];
                $slug = $img['slug'];
                $extension = strtolower(pathinfo($data_img, PATHINFO_EXTENSION));
                echo '<div class="superbox-list sm_file_' . $insert_id . '">';
                if ($isPrivate == 1):
                    echo '<span class="private_media" title="Private File"><i class="fa fa-lock"></i></span>';
                endif;
                echo '<img src="' . $src . '" data-img="' . $data_img . '" img_id="' . $insert_id . '" 
				img_slug="' . $slug . '" alt="" title="' . $title . '" ftype="' . $extension . '" title="' . $title . '"
				caption="" description=""  class="superbox-img">
				</div>';
            } else {
                echo '<span class="red padding-10">upload Error: ' . $img->first('file') . '</span>';
            }
        }
        exit;
    }

    public function getMedias($offset)
    {
        $files = SM::sm_get_media_files(config("constant.smPaginationMedia"), $offset);
        $media = '';
        $countFiles = count((array)$files);
        if ($countFiles > 0) {
            foreach ($files as $file) {
                $filename = $file->slug;
                $img = SM::sm_get_galary_src_data_img($filename, $file->is_private == 1 ? true : false);
                $src = $img['src'];
                $data_img = $img['data_img'];
                $extension = strtolower(pathinfo($data_img, PATHINFO_EXTENSION));
                $media .= '<div class="superbox-list sm_file_' . $file->id . '">';
                if ($file->is_private == 1):
                    $media .= '<span class="private_media" title="Private File"><i class="fa fa-lock"></i></span>';
                endif;
                $media .= '<img src="' . $src . '" data-img="' . $data_img . '" img_id="' . $file->id . '"
						     img_slug="' . $filename . '" alt="' . $file->alt . '" ftype="' . $extension . '" title="' . $file->title . '"
						     caption="' . $file->caption . '" description="' . $file->description . '"
						     class="superbox-img">
					</div>';

            }
        }
        $data["count"] = $countFiles;
        $data["load"] = $offset + $countFiles;
        $data["media"] = $media;
        echo json_encode($data);
        exit;
    }

    function media_search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('search');
            $files = Media_model::where('title', 'like', '%' . $query . '%')
                ->orWhere('slug', 'like', '%' . $query . '%')
                ->orderBy('id', 'desc')
                ->get();
            $countFiles = count((array)$files);
            $smPaginationMedia = config("constant.smPaginationMedia");
            if ($countFiles > 0) {
                foreach ($files as $file) {
                    $filename = $file->slug;
                    $img = SM::sm_get_galary_src_data_img($filename, $file->is_private == 1 ? true : false);
                    $src = $img['src'];
                    $data_img = $img['data_img'];
                    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    $output .= '<div class="superbox-list sm_file_' . $file->id . '">';
                    if ($file->is_private == 1) {
                        $output .= '<span class="private_media" title="Private File"><i class="fa fa-lock"></i></span>';
                    }
                    $output .= '<img title="' . $file->title . '" src="' . $src . '" data-img="' . $data_img . '" img_id="' . $file->id . '"
                         is_private="' . $file->is_private . '"
                         img_slug="' . $filename . '" alt="' . $file->alt . '"
                         ftype="' . $extension . '"
                         caption="' . $file->caption . '" description="' . $file->description . '"
                         class="superbox-img">
                </div>';
                }
            } else {
                $output .= '<div class="alert alert-warning fade in" >
                <button class="close" data - dismiss = "alert" ><i class="fa fa-times" ></i ></button >
                <i class="fa-fw fa fa-warning" ></i >
                <strong > ' . __("media.warning") . '</strong >
            ' . __("media.noMediaFileFound") . '
            </div >';
            }

        }
        $files = array(
            'media_output_data' => $output,
            'total_media_data' => $countFiles
        );

        return Response($files);
    }

}
