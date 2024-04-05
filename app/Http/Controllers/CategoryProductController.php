<?php

namespace App\Http\Controllers;

use App\Filters\ProductFilter;
use App\Models\Partner;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CategoryProductController extends Controller
{
    public function show(Request $request, $name){
        $category = ProductCategory::where(['name' => $name, 'active' => 1])->first();
        if(!empty($category)){
            $product = Product::where(['product_category_id'=> $category->id, 'active'=> 1])
                ->filter(new ProductFilter($request))
                ->orderby('created_at', 'ASC')->paginate(20);

            return view('category-product', array_merge($this->getDataLayout(), [
                'category' => $category,
                'product'  => $product,
                'partner'  => Partner::where(['active'=> 1])->orderby('index', 'DESC')->limit(8)->get(),
                'meta'     => collect([
                    'title' => $category->title,
                    'description' => $category->title,
                    'keyword' => $category->title
                ])
            ]));
        }

        redirect('404');
    }
}
