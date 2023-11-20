<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Site;

class CategoryProductController extends Controller
{
    public function show($name){
        $categores = ProductCategory::where(['active' => 1])->get();
        $category = ProductCategory::where(['name' => $name, 'active' => 1])->first();
        if(!empty($category)){
            $product = Product::where(['product_category_id'=> $category->id, 'active'=> 1])->orderby('created_at', 'ASC')->paginate(16);
            return view('category-product', array_merge($this->getDataLayout(), [
                'categores' => $categores,
                'product' => $product,
                'partner'   => Partner::where(['active'=> 1])->orderby('index', 'DESC')->limit(8)->get(),
            ]));
        }
       
        redirect('404');
    }
}
