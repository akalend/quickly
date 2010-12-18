<?php

class signInPage extends ajaxPage {

	public function __construct(Request $Request,Session $Session) {
		parent::__construct($Request,$Session);;
		
	}
	
	public function run() {
        $time = time() + 30 * 24 * 3600;
        
	    $this->Model = new UserModel();
		if( $this->Request->hasVar() ) {
			$data =   $this->Request->getVars();
			unset($data['SID']);

			$res = $this->Model->checkPassword($data);
			if (is_null($res) || !isset($res[0])) {
				$this->View['error'] = 304;
				return;
			}	
			
			$this->Session->set('webUser', $res[0]);
			
			if ( $data['mem'] == 'true') {
			     setcookie('tfn24const',str_rot13($res[0]['id'].'#'.$res[0]['code']), $time,'/');
			}
			if (!$res[0]['name'])
			    $res[0]['name'] = $res[0]['login']; 
			
			unset($res[0]['login']);    
			unset($res[0]['code']); 
			$this->View['user'] = $res[0]; 
			return;
		} else {		    
		  $this->checkCookie($time);
	   }
	}
	
	private function checkCookie($time) {
	    $token = $this->Request->getCookie('tfn24const');
		  if (!$token) {
				$this->View['error'] = 304;
				return;
		  }
		  $token = str_rot13($token);
		  $token_id = strtok($token,'#');
		  $token_code = substr(strrchr($token, '#'),1);
		   
          $res = $this->Model->checkCode(array('id'=>$token_id, 'code'=>$token_code));
		  $this->View['debug'] = array('id'=>$token_id, 'code'=>$token_code);  
		  
		  if (is_null($res) || !isset($res[0])) {
		        $log->toLog('return');
				$this->View['error'] = 404;
				return;
		  }
		  
		  if (!$res[0]['name']) {
		      $res[0]['name'] = $res[0]['login'];
		      unset($res[0]['login']);
		  }
		  
		  setcookie('tfn24const',str_rot13($token_id.'#'.$token_code), $time,'/');

		  $this->View['user'] = $res[0];
		  $this->Session->set('webUser', $res[0]);
	}
}