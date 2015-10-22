<?php

echo show_header();

echo "<span class='name'>Бронирование кванта времени</span><br>";
switch ($_GET[error]) {
	case 1:
		echo "<b style='color:red'>Недостаточно средств на аккаунте! Необходимо <a href='index.php?page=payin'>пополнить счет</a>!</b>";
		break;
	case 2:
		echo "<b style='color:red'>Выбранный квант времени уже закончился или прошел!</b>";
		break;
	case 3:
		echo "<b style='color:red'>Бронирование стиралка на выбранный день еще не началось!</b>";
		break;
	case 4:
		echo "<b style='color:red'>Произошла неизвестная ошибка!</b>";
		break;
	case 5:
		echo "<b style='color:red'>Выбранный квант времени уже забронирован!</b>";
		break;
	case 6:
		echo "<b style='color:green'>Выбранный квант времени успешно забронирован!</b>";
		break;
}
echo show_footer();

?>