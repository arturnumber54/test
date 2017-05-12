<?php
//
// Класс работы с MySQL.
//
class MySQL
{
	// Параметры подлючения к БД.
	private $hostname;
	private $username;
	private $password;
	private $db_name;
	// Идентификатор соединения.
	private $link = null;
	
	// Конструктор.
	public function __construct($hostname, $username, $password, $db_name) {
		$this->hostname = $hostname;
		$this->username = $username;
		$this->password = $password;
		$this->db_name = $db_name;
		// Cоединение с БД.
		$this->connect();
	}
	
	// Подключение.
	private function connect() {
		if($this->link == null) {
			// Подключение к БД.
			$this->link = mysqli_connect($this->hostname, $this->username, $this->password, $this->db_name)
				or die($this->logging('connect', mysqli_connect_error()));
			
			if(!mysqli_set_charset($this->link, "utf8")) {
				$this->logging('set charset', mysqli_error($this->link));
			}
		}
	}
	
	// Выполнение запроса.
	public function execute_query($query) {
		$this->connect();
		
		$result = mysqli_query($this->link, $query);
								
		if (!$result){
			$this->logging('query: ' . $query, mysqli_error($this->link));
			return null;
		}
		
		$this->logging('query: ' . $query);
		return $result;
	}
	
	// Запись в лог.
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