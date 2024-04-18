<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
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

    protected $appends = ['slug'];

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function getSlugAttribute()
    {
        return Str::slug($this->title).'-'.$this->id;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function producer(): BelongsTo
    {
        return $this->belongsTo(Producer::class, 'producer_id');
    }

    public function comment(): HasMany
    {
        return $this->hasMany(Comment::class, 'product_id');
    }

    public function product_option(): HasMany
    {
        return $this->hasMany(ProductOption::class, 'product_id')->select('product_option.id','product_option.group_title','product_option.title','product_option.price');
    }
}
