<?php
/**
 * the example test page
 *
 */
class test2Page extends basePage {
	
	protected $args = array(
		'user_id' => null,
	);
	
	protected $template_name='test';
	protected $URL = '/test/';
	protected $layout = null;

	protected $blockNames = array( 'leftBanner' , 'html');
	
	/**
	 * ����������� �������� User
	 *
	 * @param IRequest $Request - ������ �������
	 * @param Session $Session  - ���������� ������
	 */
	public function __construct(Request $Request=null,Session $Session=null) {
		parent::__construct($Request,$Session);
		
	}
	
	/**
	 * ���������� ��� ������ ��������
	 *
	 */
	public function run() {
	    //"fileToUpload_content_type":"image\/gif",
	    //"fileToUpload_path":"\/Users\/akalend\/projects\/quickly\/tmp\/4\/0014287144","id":"8"
	    if ($this->Request->hasVar()) {
	        $contenetType = $this->Request->get('fileToUpload_content_type');
	        if( strncmp($contenetType,'image',5)) {
	           echo json_encode(array('error' => 'content type have been imgage'));
	           return;
	        }   
	        $id = $this->Request->get('id');
	        if (!$id) {
	        	 echo json_encode(array('error' => 'id news is not set')) ;		
	        	 return;
	        } 
	        
	        if (!$contenetType = $this->Request->get('fileToUpload_size')) {
	        	 echo json_encode(array('error' => 'size is zero')) ;		
	        	 return;
	        } 
	        
	        $ImageResazer = new ImageResizer( $this->Request->getImageFile());
	        try {
	        $ImageResazer->convert($id, 'news');
	        } catch (Exception $e) {
	            echo json_encode(array('error' => 'conversion error')) ;		
	            return;
	        }

	        $User = $this->Session->get('webUser');
	        	        
	        $NM = new NewsModel();
	        $res = $NM->setImage($id, $User['id']);
	        
	        $arr = array();
	        $arr['url'] = ImageInfo::url($id, 'large').'?'.crc32(rand(0,1000));    	    
    	    $arr['db'] = $res;
    	    //rand(0,1000);
//{"url":null,"upload":null,"db":0}    	    
    		echo json_encode($arr) ;		
		} else 
			echo json_encode(array('error' => 'must be imgage')) ;		
		
	}
}