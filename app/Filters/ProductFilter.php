<?php

namespace App\Filters;

class ProductFilter extends QueryFilter
{
    protected $filterable = [
        'id',
        'author_id',
    ];

    public function filterTitle($name)
    {
        return $this->builder->where('title', 'like', '%' . $name . '%');
    }
    public function filterSKU($sku)
    {
        return $this->builder->where('sku', 'like', $sku . '%');
    }

    public function filterPrice($option)
    {
        return match ($option) {
            '1' => $this->builder->where('price','<','1000000'),
            '2' => $this->builder->whereBetween('price', ['1000000', '5000000']),
            '3' => $this->builder->whereBetween('price', ['5000000', '10000000']),
            '4' => $this->builder->where('price', '>', '1000000'),
            default => $this->builder
        };
    }

}
