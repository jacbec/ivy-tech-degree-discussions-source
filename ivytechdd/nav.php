<!-- Navigation ------------------------------------------------------------------------------------------------>
<nav class="navbar navbar-default navbar-static-top">

	<!-- Main Nav ------------------------------------------------------------------------------------------------>
	<ul class="nav navbar-left-links navbar-header">
		<li class="dropdown"><a href="index.php"><i class="fa fa-home fa-1x"></i></a>
			<ul class="dropdown-menu">
				<li>
					<div>Home</div>
				</li>
			</ul>
		</li>
		
		<li class="dropdown"><a href="business.php"><i class="fa fa-building-o fa-1x"></i></a>
			<ul class="dropdown-menu">
				<li>
					<div>Business Administration</div>
				</li>
			</ul>
		</li>

		<li class="dropdown"><a href="computer.php"><i class="fa fa-desktop fa-1x"></i></a>
			<ul class="dropdown-menu">
				<li>
					<div>Computer Science</div>
				</li>
			</ul>
		</li>
		
		<li class="dropdown"><a href="criminal.php"><i class="fa fa-user-secret fa-1x"></i></a>
			<ul class="dropdown-menu">
				<li>
					<div>Criminal Justice</div>
				</li>
			</ul>
		</li>
		
		<li class="dropdown"><a href="education.php"><i class="fa fa-graduation-cap fa-1x"></i></a>
			<ul class="dropdown-menu">
				<li>
					<div>Education</div>
				</li>
			</ul>
		</li>
		
		<li class="dropdown"><a href="engineering.php"><i class="fa fa-cogs fa-1x"></i></a>
			<ul class="dropdown-menu">
				<li>
					<div>Engineering Technology</div>
				</li>
			</ul>
		</li>
		
		<li class="dropdown"><a href="nursing.php"><i class="fa fa-heartbeat fa-1x"></i></a>
			<ul class="dropdown-menu">
				<li>
					<div>Nursing</div>
				</li>
			</ul>
		</li>
	</ul>
	<!-- Main Nav ------------------------------------------------------------------------------------------------>
	
	<!-- Side Nav ------------------------------------------------------------------------------------------------>
	<ul class="nav navbar-right-links navbar-right">
<?php $user = new User(); if($user->isLoggedin()): ?>
		<!-- Notifacations ------------------------------------------------------------------------------------------------>
		<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i></a>
			<ul class="dropdown-menu dropdown-alerts">
			
				<div class="divider"></div>
				
				<?php
					// Create a user object
					$user = new User();
					
					// Query the DB ordering it by id in descending limiting it by 10
					if($result = DB::getInstance()->query('SELECT * FROM notifacations WHERE user_id = ? ORDER BY id DESC LIMIT 10', array($user->data()->id)))
					{
						// Loop through the result sets
						foreach($result->results() as $row)
						{
							// If the op posted then continue else send notifacation
							if($row->id == $user->data()->id)
							{
								continue;
							}
							else
							{							
								echo'
									<li><a href="topic.php?id=' .$row->topic_id .'">
										<div><span class="small">' .$row->username .' commented on your topic!</span></div>
									</a></li>

									<div class="divider"></div>';
							}
						}
					}
				?>

				<li><a class="text-center" href="user.php?notifacations"><strong>See All Notifactions</strong> <i class="fa fa-angle-right"></i></a></li>
				
			</ul>
		</li>
		<!-- Notifacations ------------------------------------------------------------------------------------------------>
<?php endif; ?>

		<!-- Users ------------------------------------------------------------------------------------------------>
		<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i></a>
			<ul class="dropdown-menu dropdown-user">
<?php $user = new User(); if($user->isLoggedin()): ?>
				<li><a href="user.php?account"><i class="fa fa-user fa-fw"></i> User Account</a></li>

				<div class="divider"></div>

				<li><a href="?logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
<?php else: ?>
				<li><a href="user.php?create-user"><i class="fa fa-user fa-fw"></i> Create User</a></li>

				<div class="divider"></div>

				<li><a href="user.php?login"><i class="fa fa-sign-in fa-fw"></i> Login</a></li>
<?php endif; ?>
		
			</ul>
		</li>
		<!-- Users ------------------------------------------------------------------------------------------------>
	</ul>
	<!-- Side Nav ------------------------------------------------------------------------------------------------>
</nav>
