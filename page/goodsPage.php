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
		//var_dump($this->args);
		$pageNum = $this->args['paging'];
		//$class_id= $CM->getClassIdByName($this->args['name']);
		$innername = $this->args['name'];
		
		$GM = new GoodModel();
		$this->Model = $CM = new CategoryModel();
		
		$data = $GM->getByCategoryName($innername, $pageNum);
		$CM->getClassIdByName($innername);
		$urls = $GM->makePages($this->URL.$innername);
		
		//Log::getInstance()->toLog($category);
		$bindData = array('title' => $CM->getTitle(),
						'goods' => $data,
						'pages' => $urls,
						);//, 
		$this->View->bind('page', $bindData);//, 'title'=>$CM->getTitle()
		
	}
}