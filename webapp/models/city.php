<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/models/mysqlconnection.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/models/exceptions/recordnotfoundexception.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/models/state.php');

	class City{
		//attributes
		private $id;
		private $name;
		private $status;
		private $state;

		//getters and setters
		public function getId() { return $this->id; }
		public function setId($value) { $this->id = $value; }
		public function getName() { return $this->name; }
		public function setName($value) { $this->name = $value; }
		public function getStatus() { return $this->status; }
		public function setStatus($value) { $this->status = $value; }
		public function getState() { return $this->state; }
		public function setState($value) { $this->state = $value; }

		//constructor
		public function __construct() {
			//empty object
			if (func_num_args() == 0) {
				$this->id = 0;
				$this->name = '';
				$this->status = 0;
				$this->state = new State();
			}
			//object with data from database
			if (func_num_args() == 1) {
				//get id
				$id = func_get_arg(0);
				//get connection
				$connection = MySqlConnection::getConnection();
				//query
				$query = 'select c.id, c.name, c.status, s.id, s.name, s.status
				from cities_ctg c join states_ctg s on c.state = s.id where c.id = ?';
				//command
				$command = $connection->prepare($query);
				//bind parameters
				$command->bind_param('i', $id);
				//execute
				$command->execute();
				//bind results
				$command->bind_result($id, $name, $status, $stateId, $state, $statusState);
				//fetch data
				$found = $command->fetch();
				//close command
				mysqli_stmt_close($command);
				//close connection
				$connection->close();
				//pass values to the attributes
				if ($found) {
					$this->id = $id;
					$this->name = $name;
					$this->status = $status;
					$this->state = new State($stateId, $state, $statusState);
				}
				else {
					//throw exception if record not found
					throw new RecordNotFoundException();
				}
			}

			//object with data from arguments
			if (func_num_args() == 4) {
				//get arguments
				$arguments = func_get_args();
				//pass arguments to attributes
				$this->id = $arguments[0];
				$this->name = $arguments[1];
				$this->status = $arguments[2];
				$this->state = $arguments[3];
			}
		}

		//add
		public function add() {
			//get connection
			$connection = MySqlConnection::getConnection();
			//query
			$query = 'Insert into cities_ctg (id, name, status, state) vales (?, ?, ?, ?)';
			//command
			$command = $connection->prepare($query);
			//bind parameters
			$command->bind_param('ssds', $this->id, $this->name, $this->status, $this->state->getId());
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
		public function toJson() {
			return json_encode(array(
				'id' => $this->id,
				'name' => $this->name,
				'status' => $this->status,
				'state' => json_decode($this->state->toJson())
			));
		}

		//get all
		public static function getAll() {
			//list
			$list = array();
			//get connection
			$connection = MySqlConnection::getConnection();
			//query
			$query = 'select c.id, c.name, c.status, s.id, s.name, s.status
				from cities_ctg c join states_ctg s on c.state = s.id';
			//command
			$command = $connection->prepare($query);
			//execute
			$command->execute();
			//bind results
			$command->bind_result($id, $name, $status, $stateId, $state, $statusState);
			//fetch data
			while ($command->fetch()) {
				$state = new State($stateId, $state, $statusState);
				array_push($list, new City($id, $name, $status, $state));
			}
			//close command
			mysqli_stmt_close($command);
			//close connection
			$connection->close();
			//return list
			return $list;
		}

		//get all in JSON format
		public static function getAllJson() {
			//list
			$list = array();
			//get all
			foreach(self::getAll() as $item) {
				array_push($list, json_decode($item->toJson()));
			}
			//return json encoded array
			return json_encode(array(
				'City' => $list
			));
		}
	}
?>
