<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model 
{
    use SoftDeletes;
    protected $softDelete = true;
    protected $table = 'partners';
}
