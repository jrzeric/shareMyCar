<?php

	require_once('mysqlconnection.php');
	require_once('brand.php');
	/**
	*	Class Model
	*/
	class Model
	{
		
		//Attributes
		private $id;
		private $name;
		private $brand;

		//Setters & Getter id
		public function getId() { return $this->id; }
		public function setId($value) { $this->id = $value; }

		//Setters & Getter Name
		public function getName() { return $this->name; }
		public function setName($value) { $this->id = $value; }

		//Setters & Getter Brand
		public function getBrand() { return $this->brand; }
		public function setBrand($value) { $this->brand = $value; }

		function __construct()
		{
			if (func_num_args() == 0)
			{
				$this->id = '';
				$this->name = '';
				$this->brand = new Brand();
			}//if

			//object with data from database
			if (func_num_args() == 1)
			{
				//get id
				$id = func_get_arg(0);
				//get connection
				$connection = MySQLConnection::getConnection();
				//query
				$query = 'select m.id, m.name, b.id, b.name 
							from models_ctg as m 
							inner join brands_ctg as b on b.id = m.brand
							where m.id = ?';//the ? is a param
				//command
				$command = $connection->prepare($query);
				//params
				$command->bind_param('d', $id);//s for string and the variable for parameter
				//execute
				$command->execute();
				//bind results
				$command->bind_result($id, $name, $idBrand, $nameBrand);//asign the results to the atributes
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
					$this->name = $name;
					$this->brand = new Brand($idBrand, $nameBrand);
				}
				else throw new RecordNotFoundException();
			}

			if (func_num_args() == 3) 
			{
				$arguments = func_get_args();
				$this->id = $arguments[0];
				$this->name = $arguments[1];
				$this->brand = new Brand($arguments[2]);
			}//if
		}//constructor

		//Methods
		public function toJson()
		{
			return json_encode(array(
				'id' => $this->id,
				'name' => $this->name,
				'brand' => json_decode($this->brand->toJson())
				));
		}//toJson

		public static function getAllM($id)
		{
			//list
			$list = array();
			$connection = MySQLConnection::getConnection();
			//query
			$query = 'select m.id, m.name, b.id
					from models_ctg as m
					inner join brands_ctg as b on b.id = m.brand
					where b.id = ?';
			//command
			$command = $connection->prepare($query);
			$command->bind_param('d', $id);//s for string and the variable for parameter
			//execute
			$command->execute();
			//bind results
			$command->bind_result($id, $name, $idBrand);
			//fetch
			while ($command->fetch())
			{
				array_push($list, new Model($id, $name, $idBrand));
			}
			//close statement
			mysqli_stmt_close($command);
			//close connection
			$connection->close();
			//return array
			return $list;
		}//getAll

		public static function getAllMJson($id)
		{
			//list
			$list = array();
			//encode to json
			foreach (self::getAllM($id) as $item) 
			{
				array_push($list, json_decode($item->toJson()));
			}//foreach
			return json_encode(array('models' => $list));
		}

	}

?>