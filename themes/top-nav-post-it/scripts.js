$(document).ready(function(){
	AOS.init();

	$('.container').flowtype({
		minimum   : 299,
		maximum   : 1500,
		minFont   : 16,
		maxFont   : 20,
		fontRatio : 30
	});
	$('ul').flowtype({
		minFont   : 16,
		maxFont   : 18,
		fontRatio : 30
	});
});