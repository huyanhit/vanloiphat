<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = [
        'product_id',
        'service_id',
        'name',
        'rating',
        'content',
        'active'
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:00',
    ];
}
