<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Site;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function getDataLayout(){
        return [
            'sites'  => Site::find(1),
            'menus'  => Menu::where(['active' => 1])->orderby('index', 'DESC')->get()
        ];
    }
}
