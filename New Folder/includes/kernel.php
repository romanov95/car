<?php

/**
 * Подключение к БД
 *
 * Подключние к БД с настройками из includes/rootpass.php
 * @version 1.0.0
 * @return void
 * @param string $home относительный путь до корня системы
 * @category system
 */
function db_connect($home = "") {
	$ticket = "lvhzdughhjky";
	include $home . "includes/rootpass.php";
	$connection = mysql_connect($domen, $mysqllogin, $mysqlpassword) or die("Ошибка подключения к MySQL, неверные параметры!");
	mysql_set_charset($mysql_charset);
	$home = mysql_select_db($affprogdb, $connection) or die("Ошибка выбора БД");
}
/**
 * Поддержание сессии
 * 
 * @version 1.0.0
 * @param int $noclose Не закрывать сессию после окончания выполнения функции
 * @return void
 * @category user
 */
function sess($noclose = false) {
	session_start();
	setcookie(session_name(), session_id(), time() + 7200, '/');
}
/**
 * Редирект
 *
 * Редирект средствами PHP. Вызывать только до первого вывода.
 * @version 1.0.0
 * @param string $path Адрес назначения
 * @return header
 * @category data
 */
function redirect($path) {
	$redirect = "Location: $path";
	return die(header($redirect));
}
/**
 * Редирект
 *
 * Редирект средствами JavaScript.
 * <code>echo redirect_js("http://example.com");</code>
 * @version 1.0.0
 * @param string $path Адрес назначения
 * @return string
 * @category system
 */
function redirect_js($path) {
	$redirect = '<script language="JavaScript">location.replace("' . $path . '");</script>';
	return $redirect;
}
/**
 * Проверка входа в аккаунт
 *
 * @version 1.0.0
 * @return array|null Информация о пользователе и правах
 * @category user
 */
function islogin() {
	if ($_SESSION[userid] && $_SESSION[pass]) {
		$q = "SELECT * FROM rt_users WHERE userID=\"$_SESSION[userid]\" AND deleted!='1' AND active='1'";
		$q = db_query($q);
		if (mysql_num_rows($q)) {
			$q = mysql_fetch_array($q);
			if (md5($q[token]."pass" . $q[pass]) == $_SESSION[pass]) {
				return $q;
			} else
				return null;
		}else
			return null;
	}else
		return null;
}

/**
 * Исполнение mysql запроса
 *
 * Рекомендуется использовать вместо mysql_query()
 * @version 1.0.0
 * @param string $q SQL запрос
 * @return Resource
 * @category system
 */
function db_query($q) {
	$qq = mysql_query($q) or die(mysql_error());
	return $qq;
}
function make_sql($q){
		$q = "SELECT $q";
		$q = db_query($q);
		if (!mysql_num_rows($q)){
			return null;
		}
		$r = array();
		while($rr = mysql_fetch_assoc($q)){
			$r[] = $rr;
		}
		return $r;
}
/**
	 * Генерация и вывод верхушки (header)
	 *
	 * @param string $how Выравнивание на странице, по умолчанию left
	 */
function show_header($how = 'center') {
global $user;
$JSVER=1;
if ($user){
	$toplogin = "<span class='top_login'>".$user[fio]." &nbsp;&nbsp;&nbsp;&nbsp;Баланс: ".($user[balans]*0.01)." руб.</span> <a class='nodecor' $auth title='Пополнить баланс' href='index.php?page=payin'><img class=button title='Пополнить баланс' alt='Пополнить баланс' src='img/rouble.png'></a>";
}
		echo <<<TEXT
<!DOCTYPE html><!--kykint-->
<html>
	<head>
		<title>Прокат машин</title>
		<link rel='icon' type='image/png' href='/favicon.png?v=$JSVER' />
		<link rel='stylesheet' type='text/css' href='img/style.css?v=$JSVER'>
		<script type='text/javascript' src='img/jquery.js?v=$JSVER'></script>
		<!--<script type='text/javascript' src='img/jquery-migrate.js?v=$JSVER'></script><!---->
		<script type='text/javascript' src='img/jquery.contextmenu.js?v=$JSVER' async></script>
		<link type='text/css' href='img/jquery.contextmenu.css?v=$JSVER' rel='stylesheet' async />
		<script src='img/jquery-ui.custom.min.js?v=$JSVER' type='text/javascript'></script>
		<script type='text/javascript' src='img/all.js?v=$JSVER'></script>
	</head>
<body>
<div class='top2'>
	<span class='top-left'>
		<a class='nodecor' $auth title='Домой' href='index.php?page=home'><img class=button title='Домой' alt='Домой' src='img/home.png'></a>
		</span>
		<span class='top-center'>
		<span id='top-static'></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<span id='top-dyn'></span>
		</span>
		<span class='top-right'><img id='loading' class='loading' src='img/loading.gif' style='display:none;'>
		&nbsp;<img id='barcodeIndicator' class='button' src='img/barcode.png' style='cursor:help;display:none;' title='Режим считывания штрих-кодов включен' onclick='barcode_help();'>
		&nbsp;$toplogin
		<img $auth class=button title='Выйти из системы' id='btn_exit' alt='Выйти из системы' src='img/lock.png' onclick='if (confirm("Выйти из системы?")) location.replace("action.php?action=logout");'>
	</span>
</div>
<div class='tabs'></div>		
<div class='top1'></div>
<div class='top4' style='display:none;' onclick='close_alert();'><span onclick='close_alert();' class='top3'></span></div>
<div class='block' id='main_content' style='text-align: $how;'>
TEXT;
	}
	/**
	 * Генерация подвала(footer)
	 */
