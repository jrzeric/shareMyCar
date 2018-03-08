<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/mysqlconnection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/exceptions/recordnotfoundexception.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/student.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/spot.php');

class Ride{
		private $id;
		private $spot;
		private $passenger;
		private $timeArrived;
		private $timeFinish;
		private $calificationPass;
		private $calificationDriv;
		private $status;

		public function getId(){return $this->id;}
		public function setId($value){$this->id = $value;}
		public function getSpot(){return $this->spot;}
		public function setSpot($value){$this->spot = $value;}
		public function getPassenger(){return $this->passenger;}
		public function setPassenger($value){$this->passenger = $value;}
		public function getTimeArrived(){return $this->timeArrived;}
		public function setTimeArrived($value){$this->timeArrived = $value;}
		public function getTimeFinish(){return $this->timeFinish;}
		public function setTimeFinish($value){$this->timeFinish = $value;}
		public function getCalificationPass(){return $this->calificationPass;}
		public function setCalificationPass($value){$this->calificationPass = $value;}
		public function getcalificationDriv(){return $this->calificationDriv;}
		public function setcalificationDriv($value){$this->calificationDriv = $value;}
		public function getStatus(){return $this->status;}
		public function setStatus($value){$this->status = $value;}

		function __construct(){
			if(func_num_args()==0){
				$this->id = 0;
				$this->spot= new Spot();
				$this->passenger= new Student();
				$this->timeArrived= '';
				$this->timeFinish= '';
				$this->calificationPass = 0;
				$this->calificationDriv = 0;
				$this->status = 0;
			}
			if(func_num_args()==3){
				$id = func_get_arg(0)
				$spot = func_get_arg(1);
				$passenger = func_get_arg(2);
				$connection = MySqlConnection::getConnection();
				$query = 'select id,spot,passenger,timeArrived,timeFinish,calificationPass,calificationDriv,status from ride where id = ? and spot = ? and passenger = ?';
				$command = $connection->prepare($query);
				$command->bind_param('ddd', $id,$spot,$passenger);
				$command->execute();
				$command->bind_result($id, $spot, $passenger, $timeArrived, $timeFinish, $calificationPass, $calificationDriv, $status);
				$found = $command->fetch();
				mysqli_stmt_close($command);
				$connection->close();
				if ($found) {
					$this->id = $id;
					$this->spot = new Spot($spot);
					$this->passenger = new Student($passenger);
					$this->timeArrived = $timeArrived;
					$this->timeFinish = $timeFinish;
					$this->$calificationPass = $calificationPass;
					$this->calificationDriv = $calificationDriv;
					$this->status = $status;
				}
				else {		
					throw new RecordNotFoundException();
				}
			}
			if(func_num_args()==8){
				$arguments = func_get_args();
				$this->id=$arguments[0];
				$this->spot=$arguments[1];
				$this->passenger= $arguments[2];
				$this->timeArrived= $arguments[3];
				$this->timeFinish= $arguments[4];
				$this->calificationPass = $arguments[5];
				$this->calificationDriv = $arguments[6];
				$this->status = $arguments[7];
			}
		}

		public function add()
	  	{
		    $connection = MySQLConnection::getConnection();
		    $query = "insert into ride(spot, passenger,timeArrived, timeFinish, calificationPass, calificationDriv) values(?,?,null,null,null)";
		    $command = $connection->prepare($query);
		    $command->bind_param('dd',$this->spot->getId(),$this->passenger->getId()); 
		    $result = $command->execute();
		    mysqli_stmt_close($command);
		    $connection->close();
		    return $result;
	  	}
	  	public function put(){
	  		$connection = MySQLConnection::getConnection();
	  		$query ="update ride set timeArrived = ?, timeFinish = ?, calificationPass = ?, calificationDriv = ?, status = ? where id = ? and spot = ? and passenger = ?; ";
	  		$command = $connection->prepare($query);
	  		$command->bind_param('ssddddd',$this->timeArrived,$this->timeFinish,$this->calificationPass,$this->calificationDriv,$this->status,$this->id,$this->spot->getId(),$this->passenger->getId());
	  		$result = $command->execute();
	  		mysqli_stmt_close($command);
		    $connection->close();
		    return $result;
	  	}
	  	public function delete() {
			//get connection
			$connection = MySqlConnection::getConnection();
			//query
			$query = 'update ride set status = 2 where id = ?, spot = ?, passenger = ?';
			//command
			$command = $connection->prepare($query);
			//bind parameters
			$command->bind_param('ddd', $this->spot);
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
				'spot' => json_decode($this->spot->toJson()),
				'passenger'=> json_decode($this->passenger->toJson()),
				'timeArrived'=>$this->timeArrived,
				'timeFinish' => $this->timeFinish,
				'calificationPass' => $this->calificationPass,
				'calificationDriv' => $this->calificationDriv,
				'status' => $this->status
			));
		}

		public static function getRidePassenger($passengerid) {
			$list = array();
			$connection = MySqlConnection::getConnection();
			$query = 'select r.id,r.timeArrived,r.timeFinish,r.calificationPass,r.calificationDriv,r.status,s.id, s.latitude, s.longitude, s.pay, s.hour, s.day,s.status, st.id,  st.name,  st.surname,  st.secondSurname, st.email, st.cellPhone, st.controlNumber, st.latitude, st.longitude, st.photo, st.turn,st.raiting, st.status,c.id,c.name,c.status,se.id,se.name,se.status,p.id,p.name from ride as r JOIN spots AS s ON r.spot= s.id JOIN students AS st ON s.driver = st.id JOIN cities_ctg AS c ON c.id = st.city JOIN states_ctg AS se ON se.id = c.state JOIN profiles_ctg AS p ON p.id = st.profile where r.passenger = ? and r.status = 0';
			$command = $connection->prepare($query);
			$command->bind_param('d', $passengerid);
			$command->execute();
			$command->bind_result($id,$timeArrived,$timeFinish,$calificationPass,$calificationDriv,$status,$spotid,$latitude,$longitude,$pay,$hour,$day,$statuss,$idst,$name,$surname,$secondSurname,$email,$cellPhone,$controlNumber,$latitudest,$longitudest,$photo,$turn,$raiting,$statusst,$cityid,$cName,$cStatus,$seid,$seName,$seStatus,$profileid,$pName);
			$passenger = new Student($passengerid);
			while ($command->fetch()) {
				$location = new Location($latitude, $longitude);
				/*----------------------------------------------------*/
				$state = new State($seid, $seName, $seStatus);
				$city = new City($cityid, $cName, $cStatus, $state);
				/*--------------------------------------------------------*/
				$locationst = new Location($latitudest, $longitudest);
				$profile = new Profile($profileid,$pName);
				$driver = new Student($idst,$name,$surname,$secondSurname,$email,$cellPhone,$university,$controlNumber,$locationst,$photo,$city,$turn,$raiting,$statusst,$profile);
				$spot = new Spot($spotid,$driver,$location,$pay,$hour,$day,$statuss)
				array_push($list,new Ride($id,$spot,$passenger,$timeArrived,$timeFinish,$calificationPass,$calificationDriv));
			}
			mysqli_stmt_close($command);
			$connection->close();
			return $list;
		}

		public static function getRidePassengerJson($passenger) {
			//list
			$list = array();
			//get all
			foreach(self::getRidePassenger($passenger) as $item) {
				array_push($list, json_decode($item->toJson()));
			}
			return json_encode(array(
				'Rides' => $list
			));
		}
	}
?>