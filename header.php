<?php 
	include_once ("dbConnect.php");
	$loggedIn = false;
	$username = "";
	if(isset($_SESSION['loggedIn'])){
		$loggedIn = $_SESSION['loggedIn'];
		$username = $_SESSION['name'];
		}

 ?>
<header id="header">
	<div class="container">
		<div class="logo fl">
			<img src="img/logo.png" alt="">
		</div>
		<div class="nav-menu fr">
			<div class="nav-trigger fr" id="nav-trigger">
				<i class="fas fa-bars"></i>
			</div>
			<ul class="nav" id="nav-menu">
				<?php if( $loggedIn === true){ ?>
					<li class="hidden-large" id="username"><span>
						<?php echo $username ?>
					</span></li>
				<?php } ?>
				<li id="home-page"><a href="home.php"><i class="fas fa-home"></i>Acasă</a></li>
				<li id="map-page"><a href="map.php"><i class="fas fa-location-arrow"></i>Hartă</a></li>	
				<li id="history-page"><a href="history.php"><i class="fas fa-history"></i>Istoric</a></li>
				<li id="contact-page"><a href="contact.php"><i class="fas fa-envelope"></i>Contact</a></li>
				<?php if ($loggedIn === false) { ?>
					<li id="login-page"><a href="login.php"><i class="fas fa-sign-in-alt"></i>Conectare</a></li>
				<?php } else { ?>
					<li class="hasSub">
						<span class="visible-large">
							<i class="fas fa-user"></i> <?php echo $username ?> <i class="fas fa-chevron-down"></i>
						</span>
						<ul class="sub-nav">
							<li><a href="#"><i class="fas fa-cog"></i>Setări</a></li>
							<li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Deconectare</a></li>
							
						</ul>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="clear"></div>
	
</header>

 <script type="text/javascript" src="js/selected-page.js"></script>