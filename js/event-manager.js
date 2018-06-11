class EventManager{
	constructor(map, geocoder){
		this.map = map;
		this.geocoder = geocoder;
		this.events = [];
		this.timeTable = [];
		this.directionsService = new google.maps.DirectionsService();
	}

	getMap(){
		return this.map;
	}

	getGeocoder(){
		return this.geocoder;
	}

	codeLatLng(latLng, output, callback) {
		var latlng = new google.maps.LatLng(latLng.lat, latLng.lng);
		var address=[];
		output.innerHTML = "<i class='fas fa-spinner fa-spin'></i>";
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
							if(callback){
								callback();
							}
						}
					}
				} 
				else if (status === google.maps.GeocoderStatus.ZERO_RESULTS){
					output.innerHTML = 'adresă necunoscută';
				}
				else if (status === google.maps.GeocoderStatus.OVER_QUERY_LIMIT){
					output.innerHTML = '...';
				}
			}
		);
	}

	filter(options){
		this.filterOptions = options;
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
					clickable: false,
					icon: markerIcon
				});
				setTimeout(function(){
					mp.setCenter(center);
					mp.setZoom(7);
				}, 200);
			});
		}
	}

	encodeJsDate(date){
		let days = date.getDate();
		days = days<10?'0'+days:days;
		let month = date.getMonth()+1;
		month = month<10?'0'+month:month;
		let year = date.getFullYear();
		return days+"-"+month+"-"+year;
	}


	setRoute(event){
		if(navigator.geolocation && !event.hasOwnProperty('route')){
			let obj = this;
			navigator.geolocation.getCurrentPosition(function(position){
				let directionsDisplay = new google.maps.DirectionsRenderer({
					map : null,
					options : {
						suppressMarkers : true
					}
				});

				let start = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				let end = new google.maps.LatLng(event.location.lat, event.location.lng);

				obj.directionsService.route({
					origin: start,
					destination: end,
					travelMode: 'DRIVING',
				}, function(response, status){
					if(status === 'OK'){
						directionsDisplay.setDirections(response);
					}
				});
				event.route=directionsDisplay;
			});
		}
	}


	loadEvents(lowerBound, upperBound, args, callback){
		//lowerBound & upperBound are dates
		this.timeTable = [];
		this.timeTable.push(lowerBound);
		this.timeTable.push(upperBound);

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
					    	obj.describeEvent(event);
					    });
					   	obj.events.push(event);
					   	if(obj.hasOwnProperty('filterOptions'))
					   		obj.filter(obj.filterOptions);
					}
					if(callback){
						callback(obj);
					}
				}
			}
		})(request, this);
		let postBody = 'begin='+encodeURIComponent(this.encodeJsDate(lowerBound))+'&end='+encodeURIComponent(this.encodeJsDate(upperBound));
		request.send(postBody);
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
			this.promptMessage("Introduceti o descriere pentru pericol.", "err");
			return;
		}
		if(args.type==="Tipul de pericol"){
			this.promptMessage("Selectati tipul de pericol", "err");
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
					obj.promptMessage("Unexpected error. Nu s-a putut realiza o treaba..", "err");
					return;
				}
				obj.promptMessage("Evenimentul a fost adăugat.", "succ");
				obj.loadEvents(obj.timeTable[0], obj.timeTable[1]);
				let notifyArgs = {type: 'event', args: resp.id+' '+latLng+' '+args.radius};
				if (args.type === 'person') notifyArgs.type='person';
				obj.notify(notifyArgs.type, notifyArgs.args);
			}
		}
		let desc = encodeURIComponent(args.desc);
		req.send('location='+latLng+'&range='+args.radius+'&type='+args.type+'&desc='+desc);
	}

	createComment(args){
		if(args.content.length<=1){
			this.promptMessage("Comentariu prea scurt.", "err");
			return;
		}
		let obj = this;
		let request = new XMLHttpRequest();
		request.open("POST", "resources/add-comment.php", true);
		request.onreadystatechange = function(){
			if(this.readyState === 4 && this.status === 200){
				let resp = JSON.parse(this.responseText);
				if(resp.hasOwnProperty('error'))
					obj.promptMessage(resp.error, "err");
				else{
					//obj.promptMessage(resp.success, "succ");
					for(let event of obj.events){
						if(event.id === args.eventId){
							obj.describeEvent(event);
						}
					}
				}
			}
		}
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		let content = encodeURIComponent(args.content);
		request.send('event-id='+args.eventId+"&comment-content="+content);
	}

	describeEvent(event){ 
		let modal = {
			container: document.getElementsByClassName('modals-container')[0],
			preloader: document.getElementsByClassName('preloader')[0],
			cover: document.getElementsByClassName('cover')[0],
			id: document.getElementById('event-id'),
			body: document.getElementById('view-event'),
			title: document.getElementById('event-title'),
			removeButton: document.getElementById('remove-event'),
			range: document.getElementById('event-range'),
			route: document.getElementById('toggle-route'),
			poster: {
				name: document.getElementsByClassName('poster-name')[0],
				date: document.getElementsByClassName('post-date')[0],
				address: document.getElementById('poster-address')
			},
			routeStatus: document.getElementById('toggle-state'),
			description: document.getElementById('event-description'),
			location: document.getElementById('event-location'),
			votes:{
				up: document.getElementById('upvotes'),
				down: document.getElementById('downvotes')
			},
			votebar:{
				positive: document.getElementsByClassName('up-bar')[0],
				negative: document.getElementsByClassName('down-bar')[0]
			},
			comments: document.getElementById('comments-container')
		}
		modal.cover.style.display='block';
		modal.container.style.display='block';
		modal.body.classList.add('visible');
		modal.preloader.style.display='block';
		modal.body.addEventListener('click', function(e){e.stopPropagation();});
		let obj = this;
		this.loadEventFeedback(event, function(){
			obj.prepareEventDisplay(event, modal);
		});	

	}


	prepareEventDisplay(event, modal){
		let eventTitle = this.getEventTitle(event.type);
		modal.title.innerHTML = eventTitle;
		if(event.hasOwnProperty('removeable') && event.removeable === true){
			modal.removeButton.style.display='block';
		}
		else{
			modal.removeButton.style.display='none';
		}
		modal.id.value=event.id;
		let eventRange = this.getFormattedRange(event.range);
		modal.range.innerHTML = eventRange;
		if(!event.hasOwnProperty('route')){
			modal.routeStatus.innerHTML = 'arată';
		}
		else if (event.route.getMap() === this.map){
			modal.routeStatus.innerHTML = 'ascunde';
		}
		else{
			modal.routeStatus.innerHTML = 'arată';
		}
		let feedbackInput = document.getElementById('feedback-val');
		let upvoteButton = document.getElementById('upvote-event');
		let downvoteButton = document.getElementById('downvote-event');
		if(upvoteButton && downvoteButton){
			upvoteButton.classList.remove('pressed');
			downvoteButton.classList.remove('pressed');
		}
		if(event.hasOwnProperty('feedbackValue')){
			feedbackInput.value = event.feedbackValue;
			if (event.feedbackValue == 1)
				upvoteButton.classList.add('pressed');
			else if(event.feedbackValue == -1)
				downvoteButton.classList.add('pressed');
		}
		else{
			feedbackInput.value='0';
		}
		
		let routeButtonClone = modal.route.cloneNode(true);
		modal.route.parentNode.replaceChild(routeButtonClone, modal.route);
		modal.route = document.getElementById('toggle-route');
		modal.routeStatus = document.getElementById('toggle-state')
		let obj = this;
		modal.route.addEventListener('click', function(e){
			e.preventDefault;
			if(event.route.getMap() != null){
				event.route.setMap(null);
				modal.routeStatus.innerHTML = 'arată';
			}
			else{
				event.route.setMap(obj.map);
				modal.routeStatus.innerHTML = 'ascunde';
			}
		});
		this.codeLatLng(event.location, modal.location);
		modal.description.innerHTML = event.desc.replace(/\n/g, "<br />");
		modal.votes.up.innerHTML = event.feedback.votes.up;
		modal.votes.down.innerHTML = event.feedback.votes.down;
		if(event.feedback.votes.down === 0){
			modal.votebar.positive.style.width='100%';
			modal.votebar.negative.style.width='0';
		}
		else if(event.feedback.votes.up === 0){
			modal.votebar.positive.style.width='0';
			modal.votebar.negative.style.width='100%';
		}
		else{
			let proc = 100/((event.feedback.votes.up+event.feedback.votes.down)/event.feedback.votes.up);
			proc = proc.toFixed(2);
			modal.votebar.positive.style.width=proc+'%';
			modal.votebar.negative.style.width=(100-proc)+'%';
		}
		modal.poster.name.innerText = event.user.firstname+' '+event.user.lastname;
		if(event.user.id!=-1){
			modal.poster.name.innerHTML = this.getFormattedScore(event.user.score) + modal.poster.name.innerHTML;
		}
		modal.poster.date.innerText = event.date.toLocaleDateString('ro-RO')+' '+event.date.toLocaleTimeString('ro-RO');
		this.codeLatLng(event.user.location, modal.poster.address, function(){
			let posterAddress = modal.poster.address.innerHTML;
			modal.poster.address.setAttribute('title', posterAddress);
			if(posterAddress.length>75){
				posterAddress = posterAddress.substr(0, 75)+'...';
				modal.poster.address.innerHTML = posterAddress;
			}
		})
		modal.comments.innerHTML = "";
		if(event.feedback.comments.length === 0)
			modal.comments.innerHTML = "Nu există comentarii.";
		for (let comment of event.feedback.comments){
			let commentContainer = document.createElement('div');
			commentContainer.classList.add('row');
			commentContainer.classList.add('comment');
			modal.comments.appendChild(commentContainer);
			
			var commentBody = 
			"<div class='col1'>"+
				"<div class='av-container'>"+comment.user.lastname[0]+comment.user.firstname[0]+"</div>"+
			"</div>"+
			"<div class='col11 right-side'>"+
				"<span class='user-name'>"+comment.user.firstname+' '+comment.user.lastname+"</span>"+
				"<p class='comment-content'>"+comment.content.replace(/\n/g, "<br />")+"</p>"+
				"<p class='comment-date'>"+comment.date+"</p>"+
			"</div><div class='clear'></div>";

			commentContainer.innerHTML=commentBody;

			if(comment.removeable===true){
				let removeButton = document.createElement('button');
				removeButton.classList.add('remove-comment');
				removeButton.innerHTML = "<i class='fas fa-times'></i>";
				commentContainer.appendChild(removeButton);
				let obj = this;
				removeButton.addEventListener('click', function(){
					obj.removeComment(event, comment);
				});
			}

		}

		modal.preloader.style.display='none';
	}

	removeEvent(eventId){
		let obj = this;
		let request = new XMLHttpRequest();
		request.open("POST", "resources/remove-event.php", true);
		request.onreadystatechange = function(){
			if(this.readyState === 4 && this.status === 200){
				let resp = JSON.parse(this.responseText);
				if(resp.hasOwnProperty('error'))
					obj.promptMessage(resp.error, "err");
				else{
					obj.promptMessage(resp.success, "succ");
					for (let i = 0; i < obj.events.length; i++){
						if(obj.events[i].id == eventId){
							obj.events[i].marker.setMap(null);
							obj.events[i].circle.setMap(null);
							obj.events.splice(i, 1);
						}
					}
				}
			}
		}
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		request.send('event-id='+encodeURIComponent(eventId));

	}

	removeComment(event, comment){
		let request = new XMLHttpRequest();
		let obj = this;
		request.open("POST", "resources/remove-comment.php", true);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		request.onreadystatechange = function(){
			if(request.readyState === 4 && request.status === 200){
				let response = JSON.parse(request.responseText);
				if(response.error){
					obj.promptMessage(response.error, "err");
				}
				else{
					obj.promptMessage(response.success, "succ");
				}
				obj.describeEvent(event);
			}
		}
		request.send('comment-id='+encodeURIComponent(comment.id));
	}

	loadEventFeedback(event, callback){
		let request = new XMLHttpRequest();
		request.open("POST", "query_event_feedback.php", true);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		let obj = this;
		request.onreadystatechange = function(){
			if(request.readyState===4 && request.status===200){
				let feedback = JSON.parse(request.responseText);
				event.feedback = feedback;
				obj.setRoute(event);
				callback();
			}	
		}
		request.send('event_id='+event.id);
		
	}

	setEventFeedback(eventId, feedback, callback){
		let request = new XMLHttpRequest();
		request.open("POST", "resources/set-feedback.php", true);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		let obj = this;
		request.onreadystatechange = function(){
			if(request.readyState === 4 && request.status === 200){
				let response = JSON.parse(request.responseText);
				if(response.hasOwnProperty('error')){
					obj.promptMessage(response.error, "err");
				}
				else{
					if(response.hasOwnProperty('removed')){
						window.location.reload();
					}
					callback();
				}
			}
		}
		let postBody = 'event_id='+encodeURIComponent(eventId)+'&feedback_val='+encodeURIComponent(feedback);
		request.send(postBody);
	}

	notify(type, args){
		let request = new XMLHttpRequest();
		request.open("POST", 'resources/notify.php', true);
		request.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		let obj = this;
		request.onreadystatechange = function(){
			if(request.readyState === 4 && request.status === 200){
				let response = JSON.parse(request.responseText);
				if(!response.hasOwnProperty('success')){
					obj.promptMessage('A aparut o problema la notificarea celorlalti utilizatori', 'err');
				}
			}
		}
		let postBody = 'type='+encodeURIComponent(type)+'&args='+encodeURIComponent(args);
		request.send(postBody);
	}

	promptMessage(message, type){
		let promptContainer = document.createElement('div');
		promptContainer.classList.add('prompt-container');
		let icon = document.createElement('span');
		icon.classList.add('prompt-icon');
		if(type==="err"){
			icon.innerHTML = '<i class="fas fa-exclamation-circle"></i>';
			promptContainer.classList.add('err');
		}
		else if(type==="succ"){
			icon.innerHTML = '<i class="fas fa-check-circle"></i>';
			promptContainer.classList.add('succ');
		}
		promptContainer.innerText=message;
		promptContainer.appendChild(icon);
		document.getElementsByTagName('body')[0].appendChild(promptContainer);
		promptContainer.classList.add('visible');
		setTimeout(function(){
			promptContainer.classList.remove('visible');
			setTimeout(function(){document.getElementsByTagName('body')[0].removeChild(promptContainer)}, 200);
		}, 3000);
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
			case 'storm':
				return {icon: new google.maps.MarkerImage('img/danger-icons/storm.png', null, null, new google.maps.Point(20, 21)), color: '#365e7a'};
			case 'nuclear':
				return {icon: new google.maps.MarkerImage('img/danger-icons/nuclear.png', null, null, new google.maps.Point(20, 21)), color: '#9e9c15'};
			case 'landslide':
				return {icon: new google.maps.MarkerImage('img/danger-icons/landslide.png', null, null, new google.maps.Point(20, 21)), color: '#7f6560'};
			case 'volcano':
				return {icon: new google.maps.MarkerImage('img/danger-icons/volcano.png', null, null, new google.maps.Point(20, 21)), color: '#800d0d'};
			case 'psd':
				return {icon: new google.maps.MarkerImage('img/danger-icons/psd.png', null, null, new google.maps.Point(20, 21)), color: '#000'};
			case 'person':
				return {icon: new google.maps.MarkerImage('img/danger-icons/person.png', null, null, new google.maps.Point(10, 10)), color: '#ffffff'};
			case 'safehouse':
				return {icon: new google.maps.MarkerImage('img/danger-icons/safehouse.png', null, null, new google.maps.Point(14, 14)), color: '#00a651'};
			default:
				return null;
		}
	}

	getEventTitle(eventType){
		switch(eventType){
			case 'person':
				return 'Persoana în pericol';
			case 'fire':
				return 'Incendiu';
			case 'flood':
				return 'Inundație';
			case 'snowstorm':
				return 'Viscol';
			case 'earthquake':
				return 'Cutremur';
			case 'nuclear':
				return 'Pericol nuclear';
			case 'volcano':
				return 'Erupție vulcanică';
			case 'storm':
				return 'Furtună';
			case 'landslide':
				return 'Alunecare de teren';
			case 'psd':
				return 'Miting PSD';
			default:
				return 'Eveniment';
		}
	}

	getFormattedScore(score){
		score=Math.min(score*4, 4);
		let diff = score-parseInt(score);
		score = parseInt(score);
		let html = "";
		for(let x = 1; x <= score; x++){
			html+="<i class='fas fa-star fa-fw'></i>";
		}
		if(score<4){
			if(diff >= 0.25 && diff <= 0.75){
				html+="<i class='fas fa-star-half fa-fw'></i><i class='far fa-star-half fa-fw fix-half-star'></i>";
				score++;
			}
			else if (diff>0.75){
				html+="<i class='fas fa-star fa-fw'></i>";
				score++;
			}

			for(let x = score; x<4;x++){
				html+="<i class='far fa-star fa-fw'></i>";
			}
		}
		return html;
	}

	getFormattedRange(range){
		if(range<1000)
			return range+' m';
		else
			return parseFloat(range/1000).toFixed(1)+' km';
	}
}
