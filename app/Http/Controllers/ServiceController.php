<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Site;

class ServiceController extends Controller
{
    public function index(){
        return view('service', array_merge($this->getDataLayout(), [
            'service' => Service::where(['active'=> 1])->orderby('index', 'DESC')->paginate(16),
            'top' => Service::where(['active'=> 1])->orderby('index', 'DESC')->limit(8)->get(),
        ]));
    }

    public function show($name){
        $data = explode('-', $name);
        if(!empty($data)){
            $id = end($data);
            if(is_numeric($id)){
                $service = Service::where(['active'=> 1,'id' => $id])->first();
                return view('service-content', array_merge($this->getDataLayout(), [
                    'service' => $service,
                ]));
            }
        }

        redirect('404');
    }
}
