document.getElementById('contact-submit-button').addEventListener('click', function(){
    let lastName = document.getElementById('lastname-contact').value;
    let firstName = document.getElementById('firstname-contact').value;
    let email = document.getElementById('email-contact').value;
    let message = document.getElementById('message-contact').value;
    let subject = document.getElementById('subject-contact').value;
    let request = new XMLHttpRequest();
    request.open('POST', 'resources/contact-input.php', true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = (function(){
        if(request.readyState === 4 && request.status === 200){
            let response = JSON.parse(request.responseText);

            if(response.firstName)
                addErrorMessage("firstname-row", response.firstName);
            else
                removeErrorMessage("firstname-row");
            
            if(response.lastName)
                addErrorMessage("lastname-row", response.lastName);
            else
                removeErrorMessage("lastname-row");

            if(response.email)
                addErrorMessage("email-row", response.email);
            else
                removeErrorMessage("email-row");
            
            if(response.message)
                addErrorMessage("message-row", response.message);
            else
                removeErrorMessage("message-row");
            
            if(response.subject)
                addErrorMessage("subject-row", response.subject)
            else 
                removeErrorMessage("subject-row");

            if(response.ok != ""){
                let eventManager = new EventManager();
                eventManager.promptMessage(response.ok, "succ");
            }
        }
    });
    request.send('lastname=' + lastName + '&firstname=' + firstName + '&email=' + email + '&subject=' + subject + '&message=' + message);
});