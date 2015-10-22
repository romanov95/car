<?php
$_POST[login] = mysql_real_escape_string(htmlspecialchars($_POST[login], ENT_COMPAT | ENT_HTML401, 'cp1251'));
$from = $_POST[from];

if ($_POST[login] && $_POST[pass]){
	$user = login($_POST[login], $_POST[pass]);
	if ($user) 
		redirect("http://$from/gohome.php");
	else 
		redirect("http://$from/index.php?page=login&error=2&login=".urlencode($_POST[login]));
} else 
	redirect("http://$from/index.php?page=login&error=1&login=".urlencode($_POST[login]));
?>