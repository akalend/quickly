<?php

class signUpPage extends basePage {

	protected $URL='/signup';
	protected  $template_name='signup';
	//protected $_Cached = true;
	
	/**
	 * ����������� �������� signIn
	 *
	 * @param IRequest $Request - ������ �������
	 * @param Session $Session  - ���������� ������
	 */
	public function __construct(Request $Request=null,Session $Session=null) {
		parent::__construct($Request,$Session);;
		
	}
	
	/**
	 * ���������� ��� ������ ��������
	 *
	 */
	public function run() {

		
		if( $this->Request->hasVar() ) {
			$data = $this->Request->getVars() ;

			if ( !$this->checkError( $data ) ) {
				$this->Model = new UserModel();	
				$this->Model->add($data);
				$data['server'] = $this->Request->getServer('SERVER_NAME');
				$this->View->bind( 'mail' , array($data) );

			}
		} 
		else {
			$data=array( ''=>'');
		}
				
		$this->View->bind( 'page' , $data );
	}
	
	/**
	 * ��������� �������� ������
	 *
	 * @param &array  $data - �������/�������� ������
	 * @return true ���� ���� ������
	 */
	protected function checkError(&$data){
			$is_err = false;
			
			$is_err = $is_err || $this->checkIsEmpty( $data, 'login' );
			$is_err = $is_err || $this->checkIsEmpty( $data, 'psw' );
			$is_err = $is_err || $this->checkIsEmpty( $data, 'psw2' );
			$is_err = $is_err || $this->checkIsEmpty( $data, 'email' );

			$is_err = $is_err || $this->checkEmail( $data, 'email' );
			
			$is_err = $is_err || $this->checkIsEQ( $data, 'psw' , 'psw2');
			
			 return $is_err;				
	}
	
}