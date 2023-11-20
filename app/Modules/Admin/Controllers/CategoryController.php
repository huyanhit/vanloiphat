<?php
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Services\CategoryService;
use App\Modules\Admin\Services\PageService;
use Illuminate\Http\Request;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class CategoryController extends MyController
{
    public $form;
    public $service;
	function __construct(Request $request){
        parent::__construct($request, new CategoryService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = array(
            'name'   => array('title'=> 'Tên', 'type' => self::TEXT, 'validate' => 'required|max:50'),
            'title'  => array('title'=> 'Tiều đề', 'type' => self::TEXT, 'validate' => 'required|max:50'),
            'index'  => array('title'=> 'Thứ tự', 'type' => self::TEXT),
            'active' => array('title'=> 'Trạng thái', 'type' => 'check')
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
            'name' => array(
                'title' => 'Tên',
                'width' => 10,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                )
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
