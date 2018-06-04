
var eventManager;

function requestConfirmation(title, message, callback){
	let confCover = document.getElementsByClassName('second-cover')[0];
	let conf = document.getElementById('confirmation-modal');
	let confTitle = document.getElementById('confirmation-title');
	let confContent = document.getElementById('confirmation-content');
	let confButton = document.getElementById('confirm-button');
	confTitle.innerHTML = title;
	confContent.innerHTML = message;
	let confButtonClone = confButton.cloneNode(true);
	confButton.parentNode.replaceChild(confButtonClone, confButton);
	confButton = confButtonClone;
	confCover.style.display='block';
	conf.classList.add('visible');
	confButton.addEventListener('click', function(){
		confCover.style.display='none';
		callback();
	});
}
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
	filterOptions.snowstorm = document.getElementById('snow-storm').checked;
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
    initAutocomplete(map);
    eventManager = new EventManager(map, geocoder);
    let startDate = new Date();
    startDate.setDate(1);
    eventManager.loadEvents(startDate, new Date());
    eventManager.setCurrentLocation();
    for(let option of document.getElementsByClassName('filter-option')){
    	option.addEventListener('click', updateFilterOptions);
    }
    
    let addCommentButton = document.getElementById('add-comment-button');
	let canAddComment = true;
	if(addCommentButton){
		addCommentButton.addEventListener('click', function(e){
			if(canAddComment === true){
				canAddComment = false;
				e.preventDefault;
				let args = {};
				args.eventId = parseInt(document.getElementById('event-id').value);
				args.content = document.getElementById('comment-content').value;
				document.getElementById('comment-content').value='';
				eventManager.createComment(args);
				setTimeout(function(){
					canAddComment = true;
					console.log(canAddComment);
				}, 5000);
			} 
			else{
				eventManager.promptMessage('Nu puteți adăuga alt comentariu așa de repede. (5s)', "err");
			}
		});
	}

	let removeEventButton = document.getElementById('remove-event');
	removeEventButton.addEventListener('click', function(){
		console.log('intru');
		requestConfirmation('Ștergere eveniment', "Doriți ștergerea acestui eveniment?", function(){
			let eventId = document.getElementById('event-id').value;
			eventManager.removeEvent(eventId);
			$('.modal').removeClass('visible');
			$('.cover').fadeOut(200);
			$('.modals-container').fadeOut(200);
		});
	});

	let upvoteBtn = document.getElementById('upvote-event');
	let downvoteBtn = document.getElementById('downvote-event');
	if(upvoteBtn && downvoteBtn){
		upvoteBtn.addEventListener('click', function(e){
			let fbVal = document.getElementById('feedback-val').value;
			fbVal = fbVal == 1? 0 : 1;
			let eventId = document.getElementById('event-id').value;
			eventManager.setEventFeedback(eventId, fbVal, function(){
				for(let event of eventManager.events){
					if (event.id == eventId){
						event.feedbackValue = parseInt(fbVal);
						eventManager.describeEvent(event);
						break;
					}
				}
			});
		});
		downvoteBtn.addEventListener('click', function(e){
			let fbVal = document.getElementById('feedback-val').value;
			fbVal = fbVal == -1? 0 : -1;
			let eventId = document.getElementById('event-id').value;
			eventManager.setEventFeedback(eventId, fbVal, function(){
				for(let event of eventManager.events){
					if (event.id == eventId){
						event.feedbackValue = parseInt(fbVal);
						eventManager.describeEvent(event);
						break;
					}
				}
			});
		});
	} 
	if(typeof(addEventInit) != 'undefined'){
		addEventInit();
	}
}




google.maps.event.addDomListener(window, 'load', init);