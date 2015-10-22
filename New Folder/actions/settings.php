<?php

if (!$user[perm]) die(redirect_js("index.php"));

$_POST[price] = ceil(100*$_POST[price]);
edit_setteng("price", $_POST[price]);
$_POST[part_long] = ceil($_POST[part_long]*1);
edit_setteng("part_long", $_POST[part_long]);
edit_setteng("days", ceil($_POST[days]));
edit_setteng("mashines", ceil($_POST[mashines]));
for ($i=0; $i<7; $i++){
	edit_setteng("start_time_$i", (ceil($_POST[start_hour][$i])*3600+60*ceil($_POST[start_min][$i])));
	edit_setteng("parts_$i", ceil($_POST[parts][$i]));
}
redirect("index.php?page=settings&error=1");

?>