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
    	    $file = sprintf("news/%02d/%05d.gif",floor($id/1000),$id);

    	    $res = null;
    	    $path = dirname(IMAGE_PATH.$file);
	        if (!file_exists($path)) 
	           $res = mkdir($path);
	            	
            	        
	               
	        $res = @rename($this->Request->get('fileToUpload_path'), IMAGE_PATH.$file);
            if (!$res) {
	        	 echo json_encode(array('error' => 'rename uploaded file')) ;		
	        	 return;
	        }
	        $User = $this->Session->get('webUser');
	        
	        $NM = new NewsModel();
	        $res2 = $NM->setImage($id, $User['id']);
	        
	        $arr = array();
	        $arr['url'] = $file;    	    
    	    $arr['upload'] = $res;
    	    $arr['db'] = $res2;
    		echo json_encode($arr) ;		
		} else 
			echo json_encode(array('error' => 'must be imgage')) ;		
		
	}
}