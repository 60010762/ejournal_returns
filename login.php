<?
session_start();
//Подключение к БД
require 'sys/db_config.php';
$connect_string = "host=".DB_SERVER." port=5432 dbname=".DB_DATABASE." user=".DB_USER." password=".DB_PASSWORD;
require_once ("sys/auth.php");
//Проверка была ли авторизация
if (isset($_SESSION['uname']))
{
	header('Location: index.php');
	exit;
}


?>
<!DOCTYPE html>
<html lang="ru">
<head>
<?php
	//стили
	require_once("metacss.php");
?>
</head>
<body class="background" onload="$('#myModal').modal('show')">
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-4">							
					<form role="form" action="login.php" method="post">
						<center><img src="img/logo.svg"/><h2 class="form-signin-heading">Электронный журнал возвратов</h2></center><br/>
						<center><h4 class="form-signin-heading" style="color: #6c6;">Добро пожаловать</h4></center>
						<label>LDAP <font color="red">*</font></label>
						<input type="text" class="form-control" name="login" required autofocus><br/>
						<label>Пароль <font color="red">*</font></label>
						<input type="password" class="form-control" name="password" required><br/>
						<button class="btn btn-lg btn-success btn-block" type="submit">Войти</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?
if ($text<>""){
?>
	<div class="modal fade bs-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		  </div>
		  <div class="modal-body">
			<center><h5><?=$text?></h5></center>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
		  </div>
		</div>
	  </div>
	</div>
	<?
	}
 ?>
</body>
</html>