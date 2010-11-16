<?php
/**
 * ����� ������� ������
 *
 * @author akalend
 * @package quickly
 */

/**
 * ���� ������� ��� ������ � ��������
 * � ����������� ������ �� ���-�� ����� ����������������
 *
 */
class Session {
		
	private $Data;
	/**
	 * ����������� ������ ������
	 *
	 */
	function __construct( ){
		session_start();
		$this->Data = $_SESSION;
		
	}

	/**
	 * �������� ������� ����������
	 *
	 * @param  string $name - ��� ���������� ���������� 
	 * @return bool - ���������� true ����  ������ ������ ���������� 
	 */
	public function hasVar( $name = null) {
		if (is_null( $name ))
		  return null;
		return array_key_exists( $name, $this->Data);
	}
	/**
	 * �������� �������� ��������� ����������
	 *
	 * @param  string $name - ��� ���������� ���������� 
	 * @return mixed - ���������� ������ ������ ���� �� ���������� 
	 */
	public function get( $name ) {
		return is_array( $this->Data ) && array_key_exists( $name, $this->Data) ? $this->Data[$name] : null;
	}
	
	/**
	 * ���������� ������ � ������
	 *
	 * @param string $name - ��� ���������� � ������
	 * @param mixed $value - ������
	 */
	public function set( $name , $value) {
		$this->Data[$name] = $value;
		$_SESSION[$name] = $value;
	}
	
}
