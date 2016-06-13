<?php

class Cookie 
{
	// Method to check if a cookie exists
    public static function exists($name) 
	{
		return(isset($_COOKIE[$name])) ? true : false;
	}
	
	// Method to get a cookie
	public static function get($name) 
	{
		return $_COOKIE[$name];
	}
	
	// Method to put/set a cookie
	public static function put($name, $value, $expiry) 
	{
		if(setcookie($name, $value, time() + $expiry, '/')) 
		{
			return true;
		}
		return false;
	}

	// Method to delete a cookie
	public static function delete($name) 
	{
		self::put($name, '', time() - 1);
	}
}

?>
