<?php
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Services\ProductOptionService;
use Illuminate\Http\Request;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class ProductOptionController extends MyController
{
    function __construct(Request $request)
	{
        parent::__construct($request, new ProductOptionService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = array(
            'product_id' => array('title'=> 'Sản phẩm', 'type' => 'hidden', 'validate' => 'required'),
            'title' => array('title'=> 'Tên', 'type' => self::TEXT, 'validate' => 'required'),
            'group_title' => array('title'=> 'Tên', 'type' => self::TEXT, 'validate' => 'required'),
            'price' => array('title'=> 'Mật khẩu', 'type' => self::TEXT, 'validate' => 'sometimes|numeric'),
        );
        $this->view['list'] = array(
            'title' => array(
                'title' => 'Tên',
                'width' => 20,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'group_title' => array(
                'title' => 'Tên nhóm',
                'width' => 20,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'price' => array(
                'title' => 'Giá',
                'width' => 6,
                'views' => array(
                    'type' => self::TEXT,
                ),
            ),
        );
	}

}
