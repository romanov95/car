<?php
if ($_GET[js]) die();
echo show_header();
if($_GET[reg]==1){
	if ($_GET[error]){
		if ($_GET[error]==1) $error="Необходимо заполнить все поля!";
		if ($_GET[error]==2) $error="Минимальная длина пароля - 6 символов!";
		if ($_GET[error]==3) $error="Введенные пароли не совпадают!";
		if ($_GET[error]==4) $error="Группа указана некорректно! Номер группы (три цифры) или \"асп14\" для аспиранотов, где 14 - год окончания.";
		if ($_GET[error]==5) $error="Номер комнаты указан некорректно!";
		if ($_GET[error]==6) $error="Логин уже занят!";
		if ($_GET[error]==7) $error="Некорректный код активации!<br>Для получения кода активации необходимо приложить карту студента к терминалу около стиралки";
		$error = "<span class='error'>$error</span><br>";
	};
	echo "<center><form name='regform' method='POST' action='action.php?action=reg'><span class='name'>Регистрация в стиралке</span><br>
	$error
	<table>
	<tr><td>Логин</td><td><input name='login' required value=\"".htmlspecialchars(urldecode($_GET[login]), ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
	<tr><td>Пароль</td><td> <input type='password' pattern='.{6,}' title='Минимальная длина пароля - 6 символов' required name='pass'></td></tr>
	<tr><td>Повторите пароль</td><td> <input required type='password' name='pass2'></td></tr>
	<tr><td>ФИО</td><td>    <input required name='fio' value=\"".htmlspecialchars(urldecode($_GET[fio]), ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
	<tr><td>Группа</td><td> <input placeholder='012 или асп14' required pattern='([0-9]{3})|(асп[0-9]{2})' title='Номер группы (три цифры) или \"асп14\" для аспиранотов, где 14 - год окончания' name='gr' value=\"".htmlspecialchars(urldecode($_GET[gr]), ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
	<tr><td>Комната</td><td><input required name='room' type=number min=101 max=450 pattern='[1-4][0-4][0-9]' title='три цифры - номер комнаты в общежитии №1' value=\"".htmlspecialchars(urldecode($_GET[room]), ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
	<tr><td>E-mail</td><td> <input required type='email' name='email' value=\"".htmlspecialchars(urldecode($_GET[email]), ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
	<tr><td>Телефон</td><td><input required placeholder='79031234567' title='79031234567' pattern='79[0-9]{9}' type='tel' name='phone' value=\"".htmlspecialchars(urldecode($_GET[phone]), ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
	<tr><td>Код активации карты *</td><td><input name='card' value=\"".htmlspecialchars(urldecode($_GET[card]), ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
	</table>
	<br>
	<input type='submit' value='Зарегистрироваться'><br>
	*Для получения кода активации необходимо подойти к стиралке и приложить карту студента.
	</form></center>
	";
}elseif($_GET[reg]==2){
	echo "<span class='name'>Регистрация успешна</span><br>
	Регистрация прошла успешно, однако Ваш аккаунт не активирован!<br>Для активации аккаунта Вам необходимо подойти к одному из ответственных за стиралку:
	<br><center><table>
	<tr><td><b>Имя</b></td><td><b>Комната</b></td></tr>
	<tr><td>Ананичев Леонид Дмитриевич</td><td>1-419</td></tr>
	<tr><td>Юсупов Карим Маратович</td><td>1-419</td></tr>
	</table></center>
	<br>
	<a href='index.php'>На главную</a>";
}else{
	if ($_GET[error]){
		if ($_GET[error]==1) $error="Необходимо ввести логин и пароль!";
		if ($_GET[error]==2) $error="Неверные логин и/или пароль или аккаунт не активирован!";
		$error = "<span class='error'>$error</span><br>";
	};
	echo "<form name='loginform' method='POST' action='"./*(($_SERVER[SERVER_NAME] == 'stirka')?"":'http://93.175.29.239/').*/"action.php?action=login'><!--<span class='name'>Прокат машин на физтехе</span>--><br>
	<img src='img/frtk.png'>
	<br><br>
	$error
	Логин <input required name='login' value='$_GET[login]'><br>
	Пароль <input required type='password' name='pass'><br><br>
	<input type='submit' value='Войти'><br>
	<a href='index.php?page=login&reg=1'>Регистрация</a>
	 <input type=hidden name='from' value='$_SERVER[SERVER_NAME]'>
	</form>
	<script>window.onmessage = autologin;</script><iframe width=1 height=1 frameborder=0 src='http://93.175.29.239/index.php?page=islogin'></iframe>
	";
}
echo "<script>
$('#btn_exit').hide();
</script>";
echo show_footer();
?>