<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title data-href="index">Settings &bull; Crisis Containment Service</title>
	<link rel="icon" type="image/png" href="img/icon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" href="css/media.css">
</head>
<body id="setting-page">
	<?php include "header.php" ?>
    <section id="content">
        <div class="gradient-bg">
            <div class="container no-padding">
                <div class="box-medium align-left orange" id="enlarge">
                    <div class="row">
                        <div class="col12">
                            <h3 class="subtitle">
                                Datele contului dvs
                            </h3>
                            <form class="contact-form" action="#" method="POST">
                                <div class="row">
                                    <div class="col6 no-padding">
                                        <div class="par">
                                            Nume familie
                                        </div>
                                        <input type="text" name="nume" id="firstname-setting">
                                    </div>
                                    <div class="col6 no-padding">
                                        <div class="par">
                                            Prenume
                                        </div>
                                        <input type="text" name="prenume" id="lastname-setting">
                                    </div>
                                    <div class="col12 no-padding">
                                        <div class="par">
                                            Adresa de e-mail
                                        </div>
                                        <input type="text" name="email" id="email-setting">
                                    </div>
                                    <div class="col12 no-padding">
                                        <span style = "display:none" id="span-setting"> </span>
                                        <div class="par">
                                            Adresa
                                        </div>
                                        <input type="hidden" id="user-coordinates">
                                        <input type="text" name="adresa" id="address-setting" autocomplte="off">
                                        <div  id="settings-submit-button" class = "settings-button">
                                            Salveaza
                                        </div>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include "footer.php" ?>    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8Pcx6UnNfKrOjhDrcOgG3joJPpUSDEuA&libraries=places"></script>
    <script src="js/miscs.js"></script>
    <script src="js/selected-page.js"></script>
    <script src="js/fill-page.js"></script>
    <script src="js/address-autocomplete.js"></script>
    <script src="js/settings-set-value.js"></script>
    <script src="js/event-manager.js"></script>
    <script src="js/settings-get-value.js"></script>
    <script>
        let hiddenInput = document.getElementById("user-coordinates");
        let addressInput = document.getElementById("address-setting");
        prepareAddressAutocomplete(addressInput, hiddenInput, loadUserInfo);
    </script>
</body>
</html>