<?php
require_once 'config.php';
require_once 'mysql.php';

$sql = new MySQl($GLOBALS['hostname'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['db_name']);

$res = $sql->execute_query('SELECT * FROM test_table');

if(!$res){
	die('system error');
}

while($row = mysqli_fetch_array($res)) {
	echo $row[0] . '<br>';
	echo $row[1] . '<br>';
	echo $row[2] . '<br>';
	echo '<br>';
}