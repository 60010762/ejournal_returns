<?
//получение данных о товаре через api
if(@$_POST['search_item']) {
	$item = pg_escape_string($_POST['item']);	
			
	$arrContextOptions=array(
	"ssl"=>array(
			"verify_peer"=>false,
			"verify_peer_name"=>false,
		),
	);  
	$json=file_get_contents("https://locdev/ld_pre/db/index.php?ean_lm=" .$item, false, stream_context_create($arrContextOptions));
	//$json=file_get_contents("https://locdev/ld_pre/db/index.php?ean_lm=" .$item, false, stream_context_create($arrContextOptions));
	//$json = '{"ean": "0020066118457","lm": "13321233","name": "Эмаль д/лодок MarineCoat.подвод.син 0,9л"}';
	
	$arr= json_decode($json,true);
	$item_ean = $arr['ean'];
	$item_lm = $arr['lm'];
	$item_name = $arr['name'];
	if ($item_name == "") {
		$item = "";
		$text = "Неправильный ШК или ЛМ";
	}
}

//добавление новой строки в базу о возврате
if(@$_POST['insert_new_record']) {
	$n_ord = pg_escape_string($_POST['n_ord']);
	//$n_trn = pg_escape_string($_POST['n_trn']);
	$item_ean = pg_escape_string($_POST['item_ean']);
	$item_lm = pg_escape_string($_POST['item_lm']);
	$item_name = pg_escape_string($_POST['item_name']);
	$qty = pg_escape_string(str_replace(',', '.', $_POST['qty']));
	$total = pg_escape_string(str_replace(',', '.', $_POST['total']));
	
	if (is_numeric($n_ord) && is_numeric($qty) && is_numeric($total)) {	
		$query = "INSERT INTO tbl_st_".$_SESSION['umag']." (online_ord, ord_num, trn, item_ean, item_lm, item_name, qty, total) 
		VALUES ('true', '".$n_ord."', '', '".$item_ean."', '".$item_lm."', '".$item_name."', '".$qty."', '".$total."')";
		pg_query($db, $query);
		pg_close($db);
		//предотвращение повторной отправки формы
		header("Location:".$_SERVER['PHP_SELF']);
	} else {
		//'<p style="border:3px #00B344  solid;>'.
		$text = 'Запись не добавлена. Проверьте корректность данных:';
	}
}

//изменение паролей пользователей chop, cais, ozk, dd
if(@$_POST['set_pass']) {
	//проверяем, что пароли не пустые и формируем запрос на обновление указанных паролей
	if ($_POST['pchop'].$_POST['pcais'].$_POST['pozk'].$_POST['pdd']!="") {
		$pchop = pg_escape_string($_POST['pchop']);
		$pcais = pg_escape_string($_POST['pcais']);
		$pozk = pg_escape_string($_POST['pozk']);
		$pdd = pg_escape_string($_POST['pdd']);
		
		$updatewhat = "number = ".$_SESSION['umag'];
		if ($pchop != "") $updatewhat = $updatewhat.",  pwdchop = '".crypt($pchop)."'";
		if ($pcais != "") $updatewhat = $updatewhat.",  pwdcais = '".crypt($pcais)."'";
		if ($pozk != "") $updatewhat = $updatewhat.",  pwdozk = '".crypt($pozk)."'";
		if ($pdd != "") $updatewhat = $updatewhat.",  pwddd = '".crypt($pdd)."'";
		
		pg_query($db, "UPDATE stores SET ".$updatewhat." where number = ".$_SESSION['umag']);
		pg_close($db);
		header('Location: index.php');		
	}
}

//изменение пароля пользователя secur	
if(@$_POST['ch_sec_pass']) {
	$password = pg_escape_string($_POST['password']);
	pg_query($db,"UPDATE stores SET pwdsecur = '".crypt($password)."' WHERE number =".$_SESSION['umag']);
	pg_close($db);
	header('Location: index.php');
}
//переименование магазина
if(@$_POST['set_store_name']) {
	$store_name = pg_escape_string($_POST['store_name']);
	pg_query($db,"UPDATE stores SET name = '".$store_name."' WHERE number =".$_SESSION['umag']);
	pg_close($db);
	$_SESSION['umagname'] = $store_name;
	header('Location: index.php');
}
//утверждение возврата
if(@$_POST['approve_return']) {
	//$id_retrn = $_POST['id_retrn'];
	//$n_ord = pg_escape_string($_POST['n_ord']);
	//$item_lm = pg_escape_string($_POST['item_lm']);
	//$total = pg_escape_string(str_replace(',', '.', $_POST['total']));
	if ($_POST['approve_return']=="утвердить") {
		$approve_return = "total = ".pg_escape_string(str_replace(',', '.', $_POST['total'])).", retrn = 'утвержден'";
	} else {
		$approve_return = "retrn = 'отклонен'";
	}
	
	
	pg_query($db,"UPDATE tbl_st_".$_SESSION['umag']." SET ".$approve_return." WHERE id = ".$_POST['id_retrn']);
	
	pg_close($db);
	header('Location: index.php?select_menu=1');
}

//выбор  меню
if ($_GET["select_menu"]>0){
	$select_menu = trim($_GET["select_menu"]);
} else {
	if ($_POST["select_menu"]>0){
		$select_menu = trim($_POST["select_menu"]);
	} else {
		$select_menu = 1;
	}
}

//указываем какой заказ утвердить
if ($_GET["approve"]>0){
	$approve = pg_escape_string($db,htmlspecialchars(trim($_GET["approve"])));
} else {
	if ($_POST["approve"]>0){
		$approve = pg_escape_string($db,htmlspecialchars(trim($_POST["approve"])));
	} else {
		$approve = 0;
	}
}

//указываем какой заказ отклонить
if ($_GET["reject"]>0){
	$reject = pg_escape_string($db,htmlspecialchars(trim($_GET["reject"])));
} else {
	if ($_POST["reject"]>0){
		$reject = pg_escape_string($db,htmlspecialchars(trim($_POST["reject"])));
	} else {
		$reject = 0;
	}
}
?>