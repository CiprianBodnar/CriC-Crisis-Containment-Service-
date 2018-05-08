class EventManager{
	constructor(map, geocoder){
		this.map = map;
		this.geocoder = geocoder;
		this.events = [];
		this.fTable = "1j2RBA86oA4o9sM6CA73766UpV4xI9l_g8i26XLjJ";
		this.fKey = "AIzaSyCPPSKN76hoz7yARd-4yLxU4DhZJzKOoAc";
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

	filter(options){
		for(let event of this.events){
			if(options.hideAll){
				if(event.marker.getMap() != null)
					event.marker.setMap(null);
				if(event.circle.getMap() != null)
					event.circle.setMap(null);
			}else{
				let type = options[event.type];
				let radius = options.radius;
				if(type===false){
					if(event.marker.getMap()!= null)
						event.marker.setMap(null);
					if(event.circle.getMap()!=null)
						event.circle.setMap(null);
				}
				else{
					if(event.marker.getMap() === null)
						event.marker.setMap(this.map);
					if(radius){
						if(event.circle.getMap() === null)
							event.circle.setMap(this.map);
					}
					else if(event.circle.getMap()!=null){
						event.circle.setMap(null);
					}
				}
			}

		}
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

	encodeJsDate(date){
		let days = date.getDate();
		days = days<10?'0'+days:days;
		let month = date.getMonth()+1;
		month = month<10?'0'+month:month;
		let year = date.getFullYear();
		return "str_to_date('"+days+"-"+month+"-"+year+"', '%d-%m-%Y')";
	}

	loadEvents(lowerBound, upperBound, args){
		//lowerBound & upperBound are dates
		this.timeTable = [];
		this.timeTable.push(lowerBound);
		this.timeTable.push(upperBound);
		let beginDate = this.getDateFormat(lowerBound);
		let endDate = this.getDateFormat(upperBound);

		let request = new XMLHttpRequest();
		request.open('POST', 'query_events.php', true);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		request.onreadystatechange = (function(request, obj){
			return function(){
				if(request.readyState===4 && request.status===200){
					obj.clearEvents();
					let events = JSON.parse(request.responseText);

					for(let event of events){
						let isNew = true;
						for(let other of obj.events){
							if(event.id === other.id){
								isNew = false;
								break;
							}
						}
						if(!isNew)
							continue;
						event.date = new Date(event.date);
						let markerStyle = obj.getMarkerStyle(event.type);
						let animation = google.maps.Animation.DROP;
						if(args && 'animation' in args){
							animation = args.animation;
						}
						let marker = new google.maps.Marker({
						  map: obj.map, 
						  position: event.location,
						  animation: animation,
						  icon: markerStyle.icon
						});
						let circle = new google.maps.Circle({
					        strokeColor: markerStyle.color,
					        strokeOpacity: 0.6,
					        strokeWeight: 2,
					        fillColor: markerStyle.color,
					        fillOpacity: 0.5,
					        map: obj.map,
					        center: event.location,
					        radius:  event.range,
					        clickable: false
					    });
					    event.marker = marker;
					    event.circle = circle;
					    google.maps.event.addDomListener(marker, 'click', function(){
					    	console.log(event.desc);
					    });
					   	obj.events.push(event);
					}
				}
			}
		})(request, this);
		let postBody = 'begin='+encodeURIComponent(this.encodeJsDate(lowerBound))+'&end='+encodeURIComponent(this.encodeJsDate(upperBound));
		request.send(postBody);



		// let sql = "select * from "+this.fTable+" where 'DangerDate' >= '"+beginDate+"' and 'DangerDate' <= '"+endDate+"'"; 
		// let query = new google.visualization.Query('http://www.google.com/fusiontables/gvizdata?tq=' 
		// 						+ encodeURIComponent(sql));
		// //this.queryEvents(query, this);
		// let obj = this;
		// query.send(function(response){

		// 	obj.clearEvents();
		// 	let rows = response.getDataTable().getNumberOfRows();
		// 	let cols = response.getDataTable().getNumberOfColumns();
		// 	for (let i = 0; i < rows; i++) {
		// 		let row = [];
		// 		for (let j = 0; j < cols; j++) {
		// 			row.push(response.getDataTable().getValue(i, j));
		// 		}
		// 		obj.processData(row, args);
		// 	}
		// });
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

	createEvent(args){
		if(args.desc===""){
			this.promptMessage("Introduceti o descriere pentru pericol.");
			return;
		}
		if(args.type==="Tipul de pericol"){
			this.promptMessage("Selectati tipul de pericol");
			return;
		}
		
		let latLng = args.lat+' '+args.lng;
		let req = new XMLHttpRequest();

		req.open('POST', 'add_event.php', true);
		req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		let obj = this;
		req.onreadystatechange = function(){
			if(this.readyState===4 && this.status===200){
				let resp = JSON.parse(this.responseText);
				if(resp.id===-1){
					obj.promptMessage("Unexpected error. Nu s-a putut realiza o treaba..");
					return;
				}
				obj.loadEvents(obj.timeTable[0], obj.timeTable[1]);
			}
		}
		req.send('location='+latLng+'&range='+args.radius+'&type='+args.type+'&desc='+args.desc);
	}

	promptMessage(message){
		//print a message to the screen(pop-up);
		console.log(message);
	}

	getMarkerStyle(eventType){
		switch(eventType){
			case 'snowstorm':
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
