<?php
/**
 * the shutdown function
 * save the class cache
 *
 */
function saveClassCache() {
    global $classesCache, $isSaveClassCache;
    
    if (!$isSaveClassCache) return ;
    
    //var_dump( $isSaveClassCache );
    //echo "save to class cache";
    $data = '<?php
$classesCache = '.var_export($classesCache ,true).';';
    //echo '<pre>';
    //echo $data;
    file_put_contents(APP_PATH.'/tmp/classes.cache.php', $data);
        
    //require_once('lib/App/saveClassCache.php' );
    //var_dump($classesCache);
}