<?php

	require_once('mysqlconnection.php');
	require_once('exceptions/invaliduserexception.php');
	
	/**
	*  User Class
	*/
	class User
	{

		private $iduser;
		private $password;
		private $email;


		//Setters & Getter brand
		public function getIdUser() { return $this->iduser; }
		public function setIdUser($value) { $this->iduser = $value; }

		//Setters & Getter model
		public function getPassword() { return $this->password; }
		public function setPassword($value) { $this->password = $value; }

		//Setters & Getter model
		public function getEmail() { return $this->email; }
		public function setEmail($value) { $this->email = $value; }

		function __construct()
		{
			if (func_num_args() == 0)
			{
				$this->iduser = '';
				$this->password = '';
				$this->email = '';

			}//if

			//object with data from database
			if (func_num_args() == 2)
			{
				//get id
				$email = func_get_arg(0);
				$pass = func_get_arg(1);
				//get connection
				$connection = MySQLConnection::getConnection();
				//query
				$query = 'select s.email, s.id from students as s 
							inner join users as u on s.id = u.student
							where s.email = ? AND u.password = sha1(?)';//the ? is a param
				//command
				$command = $connection->prepare($query);
				//params
				$command->bind_param('ss', $email, $pass);//s for string and the variable for parameter
				//execute
				$command->execute();
				//bind results
				$command->bind_result($this->email, $this->iduser);//asign the results to the atributes
				//fetch
				$found = $command->fetch();
				//close command
				mysqli_stmt_close($command);
				//close connection
				$connection->close();
				//throw exception if record not found
				if (!$found) throw new InvalidUserException($email);;
			}
		}//constructor

		//Methods
		// Represent the object in JSON format
		public function toJson()
		{
			return json_encode(array(
				'email' => $this->email,
				'id' => $this->iduser));
		}//toJson

		public function add()
		{
			$connection = MySQLConnection::getConnection();
			//close connection
			$id = $this->getLastId();
			$query = "INSERT INTO users (student, PASSWORD) VALUES (?, SHA1(?));";
			//command
			$command = $connection->prepare($query);
			//parameters
			$command->bind_param('ds', $id, $this->password);
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