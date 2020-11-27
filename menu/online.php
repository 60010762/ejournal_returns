
<html>
<?  //Меню Админка
	if ($text!="") {
		echo $text;				
	}
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
					<!--<th>№ транз.</th>-->
					<th>Кол-во</th>
					<th>Сумма за услугу</th>
					<th></th>
				</tr>
				<tr>
					<td style="width: 170px"><input class="form-control" name="item_ean" readonly value="<?=$item_ean?>"></td>
					<td style="width: 120px"><input class="form-control" name="item_lm" readonly value="<?=$item_lm?>"></td>
					<td><input class="form-control" name="item_name" readonly value="<?=$item_name?>"></td>
					<td style="width: 120px"><input class="form-control" name="n_ord" required autofocus onkeyup="this.value = this.value.replace (/[^0-9]/, '')"></td>
					<!--<td style="width: 100px"><input class="form-control" name="n_trn" required onkeyup="this.value = this.value.replace (/[^0-9]/, '')"></td>-->
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
	
	?>
	
	<form method="post" ENCTYPE="multipart/form-data">
		<table class="table table-bordered">
			<tr>
				<th>Дата</th><th>Время</th><th>№ заказа</th><th>ШК</th>
				<th>ЛМ</th><th>Наименование</th><th>Количество</th><th>Сумма за услугу</th>
				<th>Возврат за услугу</th><th>Возврат осуществлен</th>
			</tr>'
			<?	
			$sql_online_tab = pg_query($db,"SELECT to_char(dt, 'DD.MM.YYYY'), to_char(dt, 'HH24:MI:SS'), ord_num, item_ean, item_lm, item_name, qty, total, retrn, id FROM tbl_st_".$_SESSION['umag']." WHERE online_ord = 'true' ORDER BY id");
			
			//$rows_result = pg_query_rows($sql_online_tab);
			//if ($rows_result>0){	
			$i=1;
			while($result = pg_fetch_row($sql_online_tab)){
				/* if ($_SESSION['uname'] == 'ozk' && $result[8]=="") {
					if ($confirm!=="") {
						$input_total ='<input style="width: 100px" type="text" class="form-control" name="total'.$i.'" value='.$result[7].' onkeyup="this.value = this.value.replace (/[^0-9\.\,]/, '."''".')">';
						$confirm_return='<input type="submit" class="smallbtn" name="confirm_return" value="утвердить"">';
					} else {
					$confirm_return = '<a href="index.php?select_menu='.$select_menu.'&confirm=y'.$i.'">утвердить</a> 
					<a href="index.php?select_menu='.$select_menu.'&confirm=n'.$i.'">отклонить</a>';
					$input_total ='<input style="width: 100px" type="text" class="form-control" name="total'.$i.'" value='.$result[7].' onkeyup="this.value = this.value.replace (/[^0-9\.\,]/, '."''".')">';
					//$confirm_return = '<input type="submit" class="smallbtn" name="confirm_return" value="утвердить"">
					//<input type="submit" class="smallbtn" name="confirm_return" value="отклонить"">';
					}
				} else {
					$input_total =$result[7];
					$confirm_return = $result[8];
				} */
				//если заказ утвержден или отклонен, то подкрасим зеленым и красным соотв.
				if ($result[8] == "утвержден") {
					$rowstyle ='style="background: #98FB98"';
				} elseif ($result[8] == "отклонен") {
					$rowstyle ='style="background: #F08080"';
				} else {
					$rowstyle = "";
				}
				
				$input_total =$result[7];
				$approve_return = $result[8];
				
				if ($_SESSION['uname'] == 'ozk') {
					if ($result[8]!="") {
						//$input_total =$result[7];
						//$approve_return = $result[8];

						
					} elseif ($approve==$i) {						
						//режим подтверждения строки. поле с суммой становится input (только цифры и . ,) и появляется submit на внесение в базу
						$input_total ='<input style="width: 100px" type="text" class="form-control" name="total" value='.$result[7].' autofocus onfocus="javascript:text_save=value;value=\'\';value=text_save;" onkeyup="this.value = this.value.replace (/[^0-9\.\,]/, '."''".')">';
						$approve_return='<input type="hidden" name="id_retrn" value='.$result[9].'></input><input type="submit" class="smallbtn" name="approve_return" value="утвердить""></br></br>
										<a href="index.php?select_menu='.$select_menu.'" class="smallbtn" >отмена</a>';
						$rowstyle='style="background: #FCFF90"; font-weight: bolder;';
					} elseif ($reject==$i) {
						//режим отклонения строки. появляется submit на отклонение
						$approve_return='<input type="hidden" name="id_retrn" value='.$result[9].'></input><input type="submit" class="smallbtn" name="approve_return" value="отклонить""></br></br>
										<a href="index.php?select_menu='.$select_menu.'" class="smallbtn" >отмена</a>';
						$rowstyle='style="background: #FCFF90"; font-weight: bolder;';
					} else {
						//статус строки не определен, ставим два варианта: утвердить или отклонить
						$approve_return = '<a href="index.php?select_menu='.$select_menu.'&approve='.$i.'">утвердить</a>
											<a href="index.php?select_menu='.$select_menu.'&reject='.$i.'">отклонить</a>';
					}
				} else {
					//$input_total =$result[7];
					//$approve_return = $result[8];
				}
				
				echo '<tr '.$rowstyle.'>
						<td>'.$result[0].'</td>
						<td>'.$result[1].'</td>
						<td>'.$result[2].'</td>
						<td>'.$result[3].'</td>
						<td>'.$result[4].'</td>				
						<td>'.$result[5].'</td>
						<td>'.$result[6].'</td>
						<td>'.$input_total.'</td>
						<td>'.$approve_return.'</td>
						<td>'.$result[10].'</td>
					</tr>';	
				$i++;

					
			}
			pg_close($db);
			?>
		</table>
		<?
		//echo "SELECT to_char(dt, 'DD.MM.YYYY'), to_char(dt, 'HH24:MI:SS'), ord_num, item_ean, item_lm, item_name, qty, total, retrn FROM tbl_st_".$_SESSION['umag']." WHERE online_ord = 'true' ORDER BY id";
		?>
	</form>
</html>