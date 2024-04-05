<?php
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Services\SiteService;
use Illuminate\Http\Request;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class SiteController extends MyController
{
    function __construct(Request $request)
	{
        parent::__construct($request, new SiteService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = array(
            'image_id' => array('title'=> 'Logo', 'type' => self::IMAGE_ID),
            'meta'     => array('title'=> 'Meta', 'type' => self::TEXT, 'validate' => 'max:1000'),
            'keyword'  => array('title'=> 'Từ khóa seo', 'type' => self::TEXT, 'validate' => 'max:1000'),
            'description'=> array('title'=> 'Mô tả site', 'type' => self::TEXT, 'validate' => 'max:1000'),
            'banner_top' => array('title'=> 'Banner site', 'type' => self::IMAGE, 'validate' => 'max:255'),
            'url_banner' => array('title'=> 'Link banner', 'type' => self::TEXT, 'validate' => 'max:255'),

            'company'  => array('title'=> 'Tên công ty', 'type' => self::TEXT, 'validate' => 'max:255'),
            'hotline'  => array('title'=> 'Hotline', 'type' => self::TEXT, 'validate' => 'max:50'),
            'technique'=> array('title'=> 'Hổ trợ kỹ thuật', 'type' => self::TEXT, 'validate' => 'max:50'),

            'phone'    => array('title'=> 'Điện thoại', 'type' => self::TEXT, 'validate' => 'max:50'),
            'email'    => array('title'=> 'Email', 'type' => self::TEXT, 'validate' => 'max:50'),
            'sites'    => array('title'=> 'Website', 'type' => self::TEXT, 'validate' => 'max:255'),
            'address'  => array('title'=> 'Địa chỉ', 'type' => self::TEXT, 'validate' => 'max:255'),
            'warehouse'=> array('title'=> 'Kho vận', 'type' => self::TEXT, 'validate' => 'max:255'),

            'analytic' => array('title'=> 'Google analytic', 'type' => self::AREA),
            'facebook' => array('title'=> 'Facebook', 'type' => self::TEXT, 'validate' => 'max:4000'),
            'map'      => array('title'=> 'Google map', 'type' => self::TEXT, 'validate' => 'max:4000'),
        );
        $this->view['list'] = array(
            'image_id' => array(
                'title' => 'Logo',
                'width' => 6,
                'views' => array(
                    'type' => self::IMAGE_ID,
                ),
                'sort' => 'hidden'
            ),
            'hotline' => array(
                'title' => 'Hotline',
                'width' => 20,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'phone' => array(
                'title' => 'Điện thoại',
                'width' => 20,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'email' => array(
                'title' => 'Email',
                'width' => 20,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
        );
	}

}
