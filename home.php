<?php
 include_once("dbConnect.php");
 $error = "";
if(isset($_POST['cauta'])){
	$name = $_POST['Nume'];
	$name = htmlspecialchars($name,ENT_QUOTES);
	
	$sql = "SELECT * FROM Person_Finder  WHERE name='".$name."';";
	echo $sql;
	if ($result = $conn ->query($sql)){
		$row = $result->fetch_row();
		
		if($row === NULL){
			$sql = "SELECT * FROM Users WHERE firstname||' '||lastname='".$name."';";
			if ($result = $conn ->query($sql)){
				$row = $result->fetch_row();
				if($row === NULL)
					$error = "Aceasta persoana nu exista în baza de date.";
			}
		else
			header("Location: map.php");		
		}
	else
		header("Location: map.php");
	}
}
if(isset($_POST['ofera'])){
	$name = $_POST['Nume2'];
	$info = $_POST['Mesaj'];
	$address = null;
	if(isset($_POST['checkbox']))
		$address = $_POST['address'];

	$name = htmlspecialchars($name,ENT_QUOTES);
	$info = htmlspecialchars($info , ENT_QUOTES);
	$address = str_replace(array("ș","ă","ț","Ș","Ț","Ă","Â","â"),array("s","a","t","s","t","a","a","a"),$address);
	$address = htmlspecialchars($address,ENT_QUOTES);
	
	
	$sql = "INSERT INTO Person_Finder (name, details, address, conn_date)  VALUES ('".$name."', '".$info."', '".$address."' , sysdate());";  
	if(!$conn->query($sql)){
		echo "Eroare" . $conn->error;
	}
}

if(isset($_POST['situatiaMea'])){
	$message = $_POST['inDangerMessage'];
	$address = $_POST["myAddress"];

	
}
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
					 		<div  class="button" id="in-danger"> 
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
	<?php include "modals/popUp-inHome.php" ?>

	
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/miscs.js"></script>
	<script src="js/fill-page.js"></script>
	<script src="js/modals.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8Pcx6UnNfKrOjhDrcOgG3joJPpUSDEuA&libraries=places"></script>
	<script src="js/register-address.js"></script>
	<script src="js/event-manager.js"></script>
	<script src="js/in-danger.js"></script>
	<script src="js/address-value.js"></script>
</body>
</html>