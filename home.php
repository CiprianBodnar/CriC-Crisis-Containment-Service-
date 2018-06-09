<?php
 include_once("dbConnect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title data-href="index">Acasă &bull; Crisis Containment Service</title>
	<link rel="icon" type="image/png" href="img/icon.png">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/modals.css">
	<link rel="stylesheet" href="css/home.css">
	<link rel="stylesheet" href="css/media.css">
</head>
<body id="home-page">

	<?php include "header.php" ?>
	
	<section id="content">
		<div class="gradient-bg" >
			<div class="container" >  
				<div class="box-small"> 
					<div class="button-container">  
					 	<div class="button-wrapper"> 
					 		<div class="button" id="search-trigger"> 
							 	<i class="fas fa-search"></i> 
						 		<div class="dropdown-content"> 
						 			<span class="arrow-icon">
						 			</span>
		    						<p>Caută pe cineva</p>
		  						</div>
						 	</div>
					 	</div>
							
					 	<div class="button-wrapper">
					 		<div class="button" id="share-trigger">
						 		<i class="fas fa-info"></i>
						 		<div class="dropdown-content">
									<span class="arrow-icon">
						 			</span>
		    						<p>Oferă informații</p>
						 		</div>
						 	</div>
					 	</div>
					 	<div class="button-wrapper">
					 		<div id="in-danger"  class="button"> 
					 			<i class="fas fa-exclamation-triangle"></i>
						 		<div class="dropdown-content">
									<span class="arrow-icon">
						 			</span>
		    						<p>Sunt în pericol</p>
						 		</div>
							 </div>
					 	</div>
					 	<div class="clear"></div>
					</div>
					<div class="box"  id="enlarge" style=" box-sizing: initial;"> 
						<h3>
							Lorem ipsum dolor sit amet
						</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta vel quis asperiores deserunt, similique nobis sed molestiae vitae qui dolorum eaque placeat sequi, illo blanditiis temporibus, ullam reprehenderit aliquam dignissimos!
						</p>

						<a href="contact.php?" id="index-contact-button">  
							Contactează-ne
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php include "footer.php" ?>

	<div class="cover"></div>
	<div class="modals-container">
	<?php include "modals/danger.php" ?>
	<?php include "modals/searchInfo.php" ?>
	<?php include "modals/share-info.php" ?>
	<?php include "modals/notifications.php" ?>
	</div>
	

	
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/miscs.js"></script>
	<script src="js/fill-page.js"></script>
	<script src="js/modals.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8Pcx6UnNfKrOjhDrcOgG3joJPpUSDEuA&libraries=places"></script>
	<script src="js/event-manager.js"></script>
	<script src="js/in-danger.js"></script>
	<script src="js/users-autocomplete.js"></script>
	<script src="js/search-info-print.js"></script>
	<script src="js/share-info.js"></script>
	<script src="js/address-autocomplete.js"></script>
	<script>
		//autocomplete address for sharing information
        var shareAddressInput = document.getElementById('share-address-input');
        var finalInput = document.getElementById('share-info-location');
        prepareAddressAutocomplete(shareAddressInput, finalInput, function(){
        	shareAddressInput.value='';
        	console.log(shareAddressInput);
        	finalInput.value='';
        	console.log(finalInput);
        });
        //autocomplete address for setting in-danger
        let dangerAddressInput = document.getElementById('address-input2');
        dangerFinalInput = document.getElementById('danger-location');
        prepareAddressAutocomplete(dangerAddressInput, dangerFinalInput);
    </script>
	<script src="js/modals.js"></script>
	<script src="js/notifications.js"></script>
	
</body>
</html>