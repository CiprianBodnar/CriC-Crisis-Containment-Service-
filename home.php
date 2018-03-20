<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title data-href="index">Acasă &bull; Crisis Containment Service</title>
	<link rel="icon" type="image/png" href="img/icon.png">
	<link rel="stylesheet" href="css/style.css">
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
					 		<a href="map.php">
						 		<div class="button">
							 			<i class="fas fa-exclamation-triangle"></i>
							 		
							 		<div class="dropdown-content">
										<span class="arrow-icon">
							 			</span>
			    						<p>Sunt în pericol</p>
							 		</div>
							 	</div>
							 </a>
					 	</div>
					 	<div class="clear"></div>
					</div>
					<div class="box"  id="enlarge" style=" box-sizing: initial;">
						<h3>
							Lorem ipsum dolor sit amet
						</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta vel quis asperiores deserunt, similique nobis sed molestiae vitae qui dolorum eaque placeat sequi, illo blanditiis temporibus, ullam reprehenderit aliquam dignissimos!
						</p>

						<button id="index-send-button">
							Contact
						</button>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php include "footer.php" ?>

	<div class="cover"></div>
	<div class="modal" id="search">
		 <div class="container">
			<div class="box-small white">
				<form action="#">
					<div class="row modal-title">
						<h3>
							Caută pe cineva
						</h3>
						<div class="modal-close">
							<i class="fas fa-times"></i>
						</div>
						<div class="clear"></div>
					</div>
					<div class="row">
						<div class="col12">
							<p>
								Introduceți numele
							</p>
							<input type="text" name="Nume" value="Nume" onfocus="if(this.value=='Nume') this.value='';" onblur="if(this.value=='') this.value='Nume';">
							<button type="submit" id="submit-button">
	                            <i class="fas fa-search"></i>
	                        </button>
	                        <div class="clear"></div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal" id="share">
		 <div class="container">
			<div class="box-small white">
				<form action="#">
					<div class="row modal-title">
						<h3>
							Oferă informații despre o persoană
						</h3>
						<div class="modal-close">
							<i class="fas fa-times"></i>
						</div>
						<div class="clear"></div>
					</div>
					<div class="row">
						<div class="col12">
							<p>
								Introduceți numele
							</p>
							<input class="clearinput" name="Nume" value="Nume" onfocus="if(this.value=='Nume') this.value='';" onblur="if(this.value=='') this.value='Nume';">
	                        <div class="clear"></div>
						</div>
					</div>
					<div class="row">
						<div class="col12">
							<p>
								Detalii
							</p>
							<textarea type="text" name="Mesaj"  value="Mesaj"  onfocus="if(this.value=='Mesaj') this.value='';" onblur="if(this.value=='') this.value='Mesaj';" >Mesaj</textarea>
		                    <div class="clear"></div>
						</div>
					</div>	
					<div class="row">
						<div class="col12">
							<p>
								Oferă o locație
								<input type="checkbox" name="checkbox" id="checkbox">
							</p>
								<input class="showthis" id="showthis" name="showthis"  value="Locație" onfocus="if(this.value=='Locație') this.value='';"
								onblur="if(this.value=='') this.value='Locație';" ></textarea>
		                    <div class="clear"></div>
		                    <button id="index-send-button">
								Trimite
							</button>
						</div>
					</div>	
				</form>
			</div>
		</div>
	</div>

	
	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="js/miscs.js"></script>
	<script type="text/javascript" src="js/fill-page.js"></script>
	<script src="js/modals.js"></script>
</body>
</html>