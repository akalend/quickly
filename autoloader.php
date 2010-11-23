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
	global $classesCache;  
	global $isSaveClassCache;

	if (array_key_exists($name, $classesCache)) {
	    require_once($classesCache[$name]);
	    return;
	}
	
	if ( strpos( strtolower($name) , 'page' ))
		$path = 'page/'.$name.'.php';	   
	else {
		for ($i=1; $i < strlen($name);$i++ ) {
			if ($name[$i] <= 'Z' || $name[$i] == '.'  ) {
				
				$prefix = substr( $name,0,$i );			    
//				echo "lib/$prefix/$name.php\n";
                $path = "lib/$prefix/$name.php";				
				break;
			}
		}
		
		if ( $prefix == '') {
		    $path = "lib/App/$name.php";			
		}
	}
//	echo "cache[$name]=$path<br>";	
	$isSaveClassCache = true;
	//var_dump( $isSaveClassCache);
	$classesCache[$name] = $path;
	require_once($path);	
}