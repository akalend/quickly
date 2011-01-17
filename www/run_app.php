<?

error_reporting(E_ALL | E_STRICT);
if (ini_get('display_errors') != 1) { // проверяет значение опции display_errors
    ini_set('display_errors', 1); // включает вывод ошибок вместе с результатом работы скрипта
};

header('Content-type: text/html; charset=utf-8');

//phpinfo();
/**
 * ���� ������ ����������� �� WEB, 
 * ��� ������� �������������� �� ����� ����� ������� 
 */
include ('../inc.php');

$name = isset($_SERVER['page'])? $_SERVER['page'] : 'error';
$ssi =  isset($_SERVER['ssi']) ? $_SERVER['ssi']:false ;

if (!$ssi)
    $ssi = isset($_GET['ssi']) ? $_GET['ssi']==1 : 0;
if (!$name) 
    $ssi = isset($_GET['pagename']) ? $_GET['pagename'] : 'error';


if ( $ssi ) {
	include ('../lib/App/ApplicationSsi.php');
	$app = new ApplicationSsi( $name );
} else {
    require_once('../lib/App/Application.php' );
	$app = new Application( $name, 'web' );
}		

// @TODO it is hack !!!!
$_SERVER['SERVER_NAME'] = 'localhost';
$app->run($_SERVER);

//var_dump( $_SERVER );
