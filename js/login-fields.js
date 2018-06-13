
function checkLogin(email,password,errors){  
    let request = new XMLHttpRequest();
    request.open('POST', 'resources/login-check-inputs.php', true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = (function() {
        if(request.readyState === 4 && request.status === 200) {        
            let response = JSON.parse(request.responseText);       
            if(response.hasOwnProperty("redirect") || response.hasOwnProperty("succ"))
                window.location.href = "home.php";
            if(response.hasOwnProperty("error") && errors)
                addErrorMessage("inputs-row",response.error);
            else 
                removeErrorMessage("inputs-row");
        }
    });
    request.send('email='+email+'&password='+password);
}

document.getElementById('conecteaza').addEventListener('click',function(){ 
    let email = document.getElementById('login-email').value;
    let password = document.getElementById('login-password').value;
    checkLogin(email,password,true);
});
