<?php
namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Services\ProductService;
use Illuminate\Http\Request;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class ProductController extends MyController
{
    public $form;
    public $service;
	function __construct(Request $request){
        parent::__construct($request, new ProductService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = array(
            'product_category_id' => array(
                'title'=> 'Loại', 
                'data' => $this->renderSelectByTable($this->getDataTable('product_categories', ['active' => 1], null), 'id', 'title'),
                'type' => self::SELECT, 
                'validate' => 'required'
            ),
            'code'         => array('title'=> 'Mã', 'type' => self::TEXT, 'validate' => 'max:50'),
            'title'        => array('title'=> 'Tên', 'type' => self::TEXT, 'validate' => 'required|max:255'),
            'image_id'     => array('title'=> 'Hình', 'type' => self::IMAGE_ID),
            'description'  => array('title'=> 'Mô tả ngắn', 'type' => self::AREA, 'validate' => 'max:1000'),
            'keywords'     => array('title'=> 'Từ khóa tìm kiếm', 'type' => self::TEXT, 'validate' => 'max:1000'),
            'content'      => array('title'=> 'Chi tiết', 'type' => self::AREA),
            'new'          => array('title'=> 'Sản phẩm mới', 'type' => self::TEXT, 'validate' => 'numeric|max:1'),
            'promotion'    => array('title'=> 'Khuyến mãi', 'type' => self::TEXT, 'validate' => 'numeric|max:1'),
            'hot'          => array('title'=> 'Bán chạy', 'type' => self::TEXT, 'validate' => 'numeric|max:1'),
            'price'        => array('title'=> 'Giá gốc', 'type' => self::TEXT, 'validate' => 'numeric|max:11'),
            'price_sale'   => array('title'=> 'Giá bán', 'type' => self::TEXT, 'validate' => 'numeric|max:11'),
            'active'       => array('title'=> 'Trạng thái', 'type' => 'check')
        );

        $this->view['list'] = array(
            'code'  => array(
                'title'=> 'Mã',    
                'width' => 3,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'product_category_id'  => array(
                'title'=> 'Loại',    
                'width' => 10,
                'data' => $this->renderSelectByTable($this->getDataTable('product_categories', ['active' => 1], null), 'id', 'title'),
                'views' => array(
                    'type' => self::SELECT ,
                ),
                'filter' => array(
                    'type' => self::SELECT,
                    'value' => '',
                ),
            ),
            
            'title'  => array(
                'title'=> 'Tên',    
                'width' => 10,
                'update'=> true,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'image_id' => array(
                'title' => 'Hình Ảnh',
                'width' => 6,
                'views' => array(
                    'type' => self::IMAGE_ID,
                ),
                'sort' => 'hidden'
            ), 
            'new'  => array(
                'title'=> 'Mới',    
                'width' => 5,
                'update'=> true,
                'views' => array(
                    'type' => self::CHECK ,
                ),
                'filter' => array(
                    'type' => self::CHECK,
                    'value' => '',
                ),
            ),
            'promotion'  => array(
                'title'=> 'Khuyến mãi',    
                'width' => 5,
                'update'=> true,
                'views' => array(
                    'type' => self::CHECK ,
                ),
                'update'=> true,
                'filter' => array(
                    'type' => self::CHECK,
                    'value' => '',
                ),
            ),
            'hot'  => array(
                'title'=> 'Bán chạy',    
                'width' => 5,
                'update'=> true,
                'views' => array(
                    'type' => self::CHECK ,
                ),
                'filter' => array(
                    'type' => self::CHECK,
                    'value' => '',
                ),
            ),
            'price'  => array(
                'title'=> 'Giá gốc',    
                'width' => 5,
                'views' => array(
                    'type' => self::TEXT ,
                ),
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'price_sale'  => array(
                'title'=> 'Giá bán',    
                'width' => 5,
                'views' => array(
                    'type' => self::TEXT ,
                ),
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'active' => array(
                'title' => 'Trạng thái',
                'width' => 5,
                'update'=> true,
                'data' => array(null => self::CHOOSE , 0 => 'UnActive', 1 => 'Active'),
                'views' => array(
                    'type' => self::CHECK ,
                ),
                'filter' => array(
                    'type' => 'select',
                    'value' => '',
                ),
            )
        );
	}
}
