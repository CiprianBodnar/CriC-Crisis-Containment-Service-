 document.getElementById('sendInDanger').addEventListener('click', function(e){


    let inDangerMessage = document.getElementById("inDangerMessageId").value;
    let address = document.getElementById("address-input2").value;
    let request = new XMLHttpRequest();
    request.open('POST', 'resources/remove-danger-event.php', true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = (function() {
        if(request.readyState === 4 && request.status === 200) {
            let eventManager = new EventManager();
            let response = JSON.parse(request.responseText);
            if(response.hasOwnProperty("error")){
                eventManager.promptMessage(response.error,"err");
            }   
            else{
                let geocoder = new google.maps.Geocoder();
                geocoder.geocode({ "address": address}, function(results) {
                    if(results.length==0){
                        eventManager.promptMessage("Adresă invalidă","err");
                        return ;
                    }
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

            
        }
    });
    request.send();
   
 });