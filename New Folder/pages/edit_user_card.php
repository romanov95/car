<?php
echo show_header();
if (!$user[perm]) die(redirect_js("index.php"));

echo "<span class='name'>��������� ����� ������������</span><br>";
	if ($_GET[userID]) {
			if ($u = read_user('userID', $_GET[userID] * 1)) {
			if ($_GET[error]){
				switch ($_GET[error]){
					case -1: 
						$error = "�������� ���!";
						break;
					case 1: 
						$error = "OK!";
						break;
				}
			}
			
				echo "<center><div id='errortxt' class='error'>$error</div>
				<form id='form_edit' action='action.php?action=edit_user_card' method=POST>
				<table>
				<tr><td>userID</td><td>$u[userID]</td></tr>
				<tr><td>�����</td><td>$u[login]</td></tr>
				<tr><td>���</td><td>$u[fio]</td></tr>
				<tr><td>��� �������</td><td> <input id='new_code' name='new_code'></td></tr>
				</table>
				<input type=submit value='��������'>
				<input type=hidden name=userID value='$u[userID]'>
				</form>
				";
			}else
		echo "��������� �����-�� ������! ���������� �����! <br><a href='?page=users'>�����</a>";
	}else
		echo "��������� �����-�� ������! ���������� �����! <br><a href='?page=users'>�����</a>";
?>