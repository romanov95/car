<?php

echo show_header();

echo "<span class='name'>������������ ������ �������</span><br>";
switch ($_GET[error]) {
	case 1:
		echo "<b style='color:red'>������������ ������� �� ��������! ���������� <a href='index.php?page=payin'>��������� ����</a>!</b>";
		break;
	case 2:
		echo "<b style='color:red'>��������� ����� ������� ��� ���������� ��� ������!</b>";
		break;
	case 3:
		echo "<b style='color:red'>������������ �������� �� ��������� ���� ��� �� ��������!</b>";
		break;
	case 4:
		echo "<b style='color:red'>��������� ����������� ������!</b>";
		break;
	case 5:
		echo "<b style='color:red'>��������� ����� ������� ��� ������������!</b>";
		break;
	case 6:
		echo "<b style='color:green'>��������� ����� ������� ������� ������������!</b>";
		break;
}
echo show_footer();

?>