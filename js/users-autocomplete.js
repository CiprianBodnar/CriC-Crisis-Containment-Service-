function loadUsers(source, hiddenInput, output) {
	let request = new XMLHttpRequest();
	request.open('POST', 'query_users.php', true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.onreadystatechange = (function() {
		if(request.readyState === 4 && request.status === 200) {
			let response = JSON.parse(request.responseText);
			output.innerHTML = '';
			if(response.status === "null"){
				return;
			}
			let users = response.result;
			hiddenInput.setAttribute('value', users[0].id_user);
			for(let user of users) {
				let newUser = document.createElement('div');
				newUser.classList.add('user');
				newUser.innerHTML = user.name;
				let location = document.createElement('span');
				location.classList.add('user-location');
				let latLng = user.address.split(" ");
				latLng = {lat: latLng[0], lng: latLng[1]};
				new EventManager(null, new google.maps.Geocoder()).codeLatLng(latLng, location, function(){
					if(location.innerText.length>35){
						location.setAttribute('title', location.innerText);
						location.innerText = location.innerText.substr(0, 35)+'...';
					}
				});
				newUser.appendChild(location);
				
				newUser.addEventListener('click', function(){
					hiddenInput.setAttribute('value', user.id_user);
					source.value=user.name;
					output.innerHTML = '';
				});
				output.appendChild(newUser);
			}
		}
	});
	let sendName = 'pre_name='+encodeURIComponent(source.value);
	request.send(sendName);
}

let instances = [
	{
		source: document.getElementById('share-autocomplete'),
		hiddenInput: document.getElementById('share-suggested-user-id'),
		output: document.getElementById('share-users-suggest')
	},
	{
		source: document.getElementById('search-autocomplete'),
		hiddenInput: document.getElementById('search-suggested-user-id'),
		output: document.getElementById('search-users-suggest')
	}
];

for(let instance of instances){
	if(instance.source && instance.hiddenInput && instance.output){
		instance.source.addEventListener('keydown', function(){
			if(instance.source.value.length>=3)
				loadUsers(instance.source, instance.hiddenInput, instance.output);
			else{
				instance.output.innerHTML = '';
				instance.hiddenInput.value='';
			}
		});
	}
}