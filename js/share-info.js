function shareInfo(){
	let idContainer = document.getElementById('share-suggested-user-id');
	let messageContainer = document.getElementById('share-message');
	let addressContainer = document.getElementById('share-info-location');
	if(idContainer.value.length===0){
		console.log(idContainer.innerText);
		new EventManager(null, null).promptMessage('Nici un utilizator nu se potrivește căutarilor', 'err');
		return;
	}
	if(messageContainer.value === 'Mesaj' || messageContainer.innerText.lenght === 0){
		new EventManager(null, null).promptMessage('Nu ați specificat nici o informație', 'err');
		return;
	}
	let request = new XMLHttpRequest();
	request.open('POST', 'resources/add-person-info.php', true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.onreadystatechange = function(){
		if(request.readyState === 4 && request.status === 200){
			let response = JSON.parse(request.responseText);
			if(response.hasOwnProperty('error'))
				new EventManager(null, null).promptMessage(response.error, 'err');
			else{
				let evMng = new EventManager(null, null);
				evMng.promptMessage(response.success, 'succ');
				document.getElementById('share').classList.remove('visible');
				document.getElementsByClassName('modals-container')[0].style.display='none';
				document.getElementsByClassName('cover')[0].style.display='none';
				let notifyArgs = {userId: idContainer.value, name: document.getElementById('username-container').value};
				evMng.notify('posted_info', notifyArgs.userId+' '+notifyArgs.name);
			}
		}
	}
	let postBody = 'id_user='+encodeURIComponent(idContainer.value)+'&message='+encodeURIComponent(messageContainer.value);
	if(addressContainer.value.length>0)
		postBody+='&address='+encodeURIComponent(addressContainer.value);
	request.send(postBody);
}

let canShare = true;
document.getElementById('share-info-submit').addEventListener('click', function(){
	if(canShare === true){
		canShare = false;
		shareInfo();
		setTimeout(function(){canShare = true;}, 5000);
	}
	else{
		new EventManager(null, null).promptMessage("Nu puteți oferii alte informații așa de repede. (5s)", "err");
	}
})