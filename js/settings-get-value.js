
    document.getElementById('settings-submit-button').addEventListener('click',function(e){
        let firstname = document.getElementById("firstname-setting").value;
        let lastname = document.getElementById("lastname-setting").value;
        let email = document.getElementById("email-setting").value;
        let address = document.getElementById("user-coordinates").value;
        let password = document.getElementById("password-setting").value;
        let request = new XMLHttpRequest();
        request.open('POST', 'resources/update-user-information.php', true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.onreadystatechange = (function() {
            if(request.readyState === 4 && request.status === 200) {
               
                let response = JSON.parse(request.responseText);
                
                if(response.firstnameError)
                   addErrorMessage("firstname-row",response.firstnameError);
                else
                    removeErrorMessage("firstname-row");
                
                if(response.lastnameError)
                   addErrorMessage("lastname-row",response.lastnameError);
                else
                    removeErrorMessage("lastname-row");
                
                if(response.emailError)
                    addErrorMessage("email-row",response.emailError);
                else
                    removeErrorMessage("email-row");

                if(response.addressError)
                    addErrorMessage("address-row",response.addressError);
                else
                    removeErrorMessage("address-row");

                if(response.passwordError)
                    addErrorMessage("password-row",response.passwordError);
                else
                    removeErrorMessage("password-row");
                
                
                if(response.ok != ""){
                    let eventManager = new EventManager();
                    eventManager.promptMessage(response.ok,"succ");
                }   
            }
        });
        request.send('firstname='+firstname+'&lastname='+lastname+'&email='+email+'&address='+address+'&password='+password);
    });

    
    