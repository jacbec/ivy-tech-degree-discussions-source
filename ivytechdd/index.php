<?php 
require_once '@core/init.php'; 
Session::set('page', '');				
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Ivy Tech Degree Discussions</title>

		<!-- Meta/Favicons/Fonts Section ------------------------------------------------------------------------------------------------>
		<link rel="stylesheet" type="text/css" media="screen" href="fonts/font-awesome/css/font-awesome.min.css">
	
		<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/style.css">

	</head>
	<body>
		<!-- Header Section ------------------------------------------------------------------------------------------------>
		<?php require 'nav.php'; ?>

		<!-- Content Section ------------------------------------------------------------------------------------------------>
		<section style="background-color: #FFF;">
			<section id="header" class="container-fluid" style="padding: 50px 0px 50px 0px">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 text-center">
							<h1 class="section-heading">Ivy Tech Degree Discussions</h1>
							<hr class="primary">
						</div>
					</div>
				</div>
				<div class="container">
					<div class="col-lg-12">
						<p>The purpose of this website is to provide a helpful collaborating forum for Ivy Tech students or people wanting to become an Ivy Tech student. The web presence will allow students to achieve insight on problematic issues with certain classes by their degree type and give guests insight on some the programs Ivy Tech has to offer. Consolidating Ivy Tech principles this easy-to-use website helps you:</p>

						<ul>
							<li>Provide students/guests with an high quality, interactive, informative, and easy to navigate student/guest online forum.</li>

							<li>Increasing student engagement and accessibility of information to Ivy Tech students, potential students, and alumni.</li>

							<li>Improving lines of communication and information throughout Ivy Tech Community College.</li>

							<li>Provide a well-rounded more rewarding Ivy Tech Community College experience leading into improved graduation rates and career opportunities for students.</li>
							
							<li>To create a user or login. Click the person icon in the top right corner.</li>
							
							<li>To view or create a topic. Click a link below.</li>
						</ul>

					</div>
				</div>
			</section>
			<!-- Degrees Section ------------------------------------------------------------------------------------------------>
			<section id="degrees" class="no-padding container-fluid">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 text-center">
							<h2 class="section-heading">Degrees</h2>
							<hr>
						</div>
					</div>
				</div>

				<!-- Business Administration Section ------------------------------------------------------------------------------------------------>
				<div class="container-fluid">
					<div class="row no-gutter">

						<div class="col-lg-4 col-md-6 text-center">
							<a href="business.php">
								<div class="box">
									<i class="fa fa-building-o fa-5x text-primary"></i>
									<h3>Business Administration</h3>
									<p class="text-muted">The principles taught through Business Administration at Ivy Tech are threaded in all industries including non-profit ...</p>
								</div>
							</a>
						</div>

						<!-- Computer Science Section ------------------------------------------------------------------------------------------------>
						<div class="col-lg-4 col-md-6 text-center">
							<a href="computer.php">
								<div class="box">
									<i class="fa fa-desktop fa-5x text-primary"></i>
									<h3>Computer Science</h3>
									<p class="text-muted">Computer Science is an exciting field that explores the limits of what computers can accomplish. It also spans many ...</p>
								</div>
							</a>
						</div>

						<!-- Criminal Justice Section ------------------------------------------------------------------------------------------------>
						<div class="col-lg-4 col-md-6 text-center">
							<a href="criminal.php">
								<div class="box">
									<i class="fa fa-user-secret fa-5x fa text-primary"></i>
									<h3>Criminal Justice</h3>
									<p class="text-muted">All of the Criminal Justice instructors at Ivy Tech have been employed or are currently employed in the criminal justice ...</p>
								</div>
							</a>
						</div>

						<!-- Education Section ------------------------------------------------------------------------------------------------>
						<div class="col-lg-4 col-md-6 text-center">
							<a href="education.php">
								<div class="box">
									<i class="fa fa-graduation-cap fa-5x fa text-primary"></i>
									<h3>Education</h3>
									<p class="text-muted">The Education program at Ivy Tech gives future teachers the perfect opportunity to prepare for their career in education ...</p>
								</div>
							</a>
						</div>

						<!-- Engineering Technology Section ------------------------------------------------------------------------------------------------>
						<div class="col-lg-4 col-md-6 text-center">
							<a href="engineering.php">
								<div class="box">
									<i class="fa fa-cogs fa-5x text-primary"></i>
									<h3>Engineering Technology</h3>
									<p class="text-muted">Students in the Engineering Technology programs will become skilled technicians who will work with engineers and other ...</p>
								</div>
							</a>
						</div>

						<!-- Nursing Section ------------------------------------------------------------------------------------------------>
						<div class="col-lg-4 col-md-6 text-center">
							<a href="nursing.php">
								<div class="box">
									<i class="fa fa-heartbeat fa-5x text-primary"></i>
									<h3>Nursing</h3>
									<p class="text-muted">Nursing students have opportunities to care for real patients in a variety of clinical settings, and skills are also ...</p>
								</div>
							</a>
						</div>

					</div>
				</div>
			</section>
		</section>
		<!-- Footer ------------------------------------------------------------------------------------------------>
		<?php require 'footer.php'; ?>
    	<!-- Scripts ------------------------------------------------------------------------------------------------>
		<script src="js/jquery-2.1.4.min.js"></script>
		<script src="js/jquery-ui.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>
