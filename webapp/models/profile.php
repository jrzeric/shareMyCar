<?php

  require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/mysqlconnection.php');
  require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/exceptions/recordnotfoundexception.php');

  class Profile{
    // Attributes
    private $id;
    private $name;

    // Setters and Getters
    public function getCode() { return $this->id; }
    public function setCode($value) { $this->id = $value; }
    public function getName() { return $this->name; }
    public function setName($value) { $this->name = $value; }

    //constructors
    function __construct()
    {
      if(func_num_args() == 0){
        $this->id = '';
        $this->name = '';
      }
      if(func_num_args() == 1) {
        $id = func_get_arg(0);
        $connection = MySQLConnection::getConnection();
        $query = 'Select id, name from profiles_ctg Where id = ?';
        $command = $connection->prepare($query);
        $command->bind_param('s', $id);
        $command->execute();
        $command->bind_result($id, $name);
        $found = $command->fetch();
        //close command
        mysqli_stmt_close($command);
        //close connection
        $connection->close();
        if ($found) {
          $this->id = $id;
          $this->name = $name;
        } else {
          //throw exception if record not found
          throw new RecordNotFoundException();
        }
      }
	  //object with data from arguments
			if (func_num_args() == 2) {
				//get arguments
				$arguments = func_get_args();
				//pass arguments to attributes
				$this->id = $arguments[0];
				$this->name = $arguments[1];
			}
    }

      //add
    public function add()
    {
      //get connection
      $connection = MySqlConnection::getConnection();
      //query
      $query = 'Insert into profiles_ctg (id, name) values (?, ?)';
      //command
      $command = $connection->prepare($query);
      //bind parameters
      $command->bind_param('ss',$this->id, $this->name);
      //execute
      $result = $command->execute();
      //close command
      mysqli_stmt_close($command);
      //close connection
      $connection->close();
      //return result
      return $result;
    }

    //represents the object in JSON format
    public function toJson()
    {
      return json_encode(array(
        'id' => $this->id,
        'name' => $this->name
      ));
    }

    public static function getAll()
    {
      //list
      $list = array();
      //get connection
      $connection = MySqlConnection::getConnection();
      //query
      $query = 'Select id, name From profiles_ctg';
      //command
      $command = $connection->prepare($query);
      //execute
      $command->execute();
      //bind results
      $command->bind_result($id, $name);
      //fetch data
      while ($command->fetch()) {
        array_push($list, new Profile($id, $name));
      }

      //close command
      mysqli_stmt_close($command);
      //close connection
      $connection->close();
      //return list
      return $list;
    }

    //get all in JSON format
    public static function getAllJson()
    {
      //list
      $list = array();
      //get all
      foreach(self::getAll() as $item) {
        array_push($list, json_decode($item->toJson()));
      }
      //return json encoded array
      return json_encode(array(
        'Profile' => $list
      ));
    }
}

?>
