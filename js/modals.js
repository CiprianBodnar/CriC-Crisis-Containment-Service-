
$('#search-trigger').on('click', function(){
	$("#search").addClass('visible');
	$(".modals-container").fadeIn(200);
	$('.cover').fadeIn(200);
});

$('#share-trigger').on('click', function(){
	$("#share").addClass('visible');
	$(".modals-container").fadeIn(200);
	$('.cover').fadeIn(200);
});

$('#in-danger').on('click', function(){
	$("#inDanger").addClass('visible');
	$(".modals-container").fadeIn(200);
	$('.cover').fadeIn(200);
});

$('.cover').on("click", function(){
	$('.modal').removeClass('visible');
	$(this).fadeOut(200);
});

$('.bottom-nav-menu ul li').on("click", function(){
	if($(this).is('.tab-selected')){
		$(this).removeClass('tab-selected');
		$('.tab').removeClass('tab-visible');
	}
	else{
		$('.bottom-nav-menu ul li').removeClass('tab-selected');
		$(this).addClass('tab-selected');
		var tab = $(this).data('tab');
		$('.tab').removeClass('tab-visible');
		$('.tab#'+tab).addClass('tab-visible');
	}
});

$('.input-trigger').on("click", function(){
	$(this).removeClass('visible');
	$('#map-cover').fadeIn(200);
	$('.wrapper').addClass('input-visible');
	document.getElementById('address-keyword').focus();
});

$("#address-keyword").on("blur", function(e){
	e.preventDefault();
	$('.input-trigger').addClass('visible');
	$(this).val('');
	$('.wrapper').removeClass('input-visible');
	$('#map-cover').fadeOut(200);
});

$('.modal').on('click', function(e){e.stopPropagation();});
$('.modal-close').on('click', function(){
	$('.modal').removeClass('visible');
	$('.cover').fadeOut(200);
	$('.modals-container').hide();
});

$('.modals-container').on("click", function(){
	$('.modal').removeClass('visible');
	$('.cover').fadeOut(200);
	$(this).fadeOut(200);
});

$('.second-cover, .popup-close').on("click", function(e){
	e.stopPropagation();
	$('.second-cover').fadeOut();
	$('.second-cover .modal').removeClass('visible');
});

 $(function(){
    $('input#share-address-input').hide();
    $('input#checkbox').on('click', function(){
        if ($(this).prop('checked')){
            $('input#share-address-input').fadeIn();
        } else{
            $('input#share-address-input').hide();
        }
    });
});


