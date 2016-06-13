<?php

class Validate 
{
	// Setting private variables to be used throughout the Validation class
    private $_passed = false,
            $_errors = "",
            $_db = null;

	// Method to set the DB connection
    public function __construct() 
	{
        $this->_db = DB::getInstance();
    }

	// Mehtod to check the input fields
	// This method can be confusing so will go through it
    public function check($source, $items = array()) 
	{
		// Looping through the arrays to get the rules
        foreach ($items as $item => $rules) 
		{
			// Setting the name of the rule
            $name1 = $rules['name'];
			
			// Looping through the rules to get their value
            foreach ($rules as $rule => $rule_value) 
			{
                $value = trim($source[$item]);

				// Checking if the rule is required
                if($rule === 'required' && empty($value)) 
				{
                    $this->addError("{$name1} is required!");
                } 
				else if(!empty($value)) 
				{
					// Switching through the rules and checking if they are valid
                    switch($rule) 
					{
						// Checking the min character value
                        case 'min':
                            if(strlen($value) < $rule_value) 
							{
                                $this->addError("{$name1} must be more than {$rule_value} characters!");
                            }
                            break;
						// Checking the max character value
                        case 'max':
                            if(strlen($value) > $rule_value) 
							{
                                $this->addError("{$name1} must be less than {$rule_value} characters!");
                            }
                            break;
						// Checking to see if it is a preg match
                        case 'preg':
                            if($rule_value === 'email') 
							{
                                if(!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i', $source[$rule_value])) 
								{
                          		        $this->addError("{$name1} is an invalid email address!");
                          	    } 
								else if($rule_value === 'username') 
								{
                                    if(!preg_match('/^[a-z\d-_]{2,20}$/i', $source[$rule_value])) 
									{
                                        $this->addError("{$name1} can only be (a-z, A-Z, 0-9, dashes(-), and underscores( _ )!");
                                    }
                                }
                            }
                            break;
						// Checking the field to see if matches the verify field
                        case 'matches':
                            if($rule_value === 'email') 
							{
                                $name2 = 'Email';
                            } 
							else if($rule_value === 'password') 
							{
                                $name2 = 'Password';
                            }
                            if($value != $source[$rule_value]) 
							{
                                $this->addError("{$name1} must match {$name2}!");
                            }
                            break;
						// Checking the DB to make sure that entry is not in the DB
                        case 'unique':
                            $check = $this->_db->get($rule_value, array($item, '=', $value));
                            if($check->count()) 
							{
                                $this->addError("{$value} already in use!");
                            }
                            break;
                        default:

                            break;
                    }
                }
            }
        }

        if(empty($this->_errors)) 
		{
            $this->_passed = true;
        }
        return $this;
    }

	// A method to add the errors
    private function addError($error) 
	{
        $this->_errors .= "$error <br>";
    }

	// A method to print the errors
    public function errors() 
	{
        return "Error:<br> $this->_errors";
    }

	// Method to check if validation has passed
    public function passed() 
	{
        return $this->_passed;
    }
}

?>
