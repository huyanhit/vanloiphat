<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/12/2020
 * Time: 2:54 PM
 */

namespace App\Modules\Admin\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use Exception;

class Service {
    const UN_ACTIVE = 0;
    const IMAGE  = 'image';
    const VIDEO  = 'video';
    const IMAGES = 'images';
    const FILE   = 'file';
    const FILES  = 'files';
    const CHOOSE = 'Choose';

    const STORE_FILE         = 'local';
    const THUMBNAIL_SEPARATE = 'thumb_';
    const PUCLIC_STORAGE     = '/storage/';

    public $model;
    function __construct($model){
        $this->model = $model;
    }

    public function generateList($data){
        $this->filter($data);
        $this->sort($data);
        return $this->paginate($data);
    }

    protected function filter($data){
        $filter = [];
        foreach($data["list"] as $key => $value){
            if(isset($value['filter']['type']) ){
                switch ($value['filter']['type']){
                    case 'text':
                        if(!empty($value['filter']['value']))
                            $filter[] = array($key, 'like', '%' . $value['filter']['value'] . '%');
                        break;
                    case 'select':
                        if($value['filter']['value'] != null)
                            $filter[] = array($key, 'like', $value['filter']['value']);
                        break;
                }
            }
        }

        if(!empty($filter)){
            $this->model = $this->model->where($filter);
        }
    }

    protected function sort($data){
        if(!empty($data['sort'])){
            $this->model = $this->model->orderby($data['sort']['order'], $data['sort']['by']);
        }
    }

    protected function paginate($data){
        if(!empty($data['paginate'])){
            return $this->model->paginate($data['paginate']['page']);
        }else{
            return $this->model->get();
        }
    }

    public function generateArrayList($data){
        foreach ($data['form'] as $key => $value) {
            if (isset($value['filter']['type'])) {
                switch ($value['filter']['type']) {
                    case 'text' || 'dropdown':
                        if (!empty($value['filter']['value'])) {
                            $data['items'] = collect($data['items'])->filter(function ($item) use ($key, $value) {
                                $compare = (array)$item;
                                return stristr($compare[$key], $value['filter']['value']);
                            });
                        }
                        break;
                }
            }
        }

        // sort
        foreach ($data["form"] as $key => $value) {
            if (isset($value['sort']) && $value['sort'] !== '') {
                if ($value['sort'] === 'asc') {
                    $data['items'] = collect($data['items'])->sortBy($key)->values()->all();
                } else {
                    $data['items'] = collect($data['items'])->sortByDesc($key)->values()->all();
                }
            }
        }

        return $this->paginateArray($data['items'], $data['paginate']['page']);
    }

    public function filerFormType(&$data): array
    {
        foreach($data['form'] as $key => $value){
            if(isset($value['type'])){
                if($value['type'] === 'password'){
                    if(!empty($data['data'][$key])){
                        $data['data'][$key] = Hash::make($data['data'][$key]);
                    }else{
                        unset($data['form'][$key]);
                    }
                }

                if($value['type'] === 'confirm'){
                    unset($data['data'][$key]);
                }
                if($value['type'] === 'date'){
                    $data['data'][$key] = strtotime($data['data'][$key]);
                }
            }
        }

        return $data;
    }
    public function addData($request, $data){
        if($this->validateData($request, $data)){
            DB::beginTransaction();
            try{
                $data['data'] = $request->input();
                $this->filerFormType($data);

                $arrayInsert = array();
                $keyHasMany  = '';
                foreach($data["form"] as $key => $value){
                    if($value['type'] === 'has_many'){
                        $keyHasMany = $key;
                    }elseif(isset($data["data"][$key])){
                        $arrayInsert[$key] = $data["data"][$key];
                    }
                }

                if(!empty($request->file())){
                    $arrayInsert = $this->uploadFiles($data['form'], $arrayInsert, $request->file());
                }

                $id = $this->model->insertGetId($arrayInsert);
                $this->updateHasMany($keyHasMany, $id, $data);

                if($id){
                    DB::commit();
                    return $id;
                }

            }catch (Exception $e){
                dd($e);
                DB::rollBack();
            }
        }
        return false;
    }

    private function editImages($id, $data): void{
        if(isset($data['data']['delete_images'])){
            $delete_images = $data['data']['delete_images'];
            foreach($data['form'] as $key => $value){
                if ($value['type'] === 'images' && $delete_images) {
                    $images = $this->model->find($id)->$key;
                    if(!empty($images)){
                        $images = str_replace([','.$delete_images, $delete_images.',', $delete_images], '', $images);
                        $this->model->where('id', $id)->update([$key => $images]);
                        $this->importModel('images')->where('id',  $delete_images)->delete();
                    }
                }
            }
        }
    }

    public function updateHasMany($key, $id, $data): void
    {
        $model = $this->model->find($id);
        if(isset($data['data'][$key.'_update'])) {
            foreach ($model->$key as $k => $item) {
                if (isset($data['data'][$key.'_update'][$k])) {
                    foreach ($data["form"][$key]['update'] as $field) {
                        $model->$key[$k]->$field = $data['data'][$key.'_update'][$k][$field];
                    }
                } else {
                    $model->$key()->whereId($model->$key[$k]->id)->delete();
                }
            }

            $model->push();
        }

        if(isset($data['data'][$key.'_insert'])){
            $group = [];
            foreach ($data['data'][$key.'_insert'] as $ks =>  $fields) {
                foreach ($fields as $k => $field) {
                    $group[$k][$ks] = $field;
                }
            }
            $model->$key()->createMany($group);
        }
    }

