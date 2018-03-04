<?php

	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/mysqlconnection.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/reportOption.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/student.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/exceptions/recordnotfoundexception.php');

	class Report{
		
		//Attributes
		private $id;
		private $dateOfReport;
		private $ride;
		private $whoReport;
		private $status;
		private $option;
		
		//Setters and getters
		public function getId() { return $this->id; }
		public function setId($value) { $this->id = $value; }		
		public function getDateOfReport() { return $this->dateOfReport; }
		public function setDateOfReport($value) { $this->dateOfReport = $value; }
		public function getRide() { return $this->ride; }
		public function setRide($value) { $this->ride = $value; }
		public function getWhoReport() { return $this->whoReport; }
		public function setWhoReport($value) { $this->whoReport = $value; }
		public function getStatus() { return $this->status; }
		public function setStatus($value) { $this->status = $value; }
		public function getOption() { return $this->option; }
		public function setOption($value) { $this->option = $value; }
		
		//constructors
		public function __construct() {
			//empty object
			if (func_num_args() == 0) {
				$this->id = 0;
				$this->dateOfReport = '';
				$this->ride = 0;
				$this->status = '';
				$this->whoReport = new Student();
				$this->option = new ReportOption();
			}
			//object with data from database
			if (func_num_args() == 1) {
				//get id
				$id = func_get_arg(0);
				//get connection
				$connection = MySqlConnection::getConnection();
				//query
				$query = 'SELECT r.id, r.dateOfReport, r.ride, r.status, ro.id idOption, ro.description, s.id, s.name, s.surname, s.secondSurname
						FROM reports r JOIN reportoption ro 
						ON r.reportoption = ro.id JOIN students s ON r.whoReport = s.id WHERE r.id = ?';
				//command
				$command = $connection->prepare($query);
				//bind parameters
				$command->bind_param('i', $id);
				//execute
				$command->execute();
				//bind results
				$command->bind_result($id, $dateOfReport, $ride, $status, $optionId, $description, $studentId, $name, $surname, $secondSurname);
				//fetch data
				$found = $command->fetch();
				//close command
				mysqli_stmt_close($command);
				//close connection
				$connection->close();
				//pass values to the attributes
				if ($found) {
					$this->id = $id;
					$this->dateOfReport = $dateOfReport;
					$this->ride = $ride;
					$this->status = $status;
					$this->option = new ReportOption($optionId, $description);	
					$this->whoReport = new Student($studentId, $name, $surname, $secondSurname);
				}
				else {		
					//throw exception if record not found
					throw new RecordNotFoundException();
				}
			}
			//object with data from arguments
			if (func_num_args() == 6) {
				//get arguments
				$arguments = func_get_args();
				//pass arguments to attributes
				$this->id = $arguments[0];
				$this->dateOfReport = $dateOfReport[1];
				$this->ride = $ride[2];
				$this->whoReport = $whoReport[3];
				$this->status = $status[4];
				$this->option = $option[5];
			}
		}
		
		//instance methods
			
		//add
		public function add() {
			//get connection
			$connection = MySqlConnection::getConnection();
			//query
			$query = 'insert into report (id, dateOfReport, ride, whoReport, status, reportoption) VALUES (?, ?, ?, ?, ?, ?)';
			//command
			$command = $connection->prepare($query);
			//bind parameters
			$command->bind_param('isissi', $this->id, $this->dateOfReport, $this->ride, $this->whoReport->getid(), $this->status, $this->option->getId());
			//execute
			$result = $command->execute();
			//close command
			mysqli_stmt_close($command);
			//close connection
			$connection->close();
			//return result
			return $result;
		}
		
		//edit
		public function edit() {
			//get connection
			$connection = MySqlConnection::getConnection();
			//query
			$query = 'Update report set dateOfReport = ?, ride = ?, whoReport = ?, status = ? reportOption = ? Where id = ?';
			//command
			$command = $connection->prepare($query);
			//bind parameters
			$command->bind_param('sissii',
				$this->dateOfReport,
				$this->ride,
				$this->whoReport->getId(),
				$this->status,
				$this->option->getId(),
				$this->id);
			//execute
			$result = $command->execute();
			//close command
			mysqli_stmt_close($command);
			//close connection
			$connection->close();
			//return result
			return $result;
		}
		
		//represents the object in JSON format
		public function toJson() {
			return json_encode(array(
				'id' => $this->id,
				'dateOfReport' => $this->dateOfReport,
				'ride' => $this->ride,
				'status' => $this->status,
				'whoReport' => json_decode($this->whoReport->toJson()),
				'reportOption' => json_decode($this->option->toJson())
			));
		}
		
		//get all
		public static function getAll() {
			//list
			$list = array();
			//get connection
			$connection = MySqlConnection::getConnection();
			//query
			$query = 'SELECT r.id, r.dateOfReport, r.ride, r.status, ro.id idOption, ro.description, r.whoReport, s.id, s.name, s.surname, s.secondSurname
					FROM reports r JOIN reportoption ro 
					ON r.reportoption = ro.id JOIN students s ON r.whoReport = s.id';
			//command
			$command = $connection->prepare($query);
			//execute
			$command->execute();
			//bind results
			$command->bind_result($id, $dateOfReport, $ride, $status, $option, $description, $whoReport, $studentId, $name, $surname, $secondSurname);
			//fetch data
			while ($command->fetch()) {
				$option = new ReportOption($idOption, $description);
				$whoReport = new Student($studentId, $name, $surname, $secondSurname);
				array_push($list, new Report($id, $dateOfReport, $ride, $whoReport, $status, $option));
			}
			//close command
			mysqli_stmt_close($command);
			//close connection
			$connection->close();
			//return list
			return $list;
		}
		
		//get all in JSON format
		public static function getAllJson() {
			//list
			$list = array();
			//get all
			foreach(self::getAll() as $item) {
				array_push($list, json_decode($item->toJson()));
			}
			//return json encoded array
			return json_encode(array(
				'reports' => $list
			));
		}
	}
?>