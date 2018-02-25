<?php
require_once('mysqlconnection.php');
require_once('exceptions/recordnotfoundexception.php');

class Spot{
		private $id;
		private $driver;
		private $location;
		private $pay;
		private $timeArrived;
		private $status;

		public function getId(){return $this->id;}
		public function setId($value){$this->id = $value;}
		public function getDriver(){return $this->driver;}
		public function setDriver($value){$this->driver = $value;}
		public function getLocation(){return $this->location;}
		public function setLocation($value){$this->location = $value;}
		public function getPay(){return $this->pay;}
		public function setPay($value){$this->pay = $value;}
		public function getTimeArrived(){return $this->timeArrived;}
		public function setTimeArrived($value){$this->timeArrived = $value;}
		public function getStatus(){return $this->status;}
		public function setStatus($value){$this->status = $value;}

		function __construct(){
			if(func_num_args()==0){
				$this->id=0;
				$this->driver= new Student();
				$this->location= new Location();
				$this->pay= 0;
				$this->timeArrived='';
				$this->status=0;
			}
			if(func_num_args()==1){
				$id = func_get_arg(0);
				$connection = MySqlConnection::getConnection();
				$query = 'select id,driver,location,pay,timeArrived,status from spots where id = ?';
				$command = $connection->prepare($query);
				$command->bind_param('d', $id);
				$command->execute();
				$command->bind_result($id, $driver, $location, $pay, $timeArrived, $status);
				$found = $command->fetch();
				mysqli_stmt_close($command);
				$connection->close();
				if ($found) {
					$this->id = $id;
					$this->driver = new Student($driver);
					$this->location = new Location($location);
					$this->pay = $pay;
					$this->timeArrived = $timeArrived;
					$this->status = $status;
				}
				else {		
					throw new RecordNotFoundException();
				}
			}
			if(func_num_args()==6){
				$arguments = func_get_args();
				$this->id=$arguments[0];
				$this->driver= $arguments[1];
				$this->location= $arguments[2];
				$this->pay= $arguments[3];
				$this->timeArrived=$arguments[4];
				$this->status=$arguments[5];
			}
		}

		public function add()
	  	{
		    $connection = MySQLConnection::getConnection();
		    $query = "insert into spots(driver,latitude, longitude, pay, timeArrived) values(?,?,?,?,?,1);"; // this query is empty
		    $command = $connection->prepare($query);
		    $command->bind_param('dssds',$this->driver,$this->location->getLatitude(), $this->location->getLongitude(),$this->pay,$this->timeArrived);
		    $result = $command->execute();
		    mysqli_stmt_close($command);
		    $connection->close();
		    return $result;
	  	}
	  	public function put(){
	  		$connection = MySQLConnection::getConnection();
	  		$query ="update spots set driver = ?, latitude = ?, longitude = ?, pay = ?, timeArrived = ?, status = ? where id = ?;";
	  		$command = $connection->prepare($query);
	  		$command->bind_param('dssdsdd',$this->driver,$this->location->getLatitude(), $this->location->getLongitude(),$this->pay,$this->timeArrived,$this->status,$this->id);
	  		$result = $command->execute();
	  		mysqli_stmt_close($command);
		    $connection->close();
		    return $result;
	  	}
	  	public function delete() {
			//get connection
			$connection = MySqlConnection::getConnection();
			//query
			$query = 'delete from spots where id = ?';
			//command
			$command = $connection->prepare($query);
			//bind parameters
			$command->bind_param('d', $this->id);
			//execute
			$result = $command->execute();
			//close command
			mysqli_stmt_close($command);
			//close connection
			$connection->close();
			//return result
			return $result;
		}

		public function toJson(){
			return json_encode(array(
				'id' => $this->id,
				'driver'=>$this->json_decode($this->driver->toJson()),
				'location'=>$this->json_decode($this->location->toJson()),
				'pay' => $this->pay,
				'timeArrived' => $this->timeArrived,
				'status' => $this->spots
			));
		}

		public static function getAll($universityid) {
			$list = array();
			$connection = MySqlConnection::getConnection();
			$query = 'select s.id, s.latitude, s.longitude, s.pay, s.timeArrived,s.status st.id,  st.name,  st.surname,  st.secondSurname, st.email, st.cellPhone, st.university, st.controlNumber, st.latitude, st.longitude, st.photo, st.city, st.turn, st.profile, s.status from spots as s join students as st on s.driver = st.id where st.university = ?';
			$command = $connection->prepare($query);
			$command->bind_param('d', $universityid);
			$command->execute();
			$command->bind_result($id,$latitude,$longitude,$pay,$timeArrived,$status,$idst,$name,$surname,$secondSurname,$email,$cellPhone,$university,$controlNumber,$latitudest,$longitudest,$photo,$city,$turn,$profile,$statusst);
			while ($command->fetch()) {
				$location = new Location($latitude, $longitude);
				$locationst = new Location($latitudest, $longitudest);
				$student = new Student($idst,$name,$surname,$secondSurname,$email,$cellPhone,$university,$controlNumber,$locationst,$photo,$city,$turn,$profile,$statusst)
				array_push($list,new Spot($id,$student,$location,$pay,$timeArrived,$status));
			}
			mysqli_stmt_close($command);
			$connection->close();
			return $list;
		}

		public static function getAllJson() {
			//list
			$list = array();
			//get all
			foreach(self::getAll() as $item) {
				array_push($list, json_decode($item->toJson()));
			}
			return json_encode(array(
				'Spots' => $list
			));
		}
	}
?>