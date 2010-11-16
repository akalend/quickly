<?php

class indexPage extends basePage {
	
	protected $URL='/main';	
	protected  $template_name='photowell';
	protected  $_Cached = true;
	
	public  $CachingKey = '/';
	/**
	 * конструктор страницы User
	 *
	 * @param IRequest $Request - данные запроса
	 * @param Session $Session  - сессионные данные
	 */
	public function __construct(Request $Request=null,Session $Session=null) {
		parent::__construct($Request,$Session);;
		
	}
	
	protected  function cachingRule() {
		
		if ( $this->Request->hasVar('error')) 
			return false;
		return true;
	}
	
	/**
	 * вызывается для каждой страницы
	 *
	 */
	public function run() {
		
		$this->Model = new UserProfileModel();
		$data = array( 'item' => $this->Model->getPhotoWell() );
		$loginData = $this->Request->getVars();
		if ( $this->Request->hasVar('error') )
			$loginData['error'] = true;
		
				
		$this->View->bind('page', $data );	
		$this->View->bind( 'login' ,  $loginData );
		$this->bindGlobal('js', array( 
			'src'=> 'photowell.js',
			//'run' => 'TPhotoWell();',
			)	);	
	}
}