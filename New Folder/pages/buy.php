<?php
$nowday = $_GET[k]*1;
$quant = $_GET[q]*1;
$mashine = $_GET[m]*1;
$today = strtotime("today");
if ($nowday < $today)
	redirect("index.php");
	
$part_long = read_setting("part_long")*60;
$plan = read_plan_day($nowday);
$days = read_setting("days");
if ($plan===null && $nowday > strtotime("+$days days", $today))
	redirect("index.php");

if ($plan===null){
	$dayofweek = date("N", $nowday)-1;
	$timenow = read_setting("start_time_".$dayofweek)+$nowday;
	$quants = read_setting("parts_".$dayofweek);
	if (($quants < $quant) || ($mashine>read_setting("mashines")))
		redirect("index.php");	
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
		redirect("index.php");
	if ($ok[$quant][userID])
		redirect("index.php?page=buyok&error=5");
	$timenow = $ok[$quant][fromtime];
	$totime = $ok[$quant][totime];
}
	
echo show_header();
if ($user[balans] >= read_setting("price")){
	$bal = "<input type=submit value='������������� � ��������'>";
}else{
	$bal = "<b style='color:red;'>������������ ������� �� ��������! ���������� <a href='index.php?page=payin'>��������� ����</a>!</b>";
}
$price = read_setting("price")*0.01;
echo "<span class='name'>������������ ������ �������</span><br>";
echo "<form id='aaa' method='POST' action='action.php?action=buy'><center><table>
<input type=hidden name='k' value='$nowday'>
<input type=hidden name='q' value='$quant'>
<input type=hidden name='m' value='$mashine'>
<tr><td>C</td><td>".date("d.m.Y H:i", $timenow)."</td></tr>
<tr><td>��</td><td>".date("d.m.Y H:i", $totime)."</td></tr>
<tr><td><label><input type=checkbox name='rem[1][on]' id='rem1' onchange='recalc_sum();'> ��������� �� ��� �� ����� +$user[phone] *</label></td><td>�� <input type=number min=0 max=1000 step=1 name='rem[1][min]' style='width:60px' value=30 onclick='$(\"#rem1\")[0].checked=true;'> ��� <select name='rem[1][before]' onclick='$(\"#rem1\")[0].checked=true;'><option value=1>�� ������<option value=2>�� �����</select></td></tr>
<tr><td><label><input type=checkbox name='rem[2][on]' id='rem2' onchange='recalc_sum();'> ��������� �� ��� �� ����� +$user[phone] *</label></td><td>�� <input onclick='$(\"#rem2\")[0].checked=true;' type=number min=0 max=1000 step=1 name='rem[2][min]' style='width:60px' value=5> ��� <select name='rem[2][before]' onclick='$(\"#rem2\")[0].checked=true;'><option value=1>�� ������<option value=2>�� �����</select></td></tr>
<tr><td><label><input type=checkbox name='rem[3][on]' id='rem3' onchange='recalc_sum();'> ��������� �� ��� �� ����� +$user[phone] *</label></td><td>�� <input onclick='$(\"#rem3\")[0].checked=true;' type=number min=0 max=1000 step=1 name='rem[3][min]' style='width:60px' value=30> ��� <select name='rem[3][before]' onclick='$(\"#rem3\")[0].checked=true;'><option value=1>�� ������<option value=2 selected>�� �����</select></td></tr>
<tr><td><label><input type=checkbox name='rem[4][on]' id='rem4' onchange='recalc_sum();'> ��������� �� ��� �� ����� +$user[phone] *</label></td><td>�� <input onclick='$(\"#rem4\")[0].checked=true;' type=number min=0 max=1000 step=1 name='rem[4][min]' style='width:60px' value=5> ��� <select name='rem[4][before]' onclick='$(\"#rem4\")[0].checked=true;'><option value=1>�� ������<option value=2 selected>�� �����</select></td></tr>
<tr><td>C��������</td><td id=sum data-price='$price'>$price ���.</td></tr>
<tr><td>������</td><td>".($user[balans]*0.01)." ���.</td></tr>
<tr><td colspan=2 style='text-align:center;'>$bal</td></tr></table>
<form><font size=1>* ������ �������. ��������� ������ ���������: �� 1 �� 2 ���, ��������� ��������������� �������������.</font>";
echo show_footer();

?>