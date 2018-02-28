<?php

	//require_once('equestadistica.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/models/profile.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/models/student.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/models/location.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/models/mysqlconnection.php');

	/*
	$u = new profile('USE');
	echo $u->toJson();*/
	$u = new University('UTT');
	$su = new Student('a', 'b', 'c', '345544@miutt.edu.mx','664-211-22-43',$u,'011111111','32.410902', '-116.822555','default',1,0,'USE');
	if ($su->add()) {
		echo "Insercion";
	}else {
		echo "Nulo";
	}
?>

<!--
$connection = MySQLConnection::getConnection();
$query = "insert into students(name, surname, secondSurname, email, cellPhone, university, controlNumber,latitude, longitude, photo, city,turn, profile) values(?,?,?,?,?,?,?,?,?,?,?,?,?)"; // this query is empty
$command = $connection->prepare($query);
$command->bind_param('ssssssssssiiis',$this->name,$this->surname,$this->secondSurname,
	$this->email,$this->cellPhone,$this->university,$this->controlNumber,$this->location->getLatitude(),$this->location->getLongitude(),
	$this->photo,$this->city,$this->turn,$this->profile,$this->status);

	//Attributes
	private $id;
	private $name;
	private $surname; // this have a problem with name ?
	private $secondSurname; // SUR o USR NAME ?
	private $email;
	private $cellPhone;
	private $university;  // this variable is an object
	private $controlNumber;
	private $location; // this variable is an object
	private $photo;
	private $city; // this variable is an object
	private $turn;
	private $status;
	private $profile;  // this variable is an object

	public function getId(){ return $this->id; }
	public function setId($value){ $this->id = $value; }
	public function getProfile(){ return $this->profile; }
	public function setProfile($value){ $this->profile = $value; }
	public function getName(){ return $this->name; }
	public function setName($value){ $this->name = $value; }
	public function getEmail(){ return $this->email; }
	public function setEmail($value){ $this->email = $value; }
	public function getCellPhone(){ return $this->cellPhone; }
	public function setCellPhone($value){ $this->cellPhone = $value; }
	public function getUniversity(){ return $this->university; }
	public function setUniversity($value){ $this->university = $value; }
	public function getcontrolNumber(){ return $this->controlNumber; }
	public function setcontrolNumber($value){ $this->controlNumber = $value; }
	public function getLocation(){ return $this->location; }
	public function setLocation($value){ $this->location = $value; }
	public function getPhoto(){ return $this->photo; }
	public function setPhoto($value){ $this->photo = $value; }
	public function getCity(){ return $this->city; }
	public function setCity($value){ $this->city = $value; }
	public function getTurn(){ return $this->turn; }
	public function setTurn($value){ $this->turn = $value; }
	public function getStatus(){ return $this->status; }
	public function setStatus($value){ $this->status = $value; }
	public function getSurName(){ return $this->surname; }
	public function setSurName($value){ $this->surname = $value; }
	public function getSecondSurName(){ return $this->secondSurname; }
	public function setSecondSurName($value){ $this->secondSurname = $value; }

	function __construct()
	{
		if (func_num_args()==0)
		{
			$this->id = 0;
			$this->profile = new Profile();  // this variable is an object
			$this->name = '';
			$this->email = '';
			$this->cellPhone = '';
			$this->university = new University();  // this variable is an object
			$this->controlNumber = '';
			$this->location = new Location(); // this variable is an object
			$this->photo = '';
			$this->city = new City(); // this variable is an object
			$this->turn = 0;
			$this->status = 1;
			$this->surname = ''; // this have a problem with name ?
			$this->secondSurname = ''; // SUR o USR NAME ?
		}

		if (func_num_args()==1)
		{
			$id = func_get_arg(0);
			$connection = MySQLConnection::getConnection();
			$query = 'select id, name,surname, secondSurname, email, cellPhone, university, controlNumber, latitude, longitude, photo, city, turn, profile, status from students WHERE id = ?;';

			$command = $connection->prepare($query);
			$command->bind_param('i',$id);
			$command->execute();

			$command->bind_result($id, $name, $surname, $secondSurname, $email, $cellPhone, $university, $controlNumber, $latitude, $longitude, $photo, $city, $turn, $profile, $status);
			//$found->fetch();
			$found = $command->fetch();
			mysqli_stmt_close($command);
			$connection->close();
			if ($found)
			{
				$this->id = $id;
				$this->name = $name;
				$this->surname = $surname; // this have a problem with name ?
				$this->secondSurname = $secondSurname; // SUR o USR NAME ?
				$this->email = $email;
				$this->cellPhone = $cellPhone;
				$this->university = new University($university);  // this variable is an object
				$this->controlNumber = $controlNumber;
				$this->location = new Location($latitude,$longitude); // this variable is an object
				$this->photo = $photo;
				$this->city = new City($city); // this variable is an object
				$this->turn = $turn;
				$this->profile = new Profile($profile);  // this variable is an object
				$this->status = $state;
			}
			else
			{
				throw new RecordNotFoundException();
			}
		}

		if (func_num_args()==13)
		{
			$arguments = func_get_args();
			$this->name = $arguments[0];
			$this->surname = $arguments[1]; // this have a problem with name ?
			$this->secondSurname = $arguments[2]; // SUR o USR NAME ?
			$this->email = $arguments[3];
			$this->cellPhone = $arguments[4];
			$this->university = $arguments[5];  // this variable is an object
			$this->controlNumber = $arguments[6];
			$this->location = $arguments[7]; // this variable is an object
			$this->photo = $arguments[8];
			$this->city = $arguments[9]; // this variable is an object
			$this->turn = $arguments[10];
			$this->profile = $arguments[11];  // this variable is an object
			$this->status = $arguments[12];
		}
	} -->
