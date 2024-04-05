<?php

namespace App\Http\Controllers;

use App\Filters\ProductFilter;
use App\Models\Partner;
use App\Models\Producer;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProducerController extends Controller
{
    public function show(Request $request, $name){
        $producer = Producer::where(['name' => $name, 'active' => 1])->first();
        if(!empty($producer)){
            $product = Product::where(['producer_id'=> $producer->id, 'active'=> 1])
                ->filter(new ProductFilter($request))
                ->orderby('created_at', 'ASC')->paginate(20);

            return view('producer', array_merge($this->getDataLayout(), [
                'producer' => $producer,
                'product'  => $product,
                'meta'     => collect([
                    'title' => $producer->title,
                    'description' => $producer->title,
                    'keyword' => $producer->title
                ])
            ]));
        }

        redirect('404');
    }
}
