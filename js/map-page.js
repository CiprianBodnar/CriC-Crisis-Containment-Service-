google.load('visualization', '1', {});

var eventManager;

function initAutocomplete(map){
	var input = document.getElementById('address-keyword');
    var autocomplete = new google.maps.places.Autocomplete(input);
    input.setAttribute('placeholder', '');
    autocomplete.bindTo('bounds', map); 
    autocomplete.addListener('place_changed', function() {
		var place = autocomplete.getPlace();
		if (!place.geometry) {
			return;
		}
		if (place.geometry.viewport) {
		    map.fitBounds(place.geometry.viewport);
		} else {
		    map.setCenter(place.geometry.location);
		    map.setZoom(15); 
		}
	});
}

function initDangerForm(latLng){
	$('#add-danger').addClass('visible');
	$('.cover').fadeIn();
	if(!document.getElementById('lat-input'))
		return;
	document.getElementById('lat-input').setAttribute('value', latLng.lat);
	document.getElementById('lng-input').setAttribute('value', latLng.lng);
	var addressP = document.getElementById('location-from-coord');
	eventManager.codeLatLng(latLng, addressP);
}

function init(){
	var geocoder = new google.maps.Geocoder();
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
    google.maps.event.addDomListener(map, 'dblclick', function(e){
    	singleClick=false;
    });
    google.maps.event.addDomListener(map, 'click', function(e){
    	singleClick=true;
    	setTimeout(function(){
    		if(singleClick){
    			var latLng = {}
		    	latLng.lat = e.latLng.lat();
		    	latLng.lng = e.latLng.lng();
		    	initDangerForm(latLng);
    		}
    	}, 200);
    });
    initAutocomplete(map);
    eventManager = new EventManager(map, geocoder);
    eventManager.loadEvents(new Date(), new Date());
    eventManager.setCurrentLocation();
}

google.maps.event.addDomListener(window, 'load', init);

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
$('.modal-close').on('click', function(){
	$('.modal').removeClass('visible');
	$('.cover').fadeOut(200);
});
$('.cover').on("click", function(){
	$('.modal').removeClass('visible');
	$(this).fadeOut(200);
})