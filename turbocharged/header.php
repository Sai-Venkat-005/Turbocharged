<?php
	session_start();
	error_reporting("E-NOTICE");
?>
<header>
			<div class="wrapper">
				<h1 class="logo"> TURBOCHARGED</h1>
				<a href="#" class="hamburger"></a>
				<nav>
					<?php
						if(!$_SESSION['email'] && (!$_SESSION['pass'])){
					?>
					<ul>
						<li><a href="index.php">Home</a></li>
						<li><a href="spares.php">Parts</a></li>
						<li><a href="about_us.php">About Us</a></li>
						<li><a href="contact_us.php">Reach us</a></li>
						
					</ul>
					
					<a href="account.php">  Customer Login</a>
					<a href="login.php">Admin Login</a>
					
					<?php
						} else{
					?>
							<ul>
								<li><a href="index.php">Home</a></li>
								<li><a href="status.php">View Status</a></li>
								<li><a href="message_admin.php">Contact Us</a></li>
							</ul>
					<a href="admin/logout.php">Logout</a>
					<?php
						}
					?>
				</nav>
			</div>
		</header>