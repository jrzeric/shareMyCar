<?php

	require_once('mysqlconnection.php');
	require_once('exceptions/recordnotfoundexception.php');

	/**
	*  brand class
	*/
	class Brand
	{

		//Atributes
		private $id;
		private $name; 

		//Setter & Getters id
		public function getId() { return $this->id; }
		public function setId($value) { $this->id = $value; }

		//Setter & Getters Name
		public function getName() { return $this->name; }
		public function setName($value) { $this->name = $value; }


		function __construct()
		{
			if (func_num_args() == 0)
			{
				$this->id = '';
				$this->name = '';
			}//if

			//object with data from database
			if (func_num_args() == 1)
			{
				//get id
				$id = func_get_arg(0);
				//get connection
				$connection = MySQLConnection::getConnection();
				//query
				$query = 'select id, name from brands_ctg where id = ?';//the ? is a param
				//command
				$command = $connection->prepare($query);
				//params
				$command->bind_param('s', $id);//s for string and the variable for parameter
				//execute
				$command->execute();
				//bind results
				$command->bind_result($this->id, $this->name);//asign the results to the atributes
				//fetch
				$found = $command->fetch();
				//close command
				mysqli_stmt_close($command);
				//close connection
				$connection->close();
				//throw exception if record not found
				if (!$found) throw new RecordNotFoundException();
			}

			if (func_num_args() == 2) 
			{
				$arguments = func_get_args();
				$this->id = $arguments[0];
				$this->name = $arguments[1];
			}//if
		}//constructor


		//Methods
		// Represent the object in JSON format
		public function toJson()
		{
			return json_encode(array(
				'id' => $this->id,
				'name' => $this->name));
		}//toJson

		public static function getAll()
		{
			//list
			$list = array();
			$connection = MySQLConnection::getConnection();
			//query
			$query = 'select id, name from brands_ctg';
			//command
			$command = $connection->prepare($query);
			//execute
			$command->execute();
			//bind results
			$command->bind_result($id, $name);
			//fetch
			while ($command->fetch())
			{
				array_push($list, new Brand($id, $name));
			}
			//close statement
			mysqli_stmt_close($command);
			//close connection
			$connection->close();
			//return array
			return $list;
		}//getAll

		public static function getAllJson()
		{
			//list
			$list = array();
			//encode to json
			foreach (self::getAll() as $item) 
			{
				array_push($list, json_decode($item->toJson()));
			}//foreach
			return json_encode(array('brands' => $list));
		}


	}
?>