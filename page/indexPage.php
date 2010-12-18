<?php

class indexPage extends basePage {
	
	protected $URL='/main';	
	protected  $template_name='photowell';
	protected  $_Cached = true;
	
	public  $CachingKey = '/';
	/**
	 * ����������� �������� User
	 *
	 * @param IRequest $Request - ������ �������
	 * @param Session $Session  - ���������� ������
	 */
	public function __construct(Request $Request,Session $Session) {
		parent::__construct($Request,$Session);;
		
	}
	
	protected  function cachingRule() {
		
		if ( $this->Request->hasVar('error')) 
			return false;
		return true;
	}
	
	/**
	 * ���������� ��� ������ ��������
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