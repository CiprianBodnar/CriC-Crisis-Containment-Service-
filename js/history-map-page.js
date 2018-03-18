function createMap(){
    var mapContainer = document.getElementById("map-container");
    var mapOptions = {
        center: new google.maps.LatLng(46.1739206 , 25.5752338),
        zoom: 7,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControlOptions: {
              style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
              position: google.maps.ControlPosition.BOTTOM_CENTER
          }
    }
    var map = new google.maps.Map(mapContainer, mapOptions);    
}
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
	$('.wrapper').addClass('input-visible');
	document.getElementById('address-keyword').focus();
});
$("#address-keyword").on("blur", function(){
	$('.input-trigger').addClass('visible');
	$('.wrapper').removeClass('input-visible');
});
