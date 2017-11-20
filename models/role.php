<?php
	/**
	* 
	*/
	class Role
	{
		
		private $id;
		private $name;

		//getters & setters id
		public function getId() { return $this->id; }
		public function setId($value) { $this->id = $value; }

		//getters & setters name
		public function getName() { return $this->name; }
		public function setName($value) { $this->name = $value; }

		function __construct()
		{
						//empty object
			if(func_num_args() == 0)
			{
				$this->id = 0;
				$this->description = "";

			}//if

			//object with data from database
			if (func_num_args() == 1)
			{
				//get id
				$id = func_get_arg(0);
				//get connection
				$connection = MySQLConnection::getConnection();
				//query
				$query = 'select code, name from profiles_ctg where code = ?';//the ? is a param
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

			if(func_num_args() == 2)
			{
				//get arguments
				$arguments = func_get_args();
				//pass values to the atributes from the array
				$this->id = $arguments[0];
				$this->name = $arguments[1];
			}//if	
		}//constructor

		public function toJson()
		{
			return json_encode(array(
				'id' => $this->id,
				'name' => $this->name));
		}//toJSON

	}
?>