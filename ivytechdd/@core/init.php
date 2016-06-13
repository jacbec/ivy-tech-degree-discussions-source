<?php
// Start the session
session_start();

// Global variables
$GLOBALS['config'] = array(
    'mysql' => array(
    'host' => 'your.domain.com',
    'user' => 'youruser',
    'pass' => 'yourpassword',
    'db' => 'yourdbname'
    ),
    'cookie' => array(
        'user' => 'hash',
        'expiry' => 604800
    ),
    'session' => array(
        'name' => 'user',
        'page' => 'page'
    ),
    'token' => array(
        'name' => 'token'
    ),
    'date' => array(
        'today' => date('F d\, Y')
    )
);

// A PHP method to include the PHP class files
spl_autoload_register(function($class) 
{
    require_once '@classes/' .$class .'.php';
});

require_once '@functions/sanitize.php';

// Checking if the user is logged in
if(isset($_GET['login'])) 
{
    $user = new User();
    if($user->isLoggedin()) 
	{
        $user->logout();
	    Redirect::to('user.php?login');
    }
}

// Checking if the user clicked log out
if(isset($_GET['logout'])) 
{
	$user = new User();
	$user->logout();
	Redirect::to('user.php?login');
}

// Checking if user asked to be remembered and if so log them in
if(Cookie::exists(Config::get('cookie/user')) && !Session::exists(Config::get('session/name')))
{
    $hash = Cookie::get(Config::get('cookie/user'));
    $hash_check = DB::getInstance()->get('users_session', array('hash', '=', $hash));

    if($hash_check->count()) 
	{
        $user = new User($hash_check->first()->user_id);
        $user->login();
    }
}

?>
