<?php
/**
 * the example test page
 *
 */
class testPage extends basePage {
	
	protected $args = array(
		'user_id' => null,
	);
	
	protected $template_name='catalog';
	protected $URL = '/test/';
	
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
		$CM = new CategoryModel();
		if (is_null($this->args['cat_name'])) {
			$data = array( 'item' =>  $CM->getTree());
			$this->View->bind('page',$data); 		
		} else {			
			$data = array( 'row' =>  $CM->getClasses($this->args['cat_name']));
			$this->View->bind('page',$data); 
		}
				
	}
}