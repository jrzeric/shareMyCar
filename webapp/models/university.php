<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/models/mysqlconnection.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/models/exceptions/recordnotfoundexception.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/models/city.php');

	class University{
		//attributes
		private $id;
		private $name;
		private $latitude;
		private $longitude;
		private $status;
		private $city;

		//getters and setters
		public function getId() { return $this->id; }
		public function setId($value) { $this->id = $value; }

		public function getName() { return $this->name; }
		public function setName($value) { $this->name = $value; }

		public function getLatitude() { return $this->latitude; }
		public function setLatitude($value) { $this->latitude = $value; }

		public function getLongitude() { return $this->longitude; }
		public function setLongitude($value) { $this->longitude = $value; }

		public function getStatus() { return $this->status; }
		public function setStatus($value) { $this->status = $value; }

		public function getCity() { return $this->city; }
		public function setCity($value) { $this->city = $value; }

		//constructor
		public function __construct()
    {
			//empty object
			if (func_num_args() == 0) {
				$this->id = '';
				$this->name = '';
				$this->latitude = 0.0;
				$this->longitude = 0.0;
				$this->city = new City();
			}
			//object with data from database
			if (func_num_args() == 1) {
				//get id
				$id = func_get_arg(0);
				//get connection
				$connection = MySqlConnection::getConnection();
				//query
				$query = 'Select u.id, u.name, u.latitude, u.longitude, u.status, c.id cityId,
					c.name cityName, c.status cityStatus, c.state cityStateId,
                    s.name as stateName, s.status as stateStatus
					FROM universities_ctg u
                    JOIN cities_ctg c ON u.city = c.id
                    Inner join states_ctg s on s.id = c.state
                    Where u.id = ?';
				//command
				$command = $connection->prepare($query);
				//bind parameters
				$command->bind_param('s', $id);
				//execute
				$command->execute();
				//bind results
				$command->bind_result($id, $name, $latitude, $longitude, $status, $cityId, $city, $statusCity, $stateId, $stateName, $stateStatus);
				//fetch data
				$found = $command->fetch();
				//close command
				mysqli_stmt_close($command);
				//close connection
				$connection->close();
				//pass values to the attributes
				if ($found) {
					$state = new State($stateId, $stateName, $stateStatus);
					$this->id = $id;
					$this->name = $name;
					$this->latitude = $latitude;
					$this->longitude = $longitude;
					$this->status = $status;
					$this->city = new City($cityId, $stateId ,$city, $statusCity);
				} else {
					//throw exception if record not found
					throw new RecordNotFoundException();
				}
			}

			//object with data from arguments
			if (func_num_args() == 6) {
				//get arguments
				$arguments = func_get_args();
				//pass arguments to attributes
				$this->id = $arguments[0];
				$this->name = $arguments[1];
				$this->latitude = $arguments[2];
				$this->longitude = $arguments[3];
				$this->status = $arguments[4];
				$this->city = $arguments[5];
			}
		}

		//instance methods

		//add
		public function add()
    {
			//get connection
			$connection = MySqlConnection::getConnection();
			//query
			$query = 'Insert into universities_ctg (id, name, city, latitude, longitude, status) VALUES (?, ?, ?, ?, ?, ?)';
			//command
			$command = $connection->prepare($query);
			//bind parameters
			$command->bind_param('ssiddi', $this->id, $this->name, $this->city->getId(), $this->latitude, $this->longitude, $this->status);
			//execute
			$result = $command->execute();
			//close command
			mysqli_stmt_close($command);
			//close connection
			$connection->close();
			//return result
			return $result;
		}

		//delete
		public function delete()
    {
			//get connection
			$connection = MySqlConnection::getConnection();
			//query
			$query = 'delete from universities_ctg where id = ?';
			//command
			$command = $connection->prepare($query);
			//bind parameters
			$command->bind_param('s', $this->id);
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
				'latitude' => $this->latitude,
				'longitude' => $this->longitude,
				'status' => $this->status,
				'city' => json_decode($this->city->toJson())
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
			$query = 'Select u.id, u.name, u.latitude, u.longitude, u.status, c.id cityId,
					c.name cityName, c.status cityStatus, c.state cityStateId,
                    s.name as stateName, s.status as stateStatus
					FROM universities_ctg u
                    JOIN cities_ctg c ON u.city = c.id
                    Inner join states_ctg s on s.id = c.state';
			//command
			$command = $connection->prepare($query);
			//execute
			$command->execute();
			//bind results
			$command->bind_result($id, $name, $latitude, $longitude, $status, $cityId, $city, $statusCity, $stateId, $stateName, $stateStatus);
			//fetch data
			while ($command->fetch()) {
				//$state = new State($stateId, $stateName, $stateStatus);
				$city = new City($cityId, $stateId,$city, $statusCity);
				array_push($list, new University($id, $name, $latitude, $longitude, $status, $city));
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
				'Universities' => $list
			));
		}

				//get all
		public static function getAllByCity($city)
    	{
			//list
			$list = array();
			//get connection
			$connection = MySqlConnection::getConnection();
			//query
			$query = 'Select u.id, u.name, u.latitude, u.longitude, u.status, c.id cityId,
					c.name cityName, c.status cityStatus, c.state cityStateId,
                    s.name as stateName, s.status as stateStatus
					FROM universities_ctg u
                    JOIN cities_ctg c ON u.city = c.id
                    Inner join states_ctg s on s.id = c.state
                    where c.id = ?';
			//command
			$command = $connection->prepare($query);
			$command->bind_param('i', $city);
			//execute
			$command->execute();
			//bind results
			$command->bind_result($id, $name, $latitude, $longitude, $status, $cityId, $city, $statusCity, $stateId, $stateName, $stateStatus);
			//fetch data
			while ($command->fetch()) {
				//$state = new State($stateId, $stateName, $stateStatus);
				$city = new City($cityId, $stateId,$city, $statusCity);
				array_push($list, new University($id, $name, $latitude, $longitude, $status, $city));
			}
			//close command
			mysqli_stmt_close($command);
			//close connection
			$connection->close();
			//return list
			return $list;
		}

		//get all in JSON format
		public static function getAllByCityJson($city)
    	{
			//list
			$list = array();
			//get all
			foreach(self::getAllByCity($city) as $item) {
				array_push($list, json_decode($item->toJson()));
			}
			//return json encoded array
			return json_encode(array(
				'Universities' => $list
			));
		}




	}
