<?
/**
 * logger class
 *
 * @author akalend
 * @package quickly
 */

/**
 * the logger class
 * release as singlenton
 *
 */
class Log {
		
	private static $log = null;
	
	const NONE    = 0;  
	const ERROR   = 1;  
	const WARNING = 2;  
	const NOTICE  = 3;
	const DEBUG   = 4; 
	const filename = 'app.log';
	
	private $level = array(
		self::NONE => 'NONE' , 
		self::ERROR => 'ERROR',
		self::WARNING  => 'WARNING',
		self::NOTICE => 'NOTICE',
		self::DEBUG => 'DEBUG',
	);
	
	private $fd=null, $set_level=0;
	
	/**
	 * private constructor
	 */
	private function __construct(){	
		$cfg = new Config('app', 'logger');
 		$sect = $cfg->getSection();
 		$this->set_level=$sect['level'];

	}
		
	/**
	 * get Instance of class
	 *
	 * @return object logger
	 */
	public static function getInstance(){
		if ( isset(self::$mc) ) return self::$log;
		
		self::$log = new Log();
		return self::$log;
	}
	
	/**
	 * the save message to log
	 *
	 * @param string $message - the message
	 * @param int  $level log level
	 */
	public function toLog($message, $level = self::ERROR ) {
		
		if ( $level > $this->set_level) return;
		$str_level = $this->level[$level];
		
		if (!is_resource($this->fd))
		  $this->open();
		  
		if (is_array($message))
			$message = var_export($message,true);
		
		$str = sprintf( "%s; %-8s; %s\n" , date('Y-d-m h:i:s'), $str_level, $message);
		//echo $str;
		fwrite( $this->fd, $str );
	}
	
	function __destruct() {
		if ($this->fd)
		  fclose($this->fd);
	}

	private function open() {		
		$this->fd = fopen( APP_PATH.'/tmp/'.self::filename ,'a');
		if (!is_resource($this->fd))
		  throw new Exception('can not open file:'.self::filename);
	}
}
