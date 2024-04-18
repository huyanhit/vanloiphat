<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function comment(CommentRequest $request){
        $data = [
            'product_id'    => $request?->product_id,
            'service_id'    => $request?->service_id,
            'name'          => $request->name,
            'rating'        => $request->rating,
            'content'       => $request->get('content'),
            'active'        => 1
        ];
        $comment = Comment::create($data);
        if($comment && $request->ajax()){
            return $comment;
        }

        abort('404');
    }

    public function loadComment(Request $request){
        $productId = $request->product_id;
        $serviceId = $request->service_id;
        if(isset($productId)){
            $comments = Comment::where('product_id', $productId)->where('active', 1)->paginate(10);
        }elseif(isset($serviceId)){
            $comments = Comment::where('service_id', $serviceId)->where('active', 1)->paginate(10);
        }
        if(!empty($comments) && $request->ajax()){
            return $comments;
        }

        abort('404');
    }
}
