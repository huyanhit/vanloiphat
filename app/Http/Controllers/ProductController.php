<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartAddRequest;
use App\Models\Counter;
use App\Models\Partner;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Jackiedo\Cart\Cart;

class ProductController extends Controller
{
    public function index(){
        $categories = ProductCategory::where(['active' => 1])->get();
        $product   = Product::where(['active'=> 1])->orderby('created_at', 'ASC')->paginate(20);
        return view('product', array_merge($this->getDataLayout(), [
            'product'    => $product,
            'categories' => $categories,
            'partner'    => Partner::where(['active'=> 1])->orderby('index', 'DESC')->limit(8)->get(),
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
                $product->view = $product->view + 1;
                $product->save();
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

    public function productCategory(Request $request){
        $product = Product::select('id', 'title', 'price', 'image_id', 'product_category_id')->find($request->id);
        $query   = Product::select('id', 'title', 'price', 'image_id')
                        ->where('product_category_id', $product->product_category_id)
                        ->where('title', 'like', '%' . $request->search . '%')
                        ->where('id', '!=', $request->id)->limit(20);

        return ['product' => $product, 'list' => $query->get()];
    }
    public function compare($name, $name2 = null){
        $product  = [];
        $product2 = [];
        if(!empty($name)){
            $data = explode('-', $name);
            $id = end($data);
            if(is_numeric($id)){
                $product = Product::where(['active'=> 1,'id' => $id])->first();
            }
        }
        if(!empty($name2)){
            $data2 = explode('-', $name2);
            $id2 = end($data2);
            if(is_numeric($id2)){
                $product2 = Product::where(['active'=> 1,'id' => $id2])->first();
            }
        }
        return view('product-compare', array_merge($this->getDataLayout(), [
            'product' => $product,
            'product2'=> $product2,
            'meta' => [
                'title' => $product->title,
                'description' => $product->keywords .'| Mã '. $product->producer->title.' | Thương hiệu '.$product->sku,
                'keyword' => $product->keywords
            ]
        ]));
    }
    public function search(Request $request){
        $products = Product::where(['active'=> 1])
        -> where('sku', 'like', $request->get('tu_khoa') . '%')
        -> orwhere('keywords', 'like', '%' .  $request->get('tu_khoa') . '%')
        -> orWhere('title', 'like', '%' .  $request->get('tu_khoa') . '%')
        -> orderby('created_at', 'ASC')->paginate(10);

        return view('search', array_merge($this->getDataLayout(), [
            'products' => $products,
        ]));
    }
}
