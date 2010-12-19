<?php
/**
 * the login page
 *
 */
class loginPage extends basePage {
	
    //protected $args = array( 'name' => null, 'paging' => null);
	
	protected $template_name='login';
	protected $URL = '/login/';

	public function __construct(Request $Request=null,Session $Session=null) {
		parent::__construct($Request,$Session);		
	}

	public function run() {	   
	   $time = time() + 30 * 24 * 3600;
	   
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
	   
	   $this->View->bind('page',$res);
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