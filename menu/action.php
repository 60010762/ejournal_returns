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

//добавление новой строки в базу о возврате
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

if(@$_POST['confirm_return']) {
	$n_ord = pg_escape_string($_POST['n_ord']);
	$item_lm = pg_escape_string($_POST['item_lm']);
	if ($_POST['confirm_return']=="утвердить") {
		$confirm_return="утверждено";
	} else {
		$confirm_return="отклонено";
	}
	$total = pg_escape_string(str_replace(',', '.', $_POST['total']));
	pg_query($db,"UPDATE online SET total = ".$total.", return = '".$confirm_return."' WHERE ord = '".$n_ord."' AND lm = '".$item_lm."'");
	$text = "UPDATE online SET total = ".$total.", return = '".$confirm_return."' WHERE ord = '".$n_ord."' AND lm = '".$item_lm."'";
	pg_close($db);
	//header('Location: index.php');
}	
if(isset($_GET['confirm'])) {
	$i=substr($_GET['confirm'], 1);
	//$text=$_POST['n_ord'.]);
	$text = $_GET['n_ord'.$i];
	//header('Location: index.php?select_menu=1');
}
?>