<?php
	require_once('mysqlconnection.php');
	require_once('exceptions/recordnotfoundexception.php');
	class Brand
	{
		private $id;
		private $name;
    private $image;
    private $status;

		public function getId() { return $this->id; }
		public function setId($value) { $this->id = $value; }
		public function getName() { return $this->name; }
		public function setName($value) { $this->name = $value; }
  	public function getImage(){ return $this->image; }
  	public function setImage($value){ $this->image = $value; }
  	public function getStatus(){ return $this->status; }
  	public function setStatus($value){ $this->status = $value; }

		function __construct()
		{
			if (func_num_args() == 0) {
				$this->id = '';
				$this->name = '';
        		$this->image = '';
        		$this->status = 1;
			}

			if (func_num_args() == 1) {
				$id = func_get_arg(0);
				$connection = MySQLConnection::getConnection();
				$query = 'SELECT id, name, image, status FROM brands_ctg WHERE id = ?';
				$command = $connection->prepare($query);
				$command->bind_param('s', $id);
				$command->execute();
				$command->bind_result($this->id, $this->name, $this->image,$this->status);
				$found = $command->fetch();
				mysqli_stmt_close($command);
				$connection->close();
				if (!$found) throw new RecordNotFoundException();
			}
			if (func_num_args() == 4) {
				$arguments = func_get_args();
				$this->id = $arguments[0];
				$this->name = $arguments[1];
        		$this->image = $arguments[2];
        		$this->status = $arguments[3];
			}
		}

		public function add()
		{
			$connection = MySQLConnection::getConnection();
			$query = "INSERT INTO brands_ctg(name,image,status) VALUES ( ? , ? , ?);";
			$command = $connection->prepare($query);
			$command->bind_param('ssi',$this->name, $this->image, $this->status);
			$result = $command->execute();
			mysqli_stmt_close($command);
			$connection->close();
			return $result;
		}

		/**
		 * Edits a brands in the database
		 *
		 * @return bool the bool of the transsaction
		 */
		public function put()
		{
			$connection = MySQLConnection::getConnection();
			$query = "UPDATE brands_ctg SET name = ?, image = ?, status = ? WHERE id = ?;";
			$command = $connection->prepare($query);
			$command->bind_param('ssii',$this->name, $this->image, $this->status, $this->id);
			$result = $command->execute();
			mysqli_stmt_close($command);
			$connection->close();
			return $result;
		}

		/**
		 * Chages the status of a brand
		 *
		 * @return bool the bool of the transsaction
		 */
		public function delete()
		{
			$connection = MySQLConnection::getConnection();
			$query = "UPDATE brands_ctg SET status = 0 WHERE id = ?;";
			$command = $connection->prepare($query);
			$command->bind_param('i',$this->id);
			$result = $command->execute();
			mysqli_stmt_close($command);
			$connection->close();
			return $result;
		}

		public function toJson()
		{
			return json_encode(array(
				'id' => $this->id,
				'name' => $this->name,
        		'image' => $this->image,
        		'status' => $this->status
      ));
		}

		public static function getAll()
		{
			$list = array();
			$connection = MySQLConnection::getConnection();
			$query = 'SELECT id, name, image, status FROM brands_ctg';
			$command = $connection->prepare($query);
			$command->execute();
			$command->bind_result($id, $name, $image, $status);
			while ($command->fetch()) {
				array_push($list, new Brand($id, $name, $image, $status));
			}
			mysqli_stmt_close($command);
			$connection->close();
			return $list;
		}

		public static function getAllJson()
		{
			$list = array();
			foreach (self::getAll() as $item) {
				array_push($list, json_decode($item->toJson()));
			}
			return json_encode(array(
				'status'=> 1,
				'brands' => $list));
		}
	}
?>
