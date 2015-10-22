<?php
if (!$_GET[planID]){
	redirect("/?error=some");
}
$plan = get_plan($_GET[planID]*1);
if ($user[perm]!=1){
	if ($user[userID] == $plan[userID]){
		$_GET['return'] = 1;
	}else{
		redirect("/?error=some");
	}
}

cancel_buy($plan[planID], $_GET['return']*1);
redirect("/?error=delok");

?>