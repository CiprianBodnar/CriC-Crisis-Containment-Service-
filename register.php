

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title data-href="index">Acasă &bull; Crisis Containment Service</title>
	<link rel="icon" type="image/png" href="img/icon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" href="css/media.css">
</head>
<body id="login-page">
	<?php include "header.php" ?>
	
	<section id="content">
        <div class="gradient-bg">
            <div class="container no-padding">
                <div class="box-medium align-left orange" id="enlarge">
                    <div class="row">
                        <div class="col12">
                            <h3 class="subtitle">
                                Inregistrarea contului dvs
                            </h3>
                            <form class="contact-form" action="#" method="POST">
                                <div class="row">
                                    <div id="lastname-row" class="col6 no-padding">
                                        <div class="par">
                                            Nume familie
                                        </div>
                                        <input type="text" name="nume" id="lastname-register" value="Nume" onfocus="if(this.value=='Nume') this.value='';" onblur="if(this.value=='') this.value='Nume';">
                                        
                                    </div>
                                    <div id="firstname-row" class="col6 no-padding">
                                            <div class="par">
                                                Prenume 
                                            </div>
                                            <input type="text" name="prenume" id="firstname-register" value="Prenume" sonfocus="if(this.value=='Prenume') this.value='';" onblur="if(this.value=='') this.value='Prenume';">
                                    </div>

                                    <div id="email-row" class="col6 no-padding">
                                        <div class="par">
                                            Adresa de e-mail
                                        </div>
                                        <input type="text" name="email" id="email-register" value="your.email@yoursite.com" onfocus="if(this.value=='your.email@yoursite.com') this.value='';" onblur="if(this.value=='') this.value='your.email@yoursite.com';">
                                    </div>

                                    <div id="verify-email-row" class="col6 no-padding">
                                        <div class="par">
                                            Verificare adresa de e-mail
                                        </div>
                                        <input type="text" name="verifica_email" id="verify-email-register" value="your.email@yoursite.com" onfocus="if(this.value=='your.email@yoursite.com') this.value='';" onblur="if(this.value=='') this.value='your.email@yoursite.com';">
                                    </div>


                                    <div id="password-row" class="col6 no-padding">
                                        <div class="par">
                                            Parola
                                        </div>
                                        <input type="password" id="password-register" name="parola">
                                    </div>

                                    <div id="verify-password-row" class="col6 no-padding">
                                        <div class="par">
                                            Verificare parola
                                        </div>
                                        <input type="password" id="verify-password-register" name="verifica_parola" >
                                    </div>
                                    
                                    <div class="clear"></div>
                                    <div id="address-row" value="Adresa" class="col12 no-padding">
                                        <div class="par">
                                            Adresa
                                        </div>

                                        <input type="text" autocomplete="off" name="Adresa" id="address-register" onfocus="if(this.value=='Adresa') this.value='';" onblur="if(this.value=='') this.value='Adresa';">
                                        <input type="hidden" id ="formatted-addr" name ="formatted-address" value="">
                                     </div>

                                    <div class="coll6 no-padding">
                                        <div id="register-submit-button" class="settings-button" name="submit">
                                            Trimitere
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </form>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
	</section>

	<?php include "footer.php" ?>
    <script src="js/miscs.js"></script>
    <script src="js/fill-page.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8Pcx6UnNfKrOjhDrcOgG3joJPpUSDEuA&libraries=places"></script>
    <script src="js/address-autocomplete.js"></script>
    <script> 
        let visible_input = document.getElementById("address-register");
        let hidden_input = document.getElementById("formatted-addr");
        console.log(visible_input, hidden_input);
        prepareAddressAutocomplete(visible_input, hidden_input);
    </script>
    <script src="js/form-errors.js"></script>
    <script src="js/register-get-value.js"></script>
</body>
</html>