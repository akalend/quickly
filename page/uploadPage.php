<?php

class uploadPage extends basePage {
	
	protected $args = array(
		'user_id' => null,
	);
	
	protected  $template_name='user';
	protected $URL = '/test/';
	
	/**
	 * конструктор страницы 
	 *
	 * @param IRequest $Request - данные запроса
	 * @param Session $Session  - сессионные данные
	 */
	public function __construct(Request $Request=null,Session $Session=null) {
		parent::__construct($Request,$Session);;
		
	}
	
	/**
	 * принимаем array(5) { ["file1_name"]=>  string(5) "7.jpg" 
	 * 						["file1_content_type"]=>  string(10) "image/jpeg" 
	 * 						["file1_path"]=>  string(15) "/tmp/0000000005" 
	 * 						["file1_md5"]=>  string(32) "be428336ecf097311e0e858fc7bf9310" 
	 * 						["file1_size"]=>  string(5) "30845" }
	 */
	public function run() {
		
	var_dump(  $_POST );		
		
	}
}