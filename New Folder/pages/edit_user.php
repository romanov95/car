<?php
echo show_header();
if (!$user[perm]) die(redirect_js("index.php"));

echo "<span class='name'>��������� ������������</span><br>";
	if ($_GET[userID]) {
			if ($u = read_user('userID', $_GET[userID] * 1)) {
			if ($_GET[error]){
				switch ($_GET[error]){
					case 1: 
						$error = "����� �����!";
						break;
					case 2: 
						$error = "OK!";
						break;
				}
			}
			
				echo "<center><div id='errortxt' class='error'>$error</div>
				<form id='form_edit' action='action.php?action=edit_user' method=POST>
				<table>
				<tr><td>userID</td><td>$u[userID]</td></tr>
				<tr><td>�����</td><td><input name='login' required value=\"".htmlspecialchars($u[login], ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
				<tr><td>������</td><td> <input placeholder='������ �� ���������' title='������ �� ���������, ���� ���� �����' id='pass' name='pass'></td></tr>
				<tr><td>���</td><td>    <input required name='fio' value=\"".htmlspecialchars($u[fio], ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
				<tr><td>������</td><td> <input placeholder='012 ��� ���14' required pattern='([0-9]{3})|(���[0-9]{2})' title='����� ������ (��� �����) ��� \"���14\" ��� �����������, ��� 14 - ��� ���������' name='gr' value=\"".htmlspecialchars($u[gr], ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
				<tr><td>�������</td><td><input required name='room' type=number min=101 max=450 pattern='[1-4][0-4][0-9]' title='��� ����� - ����� ������� � ��������� �1' value=\"".htmlspecialchars($u[room], ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
				<tr><td>E-mail</td><td> <input required type='email' name='email' value=\"".htmlspecialchars($u[email], ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
				<tr><td>�������</td><td><input required placeholder='79031234567' title='79031234567' pattern='79[0-9]{9}' type='tel' name='phone' value=\"".htmlspecialchars($u[phone], ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
				<tr><td>����� <a href='index.php?page=edit_user_card&userID=$u[userID]' class=nodecor title='�������� �� ���� �������'><img class=button src='img/edit.png'></a></td><td><div><a href='javascript:void(0);' onclick='$(this).parent().slideUp(300);$(\"#card\").parent().slideDown(300);'>��������</a></div><div style='display:none;'><input required id='card' name='card' value=\"".htmlspecialchars($u[card], ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></div></td></tr>
				<tr><td>�����</td><td><input type=checkbox value=1 name=perm ".(($u[perm]==1)?"checked":"")."></td></tr>
				<tr><td>�������</td><td><input type=checkbox value=1 name=active ".(($u[active]==1)?"checked":"")."></td></tr>
				</table>
				<input type=submit value='��������'>
				<input type=hidden name=userID value='$u[userID]'>
				</form><br><br>
				";
				
$pays = get_pay_list($u[userID]);
if ($pays){
	echo "<table><tr>
	<td>id</td>
	<td>�����</td>
	<td>��������</td>
	<td>������������</td>
	<td>�����</td>
	</tr>";
	foreach ($pays as $pay){
	if ($pay[amount]<0){
		$amountcolor = "red";
	}else{
		$amountcolor = "green";
	}
	$uname = "";
	if (strpos($pay[descr], "������ ������ ������� ")!==false){
		$m=array();
		preg_match("/������ ������ ������� � ([0-9]+) �� ([0-9]+)/", $pay[descr],$m);
		$pay[descr] = "������ ������ ������� � ".date("d.m.Y H:i:s", $m[1])." �� ".date("d.m.Y H:i:s", $m[2])."";
	}else{
		if ($pay[adminID] == -1){
			$uname = "������.������";
		}else{
			$u = read_user("userID", $pay[adminID]);
			$uname = $u[fio];
		}
	
	}
	$t = "";
	if ($pay["time"]=="0000-00-00 00:00:00"){
		$pay["time"] = "";
	}
		echo "<tr>
	<td>$pay[merchantID]</td>
	<td style='color:$amountcolor;'>".($pay[amount]*0.01)."</td>
	<td>$pay[descr]</td>
	<td>$uname</td>
	<td>$pay[time]</td>
	</tr>";
	}
}else{
	echo "���������� ������� �� ����!";
}
echo "</center>";
			}else
		echo "��������� �����-�� ������! ���������� �����! <br><a href='?page=users'>�����</a>";
	}else
		echo "��������� �����-�� ������! ���������� �����! <br><a href='?page=users'>�����</a>";
?>