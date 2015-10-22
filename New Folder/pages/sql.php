<?php
echo show_header();
if (!$user[perm]) die(redirect_js("index.php"));

echo "<span class='name'>Запросы</span><br>
<center><form method='POST'>
SELECT <br>
<textarea name='sql' cols=30 rows=4>".($_POST[sql]?:"* FROM rt_merchant")."</textarea><br>
<input type=submit value='OK'>
</form>
</center>
";
if ($_POST[sql]){
	$sql = make_sql($_POST[sql]);
	echo "<table><tr>";
	if ($sql){
	foreach ($sql[0] as $k => $v){
		echo "<td>$k</td>";
	};
	echo "</tr>";
	foreach ($sql as $r){
	echo "<tr>";
		foreach ($r as $k => $v){
			echo "<td>$v</td>";
		};
		echo "</tr>";
	}
}else{
	echo "Ничего нет!";
}
echo "</center>";
}

echo show_footer();

?>