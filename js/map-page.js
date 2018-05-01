google.load('visualization', '1', {});
var map;
var geocoder;
var dangers = []
var markerTypes = [
	{
		img: 'img/danger-icons/snow-storm.png',
		color: '#3292be'
	},
	{
		img: 'img/danger-icons/earthquake.png',
		color: '#ac4e2f'
	},
	{
		img: 'img/danger-icons/flood.png',
		color: '#3253be'
	},
	{
		img: 'img/danger-icons/fire.png',
		color: '#f41e1e'
	},
	{
		img: 'img/danger-icons/person.png',
		color: '#ffffff'
	}
];

function getMarkerStyle(dangerType){
	switch(dangerType){
		case 'snow_storm':
			return markerTypes[0];
		case 'flood':
			return markerTypes[2];

		case 'earthquake':
			return markerTypes[1];

		case 'fire':
			return markerTypes[3];

		case 'person':
			return markerTypes[4];
		default:
			return null;
	}
}

//initialize autocomplete in map search input
function initAutocomplete(){
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
		var address = '';
		if (place.address_components) {
		    address = [
		    	(place.address_components[0] && place.address_components[0].short_name || ''),
		      	(place.address_components[1] && place.address_components[1].short_name || ''),
		      	(place.address_components[2] && place.address_components[2].short_name || '')
		    ].join(' ');
		}
	});
}

function describeDanger(dangerDesc){
	$('.bottom-nav-menu ul li').removeClass('tab-selected');
	$('.bottom-nav-menu ul li:first-child').addClass('tab-selected');
	$('.tab').removeClass('tab-visible');
	$('.tab#tab-about').addClass('tab-visible');
	$('.tab#tab-about .tab-info').text(dangerDesc);

};

function createMap(){
	geocoder = new google.maps.Geocoder();
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
    map = new google.maps.Map(mapContainer, mapOptions);
    google.maps.event.addDomListener(map, 'click', function(e){
    	var latLng = {}
    	latLng.lat = e.latLng.lat();
    	latLng.lng = e.latLng.lng();
    	initDangerForm(latLng);
    	//process lat and lng
    });
    initAutocomplete();

	var query = new google.visualization.Query('http://www.google.com/fusiontables/gvizdata?tq=' 
								+ encodeURIComponent("SELECT * FROM 1j2RBA86oA4o9sM6CA73766UpV4xI9l_g8i26XLjJ"));
	query.send(getData);
}
function getData(response) {
  //for more information on the response object, see the documentation
  //http://code.google.com/apis/visualization/documentation/reference.html#QueryResponse
  numRows = response.getDataTable().getNumberOfRows();
  numCols = response.getDataTable().getNumberOfColumns();

  //create an array of row values
	for (i = 0; i < numRows; i++) {
    	var row = [];
    	for (j = 0; j < numCols; j++) {
      		row.push(response.getDataTable().getValue(i, j));
    	}
    	processData(row);
	}
}
function processData(row) {
	var id = row[0];
	//process ID of danger
	var latLng = row[1].split(" ");
	latLng = {lat: parseFloat(latLng[0]), lng: parseFloat(latLng[1])};
	var dangerRadius = row[2];
	var dangerType = row[3];
	var dangerDesc = row[4];
	var dangerDate = row[5];
	var iconStyle=getMarkerStyle(dangerType);
	var icon;

	if(dangerType=='person')
		icon = new google.maps.MarkerImage(iconStyle.img, null, null, new google.maps.Point(10, 10));
	else
		icon= new google.maps.MarkerImage(iconStyle.img, null, null, new google.maps.Point(20, 21));

	var marker = new google.maps.Marker({
	  map: map, 
	  position: latLng,
	  animation: google.maps.Animation.DROP,
	  //this is where the magic happens!
	  icon: icon
	});
	var circle = new google.maps.Circle({
		id: id,
        strokeColor: iconStyle.color,
        strokeOpacity: 0.6,
        strokeWeight: 2,
        fillColor: iconStyle.color,
        fillOpacity: 0.5,
        map: map,
        center: latLng,
        radius:  dangerRadius,
        clickable: false
    });
   	danger = {
   		id: id,
   		type: dangerType,
   		marker: marker, 
   		circle: circle, 
   		radius: dangerRadius, 
   		date: dangerDate,
   		desc: dangerDesc
   	};
    google.maps.event.addDomListener(marker, 'click', function(){
    	describeDanger(dangerDesc);
    });
    // google.maps.event.addDomListener(circle, 'click', function(){
    // 	describeDanger(dangerDesc);
    // });
   	dangers.push(danger);

}

google.maps.event.addDomListener(window, 'load', createMap);


function codeLatLng(latLng) {
  var latlng = new google.maps.LatLng(latLng.lat, latLng.lng);
  geocoder.geocode({
    'latLng': latlng
  }, function (results, status) {
    if (status === google.maps.GeocoderStatus.OK) {
      if (results[1]) {
        var adressP = document.getElementById('location-from-coord');

		address =[];
		if (results[1].address_components) {
			for (var i = 0; i < results[1].address_components.length; i++ ){
				address.push((results[1].address_components[i].long_name) || '');
			}
		    address = address.join(', ');

		}
		adressP.innerHTML=address;
		console.log('adresa:'+address);


      }
    } 
  });
}

function initDangerForm(latLng){
	$('#add-danger').addClass('visible');
	$('.cover').fadeIn();
	document.getElementById('lat-input').value=latLng.lat;
	document.getElementById('lng-input').value=latLng.lng;
	codeLatLng(latLng);

	
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