function show_footer() {

		echo <<<TEXT
</div>
<div class=msg_box></div>
<div class=user_list style='display: none;'></div>
<input type=text id='barcodeText' onkeyup='barcodeScan(this);' onblur='keyDowns=0;'>
<a href='http://wm-mnogo.org/?id=site4u' target='_blank' class='copyright'>&copy; Created by WM-mnogo</a>
</body></html>
TEXT;
	}
/**
 * Данные пользователя
 *
 * <code>read_user("userID", 1);</code>
 * @version 1.0.0
 * @param string $what Название поля поиска
 * @param string|int $value Значение поля
 * @return array|null
 * @category data
 */
function read_user($what, $value) {
	$q = "SELECT * FROM rt_users WHERE $what=\"$value\" AND deleted!='1'";
	$q = db_query($q);
	if (!mysql_num_rows($q))
		return null;
	$q = mysql_fetch_array($q);
	return $q;
}
/**
 * Добавление пользователя
 *
 * @version 1.0.0
 * @return array array(error) или array(historyID)
 * @category data
 login VARCHAR(50), pass VARCHAR(32), email VARCHAR(128), phone VARCHAR(30), gr VARCHAR(10), room INT(3), fio TEXT, balans INT, active INT(1), perm 
 */
function add_user($login, $pass, $email, $phone, $gr, $room, $fio, $card, $active=0, $perm=0) {
	$pass = md5($pass);

	$q = "INSERT INTO rt_users (login, pass , email, phone, gr, room, fio, card, balans , active, perm ) VALUES 
	(\"$login\", \"$pass\", \"$email\", \"$phone\", \"$gr\", \"$room\", \"$fio\", \"$card\", 0, \"$active\", \"$perm\")";
	
	$q = db_query($q);
	$userID = mysql_insert_id();
	
	$q = "DELETE FROM rt_cards WHERE number=\"$card\"";
	$q = db_query($q);
	
	return $ret;
}
/**
 * Изменение пользователя
 *
 * @version 1.0.0
 * @return array|null Измененный пользователь
 * @category data
 */
function edit_user($id, $login, $pass, $email, $phone, $gr, $room, $fio, $active=0, $perm=0, $card=0) {
if ($pass){
	$password = "pass = '".md5($pass)."' ,";
}
		$q = "UPDATE rt_users SET 
		login = '$login', 
		$password
		email = '$email', 
		phone = '$phone', 
		gr = '$gr', 
		room = '$room', 
		fio = '$fio', 
		active = '$active', 
		perm = '$perm',
		card = '$card'
		WHERE userID='$id'";
		$q = db_query($q);

		return 1;
}
/**
 * Получение списка пополнений
 */
function get_pay_list($userID){
		$q = "SELECT * FROM rt_merchant WHERE userID='$userID' ORDER BY merchantID DESC";
		$q = db_query($q);
		if (!mysql_num_rows($q)){
			return null;
		}
		$r = array();
		while($rr = mysql_fetch_assoc($q)){
			$r[] = $rr;
		}
		return $r;
}
/**
 * Изменение карты пользователя
 *
 * @version 1.0.0
 * @return array|null Измененный пользователь
 * @category data
 */
function edit_user_card($id, $card) {
	$code = read_code_card($card, 1);
	if ($code){
		$q = "UPDATE rt_users SET 
		card = '$code'
		WHERE userID='$id'";
		$q = db_query($q);
		return 1;
	}else{
		return -1;
	}
}
/**
 * Изменение баланса
 *
 * @version 1.0.0
 * @return array|null Измененный пользователь
 * @category data
 */
function user_pay($id, $sum, $descr, $user_pay=null) {
if ($user_pay === null){
	$user_pay =$_SESSION[userid];
}
		$q = "UPDATE rt_users SET 
		balans = balans + $sum
		WHERE userID='$id'";
		$q = db_query($q);
		$q = "INSERT INTO rt_merchant
		(userID, amount, descr, adminID)
		VALUES ('$id', '$sum', '$descr', '$user_pay')";
		$q = db_query($q);
		return 1;
}
/**
 * Удаление пользователя
 *
 * @version 1.0.0
 * @param int $userID userID
 * @return int|null userID
 * @category data
 */
function del_user($userID) {
		$q = "UPDATE rt_users SET deleted='1' WHERE userID='$userID'";
		$q = db_query($q);
}
/**
 * Активация пользователя
 *
 * @version 1.0.0
 * @param int $userID userID
 * @return int|null userID
 * @category data
 */
function activate_user($userID) {
	$q = "UPDATE rt_users SET active='1' WHERE userID='$userID'";
	$q = db_query($q);
}
/**
 * Вход в аккаунт
 *
 * @version 1.0.0
 * @param string $login Логин
 * @param string $pass Пароль
 * @return int 1 - ошибка<br>2 - успех
 * @category user
 */
function login($login, $pass) {
	$user = read_user("login", $login);
	if (!$user) return 0;
	$md = md5(date("dmY5454545His")."hdgdjghjd");
	$q = "update rt_users set token='".$md."' WHERE userID='$user[userID]'";
	$q = db_query($q);
	if (md5($pass) != $user[pass]) return 0;
	if (!$user[active]) return 0;
	
	$_SESSION[userid] = $user[userID];
	$_SESSION[pass] = md5($md."pass" . $user[pass]);
	return 1;
}
/**
 * Вход в аккаунт по токену
 *
 * @version 1.0.0
 * @param int $userID 
 * @param string $token 
 * @return int 1 - успех
 * @category user
 */
function autologin($userID, $token) {
	$user = read_user("userID", $userID);
	if (md5("passw" . $user[pass] . date("dmYH")) == $token) {
		$_SESSION[userid] = $user[userID];
		$_SESSION[pass] = md5($user[token]."pass" . $user[pass]);
		return 1;
	}
	return 0;
}
/**
 * Выход из аккаунта
 *
 * @version 1.0.0
 * @return void
 * @category user
 */
function logout() {
	$md = md5(date("dmY5454545His")."hdgdjghjd");
	$q = "update rt_users set token='".$md."' WHERE userID='$_SESSION[userid]'";
	$q = db_query($q);
	$_SESSION[userid] = null;
	$_SESSION[pass] = null;
}
/**
 * Список пользователей
 *
 * @version 1.0.0
 * @param int $page Номер страницы, нумерация с 1
 * @param int $onpage Количество записей на страницу
 * @param string|int $order Колонка сортировки или сортировка по онлайну: -1 - только онлайн, -2 только оффлайн, -3 сначала онлайн, потом оффлайн
 * @param ""|"desc" $desc Направление сортировки
 * @return array
 * @category data
 */
function user_list($page = 0, $onpage = 1000, $order = 'userID', $desc = "") {
	$page = ceil($page);
	if ($page < 0)
		$page = 0;
	$onpage = ceil($onpage);
	if ($onpage < 1)
		$onpage = 100;
	$q = "SELECT * FROM rt_users WHERE deleted!='1' ORDER BY $order $desc LIMIT $page, $onpage";
	$q = db_query($q);
	$ret = array();
	if (mysql_num_rows($q))
			while ($r = mysql_fetch_array($q)) {
				$ret[] = $r;
			}
		return $ret;
}
/**
 * Чтение настройки
 *
 * @version 1.0.0
 */
function read_setting($name) {
	$q = "SELECT value FROM rt_settings WHERE name=\"$name\"";
	$q = db_query($q);
	if (mysql_num_rows($q)) {
		$q = mysql_fetch_array($q);
		return $q[value];
	}else
		return null;
}
/**
 * Изменение настройки
 *
 * @version 1.0.0
 */
function edit_setteng($name, $value) {
	if (read_setting($name)===null){
		$q = "INSERT INTO rt_settings (name, value) VALUES (\"$name\", \"$value\")";
	}else{
		$q = "UPDATE rt_settings SET value=\"$value\" WHERE name=\"$name\"";
	}
	$q = db_query($q);
	return 0;
}
/**
 * Изменение настройки
 *
 * @version 1.0.0
 */
function read_plan_day($nowday) {
	$q = "SELECT * FROM rt_plan WHERE day='$nowday' ORDER BY fromtime, mashine";
	$q = db_query($q);
	if (mysql_num_rows($q)){
		$ret=array();
		while ($r = mysql_fetch_assoc($q)){
			if (!$ret[$r[fromtime]]) $ret[$r[from]]=array();
			$ret[$r[fromtime]][$r[mashine]] = $r;
		}
		return $ret;
	}else return null;
}
/**
 * поиск карты
 *
 * @version 1.0.0
 */
function read_code_card($code, $reg=0) {
	$q = "SELECT * FROM rt_cards WHERE verify=\"$code\"";
	$q = db_query($q);
	if (mysql_num_rows($q)){
		$r = mysql_fetch_assoc($q);
		if ($reg && ($u = read_user("card", $r[number]))){
			return null;
		}else{
			return $r[number];
		}
	}else return null;
}
/**
 * добавление карты
 *
 * @version 1.0.0
 */
function add_card($card) {
	$q = "SELECT * FROM rt_cards WHERE number='$card'";
	$q = db_query($q);
	if (mysql_num_rows($q)){
		$r = mysql_fetch_assoc($q);
		return $r[verify];
	}else{
		$code = substr(md5($card.rand(1,100000)), 0, 8);
		$q = "INSERT INTO rt_cards (number, verify) VALUES ('$card', '".$code."')";
		$q = db_query($q);
		return $code;
	}
}
/**
 * проверка доступа
 *
 * @version 1.0.0
 */
function access($userID) {
	$q = "SELECT MAX(totime) totime, COUNT(*) c FROM rt_plan WHERE fromtime<".(time()+600)." AND totime>".(time()-1800)." AND userID='$userID'";
	$q = db_query($q);
	$q = mysql_fetch_assoc($q);
	if ($q[c]){
		return $q[totime]-time()+1800;
	}else{
		return 0;
	}
}

function buy($userID, $nowday, $quant, $mashine){
	$part_long = read_setting("part_long")*60;
	$mashines = read_setting("mashines");
	$plan = read_plan_day($nowday);
	if ($plan===null){
		$dayofweek = date("N", $nowday)-1;
		$timenow = read_setting("start_time_".$dayofweek)+$nowday;
		$quants = read_setting("parts_".$dayofweek);		
		for	($j=0; $j<$quants; $j++){
			for ($k=1; $k<=$mashines; $k++){
				$q = "INSERT INTO rt_plan (day, userID, fromtime, totime, mashine) VALUES ('$nowday', '0', '$timenow', '".($timenow+$part_long)."', '$k')";
				$q = db_query($q);
			}
			$timenow += $part_long;
		}
		$plan = read_plan_day($nowday);
	}
	$tonowday = $nowday + 3600*24;
	$ok = array();
	foreach ($plan as $k => $v){
		if ($k < $nowday) continue;
		if ($k > $tonowday) break;
		if ($v[$mashine]){
			$ok[] = $v[$mashine];
		}
	}//$ok[$quant]
	$q = "UPDATE rt_plan SET userID='".$userID."' WHERE planID='".$ok[$quant][planID]."'";
	$q = db_query($q);
	user_pay($userID, -read_setting("price"), "Оплата кванта времени с ".$ok[$quant][fromtime]." по ".$ok[$quant][totime]);
}

function buy_sms($userID, $nowday, $quant, $mashine, $remembers){
	$user = read_user("userID", $userID);
	$prices = array(0,100,200,300,400);
	$ok = array();
	$plan = read_plan_day($nowday);
	$tonowday = $nowday + 3600*24;
	foreach ($plan as $k => $v){
		if ($k < $nowday) continue;
		if ($k > $tonowday) break;
		if ($v[$mashine]){
			$ok[] = $v[$mashine];
		}
	}
	foreach($remembers as $rem){
		$ch = curl_init("http://sms.ru/sms/send");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POSTFIELDS, array(

			"api_id"		=>	"1cf27b49-8e99-6e44-45e7-b982dd8e5280",
			"to"			=>	$user[phone],
			"text"		=>	iconv("windows-1251","utf-8","Стирка ".(($rem[before]==1)?"начинается":"заканчивается")." через ".$rem[min]." минут. ".date("d.m.Y H:i", (($rem[before]==1)?$ok[$quant][fromtime]:$ok[$quant][totime]))),
			"time"		=>	(($rem[before]==1)?$ok[$quant][fromtime]:$ok[$quant][totime]) - $rem[min]*60,
			"from"	=> "Stiralka1",
			"partner_id" => 5932	
		));
		$body = curl_exec($ch);
		curl_close($ch);
	}
	user_pay($userID, -$prices[count($remembers)], "Оплата СМС оповещений для кванта времени с ".date("d.m.Y H:i:s", $ok[$quant][fromtime])." по ".date("d.m.Y H:i:s", $ok[$quant][totime]));
}

function get_plan($planID){
	$q = "SELECT * FROM rt_plan WHERE planID='".$planID."'";
	$q = db_query($q);
	if (mysql_num_rows($q)){
		return mysql_fetch_array($q);
	}else{
		return array();
	}
}

function cancel_buy($planID, $return){
	$user = get_plan($planID);
	$q = "UPDATE rt_plan SET userID=0 WHERE planID='".$planID."'";
	$q = db_query($q);
	if ($return){
		user_pay($user[userID], read_setting("price"), "Отмена оплаты кванта времени (id=".$planID.")");
	}
}