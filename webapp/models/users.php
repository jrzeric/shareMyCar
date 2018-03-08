<?php
  require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/student.php');
  require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/car.php');

  // constructor recibe 2 parametros USER Y PASSWORD
  //si es conductor, traigo datos del carro que tenga activo
  //si solo es estudiante traigo datos
  //si no tiene carro activo traigo solo datos del estudiante
	class Users
	{
		private $user;
		private $car;
		private $driver;

		public function getUser(){return $this->user;}
		public function setUser($value){ $this->user = $value;}
		public function getCar(){return $this->car;}
		public function setCar($value){ $this->car = $value;}
		public function getDriver(){ return $this->driver;}

		function __construct()
		{
			//object with data from database
			if (func_num_args() == 2) 
			{
				$arguments = func_get_args();
				//get id
				$connection = MySqlConnection::getConnection();
				$query = 'SELECT s.id, s.name, s.surName, s.secondSurName, s.email, s.cellPhone, u.id,u.name, c.id, c.name, c.status, st.id,
						st.name,st.status, u.latitude, u.longitude, u.status,s.controlNumber, s.latitude, s.longitude, s.photo, c.id, c.name,
						c.status, st.id,st.name, st.status, s.turn, s.status, p.id, p.name, s.raiting
						FROM students s JOIN universities_ctg u ON s.university = u.id JOIN cities_ctg c ON s.city = c.id
						JOIN states_ctg st ON c.state = st.id JOIN profiles_ctg p ON s.profile = p.id JOIN cities_ctg ci ON u.city = ci.id
						WHERE s.email = ? AND s.PASSWORD = ?;';
				$command = $connection->prepare($query);
				$command->bind_param('ss', $arguments[0], $arguments[1]);
				$command->execute();
				$command->bind_result($id, $name, $surnName, $secondSurName, $email, $cellPhone, $universityId, $universityName,
									$cityId, $cityName, $cityStatus, $stateId, $stateName, $stateStatus, $universityLt, $universityLg,
									$universityStatus, $controlNumber, $latitude, $longitude, $photo, $ctUnId, $ctUnName, $ctUnStts,
									$stUniId, $stUniName, $stUnSta, $turn, $status, $idProfile, $profileName, $raiting);
				$found = $command->fetch();
				mysqli_stmt_close($command);
				$connection->close();
				if ($found) {
					$uState = new State($stUniId, $stUniName, $stUnSta);
					$uCity = new City($ctUnId, $stUniId,$ctUnName, $ctUnStts);
					$sState = new State($stateId, $stateName, $stateStatus);
					$university = new University($universityId, $universityName, $universityLt, $universityLg, $universityStatus, $uCity);
					$city = new City($cityId, $stateId, $cityName, $cityStatus);
					$profile = new Profile($idProfile, $profileName);

					/*-------------------------*/
					$this->user = new Student($id,$name,$surnName,$secondSurName,$email,$cellPhone,$university,$controlNumber, $latitude,$longitude,$photo,$city,$turn,$status,$profile, $raiting);

				}
				else {
					//throw exception if record not found
					throw new RecordNotFoundException();
				}
			}
		}

		public function toJsonPassenger() 
		{ 
			return json_encode(array
				('user' => json_decode($this->user->toJson())));
		}

		public function toJsonDriver() 
		{ 
			return json_encode(array
				('user' => json_decode($this->user->toJson()),
					'car' => json_decode($this->car->toJson())));
		}

		public function studentHasCar($id)
		{
			$connection = MySqlConnection::getConnection();
			$query = 'select c.id, c.model, c.licencePlate, c.driverLicence, c.color, c.insurance, c.spaceCar, c.owner, c.status as carStatus, s.id
				from students as s
				inner join cars as c on s.id = c.driver
				inner join models_ctg m on m.id = c.model
				where s.email = ? and c.status = 1';
			$command = $connection->prepare($query);
			$command->bind_param('s', $id);
			$command->execute();
			$command->bind_result($carID, $idModel, $licensePlate, $driverLicense, $color, $insurance, $spaceCar, $owner, $carStatus, $studentID);
			$found = $command->fetch();
			mysqli_stmt_close($command);
			$connection->close();
			if ($found) 
			{
				$model = new Model($idModel);
				$this->car = new Car($carID, $this->user, $model, $licensePlate, $driverLicense, $color, $insurance, $spaceCar, $owner, $carStatus);
				$this->driver = true;
			}
			else {
				$this->driver = false;
			}

		}
	}
?>
