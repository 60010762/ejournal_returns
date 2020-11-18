<?php 
session_start(); 
//Подключаем БД
require 'db_config.php';
$db = pg_connect(DB_CONNSTR);


?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<? require("metacss.php");?>
</head>
<body>
	<h4>Добрый вечер, я диспетчер.</h4>
</body>
</html>