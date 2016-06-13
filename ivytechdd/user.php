<?php
require_once '@core/init.php';
DB::getInstance();

/* Check if input exists ---------------------------------------------------------------------------------------------------------*/
if(Input::exists()) 
{
	/* Create user ---------------------------------------------------------------------------------------------------------*/
    if(Input::post('create-user')) 
	{
		// Check if token matches
        if(Token::check(Input::get('token'))) 
		{
			// Check validation of input
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'username' => array(
                    'name' => 'Username',
                    'required' => true,
                    'min' => 4,
                    'max' => 32,
                    'preg' => 'username',
                    'unique' => 'users'
                ),
                'first_name' => array(
                    'name' => 'First Name',
                    'required' => true,
                    'max' => 45
                ),
                'last_name' => array(
                    'name' => 'Last Name',
                    'required' => true,
                    'max' => 45
                ),
                'email' => array(
                    'name' => 'Email',
                    'required' => true,
                    'max' => 255,
                    'preg' => 'email',
					'unique' => 'users'
                ),
                'verify_email' => array(
                    'name' => 'Verify Email',
                    'required' => true,
                    'matches' => 'email'
                ),
                'password' => array(
                    'name' => 'Password',
                    'required' => true,
                    'min' => 6
                ),
                'verify_password' => array(
                    'name' => 'Verify Password',
                    'required' => true,
                    'matches' => 'password'
                )
            ));

			// Check if validation passed
            if($validation->passed()) 
			{
                $user = new User();
                $salt = Hash::salt(32);
                try 
				{
                    $user->create(array(
                        'username' => Input::get('username'),
                        'first_name' => Input::get('first_name'),
                        'last_name' => Input::get('last_name'),
                        'email' => Input::get('email'),
                        'password' => Hash::make(Input::get('password'), $salt),
                        'salt' => $salt,
                        'group' => 1,
                        'joined' => Config::get('date/today')
                    ));
                } 
				catch(Exception $e) 
				{
                    die($e->getMessage());
                }
				// Echo message and redirect if all good
                Session::flash('success', 'Your user was successfully created. Please login.');
                Redirect::to('user.php?login');
            } 
			else 
			{
				// Echo errors and redirect to show errors
                 Session::flash('failed', $validation->errors());
                 Redirect::to('user.php?create-user');
            }
        }
    }
	/* Create user ---------------------------------------------------------------------------------------------------------*/

	/* Login ---------------------------------------------------------------------------------------------------------*/
    if(Input::post('login')) 
	{
		// Check if token matches
        if(Token::check(Input::get('token'))) 
		{
			// Check validation of input
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'username' => array(
                    'name' => 'Username',
                    'required' => true
                ),
                'password' => array(
                    'name' => 'Password',
                    'required' => true
                )
            ));

			// Check if validation passed
            if($validation->passed()) 
			{
                $user = new User();

                $remember = (Input::get('selected') === 'remember') ? true : false;
                $login = $user->login(Input::get('username'), Input::get('password'), $remember);

                if($login) 
				{
					// Redirect if all good
                    Redirect::to('index.php');
                } 
				else 
				{
					// Echo errors and redirect to show errors
                    Session::flash('failed', 'Your username or password was incorrect!');
                    Redirect::to('user.php?login');
                }
            } 
			else 
			{
				// Echo errors and redirect to show errors
                 Session::flash('failed', $validation->errors());
                 Redirect::to('user.php?login');
            }
        }
    }
	/* Login ---------------------------------------------------------------------------------------------------------*/

	/* Change Username ---------------------------------------------------------------------------------------------------------*/
    if(Input::post('change-username')) 
	{
		// Check if token matches
        if(Token::check(Input::get('token'))) 
		{
			// Check validation of input
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'username' => array(
                    'name' => 'Username',
                    'required' => true,
                    'min' => 4,
                    'max' => 32,
                    'preg' => 'username',
                    'unique' => 'users'
                )
            ));
			
			// Check if validation passed
            if($validation->passed()) 
			{
                $user = new User();
                try 
				{
                    $user->update(array(
                        'username' => Input::get('username')						
                    ));
					
					// Echo message and redirect if all good
                    Session::flash('success', 'Username Changed Successfully');
					Redirect::to('user.php?account');
                } 
				catch(Exception $e) 
				{
                    die($e->getMessage());
                }
            } 
			else 
			{
				// Echo errors and redirect to show errors
				Session::flash('failed', $validation->errors());
                Redirect::to('user.php?account');
            }
        }
    }
	/* Change Username ---------------------------------------------------------------------------------------------------------*/

	/* Change Email ---------------------------------------------------------------------------------------------------------*/
    if(Input::post('change-email')) 
	{
		// Check if token matches
        if(Token::check(Input::get('token'))) 
		{
			// Check validation of input
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'email' => array(
                    'name' => 'Email',
                    'required' => true,
                    'max' => 255,
                    'preg' => 'email',
					'unique' => 'users'
                ),
                'verify_email' => array(
                    'name' => 'Verify Email',
                    'required' => true,
                    'matches' => 'email'
                )
            ));

			// Check if validation passed
            if($validation->passed()) 
			{
                $user = new User();
                try 
				{
                    $user->update(array(
                        'email' => Input::get('email')
                    ));

					// Echo message and redirect if all good
                    Session::flash('success', 'Email Changed Successfully');
					Redirect::to('user.php?account');
                } 
				catch(Exception $e) 
				{
                    die($e->getMessage());
                }
            } 
			else 
			{
				// Echo errors and redirect to show errors
                Session::flash('failed', $validation->errors());
                Redirect::to('user.php?account');
            }
        }
    }
	/* Change Email ---------------------------------------------------------------------------------------------------------*/

	/* Change Password ---------------------------------------------------------------------------------------------------------*/
    if(Input::post('change-password')) 
	{
		// Check if token matches
        if(Token::check(Input::get('token'))) 
		{
			// Check validation of input
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'password' => array(
                    'name' => 'New Password',
                    'required' => true,
                    'min' => 6
                ),
                'verify_password' => array(
                    'name' => 'Verify New Password',
                    'required' => true,
                    'matches' => 'password'
                )
            ));

			// Check if validation passed
            if($validation->passed()) 
			{
                $user = new User();

				$salt = Hash::salt(32);
				try 
				{
					$user->update(array(
						'password' => Hash::make(Input::get('password'), $salt),
						'salt' => $salt
					));

					// Echo message and redirect if all good
					Session::flash('success', 'Password Changed Successfully');
					Redirect::to('user.php?account');
				} 
				catch(Exception $e) 
				{
					die($e->getMessage());
				}
            } 
			else 
			{
				// Echo errors and redirect to show errors
                Session::flash('failed', $validation->errors());
                Redirect::to('user.php?account');
            }
        }
    }
	/* Change Password ---------------------------------------------------------------------------------------------------------*/

	/* Notifacation Delete ---------------------------------------------------------------------------------------------------------*/
	if(Input::post('delete')) 
	{
		if($result = DB::getInstance()->query('DELETE FROM notifacations WHERE id = ?', array(Input::get('delete-id'))))
		{
			// Echo message and redirect if all good
			Session::flash('success', 'Notifacation was deleted');
			Redirect::to('user.php?notifacations');
		}
		else 
		{
			// Echo errors and redirect to show errors
			Session::flash('failed', 'Notifacation was not deleted');
			Redirect::to('user.php?notifacations');
		}
	}
	/* Notifacation Delete ---------------------------------------------------------------------------------------------------------*/
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
		
