<?php

if (!$user[perm]) die(redirect_js("index.php"));

	$ok = activate_user($_GET[userID] * 1);
redirect("index.php?page=users");
?>