<?php //интерфейс пользователя
//Подключаем БД
require 'sys/db_config.php';

/* $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE);

 */
$connect_string = "host=".DB_SERVER." port=5432 dbname=".DB_DATABASE." user=".DB_USER." password=".DB_PASSWORD;

?>
<!DOCTYPE html>
<html lang="ru">
<head>

</head>
<body>
	<?

	echo '<h4>This is Johnny /> </h4>';
	echo '<img src="https://sun9-3.userapi.com/c629308/v629308734/25806/wqEr5AN98YE.jpg" alt="Пример кода">';
	
	
	//пример рабочего запроса;
	$dbconnect = pg_connect($connect_string);
	$query = "select id, date from temp where id = 1";
	$result = pg_query($dbconnect, $query);
	$result = pg_fetch_row($result); 
	echo $result[0] . '</br>' . $result[1];
	pg_close($dbconnect);
	?>	
</body>
</html>