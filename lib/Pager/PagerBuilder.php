<?php
class PagerBuilder {
    
    const RECORDS_PER_PAGE = 20;
    private $recCount;
    private $currentPage;
    
    /**
     * The build the data for Pager View
     *
     * @param int $recCount count records into recordset
     * @param int $currentPage - the number of current recordset
     */
    public function __construct($recCount, $currentPage) {
        $this->recCount = $recCount;
        //$this->pageCount = $pageCount;
        $this->currentPage = $currentPage;        
    }
    
    public function build( $url, $queryString = NULL, $isLimit = true) {
      $pageCount = ceil($this->recCount / self::RECORDS_PER_PAGE); 
      if ($pageCount<1) $pageCount = 1;  
        
      if ($pageCount == 1)
	       return null;
	        
	   $res = array();
	   if ($queryString)
	       $queryString = '?'.$queryString;
	   else 
	       $queryString = '';
	       
	   if ($isLimit && $pageCount>50)
	       $pageCount = 50;
	           
	   for ( $i=1; $i < $pageCount+1; $i++) {
	       $item = array( 'page' => $i,
	                        'url' =>  $url.'/'.$i.$queryString);
	       if ($this->currentPage == $i) 
	           $item['currentPage'] = true;                
	       $res[] = $item;               
	   }                     
	   return $res;	    

    }
    
}