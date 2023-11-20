<?php
namespace  App\Modules\Admin\Helpers;

use mysql_xdevapi\Exception;

class Common{
    private $uploadPath;

    public function setUploadPath($value){
        $this->uploadPath = $value;
    }

    function __construct(){
        $this->setUploadPath(public_path().'/uploads/');
    }

    public function uploadImage($file, $path = '/uploads/images/'){
        $target_dir = public_path().$path;
        if(!file_exists($target_dir)){
            mkdir($target_dir, 0777);
        }
        $target_file = $target_dir.basename($file->getClientOriginalName());
        $path_file   = $path.$file->getClientOriginalName();
        $name        = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $ext         = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $allowCrop   = array('jpg','jpeg','png');
        $allowImage  = array('jpg','jpeg','png','gif','webp','apng','avif','pjpeg','jfif','pjp','svg');
        $allowVideo  = array('mp4','avi','wmv','ogg','ogv','webm','flv','swf','ram','rm','mov','mpeg','mpg');
        $run  = 1;

        if(in_array(strtolower($ext), array_merge($allowImage, $allowVideo))){
            while(true){
                if(file_exists($target_file)){
                    $target_file = $target_dir.$name.$run.'.'.$ext;
                    $path_file = $name.$run.'.'.$ext;
                }else{
                    copy($file->path(), $target_file);
                    if(in_array(strtolower($ext), $allowCrop)){
                        $this->cropImage($target_file,1,1,$path.'thumbnail',800);
                    }
                    return $path_file;
                }
                $run++;
            }
        }else{
            throw new \Exception('Can not upload');
        }
    }

    public function uploadFile($file, $path = '/uploads/files/'){
        $target_dir =  public_path().$path;
        $path_file  = $path.$file->getClientOriginalName();
        if(!file_exists($target_dir)){
            mkdir($target_dir, 0777);
        }
        $target_file = $target_dir.basename($file->getClientOriginalName());
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $ext  = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $run  = 1;
        while(true){
            if(file_exists($target_file)){
                $target_file = $target_dir.$name.$run.'.'.$ext;
                $path_file = $path.$name.$run.'.'.$ext;
            }else{
                copy($file->path(), $target_file);
                return $path_file;
            }
            $run++;
        }
    }

    public function trimText($text, $length, $ellipses = true, $strip_html = true) {
        if ($strip_html) {
            $text = strip_tags($text);
        }

        if (strlen($text) <= $length) {
            return $text;
        }

        $last_space = strrpos(substr($text, 0, $length), ' ');
        $trimmed_text = substr($text, 0, $last_space);

        if ($ellipses) {
            $trimmed_text .= '...';
        }

        return $trimmed_text;
    }

    public function cropImage($ini_filename, $xtl = 1, $ytl = 1, $save="/uploads/images/thumbnail", $resize=0){
        $arrext = explode(".", $ini_filename);
        $ext = end($arrext);
        $arrpath = explode("/", $ini_filename);
        $path = end($arrpath);
        if($xtl/$ytl !== 1){
            $save = $save.'('.$xtl.'x'.$ytl.')';
            if(!file_exists( public_path().$save)){
                mkdir( public_path().$save, 0777);
            }
        }elseif(!file_exists( public_path().$save)){
            mkdir( public_path().$save, 0777);
        }

        $new_path = public_path().$save.'/'.$path;
        if(!file_exists($new_path)){

            header('Content-Type: image/jpeg');
            if($ext == "gif" || $ext =="GIF"){
                $im = @imagecreatefromgif($ini_filename);
            } else if($ext =="png" || $ext =="PNG"){
                $im = @imagecreatefrompng($ini_filename);
            } else if($ext =="jpg" || $ext =="jpeg" || $ext =="JPG" || $ext =="JPEG"){
                $im = @imagecreatefromjpeg($ini_filename);
            }else{
                return;
            }
            if (!$im) {
                return;
            }

            $ini_x_size = getimagesize($ini_filename )[0] ;
            $ini_y_size = getimagesize($ini_filename )[1] ;
            $min_xtl = $ini_x_size/$xtl;
            $min_yht = $ini_y_size/$ytl;
            if($min_xtl < $min_yht){
                $dest = imagecreatetruecolor($ini_x_size, ($ini_x_size/$xtl*$ytl));
                imagecopy($dest, $im, 0, 0, 0, (($ini_y_size-($ini_x_size/$xtl*$ytl))/2), $ini_x_size, ($ini_x_size/$xtl*$ytl));
                $thumb_im = $dest;
            }else{
                $dest = imagecreatetruecolor(($ini_y_size/$ytl*$xtl), $ini_y_size);
                imagecopy($dest, $im, 0, 0, (($ini_x_size-($ini_y_size/$ytl*$xtl))/2), 0, ($ini_y_size/$ytl*$xtl), $ini_y_size);
                $thumb_im = $dest;
            }

            imagejpeg($thumb_im, $new_path, 100);
            if($resize > 0){
                $this->resize($path, $new_path, $resize,($resize/$xtl)*$ytl);
            }
        }else{
            if($resize > 0){
                $this->resize($path, $new_path, $resize,($resize/$xtl)*$ytl);
            }
        }

        return $save.'/'.$path;
    }

    public function resize(&$path, $ini_filename ,$new_width = 300, $new_height = 300) {
        header('Content-Type: image/jpeg');
        list($width, $height) = getimagesize($ini_filename);
        $thumb = imagecreatetruecolor($new_width, $new_height);
        $source = imagecreatefromjpeg($ini_filename);
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        $arr_path = explode(".", $path);
        $path = $arr_path[0].'('.$new_width.'x'.$new_height.')'.'.'.$arr_path[1];
        $new_path = preg_replace('/[\w]+\.[\w]+$/', $path, $ini_filename);
        if(!file_exists($new_path)) {
            imagejpeg($thumb, $new_path , 100);
        }
    }

    public function toSlug($str) {
        $str = trim(mb_strtolower($str));
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
        $str = preg_replace('/([\s]+)/', '-', $str);
        return $str;
    }
}
