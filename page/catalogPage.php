<?php
/**
 * the example test page
 *
 */
class catalogPage extends basePage {
	
	protected $args = array( 'cat_name' => null );
	
	protected $template_name='catalog';
	protected $URL = '/catalog/';
	protected $layout = 'main';

	public function __construct(Request $Request=null,Session $Session=null) {
		parent::__construct($Request,$Session);
		
	}
	
	/**
	 * запуск 
	 *
	 */
	public function run() {
	
		$CM = new CategoryModel();
		if (is_null($this->args['cat_name'])) {
			$data = array( 'item' =>  $CM->getTree());
		} else {			
			$data = array( 'row' =>  $CM->getClasses($this->args['cat_name']),
						   'title' => $CM->getTitle(),
			);
	
			if (!$CM->getParentId())		
				$data = array( 'row2' =>  $CM->getChildCategory($this->args['cat_name']),
							   'title' => $CM->getTitle(),
				);
			}	
			$this->View->bind('page',$data); 
		}
		
	}