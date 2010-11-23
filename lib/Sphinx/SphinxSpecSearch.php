<?php
class SphinxSpecSearch {
    
    const PAGESIZE=20;
    private $key;
    private $resultCount;
    private $sph;
    
    public function __construct() {
        $this->sph = new SphinxClient();
    }
    
    public function init() {
        $host = "localhost";
        $port = 9312;
        
        $this->sph->SetServer ( $host, $port );
        $this->sph->SetConnectTimeout ( 1 );
        $this->sph->SetArrayResult ( true );
        $this->sph->SetMatchMode ( SPH_MATCH_ALL );
        $this->sph->SetRankingMode (SPH_RANK_PROXIMITY_BM25);
        
    }
    
    public function getResultCount() {
        return $this->resultCount;    
    }
    
    public function setFilter($type,Array $filter) {
         $this->sph->SetFilter($type,$filter);
    }
    
    
    public function specFind($key, $page=1) {
        $limit = self::PAGESIZE;
        if (!$page) $page=1;
        
        $off = ($page -1) * self::PAGESIZE;
        //function SetLimits ( $offset, $limit, $max=0, $cutoff=0 )
        $this->sph->SetLimits ( $off, $limit, ( $limit>1000 ) ? $limit : 1000 );
        
       
     //  $this->sph->SetFilter('class_id',array(2));
        
     
        $res = $this->sph->Query ( $key, 'spec' );
        
        if ( $res===false ) {
        	print "Query failed: " . $this->sph->GetLastError() . ".\n";
        
        } else {
        	//if ( $this->sph->GetLastWarning() ) print "WARNING: " . $this->sph->GetLastWarning() . "\n\n";
            $this->resultCount = $res[total_found];
        	//print "retrieved $res[total] of $res[total_found] matches in $res[time] sec.<br>";
        	
        	if ( is_array($res["matches"]) ) {        	    
        		$n = 1;
        		$str = '';
        		foreach ( $res["matches"] as $docinfo )
        		{
        			$str .= $docinfo[id] . ','; 
        			$n++;
        		}
        	} else 
            	return false;
        }
            
            $len = strlen($str);
            $str[$len-1] = " ";
            return $str;
    }

    
    public function catFind($key) {        
        $limit = self::PAGESIZE;
       
     //  $this->sph->SetFilter('class_id',array(2));
        
     echo "cat find:$key<br>";
        $res = $this->sph->Query ( $key, 'category' );
        if ( $res===false ) {
        	print "Query failed: " . $this->sph->GetLastError() . ".\n";
        
        } else {
        	//if ( $this->sph->GetLastWarning() ) print "WARNING: " . $this->sph->GetLastWarning() . "\n\n";
            $this->resultCount = $res[total_found];
        	//print "retrieved $res[total] of $res[total_found] matches in $res[time] sec.<br>";
        	
        	if ( is_array($res["matches"]) ) {        	    
        		$result = array();
        	    foreach ( $res["matches"] as $docinfo )
        		{
        			$result[]=$docinfo[id]; 
        		}
        		return $result;
        	} else 
            	return false;
        }
            
        
    }
        
public function classesFind($key) {        
        $limit = self::PAGESIZE;
       
     //  $this->sph->SetFilter('class_id',array(2));
        
     echo "class find:$key<br>";
        $res = $this->sph->Query ( $key, 'classes' );
        if ( $res===false ) {
        	print "Query failed: " . $this->sph->GetLastError() . ".\n";
        
        } else {
            $this->resultCount = $res[total_found];
        	if ( is_array($res["matches"]) ) {        	    
        		$result = array();
        	    foreach ( $res["matches"] as $docinfo )
        		{
        			$result[]=$docinfo[id]; 
        		}
        		return $result;
        	} else 
            	return false;
        }
            
        
    }

    public function makePager($currentPage,$queryStrung) {
        $pager = new PagerBuilder( $this->resultCount,$currentPage);
        return $pager->build('/search',$queryStrung);
    }
}