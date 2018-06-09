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
				row.conn_date = new Date(row.conn_date);
				let postedInfo = document.createElement('div');
				postedInfo.classList.add('row');

				//<div class='poster-name'> <<poster name>> </div>
				let posterNameContainer = document.createElement('div');
				posterNameContainer.classList.add('poster-name');
				posterNameContainer.innerText = row.firstname+' '+row.lastname;
				postedInfo.appendChild(posterNameContainer);

				//<div class='posted-details'> <<posted details>> </div>
				let postedDetailsContainer = document.createElement('div');
				postedDetailsContainer.classList.add('posted-details');
				postedDetailsContainer.innerHTML = row.details.replace(/\n/g, "<br />");
				postedInfo.appendChild(postedDetailsContainer);

				if(row.address != null){
					//<div class='posted-address'> <<address offered by user>> </div>
					let addressContainer = document.createElement('div');
					addressContainer.classList.add('posted-address');
					postedInfo.appendChild(addressContainer);

					//convert coordinates to phisical address
					let latLng = row.address.split(" ");
					latLng = {lat: latLng[0], lng: latLng[1]};
					new EventManager(null, new google.maps.Geocoder()).codeLatLng(latLng, addressContainer);
				}

				//<div class='posted-date'> <<posted at>> </div>
				let dateContainer = document.createElement('div');
				dateContainer.classList.add('posted-date');
				dateContainer.innerText = row.conn_date.toLocaleDateString('ro-RO')+' '+row.conn_date.toLocaleTimeString('ro-RO');
				postedInfo.appendChild(dateContainer);

				//append the row to the parent element
				postedOutput.appendChild(postedInfo);
			}
			if(info.posted.length === 0){
				postedOutput.innerHTML = '<div class="info">Nu există informații oferite</div>';
			}
			userOutput.innerHTML = '';

			// <div class='user-address'> <<generated user address>> </div>
			let userAddress = document.createElement('div');
			userAddress.classList.add('user-address');
			userOutput.appendChild(userAddress);

			//convert coordinates to phisical address
			let latLng = info.user.address.split(" ");
			latLng = {lat: latLng[0], lng: latLng[1]};
			new EventManager(null, new google.maps.Geocoder()).codeLatLng(latLng, userAddress);

			//<div class='user-date'> <<generated user last active date>> </div>
			let userDate = document.createElement('div');
			userDate.classList.add('user-date');
			info.user.conn_date = new Date(info.user.conn_date);
			userDate.innerText = info.user.conn_date.toLocaleDateString('ro-RO')+' '+info.user.conn_date.toLocaleTimeString('ro-RO');
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
	for(let input of document.getElementsByTagName('input'))
		input.blur();
	document.getElementById('search-users-suggest').innerHTML='';
	loadInfo();
});
document.getElementById('search-info-form').addEventListener('submit', function(e){
	e.preventDefault();
	e.stopPropagation();
	for(let input of document.getElementsByTagName('input'))
		input.blur();
	document.getElementById('search-users-suggest').innerHTML='';
	loadInfo();
});