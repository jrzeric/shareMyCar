<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/models/mysqlconnection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/models/exceptions/recordnotfoundexception.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/models/student.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/models/location.php');

class Spot{
		private $id;
		private $driver;
		private $location;
		private $pay;
		private $hour;
		private $day;
		private $status;

		public function getId(){return $this->id;}
		public function setId($value){$this->id = $value;}

		public function getDriver(){return $this->driver;}
		public function setDriver($value){$this->driver = $value;}

		public function getLocation(){return $this->location;}
		public function setLocation($value){$this->location = $value;}

		public function getPay(){return $this->pay;}
		public function setPay($value){$this->pay = $value;}

		public function getHour(){return $this->hour;}
		public function setHour($value){$this->hour = $value;}

		public function getDay(){return $this->day;}
		public function setDay($value){$this->day = $value;}

		public function getStatus(){return $this->status;}
		public function setStatus($value){$this->status = $value;}

		function __construct()
    {
			if(func_num_args()==0) {
				$this->id=0;
				$this->driver= new Student();
				$this->location= new Location();
				$this->pay= 0;
				$this->hour = '';
				$this->day='';
				$this->status=0;
			}
			if(func_num_args()==2) {
				$id = func_get_arg(0);
				$driver = func_get_arg(1);
				$connection = MySqlConnection::getConnection();
				$query = 'select id,driver,latitude,longitude,pay,hour,day,status from spots where id = ? and driver = ?';
				$command = $connection->prepare($query);
				$command->bind_param('dd', $id,$driver);
				$command->execute();
				$command->bind_result($id, $driver, $latitude, $longitude, $pay, $hour, $day, $status);
				$found = $command->fetch();
				mysqli_stmt_close($command);
				$connection->close();
				if ($found) {
					$this->id = $id;
					$this->driver = new Student($driver);
					$this->location = new Location($latitude,$longitude);
					$this->pay = $pay;
					$this->hour = $hour;
					$this->day = $day;
					$this->status = $status;
				} else {
					throw new RecordNotFoundException();
				}
			}
			if(func_num_args()==7) {
				$arguments = func_get_args();
				$this->id=$arguments[0];
				$this->driver= $arguments[1];
				$this->location= $arguments[2];
				$this->pay= $arguments[3];
				$this->hour = $arguments[4];
				$this->day=$arguments[5];
				$this->status=$arguments[6];
			}
		}

		public function add()
	  	{
		    $connection = MySQLConnection::getConnection();
		    $query = "insert into spots(driver,latitude, longitude, pay, hour, day) values(?,?,?,?,?,?);"; // this query is empty
		    $command = $connection->prepare($query);
		    $command->bind_param('dssdss',$this->driver->getId(),$this->location->getLatitude(), $this->location->getLongitude(),$this->pay,$this->hour,$this->day);
		    $result = $command->execute();
		    mysqli_stmt_close($command);
		    $connection->close();
		    return $result;
	  	}
	  	public function put()
      {
	  		$connection = MySQLConnection::getConnection();
	  		$query ="update spots set pay = ?,hour = ?, day = ? where id = ? and driver = ?;";
	  		$command = $connection->prepare($query);
	  		$command->bind_param('dssdd',$this->pay,$this->hour,$this->day,$this->id,$this->driver->getId());
	  		$result = $command->execute();
	  		mysqli_stmt_close($command);
		    $connection->close();
		    return $result;
	  	}
	  	public function delete()
      	{
			//get connection
			$connection = MySqlConnection::getConnection();
			//query
			$query = 'update spots set status = 0 where id = ? and driver = ?';
			//command
			$command = $connection->prepare($query);
			//bind parameters
			$command->bind_param('dd', $this->id,$this->driver->getId());
			//execute
			$result = $command->execute();
			//close command
			mysqli_stmt_close($command);
			//close connection
			$connection->close();
			//return result
			return $result;
		}

