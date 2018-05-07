
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
    $('input#address-input').hide();
    $('input#checkbox').on('click', function(){
        if ($(this).prop('checked')){
            $('input#address-input').fadeIn();
            initAutocomplete();
        } else{
            $('input#address-input').hide();
        }
    });
});


