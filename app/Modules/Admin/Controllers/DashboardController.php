<?php
namespace App\Modules\Admin\Controllers;

use App\Models\Partner;
use App\Models\ProductCategory;
use App\Modules\Admin\Models\ContactModel;
use App\Modules\Admin\Models\CounterModel;
use App\Modules\Admin\Models\MenuModel;
use App\Modules\Admin\Models\NewsModel;
use App\Modules\Admin\Models\OrderModel;
use App\Modules\Admin\Models\OrderProductModel;
use App\Modules\Admin\Models\PageModel;
use App\Modules\Admin\Models\PartnerModel;
use App\Modules\Admin\Models\ProductCategoryModel;
use App\Modules\Admin\Models\ProductModel;
use App\Modules\Admin\Models\ServiceModel;
use App\Modules\Admin\Models\SiteModel;
use App\Modules\Admin\Models\SliderModel;
use App\Modules\Admin\Models\UserModel;
use App\Modules\Admin\Services\DashboardService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class DashboardController extends MyController
{
    function __construct(Request $request){
        parent::__construct($request, new DashboardService());
    }

    public function index(){
        $page = PageModel::count();
        return view('Admin::Layouts.dashboard', [
            'data'=>[
                [
                    'title'      => 'Loại sản phẩm',
                    'link'       => '/admin/product-categories',
                    'icon'       => '',
                    'background' => '#ddd',
                    'page'       =>  ProductCategoryModel::count(),
                    'active'     =>  ProductCategoryModel::where('active', '1')->count(),
                ],
                [
                    'title'      => 'Sản phẩm',
                    'link'       => '/admin/products',
                    'icon'       => '',
                    'background' => '#ddd',
                    'page'       =>  ProductModel::count(),
                    'active'     =>  ProductModel::where('active', '1')->count(),

                ],
                [
                    'title'      => 'Đơn hàng',
                    'link'       => '/admin/orders',
                    'icon'       => '',
                    'background' => '#ddd',
                    'page'       =>  OrderModel::count(),
                    'process'    =>  OrderModel::where('order_status_id', '>', '3')->count(),
                ],
                [
                    'title'      => 'Liên hệ',
                    'link'       => '/admin/contacts',
                    'icon'       => '',
                    'background' => '#ddd',
                    'page'       =>  ContactModel::count(),
                    'process'     =>  ContactModel::where('active', '1')->count(),
                ],
                [
                    'title'      => 'Trang',
                    'link'       => '/admin/pages',
                    'icon'       => '',
                    'background' => '#ddd',
                    'page'       =>  PageModel::count(),
                    'active'     =>  PageModel::where('active', '1')->count(),
                ],
                [
                    'title'      => 'Dịch vụ',
                    'link'       => '/admin/services',
                    'icon'       => '',
                    'background' => '#ddd',
                    'page'       =>  ServiceModel::count(),
                    'active'     =>  ServiceModel::where('active', '1')->count(),
                ],
                [
                    'title'      => 'Đối tác',
                    'link'       => '/admin/partners',
                    'icon'       => '',
                    'background' => '#ddd',
                    'page'       =>  PartnerModel::count(),
                    'active'     =>  PartnerModel::where('active', '1')->count(),
                ],
                [
                    'title'      => 'Tài khoản',
                    'link'       => '/admin/users',
                    'icon'       => '',
                    'background' => '#ddd',
                    'page'       =>  UserModel::count(),
                    'active'     =>  UserModel::where('active', '1')->count(),
                ],
                [
                    'title'      => 'Slider',
                    'link'       => '/admin/sliders',
                    'icon'       => '',
                    'background' => '#ddd',
                    'page'       =>  SliderModel::count(),
                    'active'     =>  SliderModel::where('active', '1')->count(),
                ],
                [
                    'title'      => 'Menu',
                    'link'       => '/admin/menus',
                    'icon'       => '',
                    'background' => '#ddd',
                    'page'       =>  MenuModel::count(),
                    'active'     =>  MenuModel::where('active', '1')->count(),
                ],
                [
                    'title'      => 'Website',
                    'link'       => '/admin/sites/1/edit',
                    'icon'       => '',
                    'background' => '#ddd',
                    'page'       =>  SiteModel::count(),
                    'active'     =>  SiteModel::where('id', '1')->count(),
                ],
            ],
            'counter' => [
                'online'=> CounterModel::where('created_at', '>', Carbon::now()->subMinutes(5)->format('Y-m-d H:i:s'))->count(),
                'today' => CounterModel::whereDate('created_at', Carbon::now())->count(),
                'total' => CounterModel::count(),
            ],
            'size' => [
                'upload' => $this->getFileSize(),
            ]
        ]);
    }

    private function getFileSize(){
        $file_size = 0;
        foreach(File::allFiles(storage_path()) as $file){
                $file_size += $file->getSize();
        }

        return $file_size;
    }
}
