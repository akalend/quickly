<?php

class signInPage extends basePage {

	protected $URL='/signin';
	protected  $template_name='signin';
	//protected $_Cached = true;
	
	/**
	 * конструктор страницы signIn
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

		if( $this->Request->hasVar() ) {
			$data =   $this->Request->getVars();
			unset($data['PHPSESSID']);
			//$query_string = http_build_query( $data );
			 //$this->Request->getVar( 'login')  $this->Request->getVar( 'login')  );
			$this->Model = new UserModel();
			$res = $this->Model->checkPassword($this->Request->getVars() );
			if (is_null($res)) {
				$this->redirectTo('indexPage',$data );
			}	
			
			$this->Session->set('webUser', $res[0]);
			$this->redirectTo('userPage', $res[0]);
			 return false;
		}
		
		$this->View->bind( 'page' , array()  );

	}
}