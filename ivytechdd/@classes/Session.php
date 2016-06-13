<?php

class Session 
{
	// A method to check if a session exists
    public static function exists($name) 
	{
        return (isset($_SESSION[$name])) ? true : false;
    }

	// A method to set a session
    public static function set($name, $value) 
	{
        return $_SESSION[$name] = $value;
    }

	// A method to get a session
    public static function get($name) 
	{
        return $_SESSION[$name];
    }

	// A method to delete a session
    public static function delete($name) 
	{
        if(self::exists($name))
		{
            unset($_SESSION[$name]);
        }
    }

	// A method to flash a message through a session
    public static function flash($name, $str = '') 
	{
        if(self::exists($name)) 
		{
            $session = self::get($name);
            self::delete($name);
            return $session;
        } 
		else 
		{
            self::set($name, $str);
        }
    }
}

?>
