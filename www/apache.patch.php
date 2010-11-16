<?php

if ( strncmp($_SERVER["SERVER_SOFTWARE"], "Apache", 6 ) != 0)
	die("Run for Apache");

if ( strncmp($_SERVER["REDIRECT_QUERY_STRING"], "catalog", 7 ) == 0) {
	$page='catalog';
	if( strlen($_SERVER["REDIRECT_QUERY_STRING"]) > 8)
		$_SERVER['cat_name'] = substr( $_SERVER["REDIRECT_QUERY_STRING"],8 );	
}
		
if ( strncmp($_SERVER["REDIRECT_QUERY_STRING"], "goods", 5 ) == 0) {
	$page='goods';
	if( strlen($_SERVER["REDIRECT_QUERY_STRING"]) > 6)
		$_SERVER['name'] = substr( $_SERVER["REDIRECT_QUERY_STRING"],6 );		
}
	
include ('../inc.php');

$app = new Application( $name, 'web');

$app->run($_SERVER);
