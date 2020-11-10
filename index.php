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

if ($_GET["select_menu"]>0){
	$select_menu = trim($_GET["select_menu"]);
} else {
	if ($_POST["select_menu"]>0){
		$select_menu = trim($_POST["select_menu"]);
	} else {
		$select_menu = 1;
	}
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<? require("metacss.php");?>
</head>
<body>

	<a href="sys/logout.php">Выход</a>
	
	<?
	


	$password = "aa";
	$hash = crypt($password);
	//echo $hash. '</br>';
	?>
	<nav aria-label="Page navigation example">
		<ul class="pagination">
			<?
			if ($select_menu=='1'){$style_features="active";}else{$style_features="";}
			echo '<li class="page-item '.$style_features.'"><a class="page-link" href="index.php?select_menu=1">Online</a></li>';
			if ($select_menu=='2'){$style_features="active";}else{$style_features="";}
			echo '<li class="page-item '.$style_features.'"><a class="page-link" href="index.php?select_menu=2">Offline</a></li>';
			?>
		</ul>
	</nav>
	<?
	echo "<h4>Here's Johnny!</h4>";
	if ($select_menu==1) {
			echo '<img style="width: 30%" src="https://sun9-3.userapi.com/c629308/v629308734/25806/wqEr5AN98YE.jpg" alt="Пример кода"></br>';
		
			echo '<hr/><table class="table table-bordered">';
			echo '<tr>
				<th>Дата</th><th>Время</th><th>№ заказа</th><th>ШК</th>
				<th>ЛМ</th><th>Наименование</th><th>Количество</th><th>Возврат за услугу</th>
				<th>Сумма за услугу</th><th>Возврат осуществлен</th>
			</tr>';
			
	/* 		while($rows_question = mysqli_fetch_row($sql_ozt_question)){
				$num_table++;
				echo '<tr><td>'.$num_table.'</td><td>'.$rows_question[1].'</td><td>'.$rows_question[2].'</td><td> <a href="index.php?select_menu='.$select_menu.'&otdel='.$otdel.'&features=0&cmd=create&create_next='.$rows_question[0].'">редактирование</td>
					<td>
					'?>
					<a href="index.php?select_menu=<?=$select_menu?>&otdel=<?=$otdel?>&del=<?=$rows_question[0]?>" onclick="return  confirm('Вы уверены, что хотите удалить тест навсегда? Все ответы так же будут удалены.')">Удаление</a>
					<!--<a href="index.php?select_menu=<?=$select_menu?>&otdel=<?=$otdel?>&delconfirm=<?=$rows_question[0]?>">Удаление</a>-->
					<?'
					</td>
				</tr>';
			} */
			echo '</table>';
				
		}
	 
	if ($select_menu==2) {
		echo '<img style="width: 30%" src="https://avatars.mds.yandex.net/get-zen_doc/1581919/pub_5d9ca84ff557d000b10d9faa_5d9cac69028d6800ae115b88/scale_1200" alt="Пример кода"></br>';
		
		echo '<hr/><table class="table table-bordered">';
			echo '<tr>
				<th>Дата</th><th>Время</th><th>№ заказа</th><th>№ транзакции</th><th>ШК</th>
				<th>ЛМ</th><th>Наименование</th><th>Количество</th><th>Возврат за услугу</th>
				<th>Сумма за услугу</th><th>Возврат осуществлен</th>
			</tr>';
			
	/* 		while($rows_question = mysqli_fetch_row($sql_ozt_question)){
				$num_table++;
				echo '<tr><td>'.$num_table.'</td><td>'.$rows_question[1].'</td><td>'.$rows_question[2].'</td><td> <a href="index.php?select_menu='.$select_menu.'&otdel='.$otdel.'&features=0&cmd=create&create_next='.$rows_question[0].'">редактирование</td>
					<td>
					'?>
					<a href="index.php?select_menu=<?=$select_menu?>&otdel=<?=$otdel?>&del=<?=$rows_question[0]?>" onclick="return  confirm('Вы уверены, что хотите удалить тест навсегда? Все ответы так же будут удалены.')">Удаление</a>
					<!--<a href="index.php?select_menu=<?=$select_menu?>&otdel=<?=$otdel?>&delconfirm=<?=$rows_question[0]?>">Удаление</a>-->
					<?'
					</td>
				</tr>';
			} */
			echo '</table>';
	}

/* 	if (password_verify('passwd', $hash)) {
    echo 'Пароль правильный!';
	} else {
		echo 'Пароль неправильный.';
	}
	echo '<hr>'; */
	
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