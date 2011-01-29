<?

class UtilConverter {

static function transLiteral($str) {    	    
	    $in = array ('а','б','в','г','д','е','ж', 'з','и','к','л','м','н','о','п','р','с','т','у','ф','х','ш', 'щ',   'ч', 'э', 'ю', 'я',  'ы',  'й' ,   'ь','ъ', ' ');
	    $out = array ('a','b','v','g','d','e','zh','z','i','k','l','m','n','o','p','r','s','t','u','f','h','sh','sch', 'ch','je','ju','ja','ji', 'j', '','', '_');
    return str_ireplace($in, $out, $str);
}
    
}