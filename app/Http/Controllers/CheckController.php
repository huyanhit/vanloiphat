<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\Request;
use Illuminate\Http\JsonResponse;
use Jackiedo\Cart\Cart;

class CheckController extends Controller
{
    public function index(){
        return view('check', array_merge($this->getDataLayout(), []));
    }
}
