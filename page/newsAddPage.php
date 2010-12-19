<?php
/**
 * the add news page
 *
 */
class newsAddPage extends basePage {	
	
    protected  $template_name='newsadd';
    protected $args = array(
                        'action' => null,
                    );

	public function __construct(Request $Request=null,Session $Session=null) {
		parent::__construct($Request,$Session);
		
	}
	
	public function run() {
	    
	    $user = $this->Session->get('webUser');
	    $isLogining = 0;
	    if ($user) {
	       $isLogining = 1;
	    }   
	    $category = array();
	    $category[] = array(
	       'id' => 1,
	       'title' => 'политика'
	    );
	    $category[] = array(
	       'id' => 2,
	       'title' => 'экономика'
	    );
	    $category[] = array(
	       'id' => 3,
	       'title' => 'семья'
	    );

	    $data = array('isLogining' => $isLogining, 'user' => $user , 'category' => $category);
	    $this->View->bind('page', $data);
	}
	

}