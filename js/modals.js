$('.modal-close').on('click', function(){
	$('.modal').removeClass('visible');
	$('.cover').fadeOut(200);
});

$('#search-trigger').on('click', function(){
	$("#search").addClass('visible');
	$('.cover').fadeIn(200);
});

$('#share-trigger').on('click', function(){
	$("#share").addClass('visible');
	$('.cover').fadeIn(200);
});


$('.cover').on("click", function(){
	$('.modal').removeClass('visible');
	$(this).fadeOut(200);
})

 $(function(){
    $('input[name="showthis"]').hide();
    $('input[name="checkbox"]').on('click', function(){
        if ($(this).prop('checked')){
            $('input[name="showthis"]').fadeIn();
        } else{
            $('input[name="showthis"]').hide();
        }
    });
});