<?php

	require_once('mysqlconnection.php');
	require_once('university.php');
	require_once('role.php');
	require_once('location.php');
	require_once('exceptions/recordnotfoundexception.php');
	/**
	*  Student Class
	*/
	class StudentPassenger
	{
		private $id;
		private $name;
		private $lastName;
		private $secondLastName;
		private $birthDate;
		private $email;
		private $cellphone;
		private $university;
		private $studentId;
		private $role;
		private $controlNumber;
		private $payAcount;
		private $location;


		//Setters & Getter id
		public function getId() { return $this->id; }

		//Setters & Getter Name
		public function getName() { return $this->name; }
		public function setName($value) { $this->name = $value; }

		//Setters & Getter Last Name
		public function getLastName() { return $this->lastName; }
		public function setLastName($value) { $this->lastName = $value; }

		//Setters & Getter Second Last Name
		public function getSecondLastName() { return $this->secondLastName; }
		public function setSecondLastName($value) { $this->secondLastName = $value; }

		//Setters & Getter birthDate
		public function getBirthDate() { return $this->birthDate; }
		public function setBirthDate($value) { $this->birthDate = $value; }

		//Setters & Getter email
		public function getEmail() { return $this->email; }
		public function setEmail($value) { $this->email = $value; }

		//Setters & Getter cellphone
		public function getCellphone() { return $this->cellphone; }
		public function setCellphone($value) { $this->cellphone = $value; }

		//Setters & Getter university
		public function getUniversity() { return $this->university; }
		public function setUniversity($value) { $this->university = $value; }

		//Setters & Getter Student
		public function getRole() { return $this->role; }
		public function setRole($value) { $this->role = $value; }

		//Setters & Getter Control Number
		public function getControlNumber() { return $this->controlNumber; }
		public function setControlNumber($value) { $this->controlNumber = $value; }

		//Setters & Getter Control Number
		public function getPayAccount() { return $this->payAcount; }
		public function setPayAccount($value) { $this->payAcount = $value; }

						//Setters & Getter Control Number
		public function getStudentId() { return $this->studentId; }
		public function setStudentId($value) { $this->studentId = $value; }

		public function getLocation() { return $this->location; }
		public function setLocation($value) { $this->location = $value; }



		function __construct()
		{

			if (func_num_args() == 0)
			{
				$this->id = 0;
				$this->name = '';
				$this->lastName = '';
				$this->secondLastName = '';
				$this->birthDate = '';
				$this->email = '';
				$this->cellphone = '';
				$this->university = new University();
				$this->role = new Role();
				$this->controlNumber = '';
				$this->payAcount = '';
			}//if

			//object with data from database
			if (func_num_args() == 1)
			{
				//get id
				$id = func_get_arg(0);
				//get connection
				$connection = MySQLConnection::getConnection();
				//query
				$query = "select id, profile, surname, secondSurname, name, birthDate, email, cellPhone, university, controlNumber, payAccount, latitude, longitude from students where id = ? and profile = 'P'";
				//command
				$command = $connection->prepare($query);
				//params
				$command->bind_param('i', $id);//s for string and the variable for parameter
				//execute

				$command->execute();
				//bind results
				$command->bind_result($id, $profile, $lastName, $secondLastName, $name, $birthDate, $email, $cellphone, $university, $controlNumber, $payAcount, $latitude, $longitude);//asign the results to the atributes
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
					$this->role = new Role($profile);
					$this->name = $name;
					$this->lastName = $lastName;
					$this->secondLastName = $secondLastName;
					$this->birthDate = $birthDate;
					$this->email = $email;
					$this->cellphone = $cellphone;
					$this->university = new University($university);
					$this->controlNumber = $controlNumber;
					$this->payAcount = $payAcount;
					$this->location = new Location($latitude, $longitude);
				}
				else
					throw new RecordNotFoundException();
			}

			if (func_num_args() == 13)
			{
				$arguments = func_get_args();
				$this->id = $arguments[0];
				$this->role = new Role($arguments[1]);
				$this->name = $arguments[2];
				$this->lastName = $arguments[3];
				$this->secondLastName = $arguments[4];
				$this->birthDate = $arguments[5];
				$this->email = $arguments[6];
				$this->cellphone = $arguments[7];
				$this->university = new University($arguments[8]);
				$this->controlNumber = $arguments[9];
				$this->payAcount = $arguments[10];
				$this->location = new Location($arguments[11], $arguments[12]);
			}//if

		}//Constructor

		//CRUD
		//add
		public function add()
		{
			//get connection
			$connection = MySQLConnection::getConnection();
			//query
			$query = "INSERT INTO students (profile, surname, secondSurname, name, birthDate, email, cellPhone, university, controlNumber, studentId, payAccount, status, latitude, longitude) VALUES ('P', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'UP', ?, ?);";
			//command
			$command = $connection->prepare($query);
			//parameters
			/*echo "INSERT INTO students (profile, surname, secondSurname, name, birthDate, email, cellPhone, university, controlNumber, studentId, payAccount, status) VALUES ('D',". $this->lastName .", ". $this->secondLastName .",".$this->name ."," .$this->birthDate .",".$this->email.",".$this->cellphone.",".$this->university->getId().",".$this->controlNumber.",".$this->studentId.",".$this->payAcount." 'UP');";*/
			$command->bind_param('ssssssdssddd', $this->lastName, $this->secondLastName, $this->name, $this->birthDate, $this->email, $this->cellphone, $this->university->getId(), $this->controlNumber, $this->studentId, $this->payAcount, $this->location->getLatitude(), $this->location->getLongitude());
			//execute
			$result = $command->execute();
			//close statement
			mysqli_stmt_close($command);
			//close connection
			$connection->close();
			//retunr result
			return $result;
		}//add

		//update
		public function update()
		{
			//get connection
			$connection = MySQLConnection::getConnection();
			//query
			$query = "UPDATE students SET surname = ?, secondSurname = ?, name = ?, birthDate = ?, email = ?, cellPhone = ?, university = ?, controlNumber = ?, studentId = ?, payAccount = ?, latitude = ?, longitude = ?  WHERE id = ?;";
			//command
			$command = $connection->prepare($query);
			//parameters
			/*echo "INSERT INTO students (profile, surname, secondSurname, name, birthDate, email, cellPhone, university, controlNumber, studentId, payAccount, status) VALUES ('D',". $this->lastName .", ". $this->secondLastName .",".$this->name ."," .$this->birthDate .",".$this->email.",".$this->cellphone.",".$this->university->getId().",".$this->controlNumber.",".$this->studentId.",".$this->payAcount." 'UP');";*/
			$command->bind_param('ssssssdssdddd', $this->lastName, $this->secondLastName, $this->name, $this->birthDate, $this->email, $this->cellphone, $this->university->getId(), $this->controlNumber, $this->studentId, $this->payAcount,$this->location->getLatitude(), $this->location->getLongitude(), $this->id);
			//execute
			$result = $command->execute();
			//close statement
			mysqli_stmt_close($command);
			//close connection
			$connection->close();
			//retunr result
			return $result;
		}//add

		//Methods
		public function toJson()
		{
			return json_encode(array(
				'id' => $this->id,
				'name' => $this->name,
				'role' => json_decode($this->role->toJson()),
				'lastName' => $this->lastName,
				'secondLastName' => $this->secondLastName,
				'birthDate' => $this->birthDate,
				'email' => $this->email,
				'cellphone' => $this->cellphone,
				'university' => json_decode($this->university->toJson()),
				'controlNumber' => $this->controlNumber,
				'location' => json_decode($this->location->toJson())
				));
		}//toJson
	}

?>
