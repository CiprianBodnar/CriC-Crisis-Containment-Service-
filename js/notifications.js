function loadNotifications(all){
	let notificationsContainer = document.getElementById('notifications-container');
	let counters = document.getElementsByClassName('notificationCount');
	let request = new XMLHttpRequest();
	request.open('POST', 'resources/poll.php', true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.onreadystatechange = function(){
		if(request.readyState === 4 && request.status === 200){
			let response = JSON.parse(request.responseText);
			console.log(response);
			if(response.hasOwnProperty('error')){
				new EventManager(null, null).promptMessage(response.error, 'err');
			}
			else{
				if(response.hasOwnProperty('notifications')){
					for(let counter of counters){
						counter.innerText = response.unread;
					}
					notificationsContainer.innerHTML = '';

					for(let notification of response.notifications){
						//<div class='row'> ...
						let notificationContainer = document.createElement('div');
						notificationContainer.classList.add('row');
						if(notification.state === 0 || notification.state === -1){
							notificationContainer.classList.add('unread');
						}
						notificationContainer.addEventListener('click', function(){
							//transforma in citita
						});

						//		<div class='notification-info'> <<message from notifications>> </div>
						let notificationInfoContainer = document.createElement('div');
						notificationInfoContainer.classList.add('notification-info');
						notificationInfoContainer.innerHTML = notification.info;
						notificationContainer.appendChild(notificationInfoContainer);

						//		<div class='notification-date'> <<date of notification>> </div>
						let notificationDateContainer = document.createElement('div');
						notificationDateContainer.classList.add('notification-date');
						notification.date = new Date(notification.date);
						notificationDateContainer.innerText = notification.date.toLocaleDateString('ro-RO')+' '+notification.date.toLocaleTimeString('ro-RO');
						notificationContainer.appendChild(notificationDateContainer);

						//</div> -- close div with class row
						notificationsContainer.appendChild(notificationContainer);
					}
				}

				setTimeout(function(){loadNotifications();}, 5000);
			}
		}
	}
	if(all)
		request.send('all=true');
	else
		request.send();
}
loadNotifications(true);