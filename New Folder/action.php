<?php
date_default_timezone_set("Europe/Moscow");
//подключение
include "includes/kernel.php";
db_connect();
$noclose=0;
if (strpos($_REQUEST[action], "/") !== false || strpos($_REQUEST[action], "\\") !== false) {
	die("error");
}
sess($noclose);
//страница
if ($_REQUEST[action])
	$action = $_REQUEST[action]; else
	die("error");
//проверка наличия страницы
if (!file_exists("actions/" . $action . ".php"))
	die("error");
//залогинен ли?
$user = islogin();
if (!$user && ($action != 'login' && $action != 'autologin' && $action != 'reg'))
	redirect("index.php");
header('Content-Type: text/html; charset=windows-1251');
include "actions/" . $action . ".php";
?>