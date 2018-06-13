document.getElementById('reset-submit-button').addEventListener('click', function() {
    let resetPassword = document.getElementById('reset-password').value;
    let resetVerifyPassword = document.getElementById('reset-verify-password').value;
    let key = window.location.href;
    key = key.split("?")[1];
    key = key.split("=")[1];
    let request = new XMLHttpRequest();
    request.open('POST', 'resources/reset-password-input.php', true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = (function() {
        if(request.readyState === 4 && request.status === 200){
            let response = JSON.parse(request.responseText);

            console.log(response);
            if(response.error !== ""){
                removeErrorMessage("password-row");
                removeErrorMessage("verify-password-row");
                addErrorMessage("password-row", response.error);
                addErrorMessage("verify-password-row", response.error);
            }
            else{
                removeErrorMessage("password-row");
                removeErrorMessage("verify-password-row");
            }

            if(response.redirect !== "")
                window.location.href = "login.php";
        }
    });
    request.send('key=' + key + '&resetPassword=' + resetPassword + '&resetVerifyPassword=' + resetVerifyPassword);
});