<?php 
session_start(); 
//Подключаем БД
require 'sys/db_config.php';

if (!isset($_SESSION['uname']))
{
	header('Location: login.php');
	exit;
}

$connect_string = "host=".DB_SERVER." port=5432 dbname=".DB_DATABASE." user=".DB_USER." password=".DB_PASSWORD;

?>
<!DOCTYPE html>
<html lang="ru">
<head>

</head>
<body>
	<a class="dropdown-item" href="sys/logout.php">Выход</a>
	<?
	echo "<h4>Here's Johnny!</h4>";
	echo '<img src="https://sun9-3.userapi.com/c629308/v629308734/25806/wqEr5AN98YE.jpg" alt="Пример кода"></br>';
	echo '<hr>';

	
	//пример рабочего запроса;
/* 	$dbconnect = pg_connect($connect_string);
	$query = "select id, date from temp where id = 1";
	$result = pg_query($dbconnect, $query);
	$result = pg_fetch_row($result); 
	echo $result[0] . '</br>' . $result[1];
	pg_close($dbconnect); */
	?>	
</body>
</html>