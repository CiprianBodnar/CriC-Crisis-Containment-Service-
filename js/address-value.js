let hiddenAddress = document.getElementById("hidden-address");

if(navigator.geolocation){
    navigator.geolocation.getCurrentPosition(function(position){
        let latLng= {};
        latLng.lat=position.coords.latitude;
        latLng.lng=position.coords.longitude;
        let geocoder = new google.maps.Geocoder();
        let eventManager = new EventManager(null,geocoder);
        eventManager.codeLatLng(latLng,hiddenAddress,function(){
            document.getElementById("address-input2").setAttribute("value",hiddenAddress.innerHTML);
        });
       
    });
}

