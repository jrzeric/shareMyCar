<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/models/mysqlconnection.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/models/exceptions/recordnotfoundexception.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/models/city.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/models/state.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/models/university.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/models/profile.php');

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
					st.name stUniName, st.status stUnSta, s.turn, s.raiting, s.status, p.id idProfile, p.name profileName
					FROM students s JOIN universities_ctg u ON s.university = u.id JOIN cities_ctg c ON s.city = c.id
					JOIN states_ctg st ON c.state = st.id JOIN profiles_ctg p ON s.profile = p.id JOIN cities_ctg ci ON u.city = ci.id
					WHERE s.id = ?';
				//command
				$command = $connection->prepare($query);
				//bind parameters
				$command->bind_param('i', $id);
				//execute
				$command->execute();
				//bind results
				$command->bind_result($id, $name, $surnName, $secondSurName, $email, $password, $cellPhone, $universityId, $universityName,
									$cityId, $cityName, $cityStatus, $stateId, $stateName, $stateStatus, $universityLt, $universityLg,
									$universityStatus, $controlNumber, $latitude, $longitude, $photo, $ctUnId, $ctUnName, $ctUnStts,
									$stUniId, $stUniName, $stUnSta, $turn, $raiting, $status, $idProfile, $profileName);
				//fetch data
				$found = $command->fetch();
				//close command
				mysqli_stmt_close($command);
				//close connection
				$connection->close();
				//pass values to the attributes
				if ($found) {
					$uState = new State($stUniId, $stUniName, $stUnSta);
					$uCity = new City($ctUnId, $ctUnName, $ctUnStts, $uState);
					$sState = new State($stateId, $stateName, $stateStatus);
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
					$this->city = new City($cityId, $cityName, $cityStatus, $sState);
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
			if (func_num_args() == 17) {
				//get arguments
				$arguments = func_get_args();
				//pass arguments to attributes
				$this->id = $arguments[0];
				$this->name = $arguments[1];
				$this->surnName = $arguments[2];
				$this->secondSurname = $arguments[3];
				$this->email = $arguments[4];
				$this->password = $arguments[5];
				$this->cellPhone = $arguments[6];
				$this->university = $arguments[7];
				$this->controlNumber = $arguments[8];
				$this->latitude = $arguments[9];
				$this->longitude = $arguments[10];
				$this->photo = $arguments[11];
				$this->city = $arguments[12];
				$this->turn = $arguments[13];
				$this->raiting = $arguments[14];
				$this->status = $arguments[15];
				$this->profile = $arguments[16];
			}
		}

		//add
		public function add()
    {
			//get connection
			$connection = MySqlConnection::getConnection();
			//query
			$query = 'Insert Into students (name, surname, secondSurname, email, cellPhone, university, controlNumber, latitude, longitude, photo, city, turn, profile, password, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 2)';
			//command
			$command = $connection->prepare($query);
			//bind parameters
			$command->bind_param('ssssssssssiiss',
				$this->name,
				$this->surnName,
				$this->secondSurname,
				$this->email,
				$this->cellPhone,
				$this->university->getId(),
				$this->controlNumber,
				$this->latitude,
				$this->longitude,
				$this->photo,
				$this->city->getCode(),
				$this->turn,
				$this->profile->getCode(),
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

		//represents the object in JSON format
		public function toJson()
    {
			return json_encode(array(
				'id' => $this->id,
				'name' => $this->name,
				'surname' => $this->surnName,
				'secondSurname' => $this->secondSurname,
				'email' => $this->email,
				'password' => $this->password,
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
