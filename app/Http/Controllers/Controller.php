<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\ProductCategory;
use App\Models\Site;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Tests\Integration\Database\EloquentHasManyThroughTest\Category;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function getDataLayout(){
        return [
            'sites'  => Site::find(1),
            'menus'  => Menu::where(['active' => 1])->orderby('index', 'ASC')->get(),
            'product_categories'  => ProductCategory::where(['active' => 1])->with(['subCategories', 'producers'])->orderby('index', 'ASC')->get()
        ];
    }
}
