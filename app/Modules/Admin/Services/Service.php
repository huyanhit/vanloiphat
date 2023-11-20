<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/12/2020
 * Time: 2:54 PM
 */

namespace App\Modules\Admin\Services;

use App\Modules\Admin\Helpers\Common;
use App\Modules\Admin\Models\CategoryModel;
use App\Modules\Admin\Models\ImageModel;
use App\Modules\Admin\Models\MenuModel;
use App\Modules\Admin\Models\PageModel;
use App\Modules\Admin\Models\PostModel;
use App\Modules\Admin\Models\ProductCategoryModel;
use App\Modules\Admin\Models\ProductModel;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use Intervention\Image\Facades\Image;

use Validator;
use Exception;

use function Laravel\Prompts\select;

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
    private $common;
    function __construct($model){
        $this->model = $model;
        $this->common = new Common();
    }

    public function generateList($data){
        $this->filter($data);
        $this->sort($data);
        return $this->paginate($data);
    }

    protected function filter($data){
        $filter = [];
        foreach($data["list"] as $key => $value){
            $select[] = $key;
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

    public function addData($request, $data){
        if($this->validateData($request, $data)){
            DB::beginTransaction();
            try{
                $id = $request->input('id');
                if(isset($id)){
                    $data['data'] = (array)$this->model->where(['id'=> $id])->first()->toArray();
                    $data['data'] = array_merge($data['data'], $request->input());
                }else{
                    $data['data'] = $request->input();
                }

                foreach($data['form'] as $key => $value){
                    if(isset($value['type'])){
                        if($value['type'] === 'password'){
                            $data['data'][$key] = Hash::make($data['data'][$key]);
                        }
                        if($value['type'] === 'confirm'){
                            unset($data['data'][$key]);
                        }
                        if($value['type'] === 'date'){
                            $data['data'][$key] = strtotime($data['data'][$key]);
                        }
                    }
                }
                $arrayInsert = array();
                $dataReference = array();

                foreach($data["form"] as $key => $value){
                    if(!isset($value['reference']) && isset($data["data"][$key])){
                        $arrayInsert[$key] = $data["data"][$key];
                    }
                }
                
                $this->uploadFiles($arrayInsert, $request->file());
                $result = $this->model->insertGetId($arrayInsert);
                foreach($data["form"] as $key => $value){
                    if($result && isset($value['reference'])){
                        $dataReference['table'] = $key;
                        $dataReference['data']  = $request->input($key);
                        $dataReference['reference'] = $value['reference'];
                        $dataInsertReference = array();
                        if(isset($dataReference['data'][$dataReference['reference']['foreign_id']])){
                            foreach ($dataReference['data'][$dataReference['reference']['foreign_id']] as $re_key => $re_value){
                                $arrayMergeUpdate = array();
                                foreach ($dataReference['reference'] as $re_data){
                                    if(empty($dataReference['data'][$re_data][$re_key]) && ($re_data == $dataReference['reference']['primary_id'])){
                                        $dataReference['data'][$re_data][$re_key] = $result;
                                    }
                                    if(empty($dataReference['data'][$re_data][$re_key])
                                        && $re_data != $dataReference['reference']['primary_id']
                                        && $re_data != $dataReference['reference']['foreign_id']){
                                        $dataReference['data'][$re_data][$re_key] = 0;
                                    }
                                    $arrayMergeUpdate = array_merge($arrayMergeUpdate, array($re_data => $dataReference['data'][$re_data][$re_key]));
                                }
                                $dataInsertReference[] = $arrayMergeUpdate;
                            }
                        }
                        $this->insertReference($dataReference['table'], $dataInsertReference);
                    }
                }

                DB::commit();
                return $result;

            }catch (Exception $e){
                DB::rollBack();
            }
        }
        return false;
    }

    public function editData($request, $id, $data){
        $data['data'] = $request->input();
        foreach($data['form'] as $key => $value){
            if(isset($value['type'])) {
                if ($value['type'] === 'password') {
                    if (!empty($data['data'][$key])) {
                        $data['data'][$key] = Hash::make($data['data'][$key]);
                    } else {
                        unset($data['form'][$key]);
                        unset($data['form']['confirm']);
                    }
                }
                if ($value['type'] === 'confirm') {
                    unset($data['data'][$key]);
                }
                if ($value['type'] === 'date') {
                    $data['data'][$key] = date('Y-m-d h:i:s', strtotime($data['data'][$key]));
                }
            }
        }
        if($this->validateData($request, $data, true)){
            DB::beginTransaction();
            try{
                $arrayUpdate = array();
                foreach($data["form"] as $key => $value){
                    if(isset($value['reference'])){
                        $dataUpdateReference = array();
                        $where = array('key' => $value['reference']['primary_id'], 'value' => $id);
                        $inputReference = $request->input($key);
                        if(!empty($inputReference) && isset($inputReference[$value['reference']['foreign_id']])){
                            foreach ($inputReference[$value['reference']['foreign_id']] as $re_key => $re_value){
                                $arrayMergeUpdate = array();
                                foreach ($value['reference'] as $re_data){
                                    $arrayMergeUpdate = array_merge($arrayMergeUpdate,
                                        array($re_data => empty($inputReference[$re_data][$re_key])? null :$inputReference[$re_data][$re_key]));
                                }
                                $dataUpdateReference[] = $arrayMergeUpdate;
                            }
                        }
                        $this->updateReference($key, $dataUpdateReference , $where , $value['reference']['foreign_id']);
                    }elseif(array_key_exists($key, $data["data"])){
                        $arrayUpdate[$key] = $data["data"][$key];
                    }
                }
       
                $this->uploadFiles($arrayUpdate, $request->file());
                $result = $this->model->where('id', $id)->update($arrayUpdate);
                DB::commit();
                return $result;

            }catch (Exception $e){
                DB::rollBack();
            }
        }
        return false;
    }

    public function deleteData($id, $form){
        DB::beginTransaction();
        try{
            foreach ($form as $key => $val){
                if(isset($val['reference'])){
                    $this->importModel($key)->where($val['reference']['primary_id'], $id)->delete();
                }
            }
            $result = $this->model->where('id', $id)->delete();

            DB::commit();
            return $result;

        }catch (Exception $e){
            DB::rollBack();
        }

        return false;
    }

    public function uploadFile($request, $type){
        if($type == self::FILE){
            foreach ($request->file() as $key => $value) {
                return $this->common->uploadFile($value);
            }
        }elseif($type == self::IMAGE || $type == self::VIDEO){
            foreach ($request->file() as $key => $value) {
                return $this->common->uploadImage($value);
            }
        }

        return false;
    }
   
    public function importModel($key){
        switch ($key){
            case 'pages':
                return new PageModel();
                break;
            case 'menus':
                return new MenuModel();
                    break;
            case 'categories':
                return new CategoryModel();
                break;
            case 'posts':
                return new PostModel();
                break;
            case 'products':
                return new ProductModel();
                break;
            case 'product_categories':
                return new ProductCategoryModel();
                break;
            case 'images':
                return new ImageModel();
                break;
            default:
                return new MyData($key);
                break;
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

    private function validateField($request, $data){
        $arrayValidate = array();
        foreach($data as $key => $value){
            if(isset($value['validate']) && ($key == $request->input('field'))){
                $arrayValidate[$key] = $value['validate'];
                break;
            }
        }
        $request->merge(array($request->input('field')=> $request->input('value')));
        if(!empty($arrayValidate)){
            return $request->validate($arrayValidate);
        }
        return true;
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

    private function upload($file, $type = null, $path = 'vanloiphat/'){
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
                    Image::make($file)->orientate()->resize(null, 100, function ($constraint) {
                        $constraint->aspectRatio();
                    })->stream());
                }
                break;
            }
            $run ++;
        }
        return $pathStore;
    }

    private function uploadFiles(&$fileData, $file){
        // create new image item
        foreach ($file as $key => $value) {
            if(is_array($value)){
                foreach ($value as $k => $val){
                    $uri = self::PUCLIC_STORAGE.$this->upload($val);
                    if(key($file) === 'image_id'){
                        $fileData['files'][$k] = $this->importModel('images')->insertGetId(['uri' => $uri, 'active' => 1]);
                    }else{
                        $fileData['files'][$k] = $uri;
                    }
                }
            }else{
                $uri = self::PUCLIC_STORAGE.$this->upload($value);
                if(key($file) === 'image_id'){
                    $fileData[$key] = $this->importModel('images')->insertGetId(['uri' => $uri, 'description' => 'image post', 'active' => 1]);
                }else{
                    $fileData[$key] = $uri;
                }
            }
        }
        
    }

    private function updateReference($table, $data, $where, $reference){
        $dataDB = $this->importModel($table)->where($where['key'], $where['value'])->get()->toArray();
        foreach ($data as $key => $value){
            $hasKey = false;
            foreach ($dataDB as $k => $v){
                if($v[$reference] == $value[$reference]){
                    $this->importModel($table)->where('id', $v['id'])->update($data[$key]);
                    unset($dataDB[$k]);
                    $hasKey = true;
                    break;
                }
            }

            if(!$hasKey){
                $this->importModel($table)->insert($data[$key]);
            }
        }

        foreach ($dataDB as $value){
            if(!empty($value)){
                $this->importModel($table)->where('id', $value['id'])->delete();
            }
        }
    }

    private function insertReference($table, $data){
        foreach ($data as $key => $value) {
            $this->importModel($table)->insert($data[$key]);
        }
    }

    public function updateField($request, $data){
        if($this->validateField($request, $data)) {
            $data = $request->input();
            $id = $request->input('id');
            return $this->model->where('id', $id)->update([$data['field']=> $data['value']]);
        }

        return false;
    }

    public function getDataTable($table, $where, $select){
        $model = $this->importModel($table);
        if(!empty($where)) $model  = $model->where($where);
        if(!empty($select)) $model = $model->select($select);

        return $model->get();
    }
}

class MyData{
    function __construct($key){
    }
    public function get(){
    }
}
