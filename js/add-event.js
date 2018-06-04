function showEventForm(latLng){
	$('#add-danger').addClass('visible');
	$('.cover').fadeIn();
	$('.modals-container').show();
	if(!document.getElementById('lat-input'))
		return;
	document.getElementById('lat-input').setAttribute('value', latLng.lat);
	document.getElementById('lng-input').setAttribute('value', latLng.lng);
	let addressP = document.getElementById('location-from-coord');
	eventManager.codeLatLng(latLng, addressP);
}
let addEventInit = function(){
	let map = eventManager.map;
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

	let canAddEvent = true;
	document.getElementById('add-danger-form').addEventListener('submit', function(e){
		e.preventDefault();
		if(canAddEvent === true){
			canAddEvent = false;
			setTimeout(function(){canAdd = true;}, 10000);
			let captchaResponse = grecaptcha.getResponse();
	    	if(!captchaResponse){
	    		eventManager.promptMessage("Nu am putut confirma că nu sunteți robot.", "err");
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
			$('.modals-container').hide();
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

	    	setTimeout(function(){
				canAddEvent = true;
				console.log(canAddEvent);
			}, 10000);
		}
		else{
			eventManager.promptMessage("Nu puteti alt eveniment așa de repede. (10s)", "err");
		}
	});
}