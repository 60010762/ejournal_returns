<?php
ini_set('display_errors','Off');

$username = pg_escape_string($_POST['login']);

//Проверка введенного пароля с хэшем из базы
if (isset($_POST['login']) && isset($_POST['password']) && $text == "") {      
	$dbconnect = pg_connect($connect_string);
	$query = "select u.pwdhash, u.name, r.name, u.mag from users u inner join roles r on u.role_id = r.id  where u.name = '" .$_POST['login']. "'";
	$result = pg_query($dbconnect, $query);
	$result = pg_fetch_row($result); 
	if (password_verify($_POST['password'], $result[0])) {
		$_SESSION['uname'] = $result[1];
		$_SESSION['urole'] = $result[2];
		$_SESSION['umag'] = $result[3];
	} else {
		$text = 'Неверный логин или пароль';
	}
	pg_close($dbconnect);     
}
?>