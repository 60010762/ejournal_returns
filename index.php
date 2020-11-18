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

if(@$_POST['search_item']) {
	$item = pg_escape_string($_POST['item']); 		
			
	$arrContextOptions=array(
	"ssl"=>array(
			"verify_peer"=>false,
			"verify_peer_name"=>false,
		),
	);  
	//$json=file_get_contents("https://locdev/ld_pre/db/index.php?ean_lm=" .$item, false, stream_context_create($arrContextOptions));
	//$json=file_get_contents("https://locdev/ld_pre/db/index.php?ean_lm=" .$item, false, stream_context_create($arrContextOptions));
	$json = '{"ean": "0020066118457","lm": "13321233","name": "Эмаль д/лодок MarineCoat.подвод.син 0,9л"}';
	
	$arr= json_decode($json,true);
	$item_ean = $arr['ean'];
	$item_lm = $arr['lm'];
	$item_name = $arr['name'];
	if ($item_name == "") {
		$item = "";
		$text = "Неправильный ШК или ЛМ";
	}
}

if(@$_POST['insert_new_record']) {
	$n_ord = pg_escape_string($_POST['n_ord']);
	$n_trn = pg_escape_string($_POST['n_trn']);
	$item_ean = pg_escape_string($_POST['item_ean']);
	$item_lm = pg_escape_string($_POST['item_lm']);
	$item_name = pg_escape_string($_POST['item_name']);
	$qty = pg_escape_string(str_replace(',', '.', $_POST['qty']));
	$total = pg_escape_string(str_replace(',', '.', $_POST['total']));
	
	if (is_numeric($n_ord) && is_numeric($n_trn) && is_numeric($qty) && is_numeric($total)) {	
		$query = "INSERT INTO online (ord, trn, ean, lm, item_name, qty, total) 
		VALUES ('".$n_ord."', '".$n_trn."', '".$item_ean."', '".$item_lm."', '".$item_name."', '".$qty."', '".$total."')";
		pg_query($db, $query);
		pg_close($db);
		//предотвращение повторной отправки формы
		header("Location:".$_SERVER['PHP_SELF']);
	//$_SESSION['temp'] = $query;
	} else {
		//'<p style="border:3px #00B344  solid;>'.
		$text = 'Запись не добавлена. Проверьте корректность данных:';
	}
}	


//$connect_string = "host=".DB_SERVER." port=5432 dbname=".DB_DATABASE." user=".DB_USER." password=".DB_PASSWORD;

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
	<? require("sys/metacss.php");?>
</head>
<body>
	<a href="sys/logout.php">Настройка</a>
	<a href="sys/logout.php">Выход</a>
	
	<?
	


	echo '&bull;' .$_SESSION['uname'];
	echo '&bull;' .$_SESSION['urole'];
	echo '&bull;' .$_SESSION['umag'];
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
	
	if ($select_menu==1) { //меню online
		if ($_SESSION['urole'] == 'chop' || $_SESSION['urole'] == 'adm') {
			if ($item == "") {
			?>
			<form method="post" ENCTYPE="multipart/form-data">
				<div style="display: flex">
					<input class="form-control" style="width: 200px;" name="item" required autofocus placeholder="Ввод ШК или ЛМ">
					&ensp;					
					<input type="submit" style="width: 120px;" name="search_item" value="Новая запись" class="btn btn-success">
				</div>
			</form			
			<?	
			} else {
				?>				
				<form method="post" ENCTYPE="multipart/form-data">
					<h5><font color="grey">Новая запись</font></h5>
					<table class="table table-bordered">
						<tr>
							<th>ШК</th>
							<th>ЛМ</th>
							<th>Наименование</th>
							<th>№ заказа</th>
							<th>№ транз.</th>
							<th>Кол-во</th>
							<th>Сумма за услугу</th>
							<th></th>
						</tr>
						<tr>
							<td style="width: 170px"><input class="form-control" name="item_ean" readonly value="<?=$item_ean?>"></td>
							<td style="width: 120px"><input class="form-control" name="item_lm" readonly value="<?=$item_lm?>"></td>
							<td><input class="form-control" name="item_name" readonly value="<?=$item_name?>"></td>
							<td style="width: 120px"><input class="form-control" name="n_ord" required autofocus ></td>
							<td style="width: 100px"><input class="form-control" name="n_trn" required ></td>
							<td style="width: 100px"><input class="form-control" name="qty" required ></td>
							<td style="width: 100px"><input class="form-control" name="total" required ></td>
							<!--<td style="width: 100px"><select name="return"><option value=1>Да</option><option value=0>Нет</option></select></td>-->
							<td><input type="submit" name="insert_new_record" value="Записать" class="btn btn-success"></td>
						</tr>
					</table>								
				</form>			
			<?
			}
		}
			if ($text!="") {

				echo $text;
				//echo '<img style="width: 30%" src="https://sun9-3.userapi.com/c629308/v629308734/25806/wqEr5AN98YE.jpg" alt="Пример кода"></br>';
			}
			
			echo '<hr/><table class="table table-bordered">';
			echo '<tr>
					<th>Дата</th><th>Время</th><th>№ заказа</th><th>ШК</th>
					<th>ЛМ</th><th>Наименование</th><th>Количество</th><th>Возврат за услугу</th>
					<th>Сумма за услугу</th><th>Возврат осуществлен</th>
				</tr>';
				
			$sql_online_tab = pg_query($db,"SELECT to_char(jdatetime, 'DD.MM.YYYY'), to_char(jdatetime, 'HH24:MI:SS'), ord, trn, ean, lm, item_name, qty, total, return FROM online");
			//$rows_result = pg_query_rows($sql_online_tab);
			//if ($rows_result>0){				
				while($result = pg_fetch_row($sql_online_tab)){
					echo '<tr><td>'.$result[0].'</td><td>'.$result[1].'</td><td>'.$result[2].'</td><td>'.$result[3].'</td><td>'.$result[4].'</td><td>'.$result[5].'</td><td>'.$result[6].'</td><td>'.$result[7].'</td><td>'.$result[8].'</td><td>'.$result[9].'</td></tr>';					
				}
			//}
			pg_close($db);
	} 
			
			echo '</table>';
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