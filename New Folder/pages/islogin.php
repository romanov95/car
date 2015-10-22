<script>
<?php
	echo "var msg = '{\"token\" : \"".md5("passw" . $user[pass] . date("dmYH"))."\", \"userID\" : \"$_SESSION[userid]\"}';";
?>
	parent.postMessage(msg, "http://stirka.mipt1.ru");
	parent.postMessage(msg, "http://1ka.mipt1.ru");
	parent.postMessage(msg, "http://frtk.mipt1.ru");
	parent.postMessage(msg, "http://www.stirka.mipt1.ru");
	parent.postMessage(msg, "http://www.1ka.mipt1.ru");
	parent.postMessage(msg, "http://www.frtk.mipt1.ru");
</script>