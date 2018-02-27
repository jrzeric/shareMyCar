<?php
require_once('mysqlconnection.php');
require_once('exceptions/recordnotfoundexception.php');

class RidePassenger{
		private $spot;
		private $passenger;
		private $destination;
		private $picked;
		private $timeArrivedDrive;
		private $status;

		public function getSpot(){return $this->spot;}
		public function setSpot($value){$this->spot = $value;}
		public function getPassenger(){return $this->passenger;}
		public function setPassenger($value){$this->passenger = $value;}
		public function getDestination(){return $this->destination;}
		public function setDestination($value){$this->destination = $value;}
		public function getPicked(){return $this->picked;}
		public function setPicked($value){$this->picked = $value;}
		public function getTimeArrivedDrive(){return $this->timeArrivedDrive;}
		public function setTimeArrivedDrive($value){$this->timeArrivedDrive = $value;}
		public function getStatus(){return $this->status;}
		public function setStatus($value){$this->status = $value;}

		function __construct(){
			if(func_num_args()==0){
				$this->spot= new Spot();
				$this->passenger= new Student();
				$this->destination= new Destination();
				$this->picked= '';
				$this->timeArrivedDrive = '';
				$this->status = 0;
			}
			if(func_num_args()==1){
				$spot = func_get_arg(0);
				$connection = MySqlConnection::getConnection();
				$query = 'SELECT spot, passenger, destination, picked_at, timeArrivedDrive, status FROM ridePassenger WHERE spot = ?';
				$command = $connection->prepare($query);
				$command->bind_param('i', $spot);
				$command->execute();
				$command->bind_result($spot, $passenger, $destination, $picked,$timeArrivedDrive,$status);
				$found = $command->fetch();
				mysqli_stmt_close($command);
				$connection->close();
				if ($found) {
					$this->spot = new Spot($spot);
					$this->passenger = new Student($passenger);
					$this->destination = new Destination($destination);
					$this->picked = $picked;
					$this->$timeArrivedDrive = $timeArrivedDrive;
					$this->status = $status;
				}
				else {
					throw new RecordNotFoundException();
				}
			}
			if(func_num_args()==6){
				$arguments = func_get_args();
				$this->spot=$arguments[0];
				$this->passenger= $arguments[1];
				$this->destination= $arguments[2];
				$this->picked= $arguments[3];
				$this->timeArrivedDrive = $arguments[4];
				$this->status = $arguments[5];
			}
		}

		public function add()
	  	{
		    $connection = MySQLConnection::getConnection();
		    $query = "INSERT INTO ridePassenger(spot, passenger, destination, picked_at, timeArrivedDriver) VALUES(?,?,?,?,?);";
		    $command = $connection->prepare($query);
		    $command->bind_param('dddss',$this->spot->getId(),$this->passenger->getId(),$this->destination->getId(),$this->picked,$this->timeArrivedDrive);
		    $result = $command->execute();
		    mysqli_stmt_close($command);
		    $connection->close();
		    return $result;
	  	}
	  	public function put(){
	  		$connection = MySQLConnection::getConnection();
	  		$query ="UPDATE ridePassenger SET destination = ?, picked_at = ?, timeArrivedDriver = ? WHERE spot = ? AND passenger = ?; ";
	  		$command = $connection->prepare($query);
	  		$command->bind_param('dssdd',$this->destination->getId(),$this->picked,$this->timeArrivedDrive,$this->spot->getId(),$this->passenger->getId());
	  		$result = $command->execute();
	  		mysqli_stmt_close($command);
		    $connection->close();
		    return $result;
	  	}
	  	public function delete() {
			//get connection
			$connection = MySqlConnection::getConnection();
			//query
			$query = 'UPDATE ridePassenger SET status = 0 WHERE spot = ? and passenger = ?;';
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
				'spot' => $this->json_decode($this->spot->toJson()),
				'passenger'=>$this->json_decode($this->passenger->toJson()),
				'destination'=>$this->json_decode($this->destination->toJson()),
				'picked' => $this->picked,
				'timeArrivedDrive' => $this->timeArrivedDrive,
				'status' => $this->status
			));
		}

		public static function getAll() {
			$list = array();
			$connection = MySqlConnection::getConnection();
			$query = 'SELECT spot, passenger, destination, picked_at, timeArrivedDriver, status FROM ridePassenger;';
			$command = $connection->prepare($query);
			$command->execute();
			$command->bind_result($spot,$passenger,$destination,$picked,$timeArrivedDrive,$status);
			while ($command->fetch())
			{
				array_push($list, new RidePassenger(new Spot($spot),new Student($passenger),new Destination($destination),$picked,$timeArrivedDrive,$status));
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
