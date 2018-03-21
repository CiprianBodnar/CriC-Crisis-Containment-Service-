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
		console.log(place);
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
	var latLng = row[0].split(" ");
	latLng = {lat: parseFloat(latLng[0]), lng: parseFloat(latLng[1])};
	var dangerRadius = row[1];
	var dangerType = row[2];
	var dangerDesc = row[3];
	var dangerDate = row[4];
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
        strokeColor: iconStyle.color,
        strokeOpacity: 0.6,
        strokeWeight: 2,
        fillColor: iconStyle.color,
        fillOpacity: 0.5,
        map: map,
        center: latLng,
        radius:  dangerRadius
    });
   	danger = {
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
    google.maps.event.addDomListener(circle, 'click', function(){
    	describeDanger(dangerDesc);
    });
   	dangers.push(danger);

}
google.maps.event.addDomListener(window, 'load', createMap);


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
	$(this).val('');
	$('.wrapper').removeClass('input-visible');
});