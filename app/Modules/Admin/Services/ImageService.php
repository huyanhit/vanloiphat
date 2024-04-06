<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/12/2020
 * Time: 2:54 PM
 */

namespace App\Modules\Admin\Services;

use App\Modules\Admin\Models\ImageModel;
use Illuminate\Support\Facades\Storage;

class ImageService extends Service{
    const STORE_FILE         = 'local';
    const THUMBNAIL_SEPARATE = 'thumb_';
    function __construct(){
        parent::__construct(new ImageModel());
    }

    public function getImageThumbnail($imageId){
        $image = $this->model->find($imageId);
        if(!empty($image)){
            $path = str_replace(self::PUCLIC_STORAGE,'', $image->uri);
            $file = Storage::disk('local')->get(self::THUMBNAIL_SEPARATE.$path);
            $type = Storage::mimeType(self::THUMBNAIL_SEPARATE.$path);

            return response($file)->header('Content-Type', $type);
        }
    }
    public function getImage($imageId){
        $image = $this->model->find($imageId);
        if(!empty($image)){
            $path = str_replace(self::PUCLIC_STORAGE,'', $image->uri);
            $file = Storage::disk('local')->get($path);
            $type = Storage::mimeType($path);

            return response($file)->header('Content-Type', $type);
        }
    }

    public function getImageResource($resource){
        if(!empty($resource)){
            $path = str_replace(self::PUCLIC_STORAGE,'', $resource);
            $file = Storage::disk('local')->get($path);
            $type = Storage::mimeType($path);
            return response($file)->header('Content-Type', $type);
        }
    }

    public function imagesDestroy(){
        $trashed  = $this->model->onlyTrashed()->get();
        $used     = $this->model->get();

        $destroys = [];
        foreach($trashed as $item){
            $destroys[] = $item->uri;
        }

        $keeps = [];
        foreach($used as $item){
            $keeps[] = $item->uri;
        }

        foreach($destroys as $destroy){
            if(!in_array($destroy, $keeps)){
                $path     = str_replace(self::PUCLIC_STORAGE, '', $destroy);
                $files[]  = $path;
                $thumbs[] = self::THUMBNAIL_SEPARATE.$path;
            }
        }

        Storage::delete($files);
        Storage::delete($thumbs);

        return redirect('admin/dashboard');
    }
}
