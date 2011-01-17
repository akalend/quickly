<?php

class newsMenuPage extends basePage {
	
	protected $URL='/';	
	protected  $template_name='newsmenu';

	public function __construct(Request $Request,Session $Session) {
		parent::__construct($Request,$Session);;		
	}
	
	public function run() {		
		$menu = new NewsModel();	
		$this->View->bind( 'page' , $menu->getMenu() );
	}
}