<?php if(isset($_GET['create-user'])): ?>
			<!-- Create User ------------------------------------------------------------------------------------------------>
            <section id="create-user" class="forums container-fluid" style="padding: 50px 0px 50px 0px;">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h2 class="section-heading">Create Profile</h2>
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
                            <form name="create_user" class="forums-form" method="post" enctype="multipart/form-data">
                                <div class="row">

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Username *" name="username" >
                                            <p class="help-block text-danger"></p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6" style="display: inline-block">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="First Name *" name="first_name" >
                                            <p class="help-block text-danger"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6" style="display: inline-block">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Last Name *" name="last_name" >
                                            <p class="help-block text-danger"></p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6" style="display: inline-block">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Email *" name="email" >
                                            <p class="help-block text-danger"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6" style="display: inline-block">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Verify Email *" name="verify_email" >
                                            <p class="help-block text-danger"></p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6" style="display: inline-block">
                                        <div class="form-group">
                                            <input type="password" class="form-control" placeholder="Password *" name="password" >
                                            <p class="help-block text-danger"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6" style="display: inline-block">
                                        <div class="form-group">
                                            <input type="password" class="form-control" placeholder="Verify Password *" name="verify_password" >
                                            <p class="help-block text-danger"></p>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>

                                    <div class="col-lg-12 text-center">
                                        <div class="success"></div>
                                        <input class="btn btn-xl" type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                                        <input class="btn btn-xl" type="submit" name="create-user" value="Create User">
                                        <input class="btn btn-xl" type="reset" value="Reset Fields">
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

