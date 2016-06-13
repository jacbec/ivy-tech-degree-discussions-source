<?php
require_once '@core/init.php';
DB::getInstance();

/* Check if input exists ---------------------------------------------------------------------------------------------------------*/						
if(Input::exists()) 
{
	/* Create Topic ---------------------------------------------------------------------------------------------------------*/
    if(Input::post('create-topic')) 
	{
		// Check if token matches and has a session page
        if(Token::check(Input::get('token')) && Session::get('page') !== '') 
		{
			// Check validation of input
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'title' => array(
                    'name' => 'Topic Title',
                    'required' => true
                ),
                'body' => array(
                    'name' => 'Topic Body',
                    'required' => true
                )
            ));
			
			// Check if validation passed
            if($validation->passed()) 
			{
				// Query DB if validation passed
				$user = new User();
				if($result = DB::getInstance()->insert('topics', array(
                        'user_id' => $user->data()->id,
                        'username' => $user->data()->username,
                        'page' => Session::get('page'),
                        'title' => escape(Input::get('title')),
                        'body' => escape(Input::get('body')),
						'views' => 0,
                        'is_locked' => 0,
                        'created_date' => Config::get('date/today')
					)));					
				{
					// Redirect if all good
					Redirect::to(Session::get('page') .'.php');
				}
            } 
			else 
			{
				// Echo errors and redirect to show errors
                Session::flash('failed', $validation->errors());
                Redirect::to('topic.php?create-topic');
            }
        }
    }
	/* Create Topic ---------------------------------------------------------------------------------------------------------*/
	
	/* Topic Reply ---------------------------------------------------------------------------------------------------------*/
    if(Input::post('topic-reply')) 
	{
		// Check if token matches and has a session page
        if(Token::check(Input::get('token')) && Session::get('page') !== '') 
		{
			// Check validation of input
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'body' => array(
                    'name' => 'Reply Body',
                    'required' => true
                )
            ));

			// Check if validation passed
            if($validation->passed()) 
			{
				// Query DB if validation passed
				$user = new User();
				if($results = DB::getInstance()->get('topics', array('id', '=', $_GET['id']))) 
				{
					foreach($results->results() as $row)
					{
						if($result = DB::getInstance()->insert('notifacations', array(
							'topic_id' => $_GET['id'],
							'user_id' => $row->user_id,
							'username' => $user->data()->username,
							'title' => $row->title,
							'page' => Session::get('page'),
							'created_date' => Config::get('date/today')
							)));
						{
								
						}
					}
				}
				// Query DB if validation passed
				if($result = DB::getInstance()->insert('posts', array(
						'topic_id' => $_GET['id'],
                        'user_id' => $user->data()->id,
                        'username' => $user->data()->username,
                        'page' => Session::get('page'),
                        'body' => Input::get('body'),
                        'is_locked' => 0,
                        'created_date' => Config::get('date/today')
					)));
				{
					// Redirect if all good
					Redirect::to('topic.php?id=' .$_GET['id']);
				}
            } 
			else 
			{
				// Echo errors and redirect to show errors
                 Session::flash('failed', $validation->errors());
                 Redirect::to('topic.php?id=' .$_GET['id']);
            }
		}
    }
	/* Topic Reply ---------------------------------------------------------------------------------------------------------*/
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
		<style type="text/css">
			.table thead > tr > th:nth-child(3),
			.table tbody > tr > td:nth-child(3) {
				vertical-align: center;
				text-align: left;
				width: 250px;
				border-right: 0;
			}
		</style>

	</head>
	<body>
		<!-- Header Section ------------------------------------------------------------------------------------------------>
		<?php require 'nav.php'; ?>

		<!-- Content Section ------------------------------------------------------------------------------------------------>
		<section style="background-color: #FFF;">
<?php if(isset($_GET['create-topic'])): ?>
			<!-- Create Topic ------------------------------------------------------------------------------------------------>
            <section id="create-topic" class="forums container-fluid" style="padding: 50px 0px 175px 0px;">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h2 class="section-heading">Create Topic</h2>
                            <?php
                            if(Session::exists('failed')) {
                                echo '<div class="flash flash-forum">' . Session::flash('failed') .'</div>';
                            } else if(Session::exists('success')) {
                                echo '<div class="flash flash-forum">' .Session::flash('success') .'</div>';
                            }
                            ?>
                            <hr class="primary">
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <form name="create_topic" class="forums-form" method="post" enctype="multipart/form-data">
                                <div class="row">
								
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Topic Title *" name="title" >
                                            <p class="help-block text-danger"></p>
                                        </div>
                                    </div>
									
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <textarea class="form-control" placeholder="Topic Body *" name="body" ></textarea>
                                            <p class="help-block text-danger"></p>
                                        </div>
                                    </div>
									
                                    <div class="clearfix"></div>
									
                                    <div class="col-lg-12 text-center">
                                        <div class="success"></div>
                                        <input class="btn btn-xl" type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                                        <input class="btn btn-xl" type="submit" name="create-topic" value="Create Topic">
                                        <input class="btn btn-xl" type="reset" value="Reset Fields">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
