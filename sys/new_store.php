<?php //форма создания нового магазина
session_start(); 
//Подключаем БД
require 'db_config.php';
$db = pg_connect(DB_CONNSTR);

if(@$_POST['insert_new_store']) {
	$store = pg_escape_string($_POST['store_nmbr']);
	$store_name = pg_escape_string($_POST['store_name']);
	$tz = $_POST['time_zone'];
	$password = pg_escape_string($_POST['password']);
	
	$sql_mag = pg_query($db,"SELECT * FROM stores WHERE number =".$store);
	if (pg_fetch_row($sql_mag)>0) {
		$text = "Магазин ".$store." уже существует.";
		pg_close($db);
	} else {
		pg_query($db,"INSERT INTO stores (number, name, time_zone, pwdsecur) VALUES (".$store.", '".$store_name."', ".$tz.", '".crypt($password)."')");
		pg_close($db);
		header('Location: ../index.php');
		exit;
	}
}
?>

<script>
//скрипт для проверки совпадения паролей без перезагрузки страницы
var check = function() {
	if (document.getElementById('password').value !=  "" || document.getElementById('confirm_password').value !=  "") {
		var regexp = /[а-яё]/i;
		if(regexp.test(document.getElementById('password').value)) {
		document.getElementById('message').style.color = 'red';
		document.getElementById('message').innerHTML = 'Только английские буквы и цифры a-z, 0-9.';
		} else if (document.getElementById('password').value ==
		document.getElementById('confirm_password').value) {
		document.getElementById('message').style.color = 'green';
		document.getElementById('message').innerHTML = '<br/><input type="submit" class="btn btn-success" name="insert_new_store" value="Сохранить">';
		} else {
		document.getElementById('message').style.color = 'red';
		document.getElementById('message').innerHTML = 'Пароли не совпадают!'; 
		}
	}
}
</script>

<!DOCTYPE html>
<html lang="ru">
<head>
	<? require("metacss.php");?>
	<style>
		.yellowform {outline: 2px solid #fff; background: #FCFF90; border-radius: 10px; padding: 8px}
	</style>
</head>
<body>
	<div class="col-sm-4 col-sm-offset-4" style="display: flex; padding: 15px 20px">
	<h5>Создать новый магазин или&emsp;</h5>
	<a href="../index.php" Class="btn btn-danger btn-sm">Выйти</a>		
	</div>

	<?
	if ($text!="") echo '</br></br><span style="color: red">&emsp;&emsp;'.$text.'</span></br></br>';
	?>
	
	<div class="col-sm-4 col-sm-offset-4">	
		<form method="post" class="yellowform">
			<font color="red">Все поля обязательны для заполнения!</font></br>
			<label>Номер магазина</label>
			<input type="text" class="form-control" style="width: 70px" name="store_nmbr" required autofocus onkeyup="this.value = this.value.replace (/[^0-9]/, '')"><br/>
			<label>Название магазина</label>
			<input type="text" class="form-control" name="store_name" required><br/>
			<label>Часовой пояс (Москва GMT +3)</label>
			<select class="form-control" name="time_zone">
				<?
				//список временных зон
				for ($i = 2; $i <= 10; $i++) echo '<option '.$sel.' value='.$i.'>GMT +'.$i.'</option>';			
				?>
			</select>
			</br>
			<label>Пароль для пользователя <b>secur</b> :
				<input class="form-control" required name="password" id="password" type="password" onkeyup='check();' />
			</label>
			<br>
			<label>Подтверждение пароля :
				<input class="form-control" required type="password" name="pass_confirm" id="confirm_password"  onkeyup='check();' /> 			
			</label>
			<!--при вводе русскими буквами или если пароли не совпадают, увидим сообщение
			если все в порядке, появится кнопка Сохранить-->
			</br><span id='message'></span>		
		</form>
	</div>
</body>
</html>