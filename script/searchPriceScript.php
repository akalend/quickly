<?php

/**
 * the example test script
 *
 */
class searchPriceScript extends baseScript {
	
	/**
	 * @param IRequest $Request - ������ �������
	 */
	public function __construct(Request $Request=null ) {
		parent::__construct($Request);		
	}

	
	public function run() {
	    $sph = new SphinxClient();
       
	    $host = "localhost";
        $port = 9312;
        
        $sph->SetServer ( $host, $port );
        $sph->SetConnectTimeout ( 1 );
        $sph->SetArrayResult ( true );
        $sph->SetMatchMode ( SPH_MATCH_ALL );
        $sph->SetRankingMode (SPH_RANK_PROXIMITY_BM25);

        $sph->SetLimits (0, 500);
        
        $min = 10000;
        $max = 18000;
        
        //$sph->SetFilterRange ( 'price', $min, $max);
        
        $res = $sph->Query ( 'INDESIT BH 180', 'goods' );
        
        if ( $res===false ) {
        	print "Query failed: " . $sph->GetLastError() . ".\n";
        
        } else {
            
            $resultCount = $res[total_found];
        	if ( is_array($res["matches"]) ) {        	    
        		$result = array();
        		$ids = '0';
        	    foreach ( $res["matches"] as $docinfo )
        		{
        			$result[]=$docinfo[id]; 
        			$ids .= ',' . $docinfo[id]; 
        		}
        		//var_dump($result);
        		var_dump($ids);
        		$sql = "select id,offer_name, good_price from goods where id in ($ids);\n";					
		          $db = new DbConvert();
		          $db->query( $sql );
		          $i=0;
		
        		while ( ($row = $db->iterate()) != null ) {			
        		        print_r(++$i);
                        print_r($row);
        		}
        		 return;
        	} else 
            	return;
        }        
        

	}
	

	public function run_old() {
	    $sph = new SphinxClient();
       
	    $host = "localhost";
        $port = 9312;
        
        $sph->SetServer ( $host, $port );
        $sph->SetConnectTimeout ( 1 );
        $sph->SetArrayResult ( true );
        $sph->SetMatchMode ( SPH_MATCH_ALL );
        $sph->SetRankingMode (SPH_RANK_PROXIMITY_BM25);


        $res = $sph->Query ( 'INDESIT BH 180', 'spec' );
        
        if ( $res===false ) {
        	print "Query failed: " . $sph->GetLastError() . ".\n";
        
        } else {
            
            $resultCount = $res[total_found];
        	if ( is_array($res["matches"]) ) {        	    
        		$result = array();
        		$ids = '0';
        	    foreach ( $res["matches"] as $docinfo )
        		{
        			$result[]=$docinfo[id]; 
        			$ids .= ',' . $docinfo[id]; 
        		}
        		//var_dump($result);
        		var_dump($ids);
        		$sql = "select spec_id,spec_name from spec where spec_id in ($ids);\n";					
		          $db = new DbConvert();
		          $db->query( $sql );
		          $i=0;
		
        		while ( ($row = $db->iterate()) != null ) {			
                        print_r($row);
        		}
        		 return;
        	} else 
            	return;
        }        
        

	}
		
}