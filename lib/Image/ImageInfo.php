<?php
class ImageInfo {
    static function url($id, $type='news') {
        return sprintf("%s/%02d/%05d.jpg",$type,floor($id/1000),$id);
    }
        
   static function dir($id, $type='news') {
        return sprintf("%s/%02d/",$type,floor($id/1000));
    }    
}