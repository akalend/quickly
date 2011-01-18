<?php
/**
* need generate config
*/

$db_conf = array(
	'host' 		=> 'localhost',
	'dbname' 	=> 'tradebox_new',
	'user'		=> 'root',
	'password'	=>	'12345', 
); 





$mc_conf = array(
	'host'	=>	'localhost',
	'port'	=>	11211,
);

$mongo_conf = array(
	'host' 		=> 'localhost',
	'dbname' 	=> 'front',
); 

$app_logger  = array(
	'level' 	=> Log::ERROR ,
	'filename' 	=> 'tmp/app.log',
);
