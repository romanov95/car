<?php
if ($_SERVER[SERVER_NAME] == "93.175.29.239"){
	header("Location: http://stirka.mipt1.ru/index.php?page=payin");die();
};
echo show_header();

echo "<span class='name'>���������� �������</span><br>";
echo "�� ������ ������ ���������� ��� ������� ���������� ������� ��������:<br><br>
1. <b>���������</b> ������ �� ������������� �� ��������:<center>
<br><table>
<tr><td><b>���</b></td><td><b>�������</b></td></tr>
<tr><td>������� ������ ���������</td><td>1-119</td></tr>
</table>
<br><br>
2. <b>������.�������� ��� � ���������� �����</b>* online**:<br>
".'<iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/shop.xml?account=410013627828620&quickpay=shop&payment-type-choice=on&writer=seller&targets=%D0%9F%D0%BE%D0%BF%D0%BE%D0%BB%D0%BD%D0%B5%D0%BD%D0%B8%D0%B5+%D0%B1%D0%B0%D0%BB%D0%B0%D0%BD%D1%81%D0%B0+%D0%BF%D1%80%D0%BE%D0%BA%D0%B0%D1%82%D0%B0+%5B'.$user[userID].'%5D&targets-hint=&default-sum=250&button-text=01&successURL=http%3A%2F%2Fcars.mipt1.ru%2Findex.php%3Fpage%3Dpayin&label=stirka.'.$user[userID].'" width="450" height="200"></iframe>'."<br><font size=1>* � ��������� ������� � ����� ����� ��������� �������������� �������� � ���� ���� �������� ������ ��� ������ ��������.<br>** �� ������ ����������� ������ ����� ����� �����, �.�. ��� ������ �� ����� 30,5 ������ ��������� ����� 30.</font><br><br><center>";

$pays = get_pay_list($user[userID]);
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
		}elseif (strpos($pay[descr], "������ ���")!==false){
			$uname = "���";
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

echo show_footer();

?>