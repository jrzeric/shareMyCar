<?php
  require_once($_SERVER['DOCUMENT_ROOT'].'/models/student.php');
  //require_once($_SERVER['DOCUMENT_ROOT'].'/models/car.php');

  // constructor recibe 2 parametros USER Y PASSWORD
  //si es conductor, traigo datos del carro que tenga activo
  //si solo es estudiante traigo datos
  //si no tiene carro activo traigo solo datos del estudiante
	class Users
	{
		private $user;
		private $car;

		public function getUser(){return $this->user;}
		public function setUser($value){ $this->user = $value;}
		public function getCar(){return $this->car;}
		public function setCar($value){ $this->car = $value;}

		function __construct($u, $p)
		{
			$connection = MySqlConnection::getConnection();
			$query = 'SELECT s.id, s.name, s.surName, s.secondSurName, s.email, s.cellPhone, u.id,u.name, c.id, c.name, c.status, st.id,
					st.name,st.status, u.latitude, u.longitude, u.status,s.controlNumber, s.latitude, s.longitude, s.photo, c.id, c.name,
					c.status, st.id,st.name, st.status, s.turn, s.status, p.id, p.name
					FROM students s JOIN universities_ctg u ON s.university = u.id JOIN cities_ctg c ON s.city = c.id
					JOIN states_ctg st ON c.state = st.id JOIN profiles_ctg p ON s.profile = p.id JOIN cities_ctg ci ON u.city = ci.id
					WHERE s.email = ?;';
			$command = $connection->prepare($query);
			$command->bind_param('s', $u);
			$command->execute();
			$command->bind_result($id, $name, $surnName, $secondSurName, $email, $cellPhone, $universityId, $universityName,
								$cityId, $cityName, $cityStatus, $stateId, $stateName, $stateStatus, $universityLt, $universityLg,
								$universityStatus, $controlNumber, $latitude, $longitude, $photo, $ctUnId, $ctUnName, $ctUnStts,
								$stUniId, $stUniName, $stUnSta, $turn, $status, $idProfile, $profileName);
			$found = $command->fetch();
			mysqli_stmt_close($command);
			$connection->close();
			if ($found) {
				$uState = new State($stUniId, $stUniName, $stUnSta);
				$uCity = new City($ctUnId, $ctUnName, $ctUnStts, $uState);
				$sState = new State($stateId, $stateName, $stateStatus);
				$university = new University($universityId, $universityName, $universityLt, $universityLg, $universityStatus, $uCity);
				$city = new City($cityId, $cityName, $cityStatus, $sState);
				$profile = new Profile($idProfile, $profileName);
				/*-------------------------*/
				$this->user = new Student($id,$name,$surnName,$secondSurName,$email,$cellPhone,$university,$controlNumber, $latitude,$longitude,$photo,$city,$turn,$status,$profile);
			}
			else {
				//throw exception if record not found
				throw new RecordNotFoundException();
			}
		}

		public function toJson() { return json_encode(array('usuario' => json_decode($this->user->toJson()))); }
	}
?>
