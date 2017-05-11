<?php
//
// ����� ������ � MySQL.
//
class M_MySQL
{
	// ������������� ����������.
	private $link;
	
	// �����������.
	public function __construct() {
		$this->link = null;
	}
	
	// �����������.
	public function connect() {
		if($this->link == null) {
			// ����������� � ��.
			$this->link = mysqli_connect($GLOBALS['host'], $GLOBALS['login'], $GLOBALS['pass'], $GLOBALS['db_name'])
				or die($this->logging('connect', mysqli_connect_error()));
			
			if(!mysqli_set_charset($this->link, "utf8")) {
				$this->logging('set charset', mysqli_error($this->link));
			}
		}
	}
	
	// ���������� �������.
	public function execute_query($query) {
		if($this->link == null) {
			$this->logging('query: ' . $query, 'No connect with data base');
			return null;
		}
		
		$result = mysqli_query($this->link, $query);
								
		if (!$result){
			$this->logging('query: ' . $query, mysqli_error($this->link));
			return null;
		}
		
		$this->logging('query: ' . $query);
		return $result;
	}
	
	// ������ � ���.
	public function logging($text, $error = '') {
		if ($error == '') {
			$status = 'SUCCESS';
		} else {
			$status = 'ERROR';
		}
		
		$f = fopen('log.txt', 'a+');
			fwrite($f, '[' . date('Y-m-d H:i:s') . '][' . $status . '] ');
			fwrite($f, $text . ", ");
			fwrite($f, $error . "\n");
		fclose($f);
	}
}