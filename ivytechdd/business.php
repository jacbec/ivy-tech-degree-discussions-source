<?php
require_once '@core/init.php';
DB::getInstance();
Session::set('page', 'business');

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
			<!-- Business Administration Section ------------------------------------------------------------------------------------------------>
			<section id="business" class="container-fluid " style="padding: 50px 0px 50px 0px">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 text-center">
							<i class="fa fa-building-o fa-5x text-primary"></i>
							<h2 class="section-heading">Business Administration</h2>
							<hr class="primary">
						</div>
					</div>
				</div>
				<div class="container">
					<div class="col-lg-12">
						<p>The principles taught through Business Administration at Ivy Tech are threaded in all industries including non-profit business and education.  Students will be creating marketing plans, budgets, building personal websites, simulations, case-studies and creating community connections.  The Business Administration program also partners with many local businesses to give students the experience and exposure in the business world that they will need to be successful.</p>

						<h3>Our Graduates</h3>

						<p>Graduates of the Business Administration program are able to work in a wide variety of positions in a wide variety of industries.  Currently we have graduates working in human resources, marketing, accounting and sales as supervisors, team leads and consultants.  Graduates of our Associate of Science (AS) degree can seamlessly transfer to a four-year institution through our T-SAP program with junior status.</p>
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
										<th colspan="2">Business Administration Discussions</th>
										<th>Views</th>
										<th>Replies</th>
									</tr>
								</thead>
								<tbody class="body">
									<?php 	
										// Querying the DB to get Business Administration Discussions
										if($result = DB::getInstance()->get('topics', array('page', '=', Session::get('page'))))
										{
											// Looping through the result sets and printing them in a tbale
											foreach($result->results() as $row)
											{
												echo'
												<tr>
													<td><span class="fa-stack fa-1x float-left"><i class="fa fa-square fa-stack-2x text-primary"></i><i class="fa fa-comments fa-stack-1x fa-inverse"></i></span></td>
													<td colspan=""><a href="topic.php?id=' .$row->id .'">' .$row->title .'</a><p class="text-muted">' .$row->username .'</p></td>
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
										<td colspan="4"></td>
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
