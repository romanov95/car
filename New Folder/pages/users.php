<?php
echo show_header();
if (!$user[perm]) die(redirect_js("index.php"));

echo "<span class='name'>Управление пользователями</span><br>";
	
	
	echo "
	<table align=center>
	<tr>
	<td>id    </td>
	<td>Логин </td>
	<td>ФИО   </td>
	<td>e-mail</td>
	<td>Телефон</td>
	<td>Группа</td>
	<td>Комната</td>
	<td>Баланс (руб)</td>
	<td>Актив</td>
	<td>Админ</td>
	<td>Действия</td>
	</tr>";
	$list = user_list();
	for ($i=0; $i<count($list); $i++){//login, pass VARCHAR(32), email VARCHAR(128), phone VARCHAR(30), gr VARCHAR(10), room INT(3), fio TEXT, balans INT, active INT(1), perm 
		echo "<tr id='r_".$list[$i][userID]."' class='rh'>
		<td>".$list[$i][userID]."</td>
		<td>".$list[$i][login]."</td>
		<td>".$list[$i][fio]."</td>
		<td>".$list[$i][email]."</td>
		<td>".$list[$i][phone]."</td>
		<td>".$list[$i][gr]."</td>
		<td>".$list[$i][room]."</td>
		<td>".(0.01*$list[$i][balans])."</td>
		<td style='text-align:center;'>".($list[$i][active]?"<img src='img/ok.png'>":"")."</td>
		<td style='text-align:center;'>".($list[$i][perm]?"<img src='img/ok.png'>":"")."</td>
		<td style='text-align:center;'>".
			($list[$i][active]?"":"<a href='action.php?action=activate_user&userID=".$list[$i][userID]."' onclick='return confirm(\"Действительно активировать?\");' class='nodecor' title='Активировать'><img class=button src='img/ok.png'></a> ").
			"<a href='index.php?page=edit_user&userID=".$list[$i][userID]."' class='nodecor' title='Редактировать'><img class=button src='img/edit.png'></a> ".
			"<a href='index.php?page=user_pay&userID=".$list[$i][userID]."' class='nodecor' title='Пополнить счет'><img class=button src='img/rouble.png'></a> ".
			"<a href='action.php?action=del_user&userID=".$list[$i][userID]."' onclick='return confirm(\"Действительно удалить?\");' class='nodecor' title='Удалить'><img class=button src='img/del.png'></a> ".
			"</td>";
		echo "</tr>";
	};	
		
	echo "</table>";	
		
echo show_footer();
?>