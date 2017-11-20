<?php
  /**
   *
   */

  require_once('mysqlconnection.php');
  require_once('exceptions/recordnotfoundexception.php');
  require_once('location.php');
  require_once('studentdriver.php');

  class Spot
  {
    // attributes
    private $slot;
    private $student;
    private $location;
    private $description;
    private $dateTime;

    // getters and setters
    public function getSlot() { return $this->slot; }
    public function setSlot($value) { $this->slot = $value; }

    public function getStudent() { return $this->student; }
    public function setStudent($value) { $this->student = $value; }

    public function getLocation() { return $this->location; }
    public function setLocation($value) { $this->location = $value; }

    public function getDescription() { return $this->descriotion; }
    public function setDescription($value) { $this->description = $value; }

    public function getDateTime() { return $this->dateTime; }

    // constructor
    function __construct() {
      // empty object
      if(func_num_args() == 0) {
        $this->slot = 0;
        $this->student = new StudentDriver();
        $this->location = new Location();
        $this->description = "";
        $this->dateTime = "";
      }
      // object with data from database
      if(func_num_args() == 1) {

				$id = func_get_arg(0);

				$connection = MySQLConnection::getConnection();
				$query = "select student, slot, latitude, longitude, updated_at from spotLocations where student = ?";
				$command = $connection->prepare($query);
				$command->bind_param('i', $id);

				$command->execute();
				$command->bind_result($student, $slot, $latitude, $longitude, $dateTime);
				$found = $command->fetch();

				mysqli_stmt_close($command);
        $connection->close();

				if ($found) {

					$this->student = new StudentDriver($student);

					$this->slot = $slot;
					$this->location = new Location($latitude, $longitude);
          $this->dateTime = $dateTime;

				} else  throw new RecordNotFoundException();
      }
      // object with data from arguments
      if(func_num_args() == 4) {
        // get arguments
        $arguments = func_get_args();
        // pass arguments to attributes
        $this->slot = $arguments[0];
        $this->student = $arguments[1];
        $this->location = $arguments[2];
        $this->description = $arguments[3];
      }
    }

    // methods
    public function add() {
      //get connection
			$connection = MySqlConnection::getConnection();

			$query = 'insert into spotlocations (student, slot, latitude, longitude, updated_at) values(?, ?, ?, ?, ?)';
			$command = $connection->prepare($query);

      $command->bind_param('iidds', $this->student->getId(), $this->slot, $this->location->getLatitude(), $this->location->getLongitude(), $this->dateTime);
      $result = $command->execute();

			mysqli_stmt_close($command);
			$connection->close();

			return $result;
    }

    public function toJson() {
      return json_encode(array(
        'student' => json_decode($this->student->toJson()),
        'slot' => $this->slot,
        'location' => json_decode($this->location->toJson()),
        'dateTime' => $this->dateTime
      ));
    }

    public static function getAll() {
			$list = array();
			$connection = MySqlConnection::getConnection();

			$query = 'select st.id, sp.slot, sp.latitude, sp.longitude, sp.updated_at
      from spotLocations sp inner join students st on sp.student = st.id';
			$command = $connection->prepare($query);

			$command->execute();
			$command->bind_result($id, $slot, $latitude, $longitude, $dateTime);
			while ($command->fetch()) {
        $student = new StudentDriver($id);
				$location = new Location($latitude, $longitude);
				array_push($list, new Spot($slot, $student, $location, $dateTime));
			}

			mysqli_stmt_close($command);
			$connection->close();

			return $list;
		}

    //get all in JSON format
		public static function getAllJson() {
			$list = array();

			foreach(self::getAll() as $item) {
				array_push($list, json_decode($item->toJson()));
			}

			return json_encode(array('spotLocations' => $list));
		}

  }



 ?>
