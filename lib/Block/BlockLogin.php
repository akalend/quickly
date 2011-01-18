<?php
class BlockLogin extends Block {
	
    const MONT_IN_SEC = 2592000;
    
    public function run() {	   
	   $time = time() + self::MONT_IN_SEC;
	   
       if ( $res = $this->checkCookie($time)) {
           $res['showLoginForm'] = 0;
           if (!$res['name'])
	           $res['name'] = $res['login'];
       } elseif($res =$this->Session->get('webUser')) {	       
	       $res['showLoginForm'] = 0;
	       if (!$res['name'])
	           $res['name'] = $res['login'];
	   }	   
	   	   
	   if(!$res)
	       $res['showLoginForm']=1;
	   $this->bind('block',$res);
	}
	
	private function checkCookie($time) {
	    $token = $this->Request->getCookie('tfn24const');
	    
		  if (!$token) {
				return false;
		  }
		  $token = str_rot13($token);
		  $token_id = strtok($token,'#');
		  $token_code = substr(strrchr($token, '#'),1);
		  $User = new UserModel();
          $res = $User->checkCode(array('id'=>$token_id, 'code'=>$token_code));
		  
		  if (is_null($res) || !isset($res[0])) {
				return false;
		  }
		  
		  if (!$res[0]['name']) {
		      $res[0]['name'] = $res[0]['login'];
		      unset($res[0]['login']);
		  }
		  
		  setcookie('tfn24const',str_rot13($token_id.'#'.$token_code), $time);

		  $this->Session->set('webUser', $res[0]);
		  return $res[0];
	}
		
}