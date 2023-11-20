<?php
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Services\PostService;
use Illuminate\Http\Request;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class PostController extends MyController
{
    public $form;
    public $service;
	function __construct(Request $request){
        parent::__construct($request, new PostService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = array(
            'title'       => array('title'=> 'Tiêu đề', 'type' => self::TEXT, 'validate' => 'required|max:50'),
            'category_id' => array('title'=> 'Loại tin', 'type' => self::AREA, 'validate' => 'required'),
            'description' => array('title'=> 'Mô tả', 'type' => self::TEXT, 'validate' => 'max:255'),
            'content'     => array('title'=> 'Nội dung', 'type' => self::TEXT),
            'image_id'    => array('title'=> 'Hình ảnh', 'type' => self::IMAGE_ID),
            'active'      => array('title'=> 'Trang thái', 'type' => self::CHECK)
        );

        $this->view['list'] = array(
            'title' => array(
                'title' => 'Tiêu đề',
                'width' => 10,
                'update'=> true,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                )
            ),
            'category_id' => array(
                'title'=> 'Loại tin',  
                'width' => 10, 
                'data' => $this->renderSelectByTable($this->getDataTable('categories', ['active' => 1], null)),
                'views' => array(
                    'type' => self::SELECT
                ),
                'filter' => array(
                    'type' => self::SELECT,
                    'value' => '',
                )
            ),
            'description' => array(
                'title'=> 'Mô tả',  
                'width' => 10,
                'update'=> true,
                'views' => array(
                    'type' => self::AREA
                ),
                'filter' => array(
                    'type' => self::AREA,
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
