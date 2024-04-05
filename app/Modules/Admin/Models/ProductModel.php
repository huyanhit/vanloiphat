<?php

namespace  App\Modules\Admin\Models;

use App\Models\ProductOption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProductModel extends Model
{
    use SoftDeletes;
    protected $table = 'products';

    public function product_option(): HasMany
    {
        return $this->hasMany(ProductOptionModel::class,'product_id');
    }
}
