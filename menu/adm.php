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
		document.getElementById('message').innerHTML = '<br/><input type="submit" class="btn btn-success" name="ch_sec_pass" value="Сохранить">';
		} else {
		document.getElementById('message').style.color = 'red';
		document.getElementById('message').innerHTML = 'Пароли не совпадают!'; 
		}
	}
}
</script>

<html>
		<div class="col-sm-4 col-sm-offset-4">
			<form method="post" class="yellowform">
				<h5>Задать новый пароль сотрудникам</h5>
				</br>
				<div style="display: flex; width: 200px">
					<label style="width: 30%">chop</label>
					<input type="text" class="form-control" name="pchop">					
				</div>
				</br>
				<div style="display: flex; width: 200px">
					<label style="width: 30%">cais</label>
					<input type="text" class="form-control" name="pcais">					
				</div>
				</br>
				<div style="display: flex; width: 200px">
					<label style="width: 30%">ozk</label>
					<input type="text" class="form-control" name="pozk">					
				</div>
				</br>
				<div style="display: flex; width: 200px">
					<label style="width: 30%">dd</label>
					<input type="text" class="form-control" name="pdd">					
				</div>
				</br>
				<input type="submit" style="width: 120px;" name="set_pass" value="Сохранить" class="btn btn-success">
			</form>
			<form method="post" class="yellowform">
				<h5>или поменять свой пароль</h5>
				<label>Пароль для пользователя <b>secur</b> :
					<input class="form-control" required name="password" id="password" type="password" onkeyup='check();' />
				</label>
				<br>
				<label>Подтверждение пароля :
						<input class="form-control" required type="password" name="pass_confirm" id="confirm_password"  onkeyup='check();' /> 			
				</label>
				</br><span id='message'></span>
			</form>
		</div>
</html>