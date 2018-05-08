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
					    	console.log(eventDesc);
					    });
					   	obj.events.push(event);
					   	console.log('adaug pe '+event.id);
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
				console.log('sterg pe'+this.events[i].id);
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
		//get maximum ID, so we can set maxId+1 to the next event
		let sql = "select MAXIMUM(id) from "+this.fTable; 
		let query = new google.visualization.Query('http://www.google.com/fusiontables/gvizdata?tq=' + encodeURIComponent(sql));
		let obj = this;
		query.send(function(response){
			let maxId = response.getDataTable().getValue(0, 0)+1;
			let formattedDate = args.date.getFullYear()+'-0'+(args.date.getMonth()+1)+'-0'+(args.date.getDate()+1);
			let latLng = args.lat+'\n'+args.lng;
			let insertSql = "insert into "+obj.fTable+" ('id', 'Location', 'Range', 'DangerType', 'DangerDesc', 'DangerDate') values('"+maxId+"', '"+latLng+"', '"+parseInt(args.radius)+"', '"+args.type+"', '"+args.desc+"', '"+formattedDate+"') ";
			console.log(insertSql);
			let req = new XMLHttpRequest();

			req.open('POST', 'https://www.googleapis.com/fusiontables/v2/query', true);
			req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

			req.onreadystatechange = function(){

				console.log('autentificare bla bla');
			}

			req.send('sql='+insertSql+'&key='+obj.fKey+'&client_id=460651768070-llhj7cvtlvu5c87hti65r5j70158hs4c.apps.googleusercontent.com&client_secret=GO92nD5vm4TLHSIdQSJWR4hB');

			let markerStyle = obj.getMarkerStyle(args.type);
			let marker = new google.maps.Marker({
				map: obj.map,
				position: {lat: parseFloat(args.lat), lng: parseFloat(args.lng)},
				animation: google.maps.Animation.DROP,
				icon: markerStyle.icon
			});
			google.maps.event.addDomListener(marker, 'click', function(){
		    	console.log(args.desc);
		    });
			let circle = new google.maps.Circle({
				id: maxId,
		        strokeColor: markerStyle.color,
		        strokeOpacity: 0.6,
		        strokeWeight: 2,
		        fillColor: markerStyle.color,
		        fillOpacity: 0.5,
		        map: obj.map,
		        center: {lat: parseFloat(args.lat), lng: parseFloat(args.lng)},
		        radius:  parseInt(args.radius),
		        clickable: false

			});
			let event = {
				id: maxId,
				type: args.type,
				marker: marker,
				circle: circle,
				radius: parseInt(args.radius),
				desc: args.desc,
				date: args.date
			}
			console.log('adaugat event');
		});
		
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
