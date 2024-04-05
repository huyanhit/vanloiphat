<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Partner;
use App\Models\Producer;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Service;
use App\Models\Site;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index(){
        return view('home', array_merge($this->getDataLayout(),[
            'slider'    => Slider::where(['active'=> 1])->orderby('index', 'DESC')->get(),
            'hot'       => Product::where(['active'=> 1,'is_hot' => true])->orderby('created_at', 'ASC')->limit(10)->get(),
            'promotion' => Product::where(['active'=> 1,'is_promotion' => true])->orderby('created_at', 'ASC')->limit(10)->get(),
            'new'       => Product::where(['active'=> 1,'is_new' => true])->orderby('created_at', 'ASC')->limit(5)->get(),
            'service'   => Service::where(['active'=> 1])->orderby('index', 'DESC')->limit(10)->get(),
            'partner'   => Producer::where(['active'=> 1])->orderby('index', 'DESC')->limit(10)->get(),
        ]));
    }

    public function counter(){
        $counterModel = new Counter();
        $ip = $_SERVER['REMOTE_ADDR'];
        if(empty($counterModel::where('ip', $ip)->first())){
            $counterModel->insertGetId(['ip'=> $ip, 'created_at' => Carbon::now()]);
        }else{
            $dateTime = Carbon::now()->subMinutes(5)->format('Y-m-d H:i:s');
            if(!$counterModel::where('ip', $ip)->where('created_at', '>', $dateTime)->count()){
                $counterModel->insertGetId(['ip'=> $ip, 'created_at' => Carbon::now()]);
            }
        }

        return true;
    }
}
