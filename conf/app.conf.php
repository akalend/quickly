<?php
/**
* need generate config
*/

$db_conf = array(
	'host' 		=> 'localhost',
	'dbname' 	=> 'tfn',
	'user'		=> 'root',
	'password'	=>	null, 
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
