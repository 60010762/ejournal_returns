<?php
ini_set('display_errors','Off');

$username = mysqli_real_escape_string($db,htmlspecialchars(trim($_POST['login'])));

//Проверка введенного пароля с хэшем из базы
if (isset($_POST['login']) && isset($_POST['password']) && $text == "") {      
	$dbconnect = pg_connect($connect_string);
	$query = "select pwdhash, username, userrole, magnmbr from users where username = '" .$_POST['login']. "'";
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