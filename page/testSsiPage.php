<?php
/**
 * the example test page
 *
 */
class testSsiPage extends basePage {
	
	protected $args = array(
		'user_id' => null,
	);
	
	protected $template_name='test';
	protected $URL = '/test/';
	protected $layout = null;

	protected $blockNames = array( 'leftBanner' , 'html');
	
	/**
	 * ����������� �������� User
	 *
	 * @param IRequest $Request - ������ �������
	 * @param Session $Session  - ���������� ������
	 */
	public function __construct(Request $Request=null,Session $Session=null) {
		parent::__construct($Request,$Session);
		
	}
	
	/**
	 * ���������� ��� ������ ��������
	 *
	 */
	public function run() {
		
		$this->Model = new UserProfileModel( $this->args['user_id'] );
		$data = $this->Model->getProfile();   

		$this->View->bind('page',  $data); 						// bind to block
		
		
	}
}