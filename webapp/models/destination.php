<?php
require_once('mysqlconnection.php');
require_once('exceptions/recordnotfoundexception.php');

class Destination{
	private $id;
	private $driver;
	private $university;
	private $timeArrivedSchool;

	public function getId(){ return $this->id; }
 	public function setId($value){ $this->id = $value; }
 	public function getDriver() { return $this->driver;}
 	public function setDriver($value){ $this->driver = $value; }
 	public function getUniversity(){ return $this->university;}
 	public function setUniversity($value){ $this->university = $value;}
 	public function getTimeArrivedSchool(){ return $this->timeArrivedSchool;}
 	public function setTimeArrivedSchool($value){ $this->timeArrivedSchool = $value; }

 	function __construct(){
 		if(func_num_args()==0){
 			$this->id = 0;
			$this->driver = new Student();
			$this->university = new University();
			$this->timeArrivedSchool = "";
 		}
 		if(func_num_args()==1){
 			$id = func_get_arg(0);
 			$connection = MySQLConnection::getConnection();
 			$query = 'select id, driver, university, timeArrivedSchool from destination where id = ?';
 			$command = $connection->prepare($query);
		    $command->bind_param('s',$id);
		    $command->execute();
		    $command->bind_result($id,$driver,$university,$timeArrivedSchool);
		    $found->fetch();
		    mysqli_stmt_close($command);
		    $connection->close();
		    if ($found)
		    {
		    	$this->id = $id;
				$this->driver = new Student($driver);
				$this->university = new University($university);
				$this->timeArrivedSchool = $timeArrivedSchool;
		    }
		    else{
		    	throw new RecordNotFoundException();
		    }
 		}
 		if(func_num_args()==4){
 			$arguments = func_get_args();
 			$this->id = $arguments[0];
 			$this->driver = $arguments[1];
 			$this->university = $arguments[2];
 			$this->timeArrivedSchool = $arguments[3];
 		}
 	}

 	public function add()
	{
	    $connection = MySQLConnection::getConnection();
	    $query = "insert into destination(driver, university, timeArrivedSchool) values(?,?,?);"; // this query is empty
	    $command = $connection->prepare($query);
	    $command->bind_param('dss', $this->driver->getId(),$this->university->getId(),$this->timeArrivedSchool); //this also is empty
	    $result = $command->execute();
	    mysqli_stmt_close($command);
	    $connection->close();
	    return $result;
	}
	public function put(){
		$connection = MySQLConnection::getConnection();
	  	$query ="update destination set driver = ?,university = ?, timeArrivedSchool = ?,  where id = ?;";
	  	$command = $connection->prepare($query);
	  	$command->bind_param('dssdsdd',$this->driver,$this->location->getLatitude(), $this->location->getLongitude(),$this->pay,$this->timeArrived,$this->status,$this->id);
	  	$result = $command->execute();
	  	mysqli_stmt_close($command);
		$connection->close();
		return $result;
	}
	public function delete() 
	{
		$connection = MySqlConnection::getConnection();
		$query = 'delete from destination where id = ?';
		$command = $connection->prepare($query);
		$command->bind_param('d', $this->id);
		$result = $command->execute();
		mysqli_stmt_close($command);
		$connection->close();
		return $result;
	}
	public function toJson(){
		return json_encode(array(
			'id' => $this->id,
			'driver' => $this->json_decode($this->driver->toJson()),
			'university' => $this->json_decode($this->university->toJson()),
			'timeArrivedSchool' => $this->timeArrivedSchool
		));
	}

}
?>