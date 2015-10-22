<?php

if (!$user[perm]) die(redirect_js("index.php"));


$_POST[new_code] = mysql_real_escape_string(strtolower(htmlspecialchars($_POST[new_code], ENT_COMPAT | ENT_HTML401, 'cp1251')));
$_POST[userID]*=1;
		
		$ok = edit_user_card($_POST[userID], $_POST[new_code]);
		redirect("index.php?page=edit_user_card&userID=$_POST[userID]&error=$ok");

?>