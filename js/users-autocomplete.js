function loadUsers(name) {
	let request = new XMLHttpRequest();
	request.open('POST', 'query_users.php', true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.onreadystatechange = (function() {
		if(request.readyState === 4 && request.status === 200) {
			let users = JSON.parse(request.responseText);
			let input = document.getElementById('users-suggest');
			input.innerHTML = '';
			for(let user of users) {
				let newUser = document.createElement('div');
				newUser.classList.add('user');
				newUser.innerHTML = user.name;
				
				newUser.addEventListener('click', function(){
					document.getElementById('suggested-user-id').setAttribute('value', user.id_user);
					document.getElementById('user-autocomplete').value=user.name;
					input.innerHTML = '';
				});
				input.appendChild(newUser);
			}
		}
	});
	let sendName = 'pre_name='+encodeURIComponent(name);
	request.send(sendName);
}


document.getElementById('user-autocomplete').addEventListener('keydown', function(){
	let userInput = this.value;
	if(userInput.length>=3)
		loadUsers(userInput);
});