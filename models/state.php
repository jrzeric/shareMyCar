<?php
	
	require_once('mysqlconnection.php');
	require_once('exceptions/recordnotfoundexception.php');
	require_once('country.php');

	/**
	* Class State
	*/
	class State
	{
		//Attributes
		private $id;
		private $name;
		private $country;

		//Setters & Getter id
		public function getId() { return $this->id; }
		public function setId($value) { $this->id = $value; }

		//Setters & Getter Name
		public function getName() { return $this->name; }
		public function setName($value) { $this->id = $value; }

		//Setters & Getter Brand
		public function getCountry() { return $this->country; }
		public function setCountry($value) { $this->country = $value; }


		function __construct()
		{
			if (func_num_args() == 0)
			{
				$this->id = '';
				$this->name = '';
				$this->country = new Country();
			}//if

			//object with data from database
			if (func_num_args() == 1)
			{
				//get id
				$id = func_get_arg(0);
				//get connection
				$connection = MySQLConnection::getConnection();
				//query
				$query = 'select code, name, country
						from states_ctg
						where code = ?';//the ? is a param
				//command
				$command = $connection->prepare($query);
				//params
				$command->bind_param('s', $id);//s for string and the variable for parameter
				//execute
				$command->execute();
				//bind results
				$command->bind_result($id, $name, $idCountry);//asign the results to the atributes
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
					$this->country = new Country($idCountry);
				}
				else throw new RecordNotFoundException();
			}

			if (func_num_args() == 3) 
			{
				$arguments = func_get_args();
				$this->id = $arguments[0];
				$this->name = $arguments[1];
				$this->country = new Country($arguments[2]);
			}//if
		}//constructor

		//Methods
		public function toJson()
		{
			return json_encode(array(
				'id' => $this->id,
				'name' => $this->name,
				'country' => json_decode($this->country->toJson())
				));
		}//toJson

		public static function getAllS($country)
		{
			//list
			$list = array();
			$connection = MySQLConnection::getConnection();
			//query
			$query = 'select code, name ,country
						from states_ctg
						where country = ?';
			//command
			$command = $connection->prepare($query);
			$command->bind_param('s', $country);//s for string and the variable for parameter
			//execute
			$command->execute();
			//bind results
			$command->bind_result($id, $name, $idCountry);
			//fetch
			while ($command->fetch())
			{
				array_push($list, new State($id, $name, $idCountry));
			}
			//close statement
			mysqli_stmt_close($command);
			//close connection
			$connection->close();
			//return array
			return $list;
		}//getAll

		public static function getAllSJson($country)
		{
			//list
			$list = array();
			//encode to json
			foreach (self::getAllS($country) as $item) 
			{
				array_push($list, json_decode($item->toJson()));
			}//foreach
			return json_encode(array('states' => $list));
		}



	}

?>