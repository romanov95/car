<?php

if (!$user[perm]) die(redirect_js("index.php"));

$_POST[description] = mysql_real_escape_string(htmlspecialchars($_POST[description], ENT_COMPAT | ENT_HTML401, 'cp1251'));
$_POST[userID]*=1;
$_POST[sum]=ceil($_POST[sum]*100);
if (abs($_POST[sum])<1)
	redirect("index.php?page=user_pay&userID=$_POST[userID]");
	
$ok = user_pay($_POST[userID], $_POST[sum], $_POST[description]);
redirect("index.php?page=user_pay&userID=$_POST[userID]&error=1");

?>