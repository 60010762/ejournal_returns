<?php
ini_set('display_errors','Off');

$username = pg_escape_string($_POST['login']);
$userpass = pg_escape_string($_POST['password']);
//$store = substr($_POST['store'], 3);
$store = $_POST['store'];


//Проверка введенного пароля с хэшем из базы
if (isset($_POST['login']) && isset($_POST['password']) && $text == "") {
		
		//header('Location: ../new_store.php');
		//exit;
	
	//$query = "select pwdhash, name, mag from users where mag = ".$store." and name = '" .$username. "'";
	$query = "select pwd" .$username. " from stores where number = ".$store;
	$result = pg_query($db, $query);
	$result = pg_fetch_row($result); 
	if (password_verify($userpass, $result[0])) {
		if ($store == 0) {
			header('Location: new_store.php');
			exit;
		} else {
			$_SESSION['uname'] = $username;
			$_SESSION['umag'] = $store;
		}
	} else {
		$text = 'Неверный логин или пароль'; //.' '.$result[0].'/'."select u.pwdhash, u.name, r.name, u.mag from users u inner join roles r on u.role_id = r.id  where u.mag = ".$store." and u.name = '" .$username. "'";
	}
	pg_close($dbconnect);     
}
?>