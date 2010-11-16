<?php
/**
 * автоматическая подгрузка классов в библиотеке или WEB страниц
 * класс должен иметь составное имя,
 * он ищется в той директории, имя которой до второй большой буквы
 * пример: имя класса UserModel, ищется файл: /lib/User/UserModel.php
 *
 * @param string $name - class name
 */
function __autoload( $name ){
	//echo $name."<br>";
	if ( strpos( strtolower($name) , 'page' ))
		require( 'page/'.$name.'.php' );
	else {
		for ($i=1; $i < strlen($name);$i++ ) {
			if ($name[$i] <= 'Z' || $name[$i] == '.'  ) {
				
				$prefix = substr( $name,0,$i );			    
//				echo "lib/$prefix/$name.php\n";
				require_once( "lib/$prefix/$name.php" );
				break;
			}
		}
		
		if ( $prefix == '') {
			require( "lib/App/$name.php" );
		}
	}
		
		
}