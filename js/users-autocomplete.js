function loadUsers(source, hiddenInput, output) {
	let request = new XMLHttpRequest();
	request.open('POST', 'query_users.php', true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.onreadystatechange = (function() {
		if(request.readyState === 4 && request.status === 200) {
			let users = JSON.parse(request.responseText);
			let input = output;
			input.innerHTML = '';
			for(let user of users) {
				let newUser = document.createElement('div');
				newUser.classList.add('user');
				newUser.innerHTML = user.name;
				
				newUser.addEventListener('click', function(){
					hiddenInput.setAttribute('value', user.id_user);
					source.value=user.name;
					input.innerHTML = '';
				});
				input.appendChild(newUser);
			}
		}
	});
	let sendName = 'pre_name='+encodeURIComponent(source.value);
	request.send(sendName);
}

let shareSource = document.getElementById('share-autocomplete');
let shareHiddenInput = document.getElementById('share-suggested-user-id');
let shareOutput = document.getElementById('share-users-suggest');

let searchSource = document.getElementById('search-autocomplete');
let searchHiddenInput = document.getElementById('search-suggested-user-id');
let searchOutput = document.getElementById('search-users-suggest');

shareSource.addEventListener('keydown', function(){
	if(shareSource.value.length>=3)
		loadUsers(shareSource, shareHiddenInput, shareOutput);
});

searchSource.addEventListener('keydown', function(){
	if(searchSource.value.length>=3)
		loadUsers(searchSource, searchHiddenInput, searchOutput);
});