function loadUserInfo(){
    let request = new XMLHttpRequest();
    request.open('POST', 'resources/get-user-information.php', true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = (function() {
        if(request.readyState === 4 && request.status === 200) {
            let firstname = document.getElementById("firstname-setting");
            let lastname = document.getElementById("lastname-setting");
            let email = document.getElementById("email-setting");
            let address = document.getElementById("address-setting");
            let hidden = document.getElementById("span-setting");
            let hiddenInput = document.getElementById("user-coordinates");
            let response = JSON.parse(request.responseText);
            firstname.value = response.user.firstname;
            lastname.value = response.user.lastname;
            email.value = response.user.email;
            hiddenInput.value = response.user.address;
            response.user.address = response.user.address.split(" ");
            let latLng = {lat: response.user.address[0], lng: response.user.address[1]};
            new EventManager(null,new google.maps.Geocoder()).codeLatLng(latLng,hidden,function(){
                address.value = hidden.innerText;
            });   
        }
    });
    request.send();
}