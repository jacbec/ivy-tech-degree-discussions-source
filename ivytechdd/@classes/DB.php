<?php

class DB 
{
	// Setting private variables to be used throughout the DB class
    private static $_instance = null;
    private $_pdo,
            $_query,
            $_error = false,
            $_results,
            $_count = 0;

	// A private constructer to connect to the database as soon as class is instantiated. 
    private function __construct() 
	{
        try 
		{
            $this->_pdo = new PDO('mysql:host=' .Config::get('mysql/host') .';dbname=' .Config::get('mysql/db') .'', Config::get('mysql/user'), Config::get('mysql/pass'));
        } 
		catch(PDOException $e) 
		{
            die($e->getMessage());
        }
    }

	// A method to make sure there is only one database connection
    public static function getInstance() 
	{
        if(!isset(self::$_instance)) 
		{
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

	// A method to make querying the DB easier
    public function query($sql, $params = array()) 
	{
        $this->_error = false;
        if($this->_query = $this->_pdo->prepare($sql)) 
		{
            if(count($params)) 
			{
                $x = 1;
                foreach ($params as $param) 
				{
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }

            if($this->_query->execute()) 
			{
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } 
			else 
			{
                $this->_error = true;
            }
        }
        return $this;
    }

	// A method that is used by get and delete to simplify those methods
	// This methods algorithm is to search through a query to find the params used
    private function action($action, $table, $where = array()) 
	{
        if(count($where) === 3) 
		{
            $operators = array('=', '>', '<', '>=', '<=');

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if(in_array($operator, $operators)) 
			{
                $sql = "{$action} From {$table} WHERE {$field} {$operator} ?";

                if(!$this->query($sql, array($value))->error()) 
				{
                    return $this;
                }
            }
        }
        return false;
    }

	// A method to select from a DB table
    public function get($table, $where) 
	{
        return $this->action('SELECT *', $table, $where);
    }

	// A method used to insert data into the DB
	// This methods algorithm is to impode values to the rows
    public function insert($table, $fields = array()) 
	{
        $keys = array_keys($fields);
        $values = '';
        $x = 1;

        foreach($fields as $field) 
		{
            $values .= '?';
            if($x < count($fields)) 
			{
                $values .= ', ';
            }
            $x++;
        }

        $sql = "INSERT INTO {$table} (`" .implode('`, `', $keys) ."`) VALUES ({$values})";

        if(!$this->query($sql, $fields)->error()) 
		{
            return true;
        }

        return false;
    }

	// A method to update a data set in the DB
    public function update($table, $id, $fields) 
	{
        $set = '';
        $x = 1;

        foreach ($fields as $name => $value) 
		{
            $set .= "{$name} = ?";
            if($x < count($fields)) 
			{
                $set .= ', ';
            }
            $x++;
        }

        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

        if(!$this->query($sql, $fields)->error()) 
		{
            return true;
        }
        return false;
    }

	// A method to delete a row in the DB
    public function delete($table, $where) 
	{
        return $this->action('DELETE', $table, $where);
    }

	// A method that returns the results of a query into a variable to be accessed
    public function results() 
	{
        return $this->_results;
    }

	// A method to return the first result in a data set
    public function first() 
	{
        return $this->results()[0];
    }

	// A method to count the rows in a query
    public function count() 
	{
        return $this->_count;
    }

	// A method that returns an error
    public function error() 
	{
        return $this->_error;
    }
}
?>
