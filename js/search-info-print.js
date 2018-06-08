function loadInfo() {
	let postedOutput = document.getElementById('posted-search-info');
	let userOutput = document.getElementById("user-search-info");
	postedOutput.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
	userOutput.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
	let request = new XMLHttpRequest();
	request.open('POST', 'resources/search-info-code.php', true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.onreadystatechange = (function() {
		if(request.readyState === 4 && request.status === 200) {
			let info = JSON.parse(request.responseText);
			postedOutput.innerHTML = '';
			for(let row of info.posted){
				let postedInfo = document.createElement('div');
				postedInfo.classList.add('row');
				postedInfo.innerHTML = "<div class='poster-name'>"+row.firstname+' '+row.lastname+"</div>"+
									"<div class='posted-details'>"+row.details+"</div>"+
									"<div class='posted-address'>"+row.address+"</div>"+
									"<div class='posted-date'>"+row.conn_date+"</div>";
				postedOutput.appendChild(postedInfo);
			}
			if(info.posted.length === 0){
				postedOutput.innerHTML = '<div class="info">Nu există informații oferite</div>';
			}
			userOutput.innerHTML = '';
			let userAddress = document.createElement('div');
			userAddress.classList.add('user-address');
			let latLng = info.user.address.split(" ");
			latLng = {lat: latLng[0], lng: latLng[1]};
			new EventManager(null, new google.maps.Geocoder()).codeLatLng(latLng, userAddress);
			let userDate = document.createElement('div');
			userDate.classList.add('user-date');
			userDate.innerText = info.user.conn_date;
			userOutput.appendChild(userAddress);
			userOutput.appendChild(userDate);
		}
	});
	if(document.getElementById('search-suggested-user-id').value.length===0){
		new EventManager(null, null).promptMessage('Niciun rezultat', 'err');
		document.getElementById('search-info').style.display='none';
		postedOutput.innerHTML='';
		userOutput.innerHTML = '';
		return;
	}
	document.getElementById('search-info').style.display='block';
	let sendInfo = 'Id=' + encodeURIComponent(document.getElementById('search-suggested-user-id').value);
	console.log(sendInfo);
	request.send(sendInfo);
}

document.getElementById('submit-button').addEventListener('click', function(){
	loadInfo();
});