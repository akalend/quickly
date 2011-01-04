<?php
/**
 * the news edit page
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
	    if ($this->Request->hasVar()) {
	        $data = $this->Request->getVars();
	        $is_err = $this->checkFielsd($data);
	        
	        if(!$is_err) {
	            $db_res = $this->Model->update($data);
	            if($db_res)
	               $this->redirectToUrl('/news/me/');// TODO redirect by referer;	            
	        }
	        $data['isLogining'] = $this->isLogining();
	    } else {
	        $res = $this->Model->get($this->args['id']);
//	    var_dump($res);
	        $data = array('isLogining' => $this->isLogining(),
	                  'id' =>    $res['id'],
	                  'title' => $res['title'],
	                  'text' =>  $res['text'],
	                  'newsCategory' => $res['newsCategory'],);	        
	    }
	    $this->showPage($data);
	}
	
	private function checkFielsd(&$data) {
			$is_err = false;
			
			// all validation functions must  return true if error exist.
			$is_err = $is_err || $this->checkIsEmpty( $data, 'title' );
			$is_err = $is_err || $this->checkIsEmpty( $data, 'text' );
			return $is_err;					    
	}
	
	private function showPage($data) {
	    $this->template_name = 'newsedit';
	    $category = $this->Model->getCategory($data['newsCategory']);
	    $data['category'] = $category; //var_dump($data);
	    $this->View->bind( 'page', $data);
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