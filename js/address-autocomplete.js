function prepareAddressAutocomplete(input, finalInput, callback){
	var address=[];
	var autocomplete = new google.maps.places.Autocomplete(input);
	var geocoder = new google.maps.Geocoder();
	if(navigator.geolocation && input.value == ""){
		navigator.geolocation.getCurrentPosition(function(position){
			let center = position.coords.latitude+' '+position.coords.longitude;
			finalInput.value=center;
			var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
			geocoder.geocode({
				'latLng': latlng
				}, 
				function (results, status) {
					if (status === google.maps.GeocoderStatus.OK) {
						if (results[1]) {
							if (results[1].address_components) {
								address=[];
								for (var i = 0; i < results[1].address_components.length; i++ ){
									address.push((results[1].address_components[i].long_name) || '');
								}
								address = address.join(', ');
								input.value=address;
							}
						}
						if(callback){
							callback();
						}
					} 
				}
			);
		});
	}
	input.setAttribute('placeholder', '');
	autocomplete.addListener('place_changed', function() {
		var place = autocomplete.getPlace();
		if (place.address_components) {
			address =[];
			for (var i = 0; i < place.address_components.length; i++ ){
				address.push((place.address_components[i].long_name) || '');
			}
		    address = address.join(', ');
		}
		finalInput.setAttribute('value', place.geometry.location.lat()+' '+place.geometry.location.lng());
		
	});
}