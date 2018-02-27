<?php
require_once('mysqlconnection.php');
require_once('exceptions/recordnotfoundexception.php');

class RidePassenger{
		private $id;
		private $spot;
		private $passenger;
		private $timeArrivedDrive;
		private $timeFinish;
		private $calificationPass;
		private $calificationDriv;

		public function getId(){return $this->id;}
		public function setId($value){$this->id = $value;}
		public function getSpot(){return $this->spot;}
		public function setSpot($value){$this->spot = $value;}
		public function getPassenger(){return $this->passenger;}
		public function setPassenger($value){$this->passenger = $value;}
		public function getTimeArrivedDrive(){return $this->timeArrivedDrive;}
		public function setTimeArrivedDrive($value){$this->timeArrivedDrive = $value;}
		public function getTimeFinish(){return $this->timeFinish;}
		public function setTimeFinish($value){$this->timeFinish = $value;}
		public function getCalificationPass(){return $this->calificationPass;}
		public function setCalificationPass($value){$this->calificationPass = $value;}
		public function getCalificationDriv(){return $this->calificationDriv;}
		public function setCalificationDriv($value){$this->calificationDriv = $value;}

		function __construct(){
			if(func_num_args()==0){
				$this->id=0;
				$this->spot= new Spot();
				$this->passenger= new Student();
				$this->timeArrivedDrive = '';
				$this->timeFinish= '';
				$this->calificationPass= 0;
				$this->calificationDriv = 0;
			}
			if(func_num_args()==1){
				$id = func_get_arg(0);
				$connection = MySqlConnection::getConnection();
				$query = 'SELECT id , spot, passenger, timeArrived, timeFinish, calificationPass, calificationDriv FROM ride WHERE id = ?;';
				$command = $connection->prepare($query);
				$command->bind_param('i', $id);
				$command->execute();
				$command->bind_result($id, $spot, $passenger, $timeArrivedDrive, $timeFinish, $calificationPass, $calificationDriv);
				$found = $command->fetch();
				mysqli_stmt_close($command);
				$connection->close();
				if ($found) {
					$this->id = $id;
					$this->spot = new Spot($spot);
					$this->passenger = new Student($passenger);
					$this->timeArrivedDrive = $timeArrivedDrive;
					$this->timeFinish = $timeFinish;
					$this->calificationPass = $calificationPass;
					$this->calificationDriv = $calificationDriv;
				}
				else {
					throw new RecordNotFoundException();
				}
			}
			if(func_num_args()==7){
				$arguments = func_get_args();
				$this->id = $arguments[0];
				$this->spot=$arguments[1];
				$this->passenger= $arguments[2];
				$this->timeArrivedDrive= $arguments[3];
				$this->timeFinish= $arguments[4];
				$this->calificationPass = $arguments[5];
				$this->calificationDriv = $arguments[6];
			}
		}

		public function add()
	  	{
		    $connection = MySQLConnection::getConnection();
		    $query = "INSERT INTO ride(spot, passenger, timeArrived, timeFinish,calificationPass,calificationDriv);";
		    $command = $connection->prepare($query);
		    $command->bind_param('ddssdd',$this->spot->getId(),$this->passenger->getId(),$this->timeArrivedDrive,$this->timeFinish,$this->calificationPass,$this->calificationDriv);
		    $result = $command->execute();
		    mysqli_stmt_close($command);
		    $connection->close();
		    return $result;
	  	}
	  	public function put(){
	  		$connection = MySQLConnection::getConnection();
	  		$query ="UPDATE ride SET timeArrived =?, timeFinish =?, calificationPass =?, calificationDriv =? WHERE id =? AND spot =? AND passenger =?; ";
	  		$command = $connection->prepare($query);
	  		$command->bind_param('ssddddd',$this->timeArrivedDrive, $this->timeFinish, $this->calificationPass, $this->calificationDriv, $this->id, $this->spot->getId(), $this->passenger->getId());
	  		$result = $command->execute();
	  		mysqli_stmt_close($command);
		    $connection->close();
		    return $result;
	  	}
	  	public function delete() {
			//get connection
			$connection = MySqlConnection::getConnection();
			//query
			$query = 'DELETE FROM ride WHERE spot = ? AND passenger = ?;';
			//command
			$command = $connection->prepare($query);
			//bind parameters
			$command->bind_param('dd', $this->spot->getId(),$this->passenger->getId());
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
				'spot' => $this->json_decode($this->spot->toJson()),
				'passenger'=>$this->json_decode($this->passenger->toJson()),
				'timeArrived'=>$this->timeArrivedDrive,
				'timeFinish' => $this->timeFinish,
				'calificationPass' => $this->calificationPass,
				'calificationDriv' => $this->calificationDriv
			));
		}

		public static function getAll() {
			$list = array();
			$connection = MySqlConnection::getConnection();
			$query = 'SELECT id, spot, passenger, timeArrived, timeFinish, calificationPass, calificationDriv FROM ride;';
			$command = $connection->prepare($query);
			$command->execute();
			$command->bind_result($id,$spot,$passenger,$timeArrivedDrive,$timeFinish,$calificationPass,$calificationDriv);
			while ($command->fetch())
			{
				array_push($list, new RidePassenger($id,new Spot($spot),new Student($passenger),$timeArrivedDrive,$timeFinish,$calificationPass,$calificationDriv));
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
			return json_encode(array(	'RidePassenger' => $list));
		}
	}
?>
