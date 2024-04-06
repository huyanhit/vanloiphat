<?php
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Services\ImageService;
use Illuminate\Http\Request;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class ImageController extends MyController
{
    public $form;
    public $service;
	function __construct(Request $request){
        parent::__construct($request, new ImageService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = array(
            'uri'         => array('title'=> 'Hình ảnh',   'type' => self::IMAGE, 'validate' => 'required|max:50'),
            'description' => array('title'=> 'Mô tả',      'type' => self::AREA),
            'active'      => array('title'=> 'Trang thái', 'type' => self::CHECK)
        );
        $this->view['list'] = array(
            'uri' => array(
                'title' => 'Hình Ảnh',
                'width' => 6,
                'views' => array(
                    'type' => self::IMAGE,
                ),
                'sort' => 'hidden'
            ),
            'description' => array(
                'title' => 'Mô tả',
                'width' => 10,
                'update'=> true,
                'views'  => array(
                    'type' => self::AREA,
                ),
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                )
            ),
            'active' => array(
                'title' => 'Active',
                'width' => 7,
                'update'=> true,
                'data' => array(null => self::CHOOSE , 0 => 'Không hiển thị', 1 => 'Hiển thị'),
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

    // public function editImage($id){
    //     $result['form'] = $this->form;
    //     $result['data'] = $this->service->model->where(['id'=> $id])->first();
    //     return  $this->service->editData($this->request, $result);
    // }

    // public function deleteImage(){
    //     return $this->service->deleteData($this->request, $this->form);
    // }

    public function getImageThumbnail($id){
        // validate request
        return $this->service->getImageThumbnail($id);
    }

    public function getImage($id){
        // process token
        return $this->service->getImage($id);
    }

    public function getImageResource($resource){
        // process token
        return $this->service->getImageResource($resource);
    }

    public function imagesDestroy(){
        return $this->service->imagesDestroy();
    }
}
