<?php
if ($_GET[js]) die();
echo show_header();
if($_GET[reg]==1){
	if ($_GET[error]){
		if ($_GET[error]==1) $error="���������� ��������� ��� ����!";
		if ($_GET[error]==2) $error="����������� ����� ������ - 6 ��������!";
		if ($_GET[error]==3) $error="��������� ������ �� ���������!";
		if ($_GET[error]==4) $error="������ ������� �����������! ����� ������ (��� �����) ��� \"���14\" ��� �����������, ��� 14 - ��� ���������.";
		if ($_GET[error]==5) $error="����� ������� ������ �����������!";
		if ($_GET[error]==6) $error="����� ��� �����!";
		if ($_GET[error]==7) $error="������������ ��� ���������!<br>��� ��������� ���� ��������� ���������� ��������� ����� �������� � ��������� ����� ��������";
		$error = "<span class='error'>$error</span><br>";
	};
	echo "<center><form name='regform' method='POST' action='action.php?action=reg'><span class='name'>����������� � ��������</span><br>
	$error
	<table>
	<tr><td>�����</td><td><input name='login' required value=\"".htmlspecialchars(urldecode($_GET[login]), ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
	<tr><td>������</td><td> <input type='password' pattern='.{6,}' title='����������� ����� ������ - 6 ��������' required name='pass'></td></tr>
	<tr><td>��������� ������</td><td> <input required type='password' name='pass2'></td></tr>
	<tr><td>���</td><td>    <input required name='fio' value=\"".htmlspecialchars(urldecode($_GET[fio]), ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
	<tr><td>������</td><td> <input placeholder='012 ��� ���14' required pattern='([0-9]{3})|(���[0-9]{2})' title='����� ������ (��� �����) ��� \"���14\" ��� �����������, ��� 14 - ��� ���������' name='gr' value=\"".htmlspecialchars(urldecode($_GET[gr]), ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
	<tr><td>�������</td><td><input required name='room' type=number min=101 max=450 pattern='[1-4][0-4][0-9]' title='��� ����� - ����� ������� � ��������� �1' value=\"".htmlspecialchars(urldecode($_GET[room]), ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
	<tr><td>E-mail</td><td> <input required type='email' name='email' value=\"".htmlspecialchars(urldecode($_GET[email]), ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
	<tr><td>�������</td><td><input required placeholder='79031234567' title='79031234567' pattern='79[0-9]{9}' type='tel' name='phone' value=\"".htmlspecialchars(urldecode($_GET[phone]), ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
	<tr><td>��� ��������� ����� *</td><td><input name='card' value=\"".htmlspecialchars(urldecode($_GET[card]), ENT_COMPAT | ENT_HTML401, 'cp1251')."\"></td></tr>
	</table>
	<br>
	<input type='submit' value='������������������'><br>
	*��� ��������� ���� ��������� ���������� ������� � �������� � ��������� ����� ��������.
	</form></center>
	";
}elseif($_GET[reg]==2){
	echo "<span class='name'>����������� �������</span><br>
	����������� ������ �������, ������ ��� ������� �� �����������!<br>��� ��������� �������� ��� ���������� ������� � ������ �� ������������� �� ��������:
	<br><center><table>
	<tr><td><b>���</b></td><td><b>�������</b></td></tr>
	<tr><td>�������� ������ ����������</td><td>1-419</td></tr>
	<tr><td>������ ����� ���������</td><td>1-419</td></tr>
	</table></center>
	<br>
	<a href='index.php'>�� �������</a>";
}else{
	if ($_GET[error]){
		if ($_GET[error]==1) $error="���������� ������ ����� � ������!";
		if ($_GET[error]==2) $error="�������� ����� �/��� ������ ��� ������� �� �����������!";
		$error = "<span class='error'>$error</span><br>";
	};
	echo "<form name='loginform' method='POST' action='"./*(($_SERVER[SERVER_NAME] == 'stirka')?"":'http://93.175.29.239/').*/"action.php?action=login'><!--<span class='name'>������ ����� �� �������</span>--><br>
	<img src='img/frtk.png'>
	<br><br>
	$error
	����� <input required name='login' value='$_GET[login]'><br>
	������ <input required type='password' name='pass'><br><br>
	<input type='submit' value='�����'><br>
	<a href='index.php?page=login&reg=1'>�����������</a>
	 <input type=hidden name='from' value='$_SERVER[SERVER_NAME]'>
	</form>
	<script>window.onmessage = autologin;</script><iframe width=1 height=1 frameborder=0 src='http://93.175.29.239/index.php?page=islogin'></iframe>
	";
}
echo "<script>
$('#btn_exit').hide();
</script>";
echo show_footer();
?>