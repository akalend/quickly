<?php
/**
 * the example test page
 *
 */
class testPage extends ajaxPage {
	
	
	public function __construct(Request $Request=null,Session $Session=null) {
		parent::__construct($Request,$Session);
		
	}
	
	public function run() {
	    die('{"login":"'.$this->Request->get('login').'", "password" : "'.$this->Request->get('password').'"}');
	}
	
	public function run2() {
		$CM = new CategoryModel();
		if (is_null($this->args['cat_name'])) {
			$data = array( 'item' =>  $CM->getTree());
			$this->View->bind('page',$data); 		
		} else {			
			$data = array( 'row' =>  $CM->getClasses($this->args['cat_name']));
			$this->View->bind('page',$data); 
		}
				
	}
}