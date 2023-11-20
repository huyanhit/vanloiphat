<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Site;
use App\Models\Slider;

class NewsController extends Controller
{
    public function index(){
        return view('news', array_merge($this->getDataLayout(), [
            'slider' => Slider::where(['active'=> 1])->orderby('index', 'DESC')->get(),
            'news' => News::where(['active'=> 1])->orderby('created_at', 'ASC')->paginate(16),
        ]));
    }

    public function show($name){
        $data = explode('-', $name);
        if(!empty($data)){
            $id = end($data);
            if(is_numeric($id)){
                $service = News::where(['active'=> 1,'id' => $id])->first();
                return view('news-content', array_merge($this->getDataLayout(), [
                    'news' => $service,
                ]));
            }
        }

        redirect('404');
    }
}
