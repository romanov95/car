<?php

echo show_header();

if ($user[perm]==1){
	echo "<a href='?page=users'>���������� �������������</a><br>
	<a href='?page=settings'>���������</a><br>";
	$adm=1;
}
echo "<span class='name'>���������� �����</span><br>";
echo "<table><tr><td></td>";
if ($user[perm] && $_POST[what]){
	if ($_POST[what] == "hide"){
		edit_setteng("mashines-hidden", read_setting("mashines-hidden").",$_POST[m],");
	}else{
		edit_setteng("mashines-hidden", str_replace(",$_POST[m],", "", read_setting("mashines-hidden")));
	}
}
$mashines = read_setting("mashines");
$hidden = read_setting("mashines-hidden");
for ($i=1; $i<=$mashines; $i++){
	if (!$user[perm] && strpos($hidden, ",$i,") !== false){
		continue;
	}	
	if ($user[perm]){
		if (strpos($hidden, ",$i,") !== false){
			$button = "<br><form method=POST><input type=hidden name='m' value='$i'><input type=hidden name='what' value='show'><input type='submit' value='��������'></form>";
		}else{
			$button = "<br><form method=POST><input type=hidden name='m' value='$i'><input type=hidden name='what' value='hide'><input type='submit' value='������'></form>";
		}
	}
	echo "<td><center><a href='instructions/$i.pdf'>������ $i</a>$button</center></td>";
}
echo "</tr>";
$part_long = read_setting("part_long")*60;
$days=read_setting("days");
$nowday = strtotime("today");
if ($user[perm]==1 && $_GET[from]){
	$nowday_tmp = strtotime($_GET[from]);
	if ($nowday_tmp){
		$nowday = $nowday_tmp;
	}
}
for ($i=0; $i<=$days; $i++){
	$plan = read_plan_day($nowday);
	$dayofweek = date("N", $nowday)-1;
	if ($plan === null){
		$timenow = read_setting("start_time_".$dayofweek)+$nowday;
		$quants = read_setting("parts_".$dayofweek);
		for	($j=0; $j<$quants; $j++){
			echo "<tr><td title='��������� � ".date("H:i", $timenow+$part_long)."'>".date("d.m.Y H:i", $timenow)."</td>";
			for ($k=1; $k<=$mashines; $k++){
				if (!$user[perm] && strpos($hidden, ",$k,") !== false){
					continue;
				}	
				if ($timenow < time()){
					$color = "yellow";
					$text = "������";
				}else{
					$color = "#91FF72;";
					$text = "<a href='index.php?page=buy&k=$nowday&q=$j&m=$k' title='������������� � ��������'>��������</a>";
				}
				echo "<td style='min-width: 100px; text-align: center; background-color: $color;'>$text</td>";
			}
			echo"</tr>";
			$timenow += $part_long;
		}
	}else{
		$j=0;
		foreach($plan as $k => $v){
			if (!$k) continue;
			echo "<tr><td title='��������� � ".date("H:i", $v[1][totime])."'>".date("d.m.Y H:i", $k*1)."</td>";
			foreach ($v as $m => $vv){
				if (!$user[perm] && strpos($hidden, ",$m,") !== false){
					continue;
				}	
				if ($vv[userID]){
					if ($user[userID] == $vv[userID]){
						$color = "green";
						$text = "�������������";
						if ($user[perm]==1){
							$nowu = read_user("userID", $vv[userID]);
							$text .= " <a href='/action.php?action=cancel_buy&return=1&planID=$vv[planID]' onclick='if (!confirm(\"������������� �������� ����� � ������� ������?\")) return false;' class='nodecor'><img class='button' src='img/del.png' title='�������� � ��������� �������'></a>";
						}
					}else{
						$color = "pink";
						$nowu = read_user("userID", $vv[userID]);
						$text = "�������������<br>$nowu[fio] $nowu[room]<br>";
						if ($user[perm]==1){
							$text .= "<a href='/index.php?page=edit_user&userID=$vv[userID]' class='nodecor'><img class='button' src='img/user.png' title='�������'></a>
							<a href='/index.php?page=user_pay&userID=$vv[userID]' class='nodecor'><img class='button' src='img/rouble.png' title='�������� ������'></a>
							<a href='/action.php?action=cancel_buy&return=0&planID=$vv[planID]' onclick='if (!confirm(\"������������� �������� ����� � �� ������� ������?\")) return false;' class='nodecor'><img class='button' src='img/cancel.png' title='�������� ��� �������� �������'></a>
							<a href='/action.php?action=cancel_buy&return=1&planID=$vv[planID]' onclick='if (!confirm(\"������������� �������� ����� � ������� ������?\")) return false;' class='nodecor'><img class='button' src='img/del.png' title='�������� � ��������� �������'></a>";
						}
					}
				}else{
					if ($vv[fromtime] < time()){
						$color = "yellow";
						$text = "������";
					}else{
						$color = "#B1FF92;";
						$text = "<a href='index.php?page=buy&k=$nowday&q=$j&m=$m' title='������������� � ��������'>��������</a>";
					}
				}
				echo "<td style='min-width: 100px; text-align: center; background-color: $color;'>$text</td>";
			}
			echo "</tr>";
			$j++;
		}
	}
	$nowday = strtotime("+1 day", $nowday);
}
echo "</table>";
if ($_GET[error]){
	switch ($_GET[error]){
		case "delok":
			echo "<script>alert('����� � �������� ��������������!');</script>";
			break;
		case "some":
			echo "<script>alert('��������� ����������� ������!');</script>";
			break;
	}
}
echo show_footer();

?>