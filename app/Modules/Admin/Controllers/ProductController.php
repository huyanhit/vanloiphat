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
            'producer_id' => array(
                'title'=> 'Nhà sản xuất',
                'data' => $this->renderSelectByTable($this->getDataTable('producers', ['active' => 1], null), 'id', 'title'),
                'type' => self::SELECT,
                'validate' => 'required'
            ),


            'sku'          => array('title'=> 'Mã hàng hóa', 'type' => self::TEXT, 'validate' => 'max:50'),
            'title'        => array('title'=> 'Tên', 'type' => self::TEXT, 'validate' => 'required|max:255'),
            'keywords'     => array('title'=> 'Từ khóa Seo sản phẩm', 'type' => self::TEXT, 'validate' => 'max:1000'),

            'image_id'     => array('title'=> 'Hình chính', 'type' => self::IMAGE_ID),
            'images'       => array('title'=> 'Hình phụ', 'type' => self::IMAGES),

            'description'  => array('title'=> 'Thông số kỹ thuật', 'type' => self::AREA),
            'content'      => array('title'=> 'Chi tiết', 'type' => self::AREA),

            'company_offer'  => array('title'=> 'Ưu đãi từ Công Ty', 'type' => self::AREA),
            'producer_offer' => array('title'=> 'Ưu đãi từ Hãng', 'type' => self::AREA),

            'is_new'       => array('title'=> 'Sản phẩm mới', 'type' => self::CHECK, 'validate' => 'numeric|max:1'),
            'is_promotion' => array('title'=> 'Khuyến mãi', 'type' => self::CHECK, 'validate' => 'numeric|max:1'),
            'is_hot'       => array('title'=> 'Bán chạy', 'type' => self::CHECK, 'validate' => 'numeric|max:1'),

            'price_root'   => array('title'=> 'Giá nhập', 'type' => self::TEXT, 'validate' => 'nullable|numeric'),
            'price_pro'    => array('title'=> 'Giá nhà sản xuất', 'type' => self::TEXT, 'validate' => 'nullable|numeric'),
            'price'        => array('title'=> 'Giá bán', 'type' => self::TEXT, 'validate' => 'nullable|numeric'),
            'product_option' => array('title'=> 'Thêm lựa chọn', 'type' => self::HAS_MANY, 'update' => ['group_title', 'title', 'price']),

            'instalment'   => array('title'=> 'Cho trả góp', 'type' => self::CHECK),
            'active'       => array('title'=> 'Cho hiển thị', 'type' => 'check')
        );

        $this->view['list'] = array(
            'sku'  => array(
                'title' => 'Mã hàng hóa',
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
                'update'=> true,
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
                'update'=> true,
                'views' => array(
                    'type' => self::IMAGE_ID,
                ),
                'sort' => 'hidden'
            ),
            'is_new'  => array(
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
            'is_promotion'  => array(
                'title'=> 'Khuyến mãi',
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
            'is_hot'  => array(
                'title'=> 'Bán chạy',
                'width' => 5,
                'update'=> true,
                'views' => array(
                    'type' => self::CHECK,
                ),
                'filter' => array(
                    'type' => self::CHECK,
                    'value' => '',
                ),
            ),
            'price'  => array(
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
                'title' => 'Hiển thị',
                'width' => 5,
                'update'=> true,
                'data' => array(null => self::CHOOSE , 0 => 'Ẩn', 1 => 'Hiển thị'),
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
