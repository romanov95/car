<?php
include "includes/kernel.php";
$i=1;
	$ticket = "lvhzdughhjky";
	include $home . "includes/rootpass.php";
	$connection = mysql_connect($domen, $mysqllogin, $mysqlpassword) or die("Ошибка подключения к MySQL, неверные параметры!");
	mysql_set_charset($mysql_charset);
$query = "CREATE DATABASE ".$affprogdb;
$result = mysql_query ($query) or die ("Невозможно создать таблицу! error: $i. ".mysql_error());
$i++;
	
	$home = mysql_select_db($affprogdb, $connection) or die("Ошибка выбора БД");
$query = "CREATE TABLE rt_users (userID INT auto_increment, login VARCHAR(50), pass VARCHAR(32), email VARCHAR(128), phone VARCHAR(30), gr VARCHAR(10), room INT(3), fio TEXT, card INT, balans INT, active INT(1), perm INT, deleted INT(1) DEFAULT 0, primary key (userID),  unique id (userID))";
$result = mysql_query ($query) or die ("Невозможно создать таблицу! error: $i. ".mysql_error());
$i++;
$query = "CREATE TABLE rt_cards (cardID INT auto_increment, number INT, verify VARCHAR(10), primary key (cardID),  unique id (cardID))";
$result = mysql_query ($query) or die ("Невозможно создать таблицу! error: $i. ".mysql_error());
$i++;
$query = "CREATE TABLE rt_merchant (merchantID INT auto_increment, userID INT, amount INT, descr TEXT, adminID INT, primary key (merchantID),  unique id (merchantID))";
$result = mysql_query ($query) or die ("Невозможно создать таблицу! error: $i. ".mysql_error());
$i++;
$query = "CREATE TABLE rt_settings (setID INT auto_increment, name TEXT, value TEXT, primary key(setID), unique id(setID))";
$result = mysql_query ($query) or die ("Невозможно создать таблицу! error: $i. ".mysql_error());
$i++;
$query = "CREATE TABLE rt_plan (planID INT auto_increment, day INT, userID INT, fromtime INT, totime INT, mashine INT, primary key(planID), unique id(planID))";
$result = mysql_query ($query) or die ("Невозможно создать таблицу! error: $i. ".mysql_error());
$i++;

?>