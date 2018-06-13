
document.getElementById('send-code-submit-button').addEventListener('click',function(){
    let email = document.getElementById('email-send-code').value;
    let request = new XMLHttpRequest();
    request.open('POST', 'resources/send-code-input.php', true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = (function() {
        if(request.readyState === 4 && request.status === 200) {    
            let response = JSON.parse(request.responseText);
            console.log(response);
            if(response.hasOwnProperty("error"))
                addErrorMessage("email-row",response.error);
            else 
                removeErrorMessage("email-row");
            
            if(response.succ === "Bravo"){
                window.location.href = "home.php";
            }
        }
    });
    request.send('email='+email);

});