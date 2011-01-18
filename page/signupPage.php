<?php

class signUpPage extends basePage {

	protected $URL='/signup';
	protected $template_name='signup';
	protected $layout = 'content';
	
	protected $blockNames = array('login','menu');
	
	//protected $_Cached = true;
	
	public function __construct(Request $Request=null,Session $Session=null) {
		parent::__construct($Request,$Session);;
		
	}
	
	public function run()
	{
	    $isOk = false;
		if( $this->Request->hasVar('email') )
		{
			$data = $this->Request->getVars() ;
			$data['ip'] = ip2long($this->Request->getServer('REMOTE_ADDR'));
            
			$this->Model = new UserModel();

			if ( $this->checkError( $data )) { 
		      	$isOk = true;
			} else {    
				
				$res = $this->Model->add($data);
				// $isOk = !$res;
				$isOk = false;

				//@TODO this hack !!!
				// $data['server'] = 'localhost' ;//$this->Request->getServer('SERVER_NAME'); //
				
				// $this->View->bind('mail' , array($data));	
				
			} 
			
		} else {
		    // clear form
			$data = array( ''=>'');
			$isOk = true;
		}
		  
		$data['ok'] = $isOk;
		// var_dump ($this->View);
		
		$data["captcha"] = CaptchaRecaptcha::getHTML();
		
		$this->View->bind('page' , $data);		
	}
	
	/**
	 * ��������� �������� ������
	 *
	 * @param &array  $data - �������/�������� ������
	 * @return true ���� ���� ������
	 */
	protected function checkError(&$data)
	{
			$is_err = true;
			
			// all validation functions must  return true if error exist.
			
			/* Нет логина у нас
			if ($this->checkIsEmpty( $data, 'login' )) {
				$is_err = false;
				$data["error_login"] = "Логин не введен";
			}
			*/

			if ($this->checkIsEmpty( $data, 'email' )) {
				$is_err = false;
				$data["error_email"] = "E-mail не введен";
			}

			if ($this->checkIsEmpty( $data, 'psw' )) {
				$is_err = false;
				$data["error_psw"] = "Пароль не введен";
			}

			
			if ($this->checkIsEmpty( $data, 'psw2' )) {
				$is_err = false;
				$data["error_psw2"] = "Подтверждение пароля не введено";
			}


			// сравниваем пароли
			$val = (
				$data['psw'] != ""
				&& $data['psw'] != $data['psw2']
			);
			if ($val) {
				$is_err = false;
				$data["error_psw2"] = "Введенные пароли не совпадают";
			}

			
			// капча
			/*
			$val = (
				isset ($data["recaptcha_challenge_field"])
				&& isset ($data["recaptcha_response_field"])
			);
			if ($val){
				$val = CaptchaRecaptcha::validate(
						$data["recaptcha_challenge_field"],
						$data["recaptcha_response_field"]
				);
				if (!$val){
					$is_err = false;
					$data["error_captcha"] = "Изображение с картинки введено не верно";
				}
			}
			else {
				$is_err = false;
				$data["error_captcha"] = "Изображение с картинки не введено";
			}
			*/

			if ($data['email'] != "") {
				if ($this->checkEmail( $data, "email" )) {
					$data["error_email"] = "E-mail адрес введен не корректно";
				};
			}

			

			// $is_err = $is_err || 
			// $is_err = $is_err || $this->checkExistEmailAndLogin( $data );
			
			return !$is_err;

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