<?php elseif(isset($_GET['login'])): ?>
			<!-- Log In ------------------------------------------------------------------------------------------------>
            <section id="login" class="forums container-fluid" style="padding: 50px 0px 50px 0px;">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h2 class="section-heading">Login</h2>
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
                            <form name="login" class="forums-form" method="post" enctype="multipart/form-data">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Username *" name="username" >
                                            <p class="help-block text-danger"></p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="password" class="form-control" placeholder="Password *" name="password" >
                                            <p class="help-block text-danger"></p>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>

                                    <div class="col-lg-12 text-center">
                                        <div class="success"></div>
                                        <input class="btn btn-xl" type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                                        <input class="btn btn-xl" type="submit" name="login" value="Login">
                                        <select class="btn btn-xl" name="selected">
                                            <option value="">Don't Remember Me</option>
                                            <option name="remember" value="remember">Remember Me</option>
                                        </select>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

<?php elseif(isset($_GET['notifacations'])): ?>
			<!-- Notifacations ------------------------------------------------------------------------------------------------>
			<section id="notifacations" class="container-fluid" style="padding: 50px 0px 50px 0px;">
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
                            <hr class="primary">
                        </div>
                    </div>
                </div>
				
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12">
							<table class="table">
								<thead class="top-label">
									<tr>
										<th colspan="5">Notifactions</th>
									</tr>
								</thead>
								<tbody class="body">
									<?php 
										// Create a user object
										$user = new User();

										// Query the DB
										if($result = DB::getInstance()->get('notifacations', array('user_id', '=', $user->data()->id)))
										{
											// Looping through the result sets and printing them in a tbale
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
													<tr>
														<td><span class="fa-stack fa-1x float-left"><i class="fa fa-square fa-stack-2x text-primary"></i><i class="fa fa-comment fa-stack-1x fa-inverse"></i></span></td>
														<td colspan="3"><a href="topic.php?id=' .$row->topic_id .'">' .$row->username .' commented on your post!</a><p class="text-muted">' .$row->title .'</td>
														<td>
															<form name="delete-notifacation" class="forums-form" method="post" enctype="multipart/form-data">
																<input class="btn btn-xl" type="submit" name="delete" value="DELETE">
																<input class="btn btn-xl" type="hidden" name="delete-id" value="' .$row->id .'">
															</form>
														</td>
														
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
<?php else: ?>
	<?php $user = new User(); if($user->isLoggedin()): ?>
			<!-- User Profile ------------------------------------------------------------------------------------------------>
            <section id="edit_user" class="forums container-fluid" style="padding: 50px 0px 50px 0px;">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h2 class="section-heading">Change User Information</h2>
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
                            <form name="edit_user" class="forums-form" method="post" enctype="multipart/form-data">
                                <div class="row">
									
									<!-- Change Username ------------------------------------------------------------------------------------------------>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Change Username *" name="username" value="<?php echo escape($user->data()->username); ?>">
                                            <p class="help-block text-danger"></p>
                                        </div>
                                    </div>
									<div class="col-lg-12 text-center">
                                        <div class="success"></div>
                                        <input class="btn btn-xl" type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                                        <input class="btn btn-xl" type="submit" name="change-username" value="Change Username">
                                    </div>

									<!-- Change Email ------------------------------------------------------------------------------------------------>
                                    <div class="col-lg-6" style="display: inline-block">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Change Email *" name="email" value="<?php echo escape($user->data()->email); ?>">
                                            <p class="help-block text-danger"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6" style="display: inline-block">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Verify Changed Email *" name="verify_email" value="<?php echo escape($user->data()->email); ?>">
                                            <p class="help-block text-danger"></p>
                                        </div>
                                    </div>
									<div class="col-lg-12 text-center">
                                        <div class="success"></div>
                                        <input class="btn btn-xl" type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                                        <input class="btn btn-xl" type="submit" name="change-email" value="Change Email">
                                    </div>

									<!-- Change Password ------------------------------------------------------------------------------------------------>
                                    <div class="col-lg-6" style="display: inline-block">
                                        <div class="form-group">
                                            <input type="password" class="form-control" placeholder="Change Password *" name="password" >
                                            <p class="help-block text-danger"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6" style="display: inline-block">
                                        <div class="form-group">
                                            <input type="password" class="form-control" placeholder="Verify Changed Password *" name="verify_password" >
                                            <p class="help-block text-danger"></p>
                                        </div>
                                    </div>
									 <div class="col-lg-12 text-center">
                                        <div class="success"></div>
                                        <input class="btn btn-xl" type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                                        <input class="btn btn-xl" type="submit" name="change-password" value="Change Password">
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
