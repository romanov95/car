<?php
echo show_header();
if (!$user[perm]) die(redirect_js("index.php"));

echo "<span class='name'>Изменение баланса</span><br>";
	if ($_GET[userID]) {
			if ($u = read_user('userID', $_GET[userID] * 1)) {
				if ($_GET[error]==1){
					$error = "Баланс успешно изменен!";
				}
				echo "<center><div id='errortxt' class='error'>$error</div>
				<form id='form_edit_pay' action='action.php?action=user_pay' method=POST>
				<table>
				<tr><td>userID</td><td>$u[userID]</td></tr>
				<tr><td>Логин</td><td>$u[login]</td></tr>
				<tr><td>ФИО</td><td>$u[fio]</td></tr>
				<tr><td>Группа</td><td>$u[gr]</td></tr>
				<tr><td>Комната</td><td>$u[room]</td></tr>
				<tr><td>E-mail</td><td>$u[email]</td></tr>
				<tr><td>Телефон</td><td>$u[phone]</td></tr>
				<tr><td>Баланс</td><td>".($u[balans]*0.01)." руб.</td></tr>
				<tr><td>Сумма пополнения/списания</td><td><input pattern='[0-9]+\.?[0-9]{0,2}' type=number min='-1000000' required max='1000000' step='0.01' name='sum'> руб.</td></tr>
				<tr><td>Описание транзакции</td><td><textarea required name='description'></textarea></td></tr>
				</table>
				<input type=submit value='Изменить баланс'>
				<input type=hidden name=userID value='$u[userID]'>
				</form>
				";
			}else
		echo "Произошла какая-то ошибка! Попробуйте снова! <br><a href='?page=users'>Назад</a>";
	}else
		echo "Произошла какая-то ошибка! Попробуйте снова! <br><a href='?page=users'>Назад</a>";
?>