<?php

class Hash 
{
	// A method to make a sha256 hash with a string and a salt
    public static function make($str, $salt = '') 
	{
        return hash('sha256', $str .$salt);
    }

	// A method to create the salt
    public static function salt($length) 
	{
        return mcrypt_create_iv($length);
    }

	// A mehtod to make an unique hash
    public static function unique() 
	{
        return self::make(uniqid());
    }
}

?>