		public function toJson()
    	{
			return json_encode(array(
				'id' => $this->id,
				'driver'=> json_decode($this->driver->toJson()),
				'location'=> json_decode($this->location->toJson()),
				'pay' => $this->pay,
				'hour' => $this->hour,
				'day' => $this->day,
				'status' => $this->status
			));
		}
		//get all the stops that go to the same university
		public static function getSpotUniversity($universityid)
    	{
			$list = array();
			$connection = MySqlConnection::getConnection();
			$query = 'SELECT s.id, s.latitude, s.longitude, s.pay, s.hour, s.day,s.status, st.id,  st.name,  st.surname,  st.secondSurname, st.email, st.cellPhone, st.controlNumber, st.latitude, st.longitude, st.photo, st.turn,st.raiting, st.status,c.id,c.name,c.status,se.id,se.name,se.status,p.id,p.name from spots AS s JOIN students AS st ON s.driver = st.id JOIN cities_ctg AS c ON c.id = st.city JOIN states_ctg AS se ON se.id = c.state JOIN profiles_ctg AS p ON p.id = st.profile WHERE st.university = ?';
			$command = $connection->prepare($query);
			$command->bind_param('s',$universityid);
			$command->execute();
			$command->bind_result($id,$latitude,$longitude,$pay,$hour,$day,$status,$idst,$name,$surname,$secondSurname,$email,$cellPhone,$controlNumber,$latitudest,$longitudest,$photo,$turn,$raiting,$statusst,$cityid,$cName,$cStatus,$seid,$seName,$seStatus,$profileid,$pName);
			$university = new University($universityid);
			while ($command->fetch()) {
				$location = new Location($latitude, $longitude);
				/*----------------------------------------------------*/
				$state = new State($seid, $seName, $seStatus);
				$city = new City($cityid, $cName, $cStatus, $state);
				/*--------------------------------------------------------*/
				$locationst = new Location($latitudest, $longitudest);
				$profile = new Profile($profileid,$pName);
				$student = new Student($idst,$name,$surname,$secondSurname,$email,$cellPhone,$university,$controlNumber,$locationst,$photo,$city,$turn,$raiting,$statusst,$profile);
				array_push($list,new Spot($id,$student,$location,$pay,$hour,$day,$status));
			}
			mysqli_stmt_close($command);
			$connection->close();
			return $list;
		}

		public static function getSpotUniversityJson($university)
    	{
			//list
			$list = array();
			//get all
			foreach(self::getSpotUniversity($university) as $item) {
				array_push($list, json_decode($item->toJson()));
			}
			return json_encode(array(
				'Spots' => $list
			));
		}
		//get all the stops that belong to the chosen driver
		public static function getSpotDriver($driver)
    	{
			$list = array();
			$connection = MySqlConnection::getConnection();
			$query = 'SELECT s.id, s.latitude, s.longitude, s.pay, s.hour, s.day,s.status from spots AS s WHERE s.driver = ?';
			$command = $connection->prepare($query);
			$command->bind_param('d', $driver);
			$command->execute();
			$command->bind_result($id,$latitude,$longitude,$pay,$hour,$day,$status);
			$driver = new Student($driver);
			while ($command->fetch()) {
				$location = new Location($latitude, $longitude);
				array_push($list,new Spot($id,$driver,$location,$pay,$hour,$day,$status));
			}
			mysqli_stmt_close($command);
			$connection->close();
			return $list;
		}

		public static function getSpotDriverJson($driver)
    	{
			//list
			$list = array();
			//get all
			foreach(self::getSpotDriver($driver) as $item) {
				array_push($list, json_decode($item->toJson()));
			}
			return json_encode(array(
				'Spots' => $list
			));
		}

		public static function getSpotDriverByDay($driver, $day)
    	{
			$list = array();
			$connection = MySqlConnection::getConnection();
			$query = 'SELECT s.id, s.latitude, s.longitude, s.pay, s.hour, s.day,s.status from spots AS s WHERE s.driver = ? AND s.day = ? AND s.status = 1';
			$command = $connection->prepare($query);
			$command->bind_param('ds', $driver, $day);
			$command->execute();
			$command->bind_result($id,$latitude,$longitude,$pay,$hour,$day,$status);
			$driver = new Student($driver);
			while ($command->fetch()) {
				$location = new Location($latitude, $longitude);
				array_push($list,new Spot($id,$driver,$location,$pay,$hour,$day,$status));
			}
			mysqli_stmt_close($command);
			$connection->close();
			return $list;
		}

		public static function getSpotDriverByDayJson($driver, $day)
    	{
			//list
			$list = array();
			//get all
			foreach(self::getSpotDriverByDay($driver, $day) as $item) {
				array_push($list, json_decode($item->toJson()));
			}
			return json_encode(array(
				'Spots' => $list
			));
		}

		public static function getLastSpot()
    	{
			$list = array();
			$connection = MySqlConnection::getConnection();
			$query = 'SELECT s.id, s.driver, s.latitude, s.longitude, s.pay, s.hour, s.day,s.status from spots AS s ORDER by s.id desc WHERE s.status = 1';
			$command = $connection->prepare($query);
			$command->execute();
			$command->bind_result($id,$driver,$latitude,$longitude,$pay,$hour,$day,$status);
			$found = $command->fetch();
			mysqli_stmt_close($command);
			$connection->close();
			if ($found)
			{
				$driver = new Student($driver);
				$location = new Location($latitude,$longitude);
				$lastSpot = new Spot($id,$driver,$location,$pay,$hour,$day,$status);
			}
			else
				throw new RecordNotFoundException();
			return $lastSpot;
		}

	}
