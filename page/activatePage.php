<?php

class activatePage extends basePage {
	
	protected $args = array(
		'code' => null,
	);
	
	protected  $template_name='user';
	protected $URL = '/activate/';

	
	/**
	 * ����������� �������� User
	 *
	 * @param IRequest $Request - ������ �������
	 * @param Session $Session  - ���������� ������
	 */
	public function __construct(Request $Request,Session $Session) {
		parent::__construct($Request,$Session);;
		
	}
	
	/**
	 * ���������� ��� ������ ��������
	 *
	 */
	public function run() {
		
		$this->Model = new UserModel();
		$this->Model->activate( $this->args);		
		$this->redirectTo( 'newsPage' );
	}
}