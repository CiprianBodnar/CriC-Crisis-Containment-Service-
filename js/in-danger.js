 
 document.getElementById('in-danger').addEventListener('click', function(e){
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(function(position){
            let eventManager = new EventManager();
            let args = {};
                args.desc = 'Descriere';
                args.type = 'person';
                args.radius = 5;
                args.lat =position.coords.latitude;
                args.lng = position.coords.longitude;
                eventManager.loadEvents(new Date(),new Date());
                console.log(args);
                eventManager.createEvent(args);
        
        });
    }
   
 });