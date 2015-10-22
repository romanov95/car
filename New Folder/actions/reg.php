<?php
$_POST[fio] = mysql_real_escape_string(htmlspecialchars($_POST[fio], ENT_COMPAT | ENT_HTML401, 'cp1251'));
$_POST[login] = mysql_real_escape_string(htmlspecialchars($_POST[login], ENT_COMPAT | ENT_HTML401, 'cp1251'));
$_POST[room] = ceil($_POST[room]*1);
$_POST[gr] = mysql_real_escape_string(htmlspecialchars($_POST[gr], ENT_COMPAT | ENT_HTML401, 'cp1251'));
$_POST[email] = mysql_real_escape_string(htmlspecialchars($_POST[email], ENT_COMPAT | ENT_HTML401, 'cp1251'));
$_POST[phone] = mysql_real_escape_string(htmlspecialchars($_POST[phone], ENT_COMPAT | ENT_HTML401, 'cp1251'));
$_POST[card] = mysql_real_escape_string(strtolower(htmlspecialchars($_POST[card], ENT_COMPAT | ENT_HTML401, 'cp1251')));

$errors = "&fio=".urlencode($_POST[fio])."&login=".urlencode($_POST[login]).
	"&room=".urlencode($_POST[room])."&gr=".urlencode($_POST[gr])."&email=".urlencode($_POST[email])."&phone=".urlencode($_POST[phone])."&card=".urlencode($_POST[card]);
/*if ($_POST[card]){
	$card = read_code_card($_POST[card], 1);
	if (!$card) redirect("index.php?page=login&reg=1&error=7".$errors);
}else redirect("index.php?page=login&reg=1&error=7&1".$errors);*/
	
	
if ($_POST[login] && $_POST[pass]){
	if (strlen($_POST[pass])>5){
		if ($_POST[pass] === $_POST[pass2]){
			if (preg_match("/^([0-9]{3})|(асп[0-9]{2})$/", $_POST[gr])!==false){
				if ($_POST[room]>0 && $_POST[room]<450){
					$user = read_user("login", $_POST[login]);
					if (!$user){
						add_user($_POST[login], $_POST[pass], $_POST[email], $_POST[phone], $_POST[gr], $_POST[room], $_POST[fio], $card);
						redirect("index.php?page=login&reg=2");
					}else{
						redirect("index.php?page=login&reg=1&error=6".$errors);
					}
				}else 
					redirect("index.php?page=login&reg=1&error=5".$errors);
			}else 
				redirect("index.php?page=login&reg=1&error=4".$errors);
		}else 
			redirect("index.php?page=login&reg=1&error=3".$errors);
	}else 
		redirect("index.php?page=login&reg=1&error=2".$errors);
} else 
	redirect("index.php?page=login&reg=1&error=1".$errors);
?>