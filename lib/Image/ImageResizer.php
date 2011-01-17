<?php
/**
* 	
* 		
* @package		Core
* @author		Alexandre Kalendarev <akalend@mail.ru>
*
*/

class ImageResizer {
			
	private $imageFile, $id;
	
	public function  __construct( $file ) {
		$this->imageFile = 	$file;
	}

	
	/**
	 * ��������������� � ����������� � ������������ � ��������
	 *
	 */
	public function convert( $id , $configName = 'profile') {
		
		
		$this->id = $id;
		if ( !$this->imageFile ||  !$this->imageFile['size'] ) 
			return false;
			
		$conf = new Config($configName, 'images');
		$img_conf = $conf->getSection();
		foreach ($img_conf as $type => $image ){			
		    $this->resizeItem( $type , $image );			
		}
			
	}
	
	public function checkError( &$data, $field) {

		if ($this->imageFile == null || !$this->imageFile['size'] )   
			return false;
		if ($this->imageFile['type'] == 'image/gif') 
			return false;
			
		if ($this->imageFile['type'] == 'image/jpeg') 
			return false;
		
		$data['error_'.$field] = '�� ��������';
			return true;	
		
	}
		
	private function resizeItem( $imageType, $item ){
		
		$typeOfImg = $this->imageFile['type'];
		$name = $this->imageFile['tmp_name'];

		$imageFile = IMAGE_PATH.ImageInfo::url($this->id , $imageType);		
		$imageDir = ImageInfo::dir($this->id , $imageType);
		
		if(!file_exists(IMAGE_PATH.$imageDir))
		  mkdir(IMAGE_PATH.$imageDir);
		
		$img = new ImageResize($name);	
		
		$img->setNewSize( $item['width'], $item['height']);
		$img->setImageType('jpg');	
        $img->setNewImage($imageFile);
		$img->make();		
	}
	
//	calcResize::get($screen_width,$screen_height,$picture_width,$picture_height,$x,$y);

} //end class
