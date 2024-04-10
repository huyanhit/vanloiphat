<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartAddRequest;
use App\Models\Partner;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Jackiedo\Cart\Cart;

class ProductController extends Controller
{
    public function index(){
        $categores = ProductCategory::where(['active' => 1])->get();
        $product   = Product::where(['active'=> 1])->orderby('created_at', 'ASC')->paginate(20);
        return view('product', array_merge($this->getDataLayout(), [
            'product'   => $product,
            'categores' => $categores,
            'partner'   => Partner::where(['active'=> 1])->orderby('index', 'DESC')->limit(8)->get(),
        ]));
    }

    public function show($name){
        $data = explode('-', $name);
        if(!empty($data)){
            $id = end($data);
            if(is_numeric($id)){
                $product = Product::where(['active'=> 1,'id' => $id])->first();
                $c_product = Product::where(['active'=> 1,'product_category_id' =>
                $product->product_category_id])->whereNotIn('id', [$id])->orderby('created_at', 'ASC')->limit(20)->get();
                return view('product-content', array_merge($this->getDataLayout(), [
                    'product' => $product,
                    'c_product' =>  $c_product,
                    'meta' => [
                        'title' => $product->title,
                        'description' => $product->keywords .'| Mã '. $product->producer->title.' | Thương hiệu '.$product->sku,
                        'keyword' => $product->keywords
                    ]
                ]));
            }
        }
    }

    public function compare($name){
        $data = explode('-', $name);
        if(!empty($data)){
            $id = end($data);
            if(is_numeric($id)){
                $product = Product::where(['active'=> 1,'id' => $id])->first();
                $c_product = Product::where(['active'=> 1,'product_category_id' =>
                    $product->product_category_id])->whereNotIn('id', [$id])->orderby('created_at', 'ASC')->limit(20)->get();
                return view('product-compare', array_merge($this->getDataLayout(), [
                    'product' => $product,
                    'c_product' =>  $c_product,
                    'meta' => [
                        'title' => $product->title,
                        'description' => $product->keywords .'| Mã '. $product->producer->title.' | Thương hiệu '.$product->sku,
                        'keyword' => $product->keywords
                    ]
                ]));
            }
        }
    }

    public function search(Request $request){
        $products = Product::where(['active'=> 1])
        -> where('sku', 'like', $request->input('keyword') . '%')
        -> orwhere('keywords', 'like', '%' .  $request->input('keyword') . '%')
        -> orWhere('title', 'like', '%' .  $request->input('keyword') . '%')
        -> orderby('created_at', 'ASC')->paginate(10);

        return view('search', array_merge($this->getDataLayout(), [
            'products' => $products,
        ]));
    }
}
