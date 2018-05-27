 document.getElementById('index-send-button').addEventListener('click', function(e){
    let inDangerMessage = document.getElementById("inDangerMessageId").value;
    let address = document.getElementById("address-input2").value;

    let request = new XMLHttpRequest();
    request.open('POST', 'resources/remove-danger-event.php', true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = (function() {
		if(request.readyState === 4 && request.status === 200) {
           
            let geocoder = new google.maps.Geocoder();
            geocoder.geocode({ "address": address}, function(results) {
                if(navigator.geolocation){
                    navigator.geolocation.getCurrentPosition(function(position){
                        let eventManager = new EventManager();
                        let args = {};
                            args.desc = inDangerMessage;
                            args.type = 'person';
                            args.radius = 15;
                            args.lat =results[0].geometry.location.lat();
                            args.lng = results[0].geometry.location.lng();
                            eventManager.loadEvents(new Date(),new Date());                
                            eventManager.createEvent(args);
                            for(let modal of document.getElementsByClassName('modal')){
                                modal.classList.remove('visible');
                            }
                            document.getElementsByClassName('cover')[0].style.display='none';
                           
                           
                    });
                }
            });
        }
    });
    request.send();
   
 });