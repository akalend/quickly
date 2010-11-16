<?php

class userEditPage extends basePage {
		
	protected  $template_name='userEdit';
	protected $URL = '/user/edit/{{user_id}}';

	protected $args = array(
		'user_id' => null,
	);
	

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
		
		if (  !$this->isAutentificate(  $this->args['user_id'] )) {
			$this->redirectTo( 'IndexPage' );
			exit;
		}
			
		
		$this->Model = new UserProfileModel( $this->args['user_id']);
		$data = $this->Model->getProfile();
		$data[0]['server'] = $this->Request->getServer('SERVER_NAME');
		
		if ($this->Request->hasVar()){
			
			$data = $this->Request->getVars();
	
			$ImageResazer = new ImageResizer( $this->Request->getFile('avatar') );
			
			if ( !$this->checkError( $data )  && !$ImageResazer->checkError( $data, 'avatar' ) ) {
			// if no error save model
				$ImageResazer->convert( $this->args['user_id'] );
					
				$FormDate = new FormDate();
				$FormDate->set($data,'birthdate');
				 
				$data['is_avatar'] = true;
				
				$this->Model->save($data);
				
				$this->redirectTo( 'userPage' , $this->args);
				
				$data['birthdate'] = $FormDate->build();
				
				if ( isset($data['is_avatar'] ) && $data['is_avatar'] ) {
					$data['avatar'] = $this->args['user_id'].'.jpg';
					$data['server'] = $this->Request->getServer('SERVER_NAME');
				}
			
			} 	else {

				$FormDate = new FormDate();
				$FormDate->set($data,'birthdate');				
				$data['birthdate'] = $FormDate->build();
				
				//echo 'errors';
				//
		}

		}
		//var_dump( $data );
		$data['user_id'] = $this->args['user_id']; 		
		$this->View->bind('page',  $data);
	}
	
	protected function checkError(&$data) {
		$is_err = false;			
		$is_err = $is_err || $this->checkIsEmpty( $data, 'name' );
		return $is_err;						
	}
	
}