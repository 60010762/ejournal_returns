<?php 
session_start(); 
//Подключаем БД
require 'db_config.php';
$db = pg_connect(DB_CONNSTR);

if(@$_POST['insert_new_store']) {
	//$_SESSION['new_store_nmbr'] = pg_escape_string($_POST['store_nmbr']);
	//$_SESSION['new_store_name'] = pg_escape_string($_POST['store_name']);
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
/* 		pg_query($db,"INSERT INTO users (mag, name, pwdhash) VALUES 
					  (".$store.", 'secur', '".crypt($password)."'),
					  (".$store.", 'chop', ''),
					  (".$store.", 'cais', ''),
					  (".$store.", 'ozk', ''),
					  (".$store.", 'dd', '')"); */
		pg_close($db);
		header('Location: ../index.php');
		exit;
	}
	//if ($_POST['password'] != $_POST['pass_confirm']) $text = "Подтверждение пароля должно быть таким же как пароль";
	
	//предотвращение повторной отправки формы
	//header("Location:".$_SERVER['PHP_SELF']);
	
	
}




?>


<script>
//скрипт из интернета для проверки совпадения паролей без перезагрузки страницы (https://askdev.ru/q/kak-proverit-pole-podtverzhdeniya-parolya-v-forme-bez-perezagruzki-stranicy-140334/)
var check = function() {
	if (document.getElementById('password').value !=  "" || document.getElementById('confirm_password').value !=  "") {
		var regexp = /[а-яё]/i;
		if(regexp.test(document.getElementById('password').value)) {
		document.getElementById('message').style.color = 'red';
		document.getElementById('message').innerHTML = 'Только английские буквы и цифры a-z, 0-9.';
		} else if (document.getElementById('password').value ==
		document.getElementById('confirm_password').value) {
		document.getElementById('message').style.color = 'green';
		//document.getElementById('message').innerHTML = '&#10004;';
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
</head>
<body>
	<div class="col-sm-4 col-sm-offset-4">
	<h4>Создание нового магазина.</h4>
	<h4>Все поля обязательны для заполнения.</h4>
	
	<?
	if ($text!="") echo '</br></br><span style="color: red">'.$text.'</span></br></br>';
	?>
		
	<form method="post">
		<label>Номер магазина</label>
		<input type="text" class="form-control" style="width: 70px" name="store_nmbr" required autofocus onkeyup="this.value = this.value.replace (/[^0-9]/, '')"><br/>
		<label>Название магазина</label>
		<input type="text" class="form-control" name="store_name" required><br/>
		<label>Часовой пояс (Москва GMT +3)</label>
		<select class="form-control" name="time_zone">
			<?
			for ($i = 2; $i <= 10; $i++) {
				//if ($i = 3) $sel = "selected";
				echo '<option '.$sel.' value='.$i.'>GMT +'.$i.'</option>';
			}
			?>
		</select>
		</br><br/>
		<label>Пароль для пользователя secur :
			<input class="form-control" required name="password" id="password" type="password" onkeyup='check();' />
		</label>
		<br>
		<label>Подтверждение пароля :
			<input class="form-control" required type="password" name="pass_confirm" id="confirm_password"  onkeyup='check();' /> 			
		</label>
		</br><span id='message'></span>
		
		
		
		
		<!--<br/><input type="submit" class="btn btn-success" name="insert_new_store" value="Сохранить">-->
		
		

		
		
	</form>
	</div>
</body>
</html>