<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/models/mysqlconnection.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/models/exceptions/recordnotfoundexception.php');

	class State {
		//attributes
		private $id;
		private $name;
		private $status;

		//setters and getters
		public function setId($value) { $this->id = $value; }
		public function getId() { return $this->id; }
		public function setName($value) { $this->name = $value; }
		public function getName() { return $this->name; }
		public function setStatus($value) { $this->status = $value; }
		public function getStatus() { return $this->status; }

		//constructors
		function __construct()
    {
			if(func_num_args() == 0) {
				$this->id = '';
				$this->name = '';
				$this->status = 0;
			}
			if(func_num_args() == 1) {
				$id = func_get_arg(0);
				$connection = MySQLConnection::getConnection();
				$query = 'Select id, name, status From states_ctg Where id = ?';
				$command = $connection->prepare($query);
				$command->bind_param('s', $id);
				$command->execute();
				$command->bind_result($id, $name, $status);
				$found = $command->fetch();
				//close command
				mysqli_stmt_close($command);
				//close connection
				$connection->close();
				//throw exception if record not found
				if (!$found) {
					$this->id = $id;
					$this->name = $name;
					$this->status = $status;
				} else {
					//throw exception if record not found
					throw new RecordNotFoundException();
				}
			}
			//object with data from arguments
			if (func_num_args() == 3) {
				//get arguments
				$arguments = func_get_args();
				//pass arguments to attributes
				$this->id = $arguments[0];
				$this->name = $arguments[1];
				$this->status = $arguments[2];
			}
		}

		//add
		public function add()
    {
			//get connection
			$connection = MySqlConnection::getConnection();
			//query
			$query = 'insert into states_ctg (id, name, status) values (?, ?, 1)';
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
				'name' => $this->name,
				'status' => $this->status
			));
		}

		//get all
		public static function getAll()
    {
			//list
			$list = array();
			//get connection
			$connection = MySqlConnection::getConnection();
			//query
			$query = 'Select id, name, status From states_ctg';
			//command
			$command = $connection->prepare($query);
			//execute
			$command->execute();
			//bind results
			$command->bind_result($id, $name, $status);
			//fetch data
			while ($command->fetch()) {
				array_push($list, new State($id, $name, $status));
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
				'State' => $list
			));
		}
	}
<<<<<<< HEAD
?>
=======
>>>>>>> 50b750d24c99d27ee28da640ef82e935cda34ac5
