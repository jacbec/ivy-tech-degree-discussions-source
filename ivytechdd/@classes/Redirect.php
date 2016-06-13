<?php

class Redirect 
{
	// A method to call the redirct function to a 404 error or any location on the internet
    public static function to($location = null)
	{
        if($location) 
		{
            if(is_numeric($location)) 
			{
                switch($location) 
				{
                    case 404:
                        header('HTTP/1.1 404 Not Found');
                        include '@includes/errors/404.php';
                        break;
                }
            }
            header('Location: ' .$location);
            exit();
        }
    }
}

?>
