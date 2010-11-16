<?
/**
 * класс FormDate 
 * подготавливает 
 * данные дл€ отображени€
 *
 */
class FormDate {
		
	private $Data, $month, $day,$year;
	private $monArr = array(
		'€нварь',
		'февраль',
		'март',
		'апрель',
		'май',
		'июнь',
		'июль',
		'август',
		'сент€брь',
		'окт€брь',
		'но€брь',
		'декабрь',
		);
	

	/**
	 * конструктор класса 
	 *
	 */
	function __construct( $date = null ){
		if (!$date) return;
		// format "1984-09-23 00:00:00" SQL
		$this->month = substr($date, 5,2);
		$this->day = substr($date, 8,2);
		$this->year = substr($date,0,4);
		
		$this->Data = mktime(0,0,0,$this->month,$this->day,$this->year) ;					
	}

	public function set(&$date, $fieldname) {
		$this->month = $date['month'];
		$this->day = $date['day'];
		$this->year = $date['year'];
		$this->Data = mktime(0,0,0,$this->month,$this->day,$this->year) ;					
		$date[$fieldname] = sprintf( '%4d-%02d-%02d' , $this->year, $this->month, $this->day );
	}
	
	public function build( ) {

		$b = new blitz( TPL_PATH.'form/FormDate.tpl' );
		$month = date('m', $this->Data);

			
		$i=1;
		foreach ( $this->monArr as $month ){
			$arr =array(
				'month' => $month,				
				'selected' =>  ( $this->month == $i) ? 'selected': null,
				'value' => $i++,
			);	
			$b->block( 'MONTH' , $arr);				
		}
				
		$day = 	date('d', $this->Data);
		for( $i=1; $i<31; $i++) {
			$b->block( 'DAY' , array( 
					'day'=> $i,
					'selected' =>  ( $day == $i) ? 'selected': null,			
			));
		}

		
		for( $i=1940; $i< date('Y')-10; $i++) {
			$b->block( 'YEAR' , array( 
					'year'=> $i,
					'selected' =>  ( $this->year == $i) ? 'selected': null,			
			));
		}
	
			
		return $b->parse();
	}
	
	public function getY() {
		return  abs ( date( 'Y', time() - $this->Data) -1970) ;		
	}
	
}