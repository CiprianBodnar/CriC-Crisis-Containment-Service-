function loadInfo(name) {
	let request = new XMLHttpRequest();
	request.open('POST', 'resources/search-info-code.php', true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.onreadystatechange = (function() {
		if(request.readyState === 4 && request.status === 200) {
			let info = JSON.parse(request.responseText);
			let postedOutput = document.getElementById('posted-search-info');
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
			let userOutput = document.getElementById("user-search-info");
			userOutput.innerHTML="<div class='user-address'>"+info.user.address+"</div>"+
								"<div class='user-date'>"+info.user.conn_date+"</div>";
		}
	});
	let sendInfo = 'Id=' + encodeURIComponent(document.getElementById('search-suggested-user-id').value);
	console.log(sendInfo);
	request.send(sendInfo);
}

document.getElementById('submit-button').addEventListener('click', function(){
	let userInput = this.value;
	loadInfo(userInput);
});