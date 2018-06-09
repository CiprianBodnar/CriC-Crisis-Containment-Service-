
    document.getElementById('settings-submit-button').addEventListener('click',function(e){
        let firstname = document.getElementById("firstname-setting").value;
        let lastname = document.getElementById("lastname-setting").value;
        let email = document.getElementById("email-setting").value;
        let address = document.getElementById("user-coordinates").value;
        let request = new XMLHttpRequest();
        request.open('POST', 'resources/update-user-information.php', true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.onreadystatechange = (function() {
            if(request.readyState === 4 && request.status === 200) {
                console.log(this.responseText);
                let response = JSON.parse(request.responseText);
                console.log(response);
            }
        });
        request.send('firstname='+firstname+'&lastname='+lastname+'&email='+email+'&address='+address);
    });

    
    