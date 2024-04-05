<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOptionModel extends Model
{
    use HasFactory;
    protected $table = 'product_option';

    protected $fillable=[
        'group_title',
        'title',
        'price'
    ];
}
