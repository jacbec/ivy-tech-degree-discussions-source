<?php

class Input 
{
	// A method to check if input exists(post or get)
    public static function exists($type = 'post') 
	{
        switch($type) 
		{
            case 'post':
                return (!empty($_POST)) ? true : false;
                break;
            case 'get':
                return (!empty($_GET)) ? true : false;
                break;
            default:
                return false;
                break;
        }
    }

	// A method to return a $_POST call
    public static function post($item) 
	{
        if(isset($_POST[$item]))
		{
            return true;
        }
        return false;
    }

	// A method to return a $_POST or $_GET item
    public static function get($item) 
	{
        if(isset($_POST[$item])) 
		{
            return $_POST[$item];
        } 
		else if(isset($_GET[$item])) 
		{
            return $_GET[$item];
        }
        return '';
    }
}

?>
