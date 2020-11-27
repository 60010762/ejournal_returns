<?php 
session_start(); 
//Подключаем БД
require 'sys/db_config.php';
$db = pg_connect(DB_CONNSTR);

if (!isset($_SESSION['uname']))
{
	header('Location: sys/login.php');
	exit;
}

include "menu/action.php";


?>



<!DOCTYPE html>
<html lang="ru">
<head>
	<? require("sys/metacss.php");?>
	<style>
		.yellowform {outline: 2px solid #fff; background: #FCFF90; border-radius: 10px; padding: 8px}		
		.smallbtn {border: 1px solid #C0C0C0; display: inline-block; padding: 5px; text-align: center; text-decoration: none; color: #000; width: 90px; background: #fcfff4;}
		.smallbtn:hover {box-shadow: 0 0 5px rgba(0,0,0,0.3);background: linear-gradient(to bottom, #fcfff4, #e9e9ce);color: #a00;text-decoration: none;}
	</style>
</head>
<body>
	<div style="text-align: right;" >			
		<?
		echo '&bull;' .$_SESSION['uname'];
		echo '&bull;' .$_SESSION['umag'];
		?>
		<a href="sys/logout.php">Выход</a>
	</div>
	<nav aria-label="Page navigation example">
		<ul class="pagination">
			<?
			//страницы меню online и offline. для secur еще отчеты и админка
			if ($select_menu=='1'){$style_features="active";}else{$style_features="";}
			echo '<li class="page-item '.$style_features.'"><a class="page-link" href="index.php?select_menu=1">Online</a></li>';
			if ($select_menu=='2'){$style_features="active";}else{$style_features="";}
			echo '<li class="page-item '.$style_features.'"><a class="page-link" href="index.php?select_menu=2">Offline</a></li>';
			if ($_SESSION['uname'] == 'secur' || $_SESSION['uname'] == 'adm') {
				if ($select_menu=='3'){$style_features="active";}else{$style_features="";}
				echo '<li class="page-item '.$style_features.'"><a class="page-link" href="index.php?select_menu=3">Отчеты</a></li>';
				if ($select_menu=='4'){$style_features="active";}else{$style_features="";}
				echo '<li class="page-item '.$style_features.'"><a class="page-link" href="index.php?select_menu=4">Админка</a></li>';
			}
			?>
		</ul>
	</nav>
	<?
	if ($select_menu==1) include 'menu/online.php'; //меню online
			
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
	
	if ($select_menu==3) {
		
	}
	
	if ($select_menu==4) include 'menu/adm.php'; //Меню Админка		
	?>	
</body>
</html>