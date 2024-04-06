<?php
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Services\OrderService;
use Illuminate\Http\Request;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class OrderController extends MyController
{
    public $form;
    public $service;
	function __construct(Request $request){
        parent::__construct($request, new OrderService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = array(
            'sex' => array('title'=> 'Giới tính',
                'data'=> array(1 => 'Anh', 2 => 'Chị'), 'type' =>  self::SELECT),
            'name' => array('title'=> 'Tên khách', 'type' => self::TEXT, 'validate' => 'required|max:255'),
            'phone' => array('title'=> 'Điện thoại khách', 'type' => self::TEXT, 'validate' => 'required|max:50'),
            'note' => array('title'=> 'Ghi chú', 'type' => self::AREA, 'validate' => 'required'),
            'address' => array('title'=> 'Địa chỉ giao hàng', 'type' => self::TEXT, 'validate' => 'required|max:1000'),
            'ship_type' => array('title'=> 'Cách giao hàng',
                'data'=> array(1 => 'Giao tại nhà', 2 => 'Lắp đặt tại nhà', 3 => 'Khách tự lấy hàng'), 'type' =>  self::SELECT),
            'order_status_id' => array(
                'title'=> 'Trang thái đơn hàng',
                'data' => $this->renderSelectByTable(
                    $this->getDataTable('order_statuses', ['active' => 1], null), 'id', 'title'),
                'type' => self::SELECT,
                'validate' => 'required'
            ),
        );

        $this->view['list'] = array(
            'name' => array(
                'width' => 3,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'address' => array(
                'width' => 5,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'phone' => array(
                'width' => 3,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'order_status_id' => array(
                'title'=> 'Trang thái đơn hàng',
                'width' => 3,
                'update'=> true,
                'filter' => array(
                    'type' => self::SELECT,
                    'value' => '',
                ),
                'data' => $this->renderSelectByTable(
                    $this->getDataTable('order_statuses', ['active' => 1], null), 'id', 'title'),
                'views' => array(
                    'type' => self::SELECT ,
                ),
            ),
        );
	}
}