<?php else: ?>
			<!-- Topic ------------------------------------------------------------------------------------------------>
			<section id="forums" class="container-fluid" style="padding: 50px 0px 50px 0px;">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12">
							<table class="table">
								<thead class="top-label">
									<?php
										// Query the DB to get the topic
										if($result = DB::getInstance()->get('topics', array('id', '=', $_GET['id'])))
										{
											// Looping through the result sets and printing them in a tbale
											foreach($result->results() as $row)
											{
												echo'
													<tr>
														<th colspan="5">' .$row->title .'</th>
													</tr>';
												
												// Check iff the user already viewed this page
												if(@Session::get('views') != $_GET['id'])
												{
													$views = $row->views + 1;
													
													// Query the DB to find the topic and store the total views
													if($update = DB::getInstance()->update('topics', $_GET['id'], array('views' => $views)))
													{
														Session::set('views', $_GET['id']);
													}
												}
											}
										}
									?>
								</thead>
								<tbody class="body">
									<?php 
										// Query the DB to get the topic
										if($result = DB::getInstance()->get('topics', array('id', '=', $_GET['id'])))
										{
											// Looping through the result sets and printing them in a tbale
											foreach($result->results() as $row)
											{ 
												// Sets the ops id
												$op = $row->user_id;
												echo'
													<tr>
														<td><span class="fa-stack fa-2x float-left"><i class="fa fa-square fa-stack-2x text-primary"></i><i class="fa fa-comments fa-stack-1x fa-inverse"></i></span></td>
														<td colspan="3"><p style="font-size: 16px;">' .$row->body .'</p></td>
														<td >USER: ' .$row->username .'<br>POSTED: '.$row->created_date .'</td>
													</tr>';
											}
										}
										
										// Query the DB to get the topic
										if($result = DB::getInstance()->get('posts', array('topic_id', '=', $_GET['id'])))
										{
											// Looping through the result sets and printing them in a tbale
											foreach($result->results() as $row)
											{
												// Check if poster is the op if so give same comment icon else give different comment icon
												if($row->user_id == $op)
												{
													echo'
													<tr>
														<td><span class="fa-stack fa-2x float-left"><i class="fa fa-square fa-stack-2x text-primary"></i><i class="fa fa-comments fa-stack-1x fa-inverse"></i></span></td>
														<td colspan="3"><p style="font-size: 16px;">' .$row->body .'</p></td>
														<td>USER: ' .$row->username .'<br>POSTED: '.$row->created_date .'</td>
													</tr>';
												}
												else
												{
													echo'
													<tr>
														<td><span class="fa-stack fa-2x float-left"><i class="fa fa-square fa-stack-2x text-primary"></i><i class="fa fa-comment fa-stack-1x fa-inverse"></i></span></td>
														<td colspan="3"><p style="font-size: 16px;">' .$row->body .'</p></td>
														<td>USER: ' .$row->username .'<br>REPLIED: '.$row->created_date .'</td>
													</tr>';
												}
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

<?php $user = new User(); if($user->isLoggedin()): ?>
			<!-- Reply ------------------------------------------------------------------------------------------------>
			<section id="reply-topic" class="forums container-fluid">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <?php
                            if(Session::exists('failed')) {
                                echo '<div class="flash flash-forum">' . Session::flash('failed') .'</div>';
                            } else if(Session::exists('success')) {
                                echo '<div class="flash flash-forum">' .Session::flash('success') .'</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <form name="topic_reply" class="forums-form" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    
									<div class="col-lg-12">
                                        <div class="form-group">
                                            <textarea class="form-control" placeholder="Reply Body *" name="body" ></textarea>
                                            <p class="help-block text-danger"></p>
                                        </div>
                                    </div>
									
                                    <div class="clearfix"></div>
									
                                    <div class="col-lg-12 text-center">
                                        <div class="success"></div>
                                        <input class="btn btn-xl" type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                                        <input class="btn btn-xl" type="submit" name="topic-reply" value="Reply">
                                    </div>
									
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
<?php endif; ?>
<?php endif; ?>
		</section>
		<!-- Footer ------------------------------------------------------------------------------------------------>
		<?php require 'footer.php'; ?>
    	<!-- Scripts ------------------------------------------------------------------------------------------------>
		<script src="js/jquery-2.1.4.min.js"></script>
		<script src="js/jquery-ui.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>
