var input = document.getElementById('address-input');
var autocomplete = new google.maps.places.Autocomplete(input);
input.setAttribute('placeholder', '');
//autocomplete.bindTo('bounds', map); 
autocomplete.addListener('place_changed', function() {
	var place = autocomplete.getPlace();
	//console.log(place);
	
	var finalInput = document.getElementById('formatted-addr');

	if (place.address_components) {
		address =[];
		for (var i = 0; i < place.address_components.length; i++ ){
			address.push((place.address_components[i].long_name) || '');
		}
	    address = address.join(', ');
	}
	finalInput.setAttribute('value', address);
	console.log('adresa:'+address);
});

