<?php
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Services\PartnerService;
use Illuminate\Http\Request;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class PartnerController extends MyController
{
    public $form;
    public $service;
	function __construct(Request $request){
        parent::__construct($request, new PartnerService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = array(
            'title'       => array('title'=> 'Tiêu đề',    'type' => self::TEXT),
            'link'        => array('title'=> 'Link đối tác', 'type' => self::TEXT, 'validate' => 'max:255'),
            'image_id'    => array('title'=> 'Hình ảnh',   'type' => self::IMAGE_ID, 'validate' => 'required'),
            'index'       => array('title'=> 'Thứ tự hiển thị', 'type' => self::TEXT),
            'active'      => array('title'=> 'Trang thái', 'type' => self::CHECK)
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
                'title' => 'Tiêu đề',
                'width' => 10,
                'update'=> true,
                'views'  => array(
                    'type' => self::TEXT,
                ),
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                )
            ),
            'link' => array(
                'title' => 'Link đối tác',
                'width' => 10,
                'views'  => array(
                    'type' => self::TEXT,
                ),
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                )
            ),
            'image_id' => array(
                'title' => 'Hình Ảnh',
                'width' => 6,
                'views' => array(
                    'type' => self::IMAGE_ID,
                ),
                'sort' => 'hidden'
            ), 
            'active' => array(
                'title' => 'Active',
                'width' => 7,
                'update'=> true,
                'data' => array(null => self::CHOOSE , 0 => 'Không hiển thị', 1 => 'Hiển thị'),
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
