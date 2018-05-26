
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
function updateFilterOptions(){
	var filterOptions = {};
	filterOptions.hideAll = document.getElementById('hide-all').checked;
	filterOptions.fire = document.getElementById('fire').checked;
	filterOptions.person = document.getElementById('person').checked;
	filterOptions.earthquake = document.getElementById('earthquake').checked;
	filterOptions.snow_storm = document.getElementById('snow-storm').checked;
	filterOptions.flood = document.getElementById('flood').checked;
	filterOptions.radius = document.getElementById('radius').checked;

	if (filterOptions.hideAll){
		for(let other of document.getElementsByClassName('filter-option')){
			if(other != document.getElementById('hide-all')){
				other.disabled = true;
			}
		}
	}
	else{
		for(let other of document.getElementsByClassName('filter-option')){
			if(other != document.getElementById('hide-all')){
				other.disabled = false;
			}
		}
	}
	eventManager.filter(filterOptions);
}

function showEventForm(latLng){
	$('#add-danger').addClass('visible');
	$('.cover').fadeIn();
	if(!document.getElementById('lat-input'))
		return;
	document.getElementById('lat-input').setAttribute('value', latLng.lat);
	document.getElementById('lng-input').setAttribute('value', latLng.lng);
	let addressP = document.getElementById('location-from-coord');
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
		    	showEventForm(latLng);
    		}
    	}, 200);
    });
    initAutocomplete(map);
    eventManager = new EventManager(map, geocoder);
    let startDate = new Date();
    startDate.setDate(1);
    eventManager.loadEvents(startDate, new Date());
    eventManager.setCurrentLocation();
    for(let option of document.getElementsByClassName('filter-option')){
    	option.addEventListener('click', updateFilterOptions);
    }

    document.getElementById('add-danger-form').addEventListener('submit', function(e){
    	e.preventDefault();
    	let captchaResponse = grecaptcha.getResponse();
    	if(!captchaResponse){
    		alert("robotu dreq");
    		return;
    	}

    	let args = {};
    	args.desc = document.getElementById('event-desc').value;
    	args.type = document.getElementById('event-type').value;
    	args.radius = document.getElementById('event-radius').value;
    	args.lat = document.getElementById('lat-input').value;
    	args.lng = document.getElementById('lng-input').value;
    	args.date = new Date();
    	eventManager.createEvent(args);
   		
   		$('.modal').removeClass('visible');
		$('.cover').fadeOut(200);
    	/*
    	verify captcha (not possible from localhost)
    	grecaptchaVerify = new XMLHttpRequest();
    	grecaptchaVerify.open('POST', 'https://www.google.com/recaptcha/api/siteverify', true);
		grecaptchaVerify.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    	grecaptchaVerify.send('secret=6LfQ2FcUAAAAAKWrgX0OQuXGH-9mMXvX4uwski3f&response='+captchaResponse);
    	grecaptchaVerify.onreadystatechange=function(){
    		if (this.readyState == 4 && this.status == 200) {
	    		console.log(grecaptchaVerify);
		    	let args = {};
		    	args.desc = document.getElementById('event-desc').value;
		    	args.type = document.getElementById('event-type').value;
		    	args.radius = document.getElementById('event-radius').value;
		    	args.lat = document.getElementById('lat-input').value;
		    	args.lng = document.getElementById('lng-input').value;
		    	args.date = new Date();
		    	eventManager.createEvent(args);
		    }
    	}*/
    });
    
}


let addCommentButton = document.getElementById('add-comment-button');
if(addCommentButton){
	addCommentButton.addEventListener('click', function(e){
		e.preventDefault;
		let args = {};
		args.eventId = parseInt(document.getElementById('event-id').value);
		args.content = document.getElementById('comment-content').value;
		eventManager.createComment(args);
	});
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