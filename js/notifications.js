function toggleUnread(notification){
	let notId = notification.id;
	let notState = notification.state;

	let request = new XMLHttpRequest();
	request.open("POST", "resources/update-notification.php", true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.onreadystatechange = function(){
		if(request.readyState === 4 && request.status === 200){
			let response = JSON.parse(request.responseText);
			if(response.hasOwnProperty('error')){
				new EventManager(null, null).promptMessage(response.error, 'err');
			}
			else{
				notification.state = response.newState;
			}
		}
	}
	let sendBody = 'not_id='+encodeURIComponent(notId)+'&not_state='+encodeURIComponent(notState);
	request.send(sendBody);
}

function loadNotifications(all){
	let notificationsContainer = document.getElementById('notifications-container');
	let counters = document.getElementsByClassName('notification-count');
	let request = new XMLHttpRequest();
	request.open('POST', 'resources/poll.php', true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.onreadystatechange = function(){
		if(request.readyState === 4 && request.status === 200){
			let response = JSON.parse(request.responseText);
			if(response.hasOwnProperty('error')){
				//new EventManager(null, null).promptMessage(response.error, 'err');
			}
			else{
				//set counters
				for(let i=0;i<counters.length;i++){
					let counter = counters[i];
					counter.innerText = response.unread;
					if (response.unread>0)
						counter.parentNode.classList.add('unread');
					else{
						counter.parentNode.classList.remove('unread');
					}
				}
				//if there's something new
				if(response.hasOwnProperty('notifications')){
					notificationsContainer.innerHTML = '';

					for(let notification of response.notifications){
						//<div class='row'> ...
						let notificationContainer = document.createElement('div');
						notificationContainer.classList.add('row');
						if(notification.state === 0 || notification.state === -1){
							notificationContainer.classList.add('unread');
						}

						//		<div class='notification-toggle-unread'> button for read/unread toggling </div>
						let unreadToggle = document.createElement('div');
						unreadToggle.classList.add('notification-toggle-unread');
						unreadToggle.innerHTML = '<span class="unread-circle"></span>';
						notificationContainer.appendChild(unreadToggle);
						unreadToggle.addEventListener('click', function(){
							toggleUnread(notification);
							notificationContainer.classList.toggle('unread');
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
					if(response.unread>0)
						new EventManager(null, null).promptMessage('Aveți notificări noi.', 'succ');
				}

				setTimeout(function(){loadNotifications();}, 2000);
			}
		}
	}
	if(all)
		request.send('all=true');
	else
		request.send();
}
loadNotifications(true);