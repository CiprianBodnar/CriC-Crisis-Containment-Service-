class EventManager{
	constructor(map, geocoder){
		this.map = map;
		this.geocoder = geocoder;
		this.events = [];
		this.fTable = "1j2RBA86oA4o9sM6CA73766UpV4xI9l_g8i26XLjJ";
		this.timeTable = [];
	}

	getDateFormat(date){
		let days = date.getDate();
		let month = date.getMonth()+1;
		let year = date.getFullYear();
		if(days<10)
			days = '0' + days;
		if(month<10)
			month = '0'+ month;
		return year+'-'+month+'-'+days;
	}

	codeLatLng(latLng, output) {
		var latlng = new google.maps.LatLng(latLng.lat, latLng.lng);
		var address=[];
		this.geocoder.geocode({
			'latLng': latlng
			}, 
			function (results, status) {
				if (status === google.maps.GeocoderStatus.OK) {
					if (results[1]) {
						if (results[1].address_components) {
							for (var i = 0; i < results[1].address_components.length; i++ ){
								address.push((results[1].address_components[i].long_name) || '');
							}
							address = address.join(', ');
							output.innerHTML = address;
						}
					}
				} 
			});
	}

	setCurrentLocation(){
		if(navigator.geolocation){
			let mp = this.map;
			navigator.geolocation.getCurrentPosition(function(position){
				let center = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				let markerIcon  = new google.maps.MarkerImage('img/position.png', null, null, new google.maps.Point(12, 12));
				let marker = new google.maps.Marker({
					map: mp,
					position: center,
					title: "You're here!",
					icon: markerIcon
				});
				setTimeout(function(){
					mp.setCenter(center);
					mp.setZoom(8);
				}, 2000);
			});
		}
	}

	loadEvents(lowerBound, upperBound, args){
		//lowerBound & upperBound are dates
		this.timeTable = [];
		this.timeTable.push(lowerBound);
		this.timeTable.push(upperBound);
		let beginDate = this.getDateFormat(lowerBound);
		let endDate = this.getDateFormat(upperBound);
		let sql = "select * from "+this.fTable+" where 'DangerDate' >= '"+beginDate+"' and 'DangerDate' <= '"+endDate+"'"; 
		let query = new google.visualization.Query('http://www.google.com/fusiontables/gvizdata?tq=' 
								+ encodeURIComponent(sql));
		//this.queryEvents(query, this);
		let obj = this;
		query.send(function(response){

			obj.clearEvents();
			let rows = response.getDataTable().getNumberOfRows();
			let cols = response.getDataTable().getNumberOfColumns();
			for (let i = 0; i < rows; i++) {
				let row = [];
				for (let j = 0; j < cols; j++) {
					row.push(response.getDataTable().getValue(i, j));
				}
				obj.processData(row, args);
			}
		});
	}

	processData(row, args){
		let id = row[0];
	    for (let other of this.events){
	    	if (id === other.id){
	    		return;
	    	}
	    }
		//process ID of danger
		let latLng = row[1].split(" ");
		latLng = {lat: parseFloat(latLng[0]), lng: parseFloat(latLng[1])};
		let eventRadius = row[2];
		let eventType = row[3];
		let eventDesc = row[4];
		let eventDate = row[5];
		let markerStyle=this.getMarkerStyle(eventType);
		let icon = markerStyle.icon;

		let animation = google.maps.Animation.DROP;

		if(args && 'animation' in args){
			animation = args.animation;
		}
		let marker = new google.maps.Marker({
		  map: this.map, 
		  position: latLng,
		  animation: animation,
		  icon: icon
		});
		let circle = new google.maps.Circle({
			id: id,
	        strokeColor: markerStyle.color,
	        strokeOpacity: 0.6,
	        strokeWeight: 2,
	        fillColor: markerStyle.color,
	        fillOpacity: 0.5,
	        map: this.map,
	        center: latLng,
	        radius:  eventRadius,
	        clickable: false
	    });
	   	let event = {
	   		id: id,
	   		type: eventType,
	   		marker: marker, 
	   		circle: circle, 
	   		radius: eventRadius, 
	   		date: eventDate,
	   		desc: eventDesc
	   	};
	    google.maps.event.addDomListener(marker, 'click', function(){
	    	console.log(eventDesc);
	    });
	   	this.events.push(event);
	}

	clearEvents(){
		for (let i = 0; i < this.events.length; i++){
			if(this.events[i].date < this.timeTable[0] || this.events[i].date > this.timeTable[1]){
				this.events[i].marker.setMap(null);
				this.events[i].circle.setMap(null);
				this.events.splice(i, 1);
			}
		}
	}

	getMarkerStyle(eventType){
		switch(eventType){
			case 'snow_storm':
				return {icon: new google.maps.MarkerImage('img/danger-icons/snow-storm.png', null, null, new google.maps.Point(20, 21)), color: '#3292be'};
			case 'flood':
				return {icon: new google.maps.MarkerImage('img/danger-icons/flood.png', null, null, new google.maps.Point(20, 21)), color: '#3253be'};
			case 'earthquake':
				return {icon: new google.maps.MarkerImage('img/danger-icons/earthquake.png', null, null, new google.maps.Point(20, 21)), color: '#ac4e2f'};
			case 'fire':
				return {icon: new google.maps.MarkerImage('img/danger-icons/fire.png', null, null, new google.maps.Point(20, 21)), color: '#f41e1e'};
			case 'person':
				return {icon: new google.maps.MarkerImage('img/danger-icons/person.png', null, null, new google.maps.Point(10, 10)), color: '#ffffff'};
			default:
				return null;
		}
	}
}
