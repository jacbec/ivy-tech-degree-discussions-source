<?php
require_once '@core/init.php';
DB::getInstance();
Session::set('page', 'nursing');

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
			<!-- Nursing Section ------------------------------------------------------------------------------------------------>
			<section id="nursing" class="container-fluid" style="padding: 50px 0px 50px 0px">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 text-center">
							<i class="fa fa-heartbeat  fa-5x text-primary"></i>
							<h2 class="section-heading">Nursing</h2>
							<hr class="primary">
						</div>
					</div>
				</div>
				<div class="container">
					<div class="col-lg-12">
						<p>Nursing students have opportunities to care for real patients in a variety of clinical settings, and skills are also learned in simulation labs. The growing use of the simulations allows students to assume roles not available to students in a clinical setting.  This allows them to make critical choices and see the results of those choices. We utilize a variety of learning strategies in the classroom and clinical settings to appeal to every learning style.</p>

						<p>The Associate of Science in Nursing (ASN) can be completed in less than two years once admitted into the program.  This means students can graduate sooner and begin working if they choose. Our faculty care about their students, we offer smaller class sizes which means we have one of the highest passing rates on board exams in the region. Class size is 20 or fewer, and clinicals never have more than 10 students at a time. Our nurses are currently in high demand in throughout Indiana and we have been told that our graduates are constantly getting chosen over students from other schools.</p>

						<p>The Nursing program is a selective admission program. When you apply to the College, you will be accepted into Healthcare Specialist with a concentration in Nursing while you complete the prerequisite requirements. The Nursing program accepts a limited number of students each year, and there is a separate application process. Contact your campus of interest below for more details.</p>

						<h3>Our Graduates</h3>

						<p>Students who complete the program will be able to obtain entry level nursing positions almost anywhere they desire, or they can continue their education and transfer to a four-year university where they can earn their bachelor’s degree. Nursing graduates are able to be employed in hospitals, long-term care facilities, physician offices, schools and health departments.</p>
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
										<th colspan="3">Nursing Discussions</th>
										<th>Views</th>
										<th>Replies</th>
									</tr>
								</thead>
								<tbody class="body">
									<?php
										// Querying the DB to get Nursing Discussions
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
