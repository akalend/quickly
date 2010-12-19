<?php
/**
 * the example test page
 *
 */
class newsPage extends basePage {

	protected $args = array(
		'part' => null,
		'action' => null,
		'id' => null,
	);

	protected $template_name='hotnews';
	protected $layout = 'main2';
	
	protected $URL = '/';
	
	public function __construct(Request $Request=null,Session $Session=null) {
		parent::__construct($Request,$Session);
		$this->Model = new NewsModel();
		 $this->User = $this->Session->get('webUser');
	}
	
	public function run() {
	    //var_dump($this->args);	   
	    switch ($this->args['action']) {
	    	case 'my':
	            $this->showMy();   		
	    		break;
	    	case 'delete':	    	    
	    	    $this->deactivate($this->args['id']);   		
	            $this->showMy();   		
	    		break;

	    	case 'activate':	    	    
	    	    $this->activate($this->args['id']);   		
	            $this->showMy();   		
	    		break;

	    	case 'hot':	    	    
	    	    $this->setHot($this->args['id']);   		
	            $this->showMy();   		
	    		break;
	    	case 'edit':	    	    
	    	    $this->edit($this->args['id']);   		
	    		break;
	    		
	    	default:
	    		$this->showHot();
	    }	    
	}
	
	private function deactivate($id) {	    
	   $res = $this->Model->deactivate($id, $this->User['id']);
//	   var_dump($res);      exit;
	}
	
	private function activate($id) {	    
	   $res = $this->Model->activate($id, $this->User['id']);
//	   var_dump($res);      exit;
	}

	private function setHot($id) {	    
	   $res = $this->Model->setHot($id, $this->User['id']);
//	   var_dump($res);      exit;
	}
	
	private function showHot() {	    
	    $this->View->bind( 'page', $this->Model->getHot($this->args['part']));	    	    
	}

	private function edit() {
	    $this->template_name = 'newsedit';
//	    var_dump($this->isLogining()); exit;
//	    die ('edit' . $this->args['id']);
	    $this->View->bind( 'page', array('isLogining'=>$this->isLogining(),));
	}
	
	    
	private function showMy() {
	    
	    $user = $this->Session->get('webUser');
	    if(!$user)
	       $this->redirectTo('newsPage');;

	    $data = $this->Model->getMy($user);
	    $this->template_name='mynews';
	    $this->View->bind( 'page', $data);
	}
	
}