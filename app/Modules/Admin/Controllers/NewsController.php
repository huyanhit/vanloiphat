<?php
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Services\NewsService;
use Illuminate\Http\Request;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class NewsController extends MyController
{
    public $form;
    public $service;
	function __construct(Request $request){
        parent::__construct($request, new NewsService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = array(
            'title'        => array('title'=> 'Tiêu đề', 'type' => self::TEXT, 'validate' => 'required|max:255'),
            'image_id'     => array('title'=> 'Hình ảnh', 'type' => self::IMAGE_ID),
            'description'  => array('title'=> 'Mô tả ngắn', 'type' => self::AREA, 'validate' => 'max:1000'),
            'content'      => array('title'=> 'Nội dung', 'type' => self::AREA),
            'active'       => array('title'=> 'Trạng thái', 'type' => 'check')
        );
        $this->view['list'] = array(
            'title'  => array(
                'title'=> 'Tiêu đề',    
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
            'description'  => array(
                'title'=> 'Mô tả ngắn',    
                'width' => 10,
                'filter' => array(
                    'type' => self::AREA,
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
