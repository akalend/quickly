<?php

class activatePage extends basePage {
	
	protected $args = array(
		'code' => null,
	);
	
	protected  $template_name='user';
	protected $URL = '/activate/';

	
	/**
	 * конструктор страницы User
	 *
	 * @param IRequest $Request - данные запроса
	 * @param Session $Session  - сессионные данные
	 */
	public function __construct(Request $Request=null,Session $Session=null) {
		parent::__construct($Request,$Session);;
		
	}
	
	/**
	 * вызывается для каждой страницы
	 *
	 */
	public function run() {
		
		$this->Model = new UserModel();
		$this->Model->activate( $this->args);		
		$this->redirectTo( 'indexPage' );
	}
}