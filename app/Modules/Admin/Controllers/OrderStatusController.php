<?php
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Services\OrderStatusService;
use Illuminate\Http\Request;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class OrderStatusController extends MyController
{
    public $form;
    public $service;
	function __construct(Request $request){
        parent::__construct($request, new OrderStatusService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = array(
            'title'   => array('title'=> 'Tiều đề', 'type' => self::TEXT, 'validate' => 'required|max:50'),
            'icon'    => array('title'=> 'Icon', 'type' => self::TEXT),
            'image_id'=> array('title'=> 'Hinh ảnh', 'type' => self::IMAGE_ID),
            'index'   => array('title'=> 'Thứ tự', 'type' => self::TEXT),
            'active'  => array('title'=> 'Trạng thái', 'type' => 'check')
        );

        $this->view['list'] = array(
            'index'  => array(
                'title'=> 'Thứ tự hiển thị',
                'width' => 3,
                'update'=> true,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'title' => array(
                'title'=> 'Tiều đề',
                'width' => 10,
                'update'=> true,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                )
            ),
            'active' => array(
                'title' => 'Trạng thái',
                'width' => 7,
                'update'=> true,
                'data' => array(null => self::CHOOSE , 0 => 'UnActive', 1 => 'Active'),
                'views' => array(
                    'type' => self::CHECK,
                ),
                'filter' => array(
                    'type' => 'select',
                    'value' => '',
                ),
            )
        );
	}
}
