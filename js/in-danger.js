 document.getElementById('sendInDanger').addEventListener('click', function(e){

    let inDangerMessage = document.getElementById("inDangerMessageId").value;
    let address = document.getElementById("danger-location").value;
    address = address.split(" ");
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
                let args = {};
                args.desc = inDangerMessage;
                args.type = 'person';
                args.radius = 500;
                args.lat =address[0];
                args.lng = address[1];
                eventManager.loadEvents(new Date(),new Date());                
                eventManager.createEvent(args);
                for(let modal of document.getElementsByClassName('modal')){
                    modal.classList.remove('visible');
                }
                document.getElementsByClassName('modals-container')[0].style.display='none';
                document.getElementsByClassName('cover')[0].style.display='none';        
            }
        }
    });
    request.send();
   
 });