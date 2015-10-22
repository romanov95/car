<?php
if ($_POST[userID] && $_POST[token]){
	$user = autologin($_POST[userID]*1, $_POST[token]);
	if ($user==1) {
		echo "ok";
	}
}