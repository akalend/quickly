<?php
/**
 * the example test page
 *
 */
class searchPage extends basePage {
    
	protected $args = array('paging' => null);
	protected $template_name='search';
	protected $URL = '/search/';
	
	public function __construct(Request $Request=null,Session $Session=null) {
		parent::__construct($Request,$Session);		
	}
	
	public function run() {
        $key = $this->Request->get('key');
        $key = iconv('UTF-8','CP1251', $key);
        $key = trim($key);
        //var_dump($key); exit;
        $tokens = explode(' ',$key);

        $searchr = new SphinxSpecSearch();
        $searchr->init();

        $n=0;
        $res = null;
        
        foreach ($tokens as $k => &$token){
           if ($token == '') {
               unset($tokens[$k]);
           }
        }
        
        if ($tokens > 1 ) {
            $res = $searchr->catFind($tokens[0]);         
            if ($res) {
                $searchr->setFilter('rubric_id',$res);
                $ids = $searchr->specFind( $tokens[1],$this->args['paging'] );
            } else {
                $res = $searchr->classesFind($tokens[0]);         
                if ($res) {
                    $searchr->setFilter('class_id',$res);
                    $ids = $searchr->specFind( $tokens[1],$this->args['paging'] );
                } else 
                    $ids = $searchr->specFind( $key,$this->args['paging'] );        
            }           
            
        } else 
            $ids = $searchr->specFind( $key,$this->args['paging'] );        
        
        
        
        
        
        
        
        $GM = new GoodModel();
       
        $this->View->bind('page',array('goods' => $ids ? $GM->getByIds($ids) : null,
                           'founded' => $searchr->getResultCount(),
                           'pages' => $searchr->makePager($this->args[paging],"key={$this->Request->get('key')}&ssi=1")
                           )); 
	}
}