<?php

class signOutPage extends ajaxPage {

	public function __construct(Request $Request,Session $Session) {
		parent::__construct($Request,$Session);;
		
	}
	
	public function run() {
	    $this->Session->clean('webUser');
		$this->View['res']='Ok';
		setcookie('tfn24const','',null,'/');				
	}
	
}