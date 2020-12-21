
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
				<h2 class="caption" style="text-align: center">Find  Spare Parts of your Vehicle Here</h2>
				<h3 class="properties" style="text-align: center">More parts will be added soon....</h3>
			</section>
	</section><!--  end hero section  -->

	<section class="listings">
		<div class="wrapper">
			<ul class="properties_list">
			<?php
						include 'includes/config.php';
						$sel = "SELECT * FROM spares WHERE status = 'Available'";
						$rs = $conn->query($sel);
						while($rws = $rs->fetch_assoc()){
			?>
				<li>
					<a href="book_spare.php?id=<?php echo $rws['spare_id'] ?>">
						<img class="thumb" src="spares/<?php echo $rws['image'];?>" width="300" height="200">
					</a>
					
					<div class="property_details">
						<h1><a href="book_spare.php?id=<?php echo $rws['spare_id'] ?>"><?php echo 'Car Name>'.$rws['car_name'];?></a></h1>
						<h2>Spare Type: <span class="property_size"><?php echo $rws['spare_type'];?></span></h2>
						<h3>Cost: Rs.<?php echo $rws['spare_cost'];?></h3>
						
					</div>
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

				<?php include_once "includes/footer.php"; ?>