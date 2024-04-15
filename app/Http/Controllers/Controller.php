<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Menu;
use App\Models\ProductCategory;
use App\Models\Site;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;
use Illuminate\Tests\Integration\Database\EloquentHasManyThroughTest\Category;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function __construct()
    {
        $this->counter();
    }

    public function getDataLayout(){
        return [
            'sites'  => Site::find(1),
            'menus'  => Menu::where(['active' => 1])->orderby('index', 'ASC')->get(),
            'product_categories'  => ProductCategory::where(['active' => 1])->with(['subCategories', 'producers'])->orderby('index', 'ASC')->get()
        ];
    }
    private function counter(): void{
        $ip = $_SERVER['REMOTE_ADDR'];
        $counter = Counter::where('ip', $ip)->first();
        $dateTime = Carbon::now()->subMinutes(5)->format('Y-m-d H:i:s');
        if(empty($counter)){
            Counter::insert(['ip'=> $ip, 'created_at' => Carbon::now(), 'counter' => 1]);
        }elseif($counter->created_at > $dateTime){
            $counter->counter = $counter->counter + 1;
            $counter->save();
        }
    }
}
