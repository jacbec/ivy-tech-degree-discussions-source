<?php

class User 
{
	// Setting private variables to be used throughout the User class
    private $_db,
            $_data,
            $_session_name,
            $_cookie_name,
            $_is_logged_in;

	// A method that connects to a DB and checks if the user is logged in
	// Also checks if the user wanted to be remembered and if so logs them in
    public function __construct($user = null) 
	{
        $this->_db = DB::getInstance();

        $this->_session_name = Config::get('session/name');
        $this->_cookie_name = Config::get('cookie/user');

        if(!$user) 
		{
            if(Session::exists($this->_session_name)) 
			{
                $user = Session::get($this->_session_name);

                if($this->find($user)) 
				{
                    $this->_is_logged_in = true;
                } 
				else 
				{
					$this->_is_logged_in = false;
                }
            }
        } 
		else 
		{
            $this->find($user);
        }
    }

	// A method to create a user
    public function create($fields = array()) 
	{
        if(!$this->_db->insert('users', $fields)) 
		{
            throw new Exception('There was an error creating the user');
        }
    }

	// A method to log a user in
	// Searches the DB checking if the username matches the re hashed password 
	//if so user is logged in else user is not
    public function login($username = null, $password = null, $remember = false) 
	{
        if(!$username && !$password && $this->exists()) 
		{
            Session::set($this->_session_name, $this->data()->id);
        }
		else 
		{
            $user = $this->find($username);

            if($user) 
			{
                if($this->data()->password === Hash::make($password, $this->data()->salt)) 
				{
                    Session::set($this->_session_name, $this->data()->id);

                    if($remember) 
					{
                        $hash = Hash::unique();
                        $hash_check = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));

                        if(!$hash_check->count()) 
						{
                            $this->_db->insert('users_session', array(
                                'user_id' => $this->data()->id,
                                'hash' => $hash
                            ));
                        } 
						else 
						{
                            $hash = $hash_check->first()->hash;
                        }
                        Cookie::put($this->_cookie_name, $hash, Config::get('cookie/expiry'));
                    }
                    return true;
                }
            }
        }
        return false;
    }

	// A method that logs a user out deleting its session and cookie
    public function logout() 
	{
        $this->_db->delete('users_session', array('user_id', '=', $this->data()->id));

        Session::delete($this->_session_name);
        Cookie::delete($this->_cookie_name);
    }

	// A method to update a user information
    public function update($fields = array(), $id = null) 
	{
        if(!$id && $this->isLoggedin()) 
		{
            $id = $this->data()->id;
        }

        if(!$this->_db->update('users', $id, $fields)) 
		{
            throw new Exception('There was an error updating the profile');
        }
    }

    public function delete() {

    }

	// A method to find a user by its id or username
    public function find($user = null) 
	{
        if($user) 
		{
            $field = (is_numeric($user)) ? 'id' : 'username';
            $data = $this->_db->get('users', array($field, '=', $user));

            if($data->count()) 
			{
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

	// A method to check if the data exists
    public function exists() 
	{
        return (!empty($this->_data)) ? true : false;
    }

	// A method to retuen a data set
    public function data() 
	{
        return $this->_data;
    }

	// A mthed to see if user is logged in
    public function isLoggedin() 
	{
        return $this->_is_logged_in;
    }
}
?>
