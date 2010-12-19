<?php
class Mail {
    
    
    static public function format(Array $data,$template ) {
            $tpl = new blitz(TPL_PATH.$template.'.tpl');
			
			$res = $tpl->parse(array( 'mail' => $data));
			unset($tpl);    
			return $res;
    }
    
    
}