 

 document.getElementById('index-send-button').addEventListener('click', function(e){
    e.preventDefault;
    let address = document.getElementById("address-input2").value;
    let geocoder = new google.maps.Geocoder();
    geocoder.geocode({ "address": address}, function(results) {
        
        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(function(position){
                
                let eventManager = new EventManager();
                let args = {};
                    args.desc = 'Descriere';
                    args.type = 'person';
                    args.radius = 5;
                    args.lat =results[0].geometry.location.lat();
                    args.lng = results[0].geometry.location.lng();
                    console.log(args);                   
                    eventManager.createEvent(args);
            
            });
        }
    });

  
   
 });