<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Order;
use Carbon\Carbon;

class CommentController extends Controller
{
    public function comment(CommentRequest $request){
        $data = [
            'product_id'    => $request?->product_id,
            'service_id'    => $request?->service_id,
            'name'          => $request->name,
            'rating'        => $request->rating,
            'content'       => $request->get('content')
        ];
        $comment = Comment::insertGetId($data);
        if($comment && $request->ajax()){
            return Comment::find($comment);
        }

        abort('404');
    }
}
