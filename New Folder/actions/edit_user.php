<?php

if (!$user[perm]) die(redirect_js("index.php"));

$_POST[fio] = mysql_real_escape_string(htmlspecialchars($_POST[fio], ENT_COMPAT | ENT_HTML401, 'cp1251'));
$_POST[login] = mysql_real_escape_string(htmlspecialchars($_POST[login], ENT_COMPAT | ENT_HTML401, 'cp1251'));
$_POST[room] = ceil($_POST[room]*1);
$_POST[gr] = mysql_real_escape_string(htmlspecialchars($_POST[gr], ENT_COMPAT | ENT_HTML401, 'cp1251'));
$_POST[email] = mysql_real_escape_string(htmlspecialchars($_POST[email], ENT_COMPAT | ENT_HTML401, 'cp1251'));
$_POST[phone] = mysql_real_escape_string(htmlspecialchars($_POST[phone], ENT_COMPAT | ENT_HTML401, 'cp1251'));
$_POST[card] *= 1;//($_POST[card][0]*1).(substr($_POST[card], 1)*1);
$_POST[userID]*=1;
		if ($u = read_user("login", $_POST[login])){
			if ($u[userID] != $_POST[userID]){
				redirect("index.php?page=edit_user&userID=$_POST[userID]&error=1");
				die();
			}
		}
		$ok = edit_user($_POST[userID], $_POST[login], $_POST[pass], $_POST[email], $_POST[phone], $_POST[gr], $_POST[room], $_POST[fio], $_POST[active]*1, 1*$_POST[perm], $_POST[card]);
		redirect("index.php?page=edit_user&userID=$_POST[userID]&error=2");

?>