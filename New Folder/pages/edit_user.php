<?php
echo show_header();
if (!$user[perm]) die(redirect_js("index.php"));

echo "<span class='name'>Изменение пользователя</span><br>";
	if ($_GET[userID]) {
			if ($u = read_user('userID', $_GET[userID] * 1)) {
			if ($_GET[error]){
				switch ($_GET[error]){
					case 1: 
						$error = "Логин занят!";
						break;
					case 2: 
						$error = "OK!";
						break;
				}
			}
			
				echo "<center><div id='errortxt' class='error'>$error</div>
				<form id='form_edit' action='action.php?action=edit_user' method=POST>
				<table>
				<tr><td>userID</td><td>$u[userID]</td></tr>
				<tr><td>Логин</td><td><input name='login' required value=\"".htmlspecialchars($u[login], ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
				<tr><td>Пароль</td><td> <input placeholder='Пароль не изменится' title='Пароль не изменится, если поле пусто' id='pass' name='pass'></td></tr>
				<tr><td>ФИО</td><td>    <input required name='fio' value=\"".htmlspecialchars($u[fio], ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
				<tr><td>Группа</td><td> <input placeholder='012 или асп14' required pattern='([0-9]{3})|(асп[0-9]{2})' title='Номер группы (три цифры) или \"асп14\" для аспиранотов, где 14 - год окончания' name='gr' value=\"".htmlspecialchars($u[gr], ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
				<tr><td>Комната</td><td><input required name='room' type=number min=101 max=450 pattern='[1-4][0-4][0-9]' title='три цифры - номер комнаты в общежитии №1' value=\"".htmlspecialchars($u[room], ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
				<tr><td>E-mail</td><td> <input required type='email' name='email' value=\"".htmlspecialchars($u[email], ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
				<tr><td>Телефон</td><td><input required placeholder='79031234567' title='79031234567' pattern='79[0-9]{9}' type='tel' name='phone' value=\"".htmlspecialchars($u[phone], ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
				<tr><td>Карта <a href='index.php?page=edit_user_card&userID=$u[userID]' class=nodecor title='Изменить по коду доступа'><img class=button src='img/edit.png'></a></td><td><div><a href='javascript:void(0);' onclick='$(this).parent().slideUp(300);$(\"#card\").parent().slideDown(300);'>Показать</a></div><div style='display:none;'><input required id='card' name='card' value=\"".htmlspecialchars($u[card], ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></div></td></tr>
				<tr><td>Админ</td><td><input type=checkbox value=1 name=perm ".(($u[perm]==1)?"checked":"")."></td></tr>
				<tr><td>Активен</td><td><input type=checkbox value=1 name=active ".(($u[active]==1)?"checked":"")."></td></tr>
				</table>
				<input type=submit value='Изменить'>
				<input type=hidden name=userID value='$u[userID]'>
				</form><br><br>
				";
				
$pays = get_pay_list($u[userID]);
if ($pays){
	echo "<table><tr>
	<td>id</td>
	<td>Сумма</td>
	<td>Описание</td>
	<td>Пользователь</td>
	<td>Время</td>
	</tr>";
	foreach ($pays as $pay){
	if ($pay[amount]<0){
		$amountcolor = "red";
	}else{
		$amountcolor = "green";
	}
	$uname = "";
	if (strpos($pay[descr], "Оплата кванта времени ")!==false){
		$m=array();
		preg_match("/Оплата кванта времени с ([0-9]+) по ([0-9]+)/", $pay[descr],$m);
		$pay[descr] = "Оплата кванта времени с ".date("d.m.Y H:i:s", $m[1])." по ".date("d.m.Y H:i:s", $m[2])."";
	}else{
		if ($pay[adminID] == -1){
			$uname = "Яндекс.деньги";
		}else{
			$u = read_user("userID", $pay[adminID]);
			$uname = $u[fio];
		}
	
	}
	$t = "";
	if ($pay["time"]=="0000-00-00 00:00:00"){
		$pay["time"] = "";
	}
		echo "<tr>
	<td>$pay[merchantID]</td>
	<td style='color:$amountcolor;'>".($pay[amount]*0.01)."</td>
	<td>$pay[descr]</td>
	<td>$uname</td>
	<td>$pay[time]</td>
	</tr>";
	}
}else{
	echo "Пополнений баланса не было!";
}
echo "</center>";
			}else
		echo "Произошла какая-то ошибка! Попробуйте снова! <br><a href='?page=users'>Назад</a>";
	}else
		echo "Произошла какая-то ошибка! Попробуйте снова! <br><a href='?page=users'>Назад</a>";
?>