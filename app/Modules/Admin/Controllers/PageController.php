<?php
namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Services\PageService;
use Illuminate\Http\Request;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class PageController extends MyController
{
	function __construct(Request $request){
        parent::__construct($request, new PageService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = array(
            'title' => array('title'=> 'Tên trang', 'type' => self::TEXT, 'validate' => 'required|max:255'),
            'router' => array('title'=> 'Đường dẫn', 'type' => self::TEXT, 'validate' => 'required||max:255'),
            'meta' => array('title'=> 'Meta SEO', 'type' => self::TEXT,'validate' =>'max:1000'),
            'description' => array('title'=> 'Mô tả', 'type' => self::AREA,'validate' =>'max:1000'),
            'content' => array('title'=> 'Nôi dung', 'type' => self::AREA),
            'active' => array('title'=>'Active', 'type' => 'check', 'value'=>true )
        );
        $this->view['list'] = array(
            'title' => array(
                'title' => 'Tên trang',
                'width' => 10,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'router' => array(
                'title' => 'Đường dẫn',
                'width' => 10,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'description' => array(
                'title' => 'Mô tả',
                'width' => 10,
                'filter' => array(
                    'type' => self::AREA,
                    'value' => '',
                ),
            ),
            'active' => array(
                'title'  => 'Active',
                'width'  => 7,
                'data'   => array(null => self::CHOOSE , 0 => 'UnActive', 1 => 'Active'),
                'update' => true,
                'views'  => array(
                    'type' => self::CHECK ,
                ),
                'filter' => array(
                    'type'  => 'select',
                    'value' => '',
                ),
            )
        );
	}
}
