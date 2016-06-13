<?php
require_once '@core/init.php';
DB::getInstance();
Session::set('page', 'criminal');

/* Check if input exists ---------------------------------------------------------------------------------------------------------*/
if(Input::exists()) 
{
	/* Create Topic Redirect ---------------------------------------------------------------------------------------------------------*/
    if(Input::post('create-topic')) 
	{
        if(Token::check(Input::get('token'))) 
		{
            Redirect::to('topic.php?create-topic');
        }
    }
	/* Create Topic Redirect ---------------------------------------------------------------------------------------------------------*/
}
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
			<!-- Criminal Justice Section ------------------------------------------------------------------------------------------------>
			<section id="criminal" class="container-fluid" style="padding: 50px 0px 50px 0px">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 text-center">
							<i class="fa fa-user-secret fa-5x fa text-primary"></i>
							<h2 class="section-heading">Criminal Justice</h2>
							<hr class="primary">
						</div>
					</div>
				</div>
				<div class="container">
					<div class="col-lg-12">
						<p>All of the Criminal Justice instructors at Ivy Tech have been employed or are currently employed in the criminal justice system.  Having faculty with real-world experience who are professionals in their field, you will be exposed to a wide variety of experiences including crime labs, court rooms, correctional facilities and jails.</p>

						<p>While in the Criminal Justice program students can choose to focus on several different areas through electives.  These electives include corrections, forensics, law enforcement and youth services.</p>

						<ul>
						<li>Corrections – Corrections officers monitor people being detained for trial and those who have been imprisoned.</li>

						<li>Forensics – Forensics officials assist in the investigation process, assess crime scenes and evidentiary material, and testify in court. This area of study places emphasis on developing the skills needed to supplement traditional law enforcement roles with an interest in forensics.</li>

						<li>Law Enforcement - Law enforcement officials provide assistance, respond to emergency calls, investigate crime scenes, and testify in court. This area of study places emphasis on developing the skills needed to be a police officer, including law, community relations, procedural law and criminal investigations.</li>

						<li>Youth Services – Youth services professionals work to prevent youth offenders from committing future crimes by helping the youth and their families discover the causes of their illegal behavior.</li>
						</ul>

						<h3>Our Graduates</h3>

						<p>Graduates of the Criminal Justice program can move right in to a variety of positions in the field including law enforcement, bailiffs, corrections officers, casino security, airports, court officials, and even school security.  Graduates of the AS degree can also transfer to one of our four-year partners.</p>
					</div>
				</div>
			</section>
			
			<!-- Discussions Section ------------------------------------------------------------------------------------------------>
			<section id="forums" class="container-fluid" style="padding: 50px 0px 50px 0px;">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12">
							<table class="table">
								<thead class="top-label">
									<tr>
										<th colspan="3">Criminal Justice Discussions</th>
										<th>Views</th>
										<th>Replies</th>
									</tr>
								</thead>
								<tbody class="body">
									<?php 
										// Querying the DB to get Criminal Justice Discussions
										if($result = DB::getInstance()->get('topics', array('page', '=', Session::get('page'))))
										{
											// Looping through the result sets and printing them in a tbale
											foreach($result->results() as $row)
											{
												echo'
												<tr>
													<td><span class="fa-stack fa-1x float-left"><i class="fa fa-square fa-stack-2x text-primary"></i><i class="fa fa-comments fa-stack-1x fa-inverse"></i></span></td>
													<td colspan="2"><a href="topic.php?id=' .$row->id .'">' .$row->title .'</a><p class="text-muted">' .$row->username .'</p></td>
													<td>' .$row->views .'</td>';
													
												if($result = DB::getInstance()->get('posts', array('topic_id', '=', $row->id)))
												{
													echo '<td>' .$result->count() .'</td>';
												}
												
												echo'
												</tr>';
											}
										}
									?>
								</tbody>
								<tfoot class="bottom-label">
									<tr>
										<td colspan="5"></td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</section>

<!-- Making sure user is logged in befor creating a topic -->			
<?php $user = new User(); if($user->isLoggedin()):?>
			<section id="create-topic" class="forums container-fluid">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <form name="topic_reply" class="forums-form" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="clearfix"></div>
                                    <div class="col-lg-12 text-center">
                                        <div class="success"></div>
                                        <input class="btn btn-xl" type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                                        <input class="btn btn-xl" type="submit" name="create-topic" value="Create Topic">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
			<?php endif;?>
		</section>
		<!-- Footer ------------------------------------------------------------------------------------------------>
		<?php require 'footer.php'; ?>
    	<!-- Scripts ------------------------------------------------------------------------------------------------>
		<script src="js/jquery-2.1.4.min.js"></script>
		<script src="js/jquery-ui.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>
