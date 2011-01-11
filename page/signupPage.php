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
	    		    
	    $isOk = false;
		if( $this->Request->hasVar('login') ) {
			$data = $this->Request->getVars() ;
			$data['ip'] = ip2long($this->Request->getServer('REMOTE_ADDR'));
            
			$this->Model = new UserModel();	
			if ( $this->checkError( $data )) { 
		      	$isOk = true;
			} else {    
				
				$res = $this->Model->add($data);
				
				//@TODO this hack !!!
				$data['server'] = 'localhost' ;//$this->Request->getServer('SERVER_NAME'); //
				
				$this->View->bind('mail' , array($data));				
				$isOk = !$res;
			} 
			
		} else {
		    // clear form
			$data = array( ''=>'');
			$isOk = true;
		}
		
		if (!$isOk) {
		   $data['mail'] = Mail::format( $data, $this->template_name );

		}
		  
		$data['ok'] = $isOk;  
		$this->View->bind('page' , $data);		
	}
	
	/**
	 * ��������� �������� ������
	 *
	 * @param &array  $data - �������/�������� ������
	 * @return true ���� ���� ������
	 */
	protected function checkError(&$data){
			$is_err = false;
			
			// all validation functions must  return true if error exist.
			$is_err = $is_err || $this->checkIsEmpty( $data, 'login' );
			$is_err = $is_err || $this->checkIsEmpty( $data, 'psw' );
			$is_err = $is_err || $this->checkIsEmpty( $data, 'psw2' );
			$is_err = $is_err || $this->checkIsEmpty( $data, 'email' );

			$is_err = $is_err || $this->checkEmail( $data, 'email' );
			
			$is_err = $is_err || $this->checkIsEQ( $data, 'psw' , 'psw2');
			
			$is_err = $is_err || $this->checkExistEmailAndLogin( $data );
			 return $is_err;				
	}
	
	protected function checkExistEmailAndLogin(&$data){

	    $res = $this->Model->checkEmailAndLogin($data);		
	    if ($res)
            return false;

        $res = false;    
		if ($this->Model->testEmail($data)) {
			$data['error_email'] = 'такой email уже существует';
			$res =  true;
		}
		
		if ($this->Model->testLogin($data)) {
			$data['error_login'] = 'такой login уже существует';
			$res =  true;
		}
		return $res;
	}
	
	
}