<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartAddRequest;
use App\Models\Product;
use http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Jackiedo\Cart\Cart;
use Psy\Util\Json;

class CartController extends Controller
{
    protected $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
        $this->cart->name('main');
    }

    public function index():JsonResponse {
        return response()->json($this->cart->getDetails());
    }

    public function show($id):JsonResponse {
        return response()->json($this->cart->getItem($id));
    }

    public function update(Request $request, $id):JsonResponse {
        $this->cart->updateItem($id, [
            'quantity'  => $request->quantity,
        ]);
        return response()->json($this->cart->getDetails());
    }

    public function store(CartAddRequest $request):JsonResponse {
        $product = Product::where('active', 1)->find($request->id);
        if(!empty($product)){
            $this->cart->addItem([
                'id'       => $product->id,
                'title'    => empty($product->title)? 'No name': $product->title,
                'price'    => $product->price,
                'quantity' => $request->quantity,
                'options'  => $request->option?? [],
                'extra_info' =>  [
                    'image_id'  => $product->image_id,
                ],
            ]);
        }

        return response()->json($this->cart->getDetails());
    }

    public function destroy($id):JsonResponse{
        return response()->json($this->cart->removeItem($id)->getDetails());
    }

    public function clear():JsonResponse{
        return response()->json($this->cart->clearItems());
    }
}
