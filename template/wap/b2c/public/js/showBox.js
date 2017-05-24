
function showBox(str) {
	$(".motify").fadeIn("slow");
	$(".motify-inner").text(str);
	setTimeout(function() {
		$(".motify").fadeOut("slow");
	}, 2000);
}