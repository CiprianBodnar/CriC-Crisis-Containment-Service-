function sendFile(){
	document.getElementById('shelter-preloader').classList.add('visible');
	let request = new XMLHttpRequest();
	request.open('POST', 'resources/shelters-parse.php', true);
	request.onreadystatechange = function(){
		if(this.readyState === 4 && this.status === 200){
			let response = JSON.parse(this.responseText);
			document.getElementById('shelter-preloader').classList.remove('visible');
			if(response.hasOwnProperty('error')){
				new EventManager(null, null).promptMessage(response.error, 'err');
			}
			else{
				new EventManager(null, null).promptMessage(response.success, 'succ');
			}
		}
	}
	let formData = new FormData();
	let fileInput = document.getElementById('shelters-file');
	let files = fileInput.files;
	if(files.length==0){
		new EventManager(null, null).promptMessage('Nu ați selectat nici un fișier', 'err');
		return;
	}
	let file = files[0];
	console.log(file);
	if(file.size>10000){
		new EventManager().promptMessage("Dimensiunea fișierului depășește 1MO", "err");
	}
	formData.append('file', files[0]);
	request.send(formData);

}
document.getElementById('shelters-file').onchange = function(){
	document.getElementById('selected-file').innerText = this.files[0].name;
}
document.getElementById('shelters-submit').addEventListener('click', function(){
	sendFile();
});