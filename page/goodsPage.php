<?php
/**
 * the example test page
 *
 */
class goodsPage extends basePage {
	
	protected $args = array( 'name' => null, 'paging' => null);
	
	protected $template_name='goods';
	protected $URL = '/goods/';
	protected $layout = 'main';

	public function __construct(Request $Request=null,Session $Session=null) {
		parent::__construct($Request,$Session);
		
	}
	
	/**
	 * ���������� ��� ������ ��������
	 *
	 */
	public function run() {
		var_dump($this->args);
		
		//$class_id= $CM->getClassIdByName($this->args['name']);
		$innername = $this->args['name'];
		
		$GM = new GoodModel();
		$this->Model = $CM = new CategoryModel();
		$data = $GM->getByCategoryName($innername);
		$CM->getClassIdByName($innername);
		
		Log::getInstance()->toLog($category);
		$bindData = array('title' => $CM->getTitle(),
						'goods' => $data,
						);//, 
		$this->View->bind('page', $bindData);//, 'title'=>$CM->getTitle()
		
	}
}