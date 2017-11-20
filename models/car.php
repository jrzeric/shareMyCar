<?php

	require_once('mysqlconnection.php');
	require_once('brand.php');
	require_once('model.php');
	require_once('exceptions/recordnotfoundexception.php');

	/**
	*  Car Class
	*/
	class Car
	{

		private $brand;
		private $model;
		private $year;
		private $licensePlate;
		private $driverLicense;

		//Setters & Getter brand
		public function getBrand() { return $this->brand; }
		public function setBrand($value) { $this->brand = $value; }

		//Setters & Getter model
		public function getModel() { return $this->model; }
		public function setModel($value) { $this->model = $value; }

		//Setters & Getter year
		public function getYear() { return $this->year; }
		public function setYear($value) { $this->year = $value; }

		//Setters & Getter licensePlate
		public function getLicensePlate() { return $this->licensePlate; }
		public function setLicensePlate($value) { $this->licensePlate = $value; }

		//Setters & Getter driverLicense
		public function getDriverLicense() { return $this->driverLicense; }
		public function setDriverLicense($value) { $this->driverLicense = $value; }

		function __construct()
		{
			if (func_num_args() == 0)
			{
				$this->brand = new Brand();
				$this->model = new Model();
				$this->year = '';
				$this->licensePlate = '';
				$this->driverLicense = '';
			}//if

			//object with data from database
			if (func_num_args() == 1)
			{
				//get id
				$id = func_get_arg(0);
				//get connection
				$connection = MySQLConnection::getConnection();
				//query
				$query = 'select brand, MODEL, year, licensePlate, driverLicense from cars where driver = ?';//the ? is a param
				//command
				$command = $connection->prepare($query);
				//params
				$command->bind_param('i', $id);//s for string and the variable for parameter
				//execute
				$command->execute();
				//bind results
				$command->bind_result($brand, $model, $year, $licensePlate, $driverLicense);//asign the results to the atributes
				//fetch
				$found = $command->fetch();
				//close command
				mysqli_stmt_close($command);
				//close connection
				$connection->close();
				echo $model."--";
				//throw exception if record not found
				if ($found)
				{echo "n..n";
					$this->brand = new Brand($brand);
					$this->model = new Model($model);
					$this->year = $year;
					$this->licensePlate = $licensePlate;
					$this->driverLicense = $driverLicense;
				}
				else
					throw new RecordNotFoundException();
			}

			if (func_num_args() == 5)
			{
				$arguments = func_get_args();
				$this->brand = new Brand($arguments[0]);
				$this->model = new Model($arguments[1]);
				$this->year = $arguments[2];
				$this->licensePlate = $arguments[3];
				$this->driverLicense = $arguments[4];
			}//if
		}//constructor

		//Methods
		// Represent the object in JSON format
		public function toJson()
		{
			return json_encode(array(
				'brand' => json_decode($this->brand->toJson()),
				'model' => json_decode($this->model->toJson()),
				'year' => $this->year,
				'licensePlate' => $this->licensePlate,
				'driverLicense' => $this->driverLicense));
		}//toJson

		public function add()
		{
			$connection = MySQLConnection::getConnection();
			//close connection
			$id = $this->getLastId();
			$query = "INSERT INTO cars (driver, brand, MODEL, year, licensePlate, driverLicense, created_at, validated_by) VALUES (?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP, '1');";
			//command
			$command = $connection->prepare($query);
			//parameters
			$command->bind_param('dddsss', $id, $this->brand->getId(), $this->model->getId(), $this->year, $this->licensePlate, $this->driverLicense);
			//execute
			$result = $command->execute();
			//close statement
			mysqli_stmt_close($command);
			//close connection
			$connection->close();
			//retunr result
			return $result;
		}

		public function getLastId()
		{
			//get connection
			$connection = MySQLConnection::getConnection();
			//query
			$query = 'select id from students ORDER by id DESC limit 1';//the ? is a param
			//command
			$command = $connection->prepare($query);
			$command->execute();
			//bind results
			$command->bind_result($id);//asign the results to the atributes
			//fetch
			$found = $command->fetch();
			//close command
			mysqli_stmt_close($command);
			//close connection
			$connection->close();
			$lastId = $id;
			return $lastId;
		}



	}
?>