    public function editData($request, $id, $data){
        $data['data'] = $request->input();
        $this->editImages($id, $data);
        $this->filerFormType($data);
        if($this->validateData($request, $data, true)){
            DB::beginTransaction();
            try{
                $arrayUpdate = array();
                foreach($data["form"] as $key => $value){
                    if($value['type'] === 'has_many'){
                        $this->updateHasMany($key, $id, $data);
                    }elseif(array_key_exists($key, $data["data"])){
                        $arrayUpdate[$key] = $data["data"][$key];
                    }
                }

                if(!empty($request->file())){
                    $arrayUpdate = $this->uploadFiles($data["form"], $arrayUpdate, $request->file(), $this->model->find($id));
                }

                if($this->model->where('id', $id)->update($arrayUpdate)){
                    DB::commit();
                    return $arrayUpdate;
                }
            }catch (Exception $e){
                dd($e);
                DB::rollBack();
            }
        }

        return false;
    }

    public function deleteData($id){
        DB::beginTransaction();
        try{
            $result = $this->model->where('id', $id)->delete();
            DB::commit();
            return $result;

        }catch (Exception $e){
            DB::rollBack();
        }

        return false;
    }

    public function importModel($key){
        $baseClass = "App\Modules\Admin\Models";
        $pathClass = "app/Modules/Admin/Models";
        $path      = base_path($pathClass).'/*.php';
        $models    = collect(glob($path))->map(function($file) use ($baseClass){
            $class = $baseClass."\\".basename($file, ".php");
            return new $class();
        });
        foreach( $models as $model){
            if($key == $model->getTable()) return $model;
        }
    }

    private function paginateArray($items, $perPage = 15, $page = null, $options = []){
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $paginator = new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);

        return $paginator;
    }

    private function validateData($request, $data, $skip = false){
        $arrayValidate = [];
        foreach($data["form"] as $key => $value){
            if($skip && empty($request->input($key))){
                continue;
            }
            if(isset($value['validate'])){
                $regx = '/\|unique:[\w\,]+(?=,{id})/i';
                $strReplace = $value['validate'];
                $id = $request->input('id');
                if(preg_match($regx, $value['validate'])){
                    if(isset($id)){
                        $strReplace = preg_replace('/{id}/i', $id, $value['validate']);
                    }else{
                        $strReplace = preg_replace('/{id}/i', '', $value['validate']);
                    }
                }
                $arrayValidate[$key] = $strReplace;
            }
        }

        $this->validateFile($arrayInsert,  $request->file());

        if(empty($arrayValidate)){
            return true;
        }

        return $request->validate($arrayValidate);
    }

    private function validateFile(&$arrayData, $file){
        foreach($file as $key => $value){
            if(is_array($value)){
                foreach ($value as $k => $val){
                    $arrayData[$key][$k] = $val->getClientOriginalName();
                }
            }else{
                $arrayData[$key] = $value->getClientOriginalName();
            }
        }
    }

    public function upload($file, $type = null, $path = 'vanloiphat/'){
        $name       = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $ext        = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $store      = self::STORE_FILE;
        $path       = $path.$name;
        $pathStore  = $path.'.'.$ext;
        $run        = 1;
        $type       = 'file';

        $imageType  = array('jpg','jpeg','png','gif','webp','apng','avif','pjpeg','jfif','pjp','svg');
        $videoType  = array('mp4','avi','wmv','ogg','ogv','webm','flv','swf','ram','rm','mov','mpeg','mpg');
        if(in_array(strtolower($ext), $imageType)) {
            $type = 'image';
        }
        if(in_array(strtolower($ext), $videoType)) {
            $type = 'video';
        }

        while($run){
            if(Storage::disk($store)->exists($pathStore)){
                $pathStore = $path.'-'.$run.'.'.$ext;
            }else{
                Storage::disk($store)->put($pathStore, file_get_contents($file));
                if($type === 'image'){
                    Storage::disk($store)->put(self::THUMBNAIL_SEPARATE.$pathStore,
                    Image::make($file)->orientate()->resize(null, 270, function ($constraint) {
                        $constraint->aspectRatio();
                    })->stream());
                }
                break;
            }
            $run ++;
        }
        return $pathStore;
    }

    private function uploadFiles($form, $fileData, $file, $data = null){
        // create new image item
        foreach ($file as $key => $value) {
            if(is_array($value)){
                $files = [];
                foreach ($value as $k => $val){
                    $uri     = self::PUCLIC_STORAGE.$this->upload($val);
                    $files[] = $this->importModel('images')->insertGetId(['uri' => $uri, 'active' => 1]);
                }
                if(isset($data)){
                    $fileData[$key] = empty($data->$key)? implode(',', $files): $data->$key.','.implode(',', $files);
                }else{
                    $fileData[$key] = implode(',', $files);
                }
            }else{
                $uri = self::PUCLIC_STORAGE.$this->upload($value);
                if($form[$key]['type'] === 'image_id'){
                    if(isset($data)) $this->importModel('images')->where('id', $data->$key)->delete();
                    $fileData[$key] = $this->importModel('images')->insertGetId(['uri' => $uri, 'description' => 'image post', 'active' => 1]);
                }else{
                    $fileData[$key] = $uri;
                }
            }
        }

        return $fileData;
    }

    public function getDataTable($table, $where, $select){
        $model = $this->importModel($table);
        if(!empty($where)) $model  = $model->where($where);
        if(!empty($select)) $model = $model->select($select);

        return $model->get();
    }

    private function getFileLocal($name, $choose = true){
        $result = [];
        if($choose)
            $result[null] = self::CHOOSE;

        $allFile = Storage::disk($name)->files('');
        foreach ($allFile as $value){
            if($value = str_replace('.blade.php','',$value)){
                $result[$value] = $value;
            }
        }

        return $result;
    }
}
