<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;

class MyController extends BaseController
{
    const CHOOSE      = 'choose';

    const CHECK       = 'check';
    const IMAGE_ID    = 'image_id';
    const IMAGE       = 'image';
    const IMAGES      = 'images';
    const PASSWORD    = 'password';
    const CONFIRM     = 'confirm';
    const SELECT      = 'select';
    const AREA        = 'area';
    const CODE        = 'code';
    const TEXT        = 'text';
    const HAS_MANY     = 'has_many';
    const HAS_PIVOT     = 'has_pivot';



    public $request;
    public $service;
    public $hookData;
    public $view;
    public $route;

    function __construct($request, $service){
        $this->request          = $request;
        $this->service          = $service;
        $this->hookData         = null;
    }

    public function init(&$result){
        Session::put('page', $this->request->get('page'));
        if($this->request->route()->getPrefix() != Session::get('router_prefix')){
            Session::forget('page');
            Session::forget('url_sort');
            Session::forget('filter');
            Session::put('router_prefix', $this->request->route()->getPrefix());
        }

        $this->sort($result);
        $this->filter($result);
        $this->paginate($result);
    }

    protected function sort(&$result){
        if($this->request->get('order') && $this->request->get('by')){
            $result['sort']['order'] = $this->request->get('order');
            $result['sort']['by']    = $this->request->get('by');
        }else{
            foreach ($result['list'] as $value){
                if( isset($value['sort']['order']) && isset($value['sort']['by'])){
                    $result['sort']['order'] = $value['sort']['order'];
                    $result['sort']['by']    = $value['sort']['by'];
                    break;
                }
                $result['sort']['order'] = 'id';
                $result['sort']['by']    = 'asc';
            }
        }

        if(isset($result['sort'])){
            if(Session::get('page') != null){
                $result['url_sort'] = '?page=' . Session::get('page') . '&order=' . $result['sort']['order'] . '&by='.  $result['sort']['by'];
            }else{
                $result['url_sort'] = '?order=' . $result['sort']['order'] . '&by='.  $result['sort']['by'];
            }

        }else{
            if(Session::get('page') != null){
                $result['url_sort'] = '?page=' . Session::get('page');
            }else{
                $result['url_sort'] = "";
            }
        }
        Session::put('url_sort', $result['url_sort']);
    }

    protected function filter(&$result){
        $filterData = Session::get('filter');
        if(!empty($filterData)){
            foreach($filterData as $key => $filter){
                 if(isset($result['list'][$key])){
                     $result['list'][$key]['filter']['value'] = $filter;
                 }
            }
        }

        foreach($result['list'] as $key => $value){
            $data = $this->request->get($key);
            if($this->request->get('submit')){
                $result['list'][$key]['filter']['value'] = $filterData[$key] = $data;
            }
        }
        Session::put('filter', $filterData);
    }

    protected function paginate(&$result, $paginate = null){
        if(!empty($paginate)){
            $result['paginate'] = $paginate;
        }else{
            $result['paginate'] = array('page' => 12);
        }
    }

    public function index(){
        $this->init($this->view);
        $this->view['data'] = $this->service->generateList($this->view);
        return view('Admin::Layouts.list', $this->view);
	}

    public function create(){
        return view('Admin::Layouts.insert', $this->view);
    }

    public function store(){
        $id = $this->service->addData($this->request, $this->view);
        if($this->request->get('submit')){
            return redirect(route($this->view['resource'].'.index'));
        }
        if($this->request->get('submit_edit')){
            return redirect(route($this->view['resource'].'.edit', [$id]));
        }

        return $id;
    }

    public function show($id){
        if($this->hookData === null){
            $this->view['data'] = $this->service->model->where(['id'=> $id])->first();
        }else{
            $this->view['data'] = $this->hookData;
        }
        //$this->view = $this->getDataReference($id, $this->view);

        return view('Admin::Layouts.insert', $this->view);
    }

    public function edit($id){
        if($this->hookData === null){
            $this->view['data'] = $this->service->model->where(['id'=> $id])->first();
        }else{
            $this->view['data'] = $this->hookData;
        }
        // $this->view = $this->getDataReference($id, $this->view);

        return view('Admin::Layouts.edit', $this->view);
    }

    public function update($id){
        // $this->view = $this->getDataReference($id, $this->view);
        $this->service->editData($this->request, $id, $this->view);
        if($this->request->get('submit')){
            if($this->request->get('back')){
                return redirect($this->request('back').Session::get('url_sort'));
            }else{
                return redirect(route($this->view['resource'].'.index').Session::get('url_sort'));
            }
        }
        if($this->request->get('submit_edit')){
            return redirect(route($this->view['resource'].'.edit', $id));
        }

        return $id;
    }

    public function destroy($id){
        return $this->service->deleteData($id, $this->view['form']);
    }

    public function getField($field, $id){
        return $this->service->model->select($field)->where(['id'=> $id])->first();
    }

    public function renderSelectByTable($data, $key = 'id', $val = 'name', $option = true){
        $render = [];
        if($option) $render[null] = self::CHOOSE;
        if(!empty($data)){
            foreach ($data as $value){
                if(isset($value[$key]) && isset($value[$val])){
                    $render[$value[$key]] = $value[$val];
                }
            }
        }
        return $render;
    }

    public function getDataTable($table, $where = null, $select = null){
        return $this->service->getDataTable($table, $where, $select);
    }

    /*private function getDataReference($id, $view){
        foreach ($view['form'] as $key => $val){
            if(isset($val['reference'])){
                if(isset($val['reference']['text'])){
                    switch ($val['reference']['text']){
                        case 'sequence':
                            $view['data'][$key] = $this->service->importModel($key)->where($val['reference']['primary_id'], $id)->orderby($val['reference']['text'],'asc')->get();
                            break;
                        default:
                            $view['data'][$key] = $this->service->importModel($key)->where($val['reference']['primary_id'], $id)->get();
                            break;
                    }
                }else{
                    $view['data'][$key] = $this->service->importModel($key)->where($val['reference']['primary_id'], $id)->get();
                }
                if(isset($val['remove_key']) && $val['remove_key']){
                    foreach ($val['data'] as $key => $value){
                        if($id == $value['id']){
                            unset($val['data'][$key]);
                        }
                    }
                }
            }
        }

        return $view;
    }*/
}
