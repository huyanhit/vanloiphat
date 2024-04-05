<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Tests\Integration\Database\EloquentHasManyThroughTest\Category;

class Product extends Model
{
    use SoftDeletes, Filterable;
    protected $softDelete = true;
    protected $table = 'products';

    protected $hidden = [
       'price_root'
    ];

    protected $casts =[
        'is_hot'=> 'boolean',
        'is_promotion'=> 'boolean',
        'is_new'=> 'boolean'
    ];

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function producer(): BelongsTo
    {
        return $this->belongsTo(Producer::class, 'producer_id');
    }

    public function product_option(): HasMany
    {
        return $this->hasMany(ProductOption::class, 'product_id');
    }
}
