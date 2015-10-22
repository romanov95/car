<?php

$test = sha1("$_POST[notification_type]&$_POST[operation_id]&$_POST[amount]&$_POST[currency]&$_POST[datetime]&$_POST[sender]&$_POST[codepro]&j73SGzafSu8hfaYgXQvA3aqI&$_POST[label]");
//$handle = fopen ("1.txt", "a");
//fwrite ($handle, "$_POST[notification_type]&$_POST[operation_id]&$_POST[amount]&$_POST[currency]&$_POST[datetime]&$_POST[sender]&$_POST[codepro]&j73SGzafSu8hfaYgXQvA3aqI&$_POST[label]\n");

if ($_POST["sha1_hash"] == $test){
//fwrite ($handle, "+\n");
	if (substr($_POST[label], 0, 7) == "stirka."){
//fwrite ($handle, "+\n");
		$uid = substr($_POST[label], 7)*1;
		if ($uid > 0){
//fwrite ($handle, "+\n");
			date_default_timezone_set("Europe/Moscow");
			$___time = time();
			//подключение
			include "includes/kernel.php";
			db_connect();
			if (read_user("userID", $uid)){
//fwrite ($handle, "+\n");
				user_pay($uid, floor($_POST[withdraw_amount]*1)*100, 
				($_POST[notification_type] == "p2p-incoming")? 
				"јвтоматическое пополнение через яндекс.деньги":
				"јвтоматическое пополнение с банковской карты", -1);
			}
		}
	}
}
?>1