<?php

class ajaxActionPage extends ajaxPage {
	
	protected $args = array(
		'action' => null,
	);

	public function __construct(Request $Request,Session $Session) {
		parent::__construct($Request,$Session);		
	}
	
		public function run() {	
//	    var_dump($this->args['action']);	
	   switch ($this->args['action']) {
	       case 'newsadd': {$this->addNews(); break;}    
	       case 'imgdel':  {$this->imgDel(); break;}    
	       default: $this->noAction();
	    } 
	}
	
	private function addNews() {
	   if (!$this->Request->get('title'))    
	       return $this->View['error'] = 'title is not full';
	       
	   if (!$this->Request->get('text'))    
	       return $this->View['error'] = 'text is not full';

	   $newsNodel = new NewsModel();
	   $data = $this->Request->getVars();
	   $user = $this->Session->get('webUser'); 
	   $data['user_id'] = $user['id'];
//Log::getInstance()->toLog($this->Session->get('webUser'));
	   $this->View['id'] = $newsNodel->add($data);    
	}
	
	
	private function imgDel() {
	   $user = $this->Session->get('webUser'); 
	   $data['user_id'] = $user['id'];	    
	   $newsNodel = new NewsModel();
	   $newsNodel->unsetImg();
	}
	
	private function noAction() {
	    $this->View['error'] = 'action "'.$this->args['action'].'"not found';
	}
}