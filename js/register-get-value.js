document.getElementById('register-submit-button').addEventListener('click', function(){
	let firstname = document.getElementById("firstname-register").value;
	let lastname = document.getElementById("lastname-register").value;
	let email = document.getElementById("email-register").value;
	let verify_email = document.getElementById("verify-email-register").value;
	let password = document.getElementById("password-register").value;
	let verify_password = document.getElementById("verify-password-register").value;
	let address = document.getElementById("formatted-addr").value;
	
	let request = new XMLHttpRequest();
	request.open('POST', 'resources/register-input.php', true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = (function() {
    	if(request.readyState === 4 && request.status === 200) {
            console.log(request.responseText);
    		let response = JSON.parse(request.responseText);
    		if(response.hasOwnProperty("redirect")) {
    			window.location.href = "login.php";
    		}
    		
    		if(response.first_name_error) 
    			addErrorMessage("firstname-row", response.first_name_error);	
    		else 
    			removeErrorMessage("firstname-row");
    		
    		if(response.last_name_error)
    			addErrorMessage("lastname-row", response.last_name_error);
    		else
    			removeErrorMessage("lastname-row");

    		if(response.email_address_error)
    			addErrorMessage("email-row", response.email_address_error);
    		else
    			removeErrorMessage("email-row");

    		if(response.different_email_address)
    			addErrorMessage("email-row", response.different_email_address);
    		else
    			removeErrorMessage("email_error");

    		if(response.verify_email_address_error)
    			addErrorMessage("verify-email-row", response.verify_email_address_error);
    		else
    			removeErrorMessage("verify-email-row");


    		if(response.password_error){
    			addErrorMessage("password-row", response.password_error);
    			addErrorMessage("verify-password-row", "");
    		} 
    		else {
    			removeErrorMessage("password-row");
    			removeErrorMessage("verify-password-row");
    		}

    		if(response.address_error)
    			addErrorMessage("address-row", response.address_error);
    		else
    			removeErrorMessage("address-row");

    	}
    });
    request.send("firstname=" + firstname + "&lastname=" + lastname + "&email=" + email + "&verify_email=" + 
    	verify_email + "&password=" + password + "&verify_password=" + verify_password + "&address=" + address);
});
