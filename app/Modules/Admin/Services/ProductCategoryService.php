<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/12/2020
 * Time: 2:54 PM
 */

namespace App\Modules\Admin\Services;

use App\Modules\Admin\Models\ProductCategoryModel;

class ProductCategoryService extends Service{
    function __construct(){
        parent::__construct(new ProductCategoryModel());
    }
}