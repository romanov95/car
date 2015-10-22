$(function() {
	if ($( document ).tooltip)
	$( document ).tooltip({ 
		show: {
			effect: "slideDown", 
			duration: 200, 
			delay: 100
		} ,
		//track: true,
		hide: {
			effect: "fadeOut", 
			duration: 200, 
			delay: 100
		} 
	});
});
function autologinhome(event) {
	autologin(event, "home");
}
function autologin(event, where) {
  var message = JSON.parse(event.data);
  if( event.origin != 'http://93.175.29.239') {
	console.log("error");
    return;
  }
  message["action"]="autologin";
  console.log(message);
  $.ajax({
		type: "POST",
		url: "action.php",
		data: message,
		cache: false,
		error: function() {
			console.log("error2");
		},
		success: function(data) {
			if (data="ok"){
				if (where){
					location.replace("index.php");
				}else{
					location.reload();
				}
			}
		}
	});
}
function recalc_sum(){
	var s = $("#sum"), p=[0,2,3,4,5], k=0;
	for (var i=1; i<=4; i++){
		if ($("#rem"+i)[0].checked) k++;
	}
	s.html(((s.data("price"))+p[k])+' руб.');
}