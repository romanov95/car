<?php
date_default_timezone_set("Europe/Moscow");
$___time = time();
//подключение
include "includes/kernel.php";
db_connect();
sess();
if (strpos($_REQUEST[page], "/") !== false || strpos($_REQUEST[page], "\\") !== false) {
	redirect("index.php");
	die();
}
//страница
if ($_REQUEST[page])
	$page = $_REQUEST[page]; else
	$page = "home";
if (!$_SESSION[userid] && $_GET[js] && $page!="login"){
	if ($page == "islogin") die();
	echo redirect_js("index.php");
	die();
}	
//проверка наличия страницы
if (!file_exists("pages/" . $page . ".php"))
	$page = "home";
//залогинен ли?
$user = islogin();

if (!$user) {
	$page = "login";
	$_GET[page] = "login";
} elseif ($page == 'login')
	$page = 'home';
header('Content-Type: text/html; charset=windows-1251');

	$GLOBALS[page] = $page;
	include "pages/" . $page . ".php";

?>