<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/mysqlconnection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/exceptions/recordnotfoundexception.php');

class State
{
  // Attributes
  private $code;
  private $name;
  private $status;

  // Setters and Getters
  public function getCode() { return $this->code; }
  public function setCode($value) { $this->code = $value; }

  public function getName() { return $this->name; }
  public function setName($value) { $this->name = $value; }

  public function getStatus() { return $this->status; }
  public function setStatus($value) { $this->status = $value; }

  // Constructor
  function __construct()
  {
    if (func_num_args() == 0) {
      $this->code = '';
      $this->name = '';
      $this->status = 0;

    }
    if (func_num_args() == 1) {
      $code = func_get_arg(0);
      $connection = MySQLConnection::getConnection();
      $query = 'SELECT code, name, status FROM states_ctg WHERE code = ?;';

      $command = $connection->prepare($query);
      $command->bind_param('s', $code);
      $command->execute();

      $command->bind_result($code, $name, $status);
      $found = $command->fetch();

      mysqli_stmt_close($command);
      $connection->close();

      if ($found) {
        $this->code = $code;
        $this->name = $name;
        $this->status = $status;
      } else {
        throw new RecordNotFoundException();
      }
    }
    if (func_num_args() == 3) {
      $arguments = func_get_args();
      $this->code = $arguments[0];
      $this->name = $arguments[1];
      $this->status = $arguments[2];
    }
  }
  
  //Instance methods
  
	//Methods
	public function toJson()
	{
		return json_encode(array(
			'code' => $this->code,
			'name' => $this->name,
			'status' => $this->status
			));
	}//toJson
	
	public static function getAll()
	{
		//list
		$list = array();
		$connection = MySQLConnection::getConnection();
		//query
		$query = 'select code, name , status
					from states_ctg';
		//command
		$command = $connection->prepare($query);
		//execute
		$command->execute();
		//bind results
		$command->bind_result($code, $name, $status);
		//fetch
		while ($command->fetch())
		{
			array_push($list, new State($code, $name, $status));
		}
		//close statement
		mysqli_stmt_close($command);
		//close connection
		$connection->close();
		//return array
		return $list;
	}//getAll

	public static function getAllJson()
	{
		//list
		$list = array();
		//encode to json
		foreach (self::getAll() as $item) 
		{
			array_push($list, json_decode($item->toJson()));
		}//foreach
		return json_encode(array(
		'status' => '1',
		'states' => $list));
	}

  /**
   * Adds a new state to the database
   *
   * @return bool the bool of the
   */
  public function add()
  {
    $connection = MySQLConnection::getConnection();
    $query = "INSERT INTO states_ctg (code, name, status) values (?, ?, ?);";

    $command = $connection->prepare($query);
    $command->bind_param('ssi', $this->code, $this->name, $this->status);

    $result = $command->execute();
    mysqli_stmt_close($command);
    $connection->close();

    return $result;
  }

  /**
   * Edits a state in the database
   *
   * @return bool the bool of the
   */
  public function put()
  {
    $connection = MySQLConnection::getConnection();
    $query = "UPDATE states_ctg SET name = ?, status = ? WHERE code = ?;";

    $command = $connection->prepare($query);
    $command->bind_param('sis', $this->name, $this->status, $this->code);

    $result = $command->execute();
    mysqli_stmt_close($command);
    $connection->close();

    return $result;
  }

  /**
   * Changes the status for a state from the database
   *
   * @return bool the bool of the
   */
  public function delete()
  {
    $connection = MySQLConnection::getConnection();
    $query = "UPDATE states_ctg SET status = 0 WHERE code = ?;";

    $command = $connection->prepare($query);
    $command->bind_param('s', $this->code);

    $result = $command->execute();
    mysqli_stmt_close($command);
    $connection->close();

    return $result;
  }
}
