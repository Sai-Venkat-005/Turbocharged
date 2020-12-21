<!DOCTYPE html>
<html lang="en">
<head>
	<title>TURBOCHARGED</title>
	<meta charset="utf-8">
	<meta name="author" content="pixelhint.com">
	<meta name="description" content="La casa free real state fully responsive html5/css3 home page website template"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />
	
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/responsive.css">

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
</head>
<body>
<section class="">
		<?php
			include 'header.php';
		?>

			<section class="caption">
				<h2 class="caption" style="text-align: center">Contact Us</h2>
				<h3 class="properties" s
	</section><!--  end hero section  -->
						
                    <section class="listings">
		                <div class="wrapper">
						<ul>
						<h1>Turbocharged Car Care Center</h1>
						<h2>NH-65, Abdullapurmet</h2>
						
						<h3>Rangareddy, Telangana - 501512</h3>
						
						<h7>Contact no:9515925928</h7><br><br>
						<h8>Email: teamturbocharged@gmail.com</h8><br><br>
						<h9>location:</h9><br>
						
						<?php
						include 'includes/config.php';
						$sel = "SELECT * FROM about ";
						$rs = $conn->query($sel);
						while($rws = $rs->fetch_assoc()){
			?>
				<li>
					<a href="https://www.google.com/maps/place/17%C2%B016'55.6%22N+78%C2%B047'03.1%22E/@17.2821111,78.7820057,17z/data=!3m1!4b1!4m13!1m6!3m5!1s0x3bcb0c481a8cd299:0x7f432c1b033db8fb!2sAndol+Maisamma+Temple!8m2!3d17.2824814!4d78.7825393!3m5!1s0x0:0x0!7e2!8m2!3d17.2821228!4d78.7842023">
						<img class="thumb" src="about/<?php echo $rws['image'];?>" width="400" height="400">
					</a>
					
					
				</li>
			<?php
				}
			?>
						
						
						
						
						
						
						
						
						
		</ul>
		</div>
	</section>	<!--  end listing section  -->
		  
	<footer>
		<div class="wrapper footer">
			<ul>
				<li class="links">
					<ul>
						<li>QUICK LINKS</li>
						<li><a href="#">About Us</a></li>
						<li><a href="#">Terms</a></li>
						<li><a href="#">Policy</a></li>
						<li><a href="#contact_us.php">Contact Us</a></li>
					</ul>
				</li>

				

				<li class="links">
					<ul>
						<li>OUR SERVICES</li>
						<li><a href="#">Washing and Sanitization</a></li>
						<li><a href="#">Complete servicing</a></li>
						<li><a href="#">Wheel Balancing and Wheel Allignment</a></li>
						<li><a href="#">Others</a></li>
					</ul>
				</li>

							<?php include_once "includes/footer.php" ?>