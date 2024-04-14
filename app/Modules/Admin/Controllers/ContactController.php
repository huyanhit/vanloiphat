<?php
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Services\ContactService;
use Illuminate\Http\Request;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class ContactController extends MyController
{
	function __construct(Request $request){
        parent::__construct($request, new ContactService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = array(
            'name' => array('title'=> 'Tên', 'type' =>  self::TEXT, 'validate' => 'max:50'),
            'phone' => array('title'=> 'Điện thoại', 'type' =>  self::TEXT, 'validate' => 'max:50'),
            'email' => array('title'=> 'Email', 'type' =>  self::TEXT, 'validate' => 'max:255'),
            'address' => array('title'=> 'Địa chỉ', 'type' =>  self::TEXT, 'validate' => 'max:255'),
            'content' => array('title'=> 'Lời nhắn', 'type' =>  self::AREA, 'validate' => 'max:2000'),
            'active' => array('title' => 'Trang thái', 'data'=> array(1 => 'Đã xem', 0 => 'Chưa xem'), 'type' =>  self::CHECK)
        );
        $this->view['list'] = array(
            'name' => array(
                'title' => 'Tên',
                'width' => 10,
                'filter' => array(
                    'type' =>  self::TEXT,
                    'value' => '',
                ),
            ),
            'phone' => array(
                'title' => 'Điện thoại',
                'width' => 10,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'email' => array(
                'title' => 'Email',
                'width' => 10,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'content' => array(
                'title' => 'Lời nhắn',
                'width' => 20,
                'views' => array(
                    'type' => self::AREA
                ),
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'active' => array(
                'title' => 'Trang thái',
                'width' => 7,
                'data' => array(1 => 'Đã xem', 0 => 'Chưa xem'),
                'update' => true,
                'views' => array(
                    'type' => self::CHECK,
                ),
                'filter' => array(
                    'type' => self::SELECT,
                    'value' => '',
                )
            )
        );
	}
}
