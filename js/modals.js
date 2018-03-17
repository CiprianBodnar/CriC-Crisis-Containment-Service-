$('.modal-close').on('click', function(){
	$('.modal').removeClass('visible');
	$('.cover').fadeOut(200);
});
$('#search-trigger').on('click', function(){
	$("#search").addClass('visible');
	$('.cover').fadeIn(200);
});
$('.cover').on("click", function(){
	$('.modal').removeClass('visible');
	$(this).fadeOut(200);
})