<?php

	require_once('mysqlconnection.php');
	require_once('exceptions/recordnotfoundexception.php');
	require_once('state.php');
	/**
	*	Class City
	*/
	class City
	{
		
		//Attributes
		private $id;
		private $name;
		private $state;

		//Setters & Getter id
		public function getId() { return $this->id; }
		public function setId($value) { $this->id = $value; }

		//Setters & Getter Name
		public function getName() { return $this->name; }
		public function setName($value) { $this->id = $value; }

		//Setters & Getter Brand
		public function getState() { return $this->state; }
		public function setState($value) { $this->state = $value; }

		function __construct()
		{
			if (func_num_args() == 0)
			{
				$this->id = '';
				$this->name = '';
				$this->state = new State();
			}//if

			//object with data from database
			if (func_num_args() == 1)
			{
				//get id
				$id = func_get_arg(0);
				//get connection
				$connection = MySQLConnection::getConnection();
				//query
				$query = 'select CODE, name, state
						from cities_ctg
						where code = ?';//the ? is a param
				//command
				$command = $connection->prepare($query);
				//params
				$command->bind_param('d', $id);//s for string and the variable for parameter
				//execute
				$command->execute();
				//bind results
				$command->bind_result($id, $name, $idState);//asign the results to the atributes
				//fetch
				$found = $command->fetch();
				//close command
				mysqli_stmt_close($command);
				//close connection
				$connection->close();
				//throw exception if record not found
				if ($found) 
				{
					$this->id = $id;
					$this->name = $name;
					$this->state = new State($idState);
				}
				else throw new RecordNotFoundException();
			}

			if (func_num_args() == 3) 
			{
				$arguments = func_get_args();
				$this->id = $arguments[0];
				$this->name = $arguments[1];
				$this->state = new State($arguments[2]);
			}//if
		}//constructor

		//Methods
		public function toJson()
		{
			return json_encode(array(
				'id' => $this->id,
				'name' => $this->name,
				'state' => json_decode($this->state->toJson())
				));
		}//toJson

		public static function getAllC($state)
		{
			//list
			$list = array();
			$connection = MySQLConnection::getConnection();
			//query
			$query = 'select CODE, name, state
						from cities_ctg
						where state = ?';
			//command
			$command = $connection->prepare($query);
			$command->bind_param('s', $state);//s for string and the variable for parameter
			//execute
			$command->execute();
			//bind results
			$command->bind_result($id, $name, $idState);
			//fetch
			while ($command->fetch())
			{
				array_push($list, new City($id, $name, $idState));
			}
			//close statement
			mysqli_stmt_close($command);
			//close connection
			$connection->close();
			//return array
			return $list;
		}//getAll

		public static function getAllCJson($state)
		{
			//list
			$list = array();
			//encode to json
			foreach (self::getAllC($state) as $item) 
			{
				array_push($list, json_decode($item->toJson()));
			}//foreach
			return json_encode(array('cities' => $list));
		}

	}

?>