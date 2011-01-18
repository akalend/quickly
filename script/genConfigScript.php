<?php

/**
 * the generate nginx config
 *
 */
class genConfigScript extends baseScript {
	
    protected $args = array( 'host' => null);

    public function __construct(Request $Request=null ) {
		parent::__construct($Request);		
	}

	/**
	 * call for all scripts
	 *
	 */
	public function run() {
//	    var_dump($this->args);
    $hostname = $this->args['host'];
	if (is_null($hostname)){
	    echo "\nUsage:\n\t./run_script genScript --host=<hostname>\n\n";
	    return;
	}

    $conf = new Config('host','conf');
    $hosts = $conf->getSection();
 
    if (!key_exists($hostname,$hosts))
        throw new Exception('The undefinit hostname, see conf/host.conf.php');
//    $ngx = $cfg->get();
    
	$T = new blitz('conf/tpl.nginx.conf');
	$T ->block( 'ngx', $hosts[$hostname]);	  
	file_put_contents("conf/$hostname.nginx.conf",$T->parse());
	
	$T->clean();
	$T->load( file_get_contents("conf/tpl.app.conf"));
	$T->block('/', array($hostname => 1));
	file_put_contents("conf/app.conf.php",$T->parse());
	
	}
	
}