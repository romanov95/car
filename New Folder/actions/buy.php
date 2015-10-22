<?php
$nowday = $_POST[k]*1;
$quant = $_POST[q]*1;
$mashine = $_POST[m]*1;
$today = strtotime("today");
if ($nowday < $today)
	redirect("index.php?page=buyok&error=2");
	
$part_long = read_setting("part_long")*60;
$plan = read_plan_day($nowday);
$days = read_setting("days");
if ($plan===null && $nowday > strtotime("+$days days", $today))
	redirect("index.php?page=buyok&error=3");

if ($plan===null){
	$dayofweek = date("N", $nowday)-1;
	$timenow = read_setting("start_time_".$dayofweek)+$nowday;
	$quants = read_setting("parts_".$dayofweek);
	if (($quants < $quant) || ($mashine>read_setting("mashines")))
		redirect("index.php?page=buyok&error=4");	
	for	($j=0; $j<$quant; $j++){
		$timenow += $part_long;
	}
	$totime = $timenow + read_setting("part_long")*60;
}else{
	$tonowday = $nowday + 3600*24;
	$ok = array();
	foreach ($plan as $k => $v){
		if ($k < $nowday) continue;
		if ($k > $tonowday) break;
		if ($v[$mashine]){
			$ok[] = $v[$mashine];
		}
	}
	if (!$ok[$quant])
		redirect("index.php?page=buyok&error=4");
	if ($ok[$quant][userID])
		redirect("index.php?page=buyok&error=5");
	$timenow = $ok[$quant][fromtime];
	$totime = $ok[$quant][totime];
}

if ($timenow < time())
	redirect("index.php?page=buyok&error=2");
$rems=0; 
$prices = array(0,200,300,400,500);
$remembers=array();
if ($_POST[rem]){
	foreach($_POST[rem] as $rem){
		if ($rem[on]){
			$remembers[] = array(before => $rem[before]*1, min => $rem[min]*1);
		}
	}
}
	
if ($user[balans] >= (read_setting("price") + $prices[count($remembers)])){
	buy($user[userID], $nowday, $quant, $mashine);
	if ($remembers){
		buy_sms($user[userID], $nowday, $quant, $mashine, $remembers);
	}
	redirect("index.php?page=buyok&error=6");
}else{
	redirect("index.php?page=buyok&error=1");
}

?>