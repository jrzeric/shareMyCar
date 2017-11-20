<?php

	require_once('mysqlconnection.php');
	require_once('exceptions/recordnotfoundexception.php');
	require_once('city.php');
	require_once('location.php');
	/**
	*	Class University
	*/
	class University
	{
		
		//Attributes
		private $id;
		private $name;
		private $city;
		private $location;

		//Setters & Getter id
		public function getId() { return $this->id; }
		public function setId($value) { $this->id = $value; }

		//Setters & Getter Name
		public function getName() { return $this->name; }
		public function setName($value) { $this->id = $value; }

		//Setters & Getter City
		public function getCity() { return $this->city; }
		public function setCity($value) { $this->city = $value; }

		//Setters & Getter Location
		public function getLocation() { return $this->location; }
		public function setLocation($value) { $this->location = $value; }

		function __construct()
		{
			if (func_num_args() == 0)
			{
				$this->id = '';
				$this->name = '';
				$this->city = new City();
				$this->location = new Location();
			}//if

			//object with data from database
			if (func_num_args() == 1)
			{
				//get id
				$id = func_get_arg(0);
				//get connection
				$connection = MySQLConnection::getConnection();
				//query
				$query = 'SELECT id, name, city, latitude, longitude 
						FROM universities_ctg 
						where id = ?';//the ? is a param
				//command
				$command = $connection->prepare($query);
				//params
				$command->bind_param('d', $id);//s for string and the variable for parameter
				//execute
				$command->execute();
				//bind results
				$command->bind_result($id, $name, $idCity, $latitude, $longitude);//asign the results to the atributes
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
					$this->city = new City($idCity);
					$this->location = new Location($latitude, $longitude);
				}
				else throw new RecordNotFoundException();
			}

			if (func_num_args() == 5) 
			{
				$arguments = func_get_args();
				$this->id = $arguments[0];
				$this->name = $arguments[1];
				$this->city = new City($arguments[2]);
				$this->location = new Location($arguments[3], $arguments[4]);
			}//if
		}//constructor

		//Methods
		public function toJson()
		{
			return json_encode(array(
				'id' => $this->id,
				'name' => $this->name,
				'city' => json_decode($this->city->toJson()),
				'location' => json_decode($this->location->toJson())
				));
		}//toJson

		public static function getAllU($city)
		{
			//list
			$list = array();
			$connection = MySQLConnection::getConnection();
			//query
			$query = 'SELECT id, name, city, latitude, longitude 
					FROM universities_ctg 
					where city = ?';
			//command
			$command = $connection->prepare($query);
			$command->bind_param('d', $city);//s for string and the variable for parameter
			//execute
			$command->execute();
			//bind results
			$command->bind_result($id, $name, $idCity, $latitude, $longitude);
			//fetch
			while ($command->fetch())
			{
				array_push($list, new University($id, $name, $idCity, $latitude, $longitude));
			}
			//close statement
			mysqli_stmt_close($command);
			//close connection
			$connection->close();
			//return array
			return $list;
		}//getAll

		public static function getAllUJson($city)
		{
			//list
			$list = array();
			//encode to json
			foreach (self::getAllU($city) as $item) 
			{
				array_push($list, json_decode($item->toJson()));
			}//foreach
			return json_encode(array('universities' => $list));
		}

	}

?>