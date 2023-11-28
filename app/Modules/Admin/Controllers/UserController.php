<?php
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Services\UserService;
use Illuminate\Http\Request;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class UserController extends MyController
{
    function __construct(Request $request)
	{
        parent::__construct($request, new UserService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = array(
            'name' => array('title'=> 'Tên', 'type' => self::TEXT, 'validate' => 'max:255'),
            'email' => array('title'=> 'Email', 'type' => self::TEXT, 'validate' => 'required|email|max:255'),
            'password' => array('title'=> 'Mật khẩu', 'type' => self::PASSWORD, 'validate' => 'required|max:255'),
            'confirm' => array('title'=> 'Nhập lại mật khẩu', 'type' => self::CONFIRM, 'validate' => 'required|same:password|max:255'),
            'image_id' => array('title'=> 'Image', 'type' => self::IMAGE_ID),
            'active' => array('title'=>'Trạng thái', 'type' => 'check')
        );
        $this->view['list'] = array(
            'name' => array(
                'title' => 'Tên',
                'width' => 20,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'image_id' => array(
                'title' => 'Hình ảnh',
                'width' => 6,
                'views' => array(
                    'type' => self::IMAGE_ID,
                ),
                'sort' => 'hidden'
            ),
            'email' => array(
                'title' => 'Email',
                'width' => 20,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'active' => array(
                'title' => 'Trạng thái',
                'width' => 7,
                'update'=> true,
                'data'  => array(null => self::CHOOSE , 0 => 'Khóa', 1 => 'Mở'),
                'views' => array(
                    'type' => self::CHECK ,
                ),
                'filter' => array(
                    'type' => self::SELECT,
                    'value' => '',
                ),
            )
        );
	}

}
