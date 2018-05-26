loadUsers() {
	let request = new XMLHttpRequest();
	request.open('POST', 'query_users.php', true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.onreadystatechange = (function() {
		if(request.readyState === 4 && request.status === 200) {
			let users = JSON.parse(request.responseText);
			print("Este");
			for(let user of users) {
				
			}
		}
	});
	let sendName = encodeURIComponent(document.getElementById('share-autocomplete'));
	request.send(sendName);
	}
}