<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/mysqlconnection.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/exceptions/recordnotfoundexception.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/city.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/state.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/university.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/profile.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/car.php');

	class Student{
		//attributes
		private $id;
		private $name;
		private $surnName;
		private $secondSurname;
		private $email;
		private $password;
		private $cellPhone;
		private $university;
		private $controlNumber;
		private $latitude;
		private $longitude;
		private $photo;
		private $city;
		private $turn;
		private $status;
		private $profile;
		private $raiting;
		private $car;
		private $driver;


		//setters and getters
		public function getId() { return $this->id; }
		public function setId($value) { $this->id = $value; }
		public function getName() { return $this->name; }
		public function setName($value) { $this->name = $value; }
		public function getSurName() { return $this->surnName; }
		public function setSurName($value) { $this->surnName = $value; }
		public function getSecondSurname() { return $this->secondSurname; }
		public function setSecondSurname($value) { $this->secondSurname = $value; }
		public function getEmail() { return $this->email; }
		public function setEmail($value) { $this->email = $value; }
		public function getPassword() { return $this->password; }
		public function setPassword($value) { $this->password = $value; }
		public function getCellPhone() { return $this->cellPhone; }
		public function setCellPhone($value) { $this->cellPhone = $value; }
		public function getUniversity() { return $this->university; }
		public function setUniversity($value) { $this->university = $value; }
		public function getControlNumber() { return $this->controlNumber; }
		public function setControlNumber($value) { $this->controlNumber = $value; }
		public function getLatitude() { return $this->latitude; }
		public function setLatitude($value) { $this->latitude = $value; }
		public function getLongitude() { return $this->longitude; }
		public function setLongitude($value) { $this->longitude = $value; }
		public function getPhoto() { return $this->photo; }
		public function setphoto($value) { $this->photo = $value; }
		public function getCity() { return $this->city; }
		public function setCity($value) { $this->city = $value; }
		public function getTurn() { return $this->turn; }
		public function setTurn($value) { $this->turn = $value; }
		public function getStatus() { return $this->status; }
		public function setStatus($value) { $this->status = $value; }
		public function getProfile() { return $this->profile; }
		public function setProfile($value) { $this->profile = $value; }
		public function getRaiting() { return $this->raiting; }
		public function setRaiting($value) { $this->raiting = $value; }

		public function setCar($value) { $this->car = $value; }
		public function getCar() { return $this->car; }

		public function getDriver() { return $this->driver; }

		//constructor
		public function __construct() {
			//empty object
			if (func_num_args() == 0) {
				$this->id = '';
				$this->name = '';
				$this->surnName = '';
				$this->secondSurname = '';
				$this->email = '';
				$this->password = '';
				$this->cellPhone = '';
				$this->university = new University();
				$this->controlNumber = '';
				$this->latitude = 0.0;
				$this->longitude = 0.0;
				$this->photo = '';
				$this->city = new City();
				$this->turn = 0;
				$this->raiting = 0;
				$this->status = 0;
				$this->profile = new Profile();
			}
			//object with data from database
			if (func_num_args() == 1) {
				//get id
				$id = func_get_arg(0);
				//get connection
				$connection = MySqlConnection::getConnection();
				//query
				$query = 'Select s.id, s.name, s.surName, s.secondSurName, s.email, s.password, s.cellPhone, u.id universityId,
					u.name universityName, c.id cityId, c.name cityName, c.status cityStatus, st.id stateId, st.name stateName,
					st.status stateStatus, u.latitude universityLt, u.longitude universityLg, u.status universityStatus,
					s.controlNumber, s.latitude, s.longitude, s.photo, c.id ctUnId, c.name ctUnName, c.status ctUnStts, st.id stUniId,
					st.name stUniName, st.status stUnSta, s.turn, s.raiting, s.status, p.id idProfile, p.name profileName, u.city, c.state
					FROM students s JOIN universities_ctg u ON s.university = u.id JOIN cities_ctg c ON s.city = c.id
					JOIN states_ctg st ON c.state = st.id JOIN profiles_ctg p ON s.profile = p.id JOIN cities_ctg ci ON u.city = ci.id
					WHERE s.id = ?';
				//command
				$command = $connection->prepare($query);
				//bind parameters
				$command->bind_param('d', $id);
				//execute
				$command->execute();
				//bind results
				$command->bind_result($id, $name, $surnName, $secondSurName, $email, $password, $cellPhone, $universityId, $universityName,
									$cityId, $cityName, $cityStatus, $stateId, $stateName, $stateStatus, $universityLt, $universityLg,
									$universityStatus, $controlNumber, $latitude, $longitude, $photo, $ctUnId, $ctUnName, $ctUnStts,
									$stUniId, $stUniName, $stUnSta, $turn, $raiting, $status, $idProfile, $profileName, $universityCity, $stateCity);
				//fetch data
				$found = $command->fetch();
				//close command
				mysqli_stmt_close($command);
				//close connection
				$connection->close();
				//pass values to the attributes
				if ($found) {
					//$uState = new State($stUniId, $stUniName, $stUnSta);
					$uCity = new City($universityCity);
					//$sState = new State($stateId, $stateName, $stateStatus);
					/*-------------------------*/
					$this->id = $id;
					$this->name = $name;
					$this->surnName = $surnName;
					$this->secondSurname = $secondSurName;
					$this->email = $email;
					$this->password = $password;
					$this->cellPhone = $cellPhone;
					$this->university = new University($universityId, $universityName, $universityLt, $universityLg, $universityStatus, $uCity);
					$this->controlNumber = $controlNumber;
					$this->latitude = $latitude;
					$this->longitude = $longitude;
					$this->photo = $photo;
					$this->city = new City($cityId, $stateCity, $cityName, $cityStatus);
					$this->turn = $turn;
					$this->raiting = $raiting;
					$this->status = $status;
					$this->profile = new Profile($idProfile, $profileName);
				} else {
					//throw exception if record not found
					throw new RecordNotFoundException();
				}
			}
/*
			//validation email and password
			if (func_num_args() == 2)
			{
				//get id
				$email = func_get_arg(0);
				$pass = func_get_arg(1);
				//get connection
				$connection = MySQLConnection::getConnection();
				//query
				$query = 'select email, id, profile from students where email = ? AND password = ?';
				$command = $connection->prepare($query);
				$command->bind_param('ss', $email, $pass);
				$command->execute();
				$command->bind_result($em, $idu, $pro);
				$found = $command->fetch();
				mysqli_stmt_close($command);
				$connection->close();
				if ($found)
				{
					if ($pro == 'USE')
					{
						$this->email = $em;
						$this->user = new Student($idu);
					}
					else
					{
						$this->email = $em;
						$this->user = new Student($idu);
					}
				}
				else
					throw new InvalidUserException($email);
				}*/
			//object with data from arguments
			if (func_num_args() == 16) {
				//get arguments
				$arguments = func_get_args();
				//pass arguments to attributes
				$this->id = $arguments[0];
				$this->name = $arguments[1];
				$this->surnName = $arguments[2];
				$this->secondSurname = $arguments[3];
				$this->email = $arguments[4];
				$this->cellPhone = $arguments[5];
				$this->university = $arguments[6];
				$this->controlNumber = $arguments[7];
				$this->latitude = $arguments[8];
				$this->longitude = $arguments[9];
				$this->photo = $arguments[10];
				$this->city = $arguments[11];
				$this->turn = $arguments[12];
				$this->status = $arguments[13];
				$this->profile = $arguments[14];
				$this->raiting = $arguments[15];
			}
		}
		//add
		public function add()
    {
			//get connection
			$connection = MySqlConnection::getConnection();
			//query
			$query = 'Insert Into students (name, surname, secondSurname, email, cellPhone, university, controlNumber, latitude, longitude, photo, city, turn, profile, password, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 3);';
			//command
			$command = $connection->prepare($query);
			$universityId = $this->university->getId();
			$cityId = $this->city->getCode();
			$profileId = $this->profile->getCode();
			//bind parameters
			$command->bind_param('ssssssssssiiss',
				$this->name,
				$this->surnName,
				$this->secondSurname,
				$this->email,
				$this->cellPhone,
				$universityId,
				$this->controlNumber,
				$this->latitude,
				$this->longitude,
				$this->photo,
				$cityId,
				$this->turn,
				$profileId,
				$this->password
				);
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
			$query = 'delete from students Where id = ?';
			//command
			$command = $connection->prepare($query);
			//bind parameters
			$command->bind_param('i', $this->id);
			//execute
			$result = $command->execute();
			//close command
			mysqli_stmt_close($command);
			//close connection
			$connection->close();
			//return result
			return $result;
		}

		public static function updateStatus($id)
		{
			//get connection
			$connection = MySqlConnection::getConnection();
			//query
			$query = 'update students set status = 1 where id = ?';
			//command
			$command = $connection->prepare($query);
			//bind parameters
			$command->bind_param('i', $id);
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
		public function toJsonPassenger()
    	{
			return json_encode(array(
				'id' => $this->id,
				'name' => $this->name,
				'surname' => $this->surnName,
				'secondSurname' => $this->secondSurname,
				'email' => $this->email,
				'cellPhone' => $this->cellPhone,
				'controlNumber' => $this->controlNumber,
				'latitude' => $this->latitude,
				'longitude' => $this->longitude,
				'photo' => $this->photo,
				'turn' => $this->turn,
				'raiting' => $this->raiting,
				'status' => $this->status,
				'university' => json_decode($this->university->toJson()),
				'city' => json_decode($this->city->toJson()),
				'profile' => json_decode($this->profile->toJson())
			));
		}


		public function toJsonDriver()
    	{
			return json_encode(array(
				'id' => $this->id,
				'name' => $this->name,
				'surname' => $this->surnName,
				'secondSurname' => $this->secondSurname,
				'email' => $this->email,
				'cellPhone' => $this->cellPhone,
				'controlNumber' => $this->controlNumber,
				'latitude' => $this->latitude,
				'longitude' => $this->longitude,
				'photo' => $this->photo,
				'turn' => $this->turn,
				'raiting' => $this->raiting,
				'status' => $this->status,
				'university' => json_decode($this->university->toJson()),
				'city' => json_decode($this->city->toJson()),
				'profile' => json_decode($this->profile->toJson()),
				'car' => json_decode($this->car->toJson())
			));
		}

		public function studentHasCar($id)
		{
			$connection = MySqlConnection::getConnection();
			$query = 'select c.id, c.model, c.licencePlate, c.driverLicence, c.color, c.insurance, c.spaceCar, c.owner, c.status as carStatus, s.id
				from students as s
				inner join cars as c on s.id = c.driver
				inner join models_ctg m on m.id = c.model
				where c.driver = ?';
			$command = $connection->prepare($query);
			$command->bind_param('i', $id);
			$command->execute();
			$command->bind_result($carID, $idModel, $licensePlate, $driverLicense, $color, $insurance, $spaceCar, $owner, $carStatus, $studentID);
			$found = $command->fetch();
			mysqli_stmt_close($command);
			$connection->close();
			if ($found)
			{
				//$driver = new Student($id);
				$model = new Model($idModel);
				$this->car = new Car($carID, $model, $licensePlate, $driverLicense, $color, $insurance, $spaceCar, $owner, $carStatus);
				$this->driver = true;
			}
			else {
				$this->driver = false;
			}
		}





		//get all
		public static function getAll()
    	{
			//list
			$list = array();
			//get connection
			$connection = MySqlConnection::getConnection();
			//query
			$query = 'Select s.id, s.name, s.surName, s.secondSurName, s.email, s.password, s.cellPhone, u.id universityId,
					u.name universityName, c.id cityId, c.name cityName, c.status cityStatus, st.id stateId, st.name stateName,
					st.status stateStatus, u.latitude universityLt, u.longitude universityLg, u.status universityStatus,
					s.controlNumber, s.latitude, s.longitude, s.photo, c.id ctUnId, c.name ctUnName, c.status ctUnStts, st.id stUniId,
					st.name stUniName, st.status stUnSta, s.turn, s.raiting, s.status, p.id idProfile, p.name profileName
					FROM students s JOIN universities_ctg u ON s.university = u.id JOIN cities_ctg c ON s.city = c.id
					JOIN states_ctg st ON c.state = st.id JOIN profiles_ctg p ON s.profile = p.id JOIN cities_ctg ci ON u.city = ci.id';
			//command
			$command = $connection->prepare($query);
			//execute
			$command->execute();
			//bind results
			$command->bind_result($id, $name, $surnName, $secondSurName, $email, $password,$cellPhone, $universityId, $universityName, $cityId, $cityName, $cityStatus, $stateId, $stateName, $stateStatus, $universityLt, $universityLg, $universityStatus, $controlNumber, $latitude, $longitude, $photo,
														$ctUnId, $ctUnName, $ctUnStts, $stUniId, $stUniName, $stUnSta, $turn, $raiting, $status, $idProfile, $profileName);
			//fetch data
			while ($command->fetch()) {
				$uState = new State($stUniId, $stUniName, $stUnSta);
				$uCity = new City($ctUnId, $ctUnName, $ctUnStts, $uState);
				$sState = new State($stateId, $stateName, $stateStatus);
				/*-------------------------------------------------------*/
				$university = new University($universityId, $universityName, $universityLt, $universityLg, $universityStatus, $uCity);
				$city = new City($cityId, $cityName, $cityStatus, $sState);
				$profile = new Profile($idProfile, $profileName);
				/*-------------------------------------------------------*/
				array_push($list, new Student($id, $name, $surnName, $secondSurName, $email, $password, $cellPhone, $university, $controlNumber, $latitude, $longitude, $photo, $city, $turn, $raiting, $status, $profile));
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
				'Student' => $list
			));
		}
	}
