<?php
echo show_header();
if (!$user[perm]) die(redirect_js("index.php"));

echo "<span class='name'>���������</span><br>";
	if ($_GET[error]){
		switch ($_GET[error]){
			case 1: 
				$error = "���������!";
				break;
		}
	}
	
	echo "<center style='color:green; font-weight: bold;'>$error</center><form action='action.php?action=settings' method='POST'>
	<table align=center>
	<tr><td>��������� ������ �������</td><td><input type=number step='0.01' min=0 name='price' required value='".(read_setting("price")*0.01)."' size=5 pattern='[0-9]+\.?[0-9]{0,2}'> ���.</td></tr>
	<tr><td>������������ ������ �������</td><td><input type=number step='1' min=0 name='part_long' required value='".read_setting("part_long")."' size=5 pattern='[0-9]+'> ���</td></tr>
	<tr><td>���������� ���� ������ �� �������</td><td><input type=number step='1' min=0 name='days' required value='".read_setting("days")."' size=5 pattern='[0-9]+'></td></tr>
	<tr><td>���������� ���������� �����</td><td><input type=number step='1' min=0 name='mashines' required value='".read_setting("mashines")."' size=5 pattern='[0-9]+'></td></tr>
	<tr><td colspan=2 style='text-align:center;'>����� ������</td></tr>
	<tr><td colspan=2>
	<table>
	<tr><td></td><td>��</td><td>��</td><td>��</td><td>��</td><td>��</td><td>��</td><td>��</td></tr>
	<tr><td>������</td>";
	for ($i=0; $i<7; $i++){
		$s = read_setting("start_time_$i");
		echo "<td><input name='start_hour[$i]' value='".round($s/3600)."' required placeholder='��' maxlength=2 type=number min=0 style='width:24px;'
			max=23 pattern='(([01]?[0-9])|(2[0-3]))' title='������� ���'>:" .
		"<input name='start_min[$i]' value='".(round($s/60)%60)."' placeholder='��' required maxlength=2 type=number min=0 style='width:24px;'
			max=59 pattern='[012345]?[0-9]' title='������� ������'></td>";
	}
	echo "</tr><tr><td>���������� �������</td>";
	for ($i=0; $i<7; $i++){
		echo "<td><input name='parts[$i]' value='".read_setting("parts_$i")."' required maxlength=2 type=number min=0 style='width:54px;'
			max=100 pattern='[0-9]+' title='������� ���������� ������� ������� � ���� ����'>";
	}
	echo "</tr>
	</table>
	</td></tr>
	<tr><td colspan=2 style='text-align:center;'><input type=submit value='���������'></td></tr>
	</table>
	</form>";	
		
echo show_footer();
?>