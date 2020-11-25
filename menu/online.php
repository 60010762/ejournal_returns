
<html>
<?  //Меню Админка
	if ($_SESSION['uname'] == 'chop' || $_SESSION['uname'] == 'secur' || $_SESSION['uname'] == 'adm') {
	if ($item == "") {
	?>
	<form method="post" ENCTYPE="multipart/form-data">
		<div style="display: flex">
			<input class="form-control" style="width: 200px;" name="item" required autofocus placeholder="Ввод ШК или ЛМ" onkeyup="this.value = this.value.replace (/[^0-9]/, '')">
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
					<td style="width: 120px"><input class="form-control" name="n_ord" required autofocus onkeyup="this.value = this.value.replace (/[^0-9]/, '')"></td>
					<td style="width: 100px"><input class="form-control" name="n_trn" required onkeyup="this.value = this.value.replace (/[^0-9]/, '')"></td>
					<td style="width: 100px"><input class="form-control" name="qty" required onkeyup="this.value = this.value.replace (/[^0-9\.\,]/, '')"></td>
					<td style="width: 100px"><input class="form-control" name="total" required onkeyup="this.value = this.value.replace (/[^0-9\.\,]/, '')"></td>
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
	}
	?>
	<!--<form method="post" ENCTYPE="multipart/form-data">-->
		<table class="table table-bordered">
			<tr>
				<th>Дата</th><th>Время</th><th>№ заказа</th><th>ШК</th>
				<th>ЛМ</th><th>Наименование</th><th>Количество</th><th>Сумма за услугу</th>
				<th>Возврат за услугу</th><th>Возврат осуществлен</th>
			</tr>'
			<?	
			$sql_online_tab = pg_query($db,"SELECT to_char(jdatetime, 'DD.MM.YYYY'), to_char(jdatetime, 'HH24:MI:SS'), ord, ean, lm, item_name, qty, total, return FROM online");
			//$rows_result = pg_query_rows($sql_online_tab);
			//if ($rows_result>0){	
			$i=1;
			while($result = pg_fetch_row($sql_online_tab)){
				if ($_SESSION['uname'] == 'ozk' && $result[8]=="") {
					$confirm_return = '<a href="index.php?select_menu='.$select_menu.'&confirm=y'.$i.'">утвердить</a> 
					<a href="index.php?select_menu='.$select_menu.'&confirm=n'.$i.'">отклонить</a>';
					$input_total ='<input style="width: 100px" type="text" class="form-control" name="total'.$i.'" value='.$result[7].' onkeyup="this.value = this.value.replace (/[^0-9\.\,]/, '."''".')">';
					//$confirm_return = '<input type="submit" class="smallbtn" name="confirm_return" value="утвердить"">
					//<input type="submit" class="smallbtn" name="confirm_return" value="отклонить"">';
				} else {
					$input_total =$result[7];
					$confirm_return = $result[8];
				}
				echo '<tr><td>'.$result[0].'</td><td>'.$result[1].'</td>
				<td><input style="width: 100px;border: none; outline: none;" name="n_ord'.$i.'" readonly value='.$result[2].'></td>
				<td>'.$result[3].'</td>
				<td><input style="width: 70px;border: none; outline: none;" name="item_lm'.$i.'" readonly value='.$result[4].'></td>
				<td>'.$result[5].'</td><td>'.$result[6].'</td>
				<td>'.$input_total.'</td>
				<td>'.$confirm_return.'</td>
				<td>'.$result[9].'</td></tr>';	
				$i++;

					
			}
			pg_close($db);
			?>
		</table>
	<!--</form>-->
</html>