
document.getElementById('conecteaza').addEventListener('click',function(e){
    let email = document.getElementById('login-email');
    let password = document.getElementById('login-password');
    let request = new XMLHttpRequest();
    request.open('POST', 'resources/login-check-inputs.php', true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = (function() {
        if(request.readyState === 4 && request.status === 200) {
            console.log(request.responseText);
            let response = JSON.parse(request.responseText);
        }
    });
    request.send('email='+email+'&password='+password);
});