<?
//phpinfo();
/**
 * этот скрипт запускается из WEB, 
 * все запросы заварачиваются на вызов этого скрипта 
 */
include ('../inc.php');

$name =  $_SERVER['page'];
$ssi =  $_SERVER['ssi'];

if (!$ssi)
    $ssi = isset($_GET['ssi']) ? $_GET['ssi']==1 : 0;


if ( $ssi ) {
	include ('../lib/App/ApplicationSsi.php');
	$app = new ApplicationSsi( $name );
} else {
    require_once('lib/App/Application.php' );
	$app = new Application( $name, 'web' );
}		
$app->run($_SERVER);

//var_dump( $_SERVER );

?>

