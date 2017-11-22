<?php
  require_once('mysqlconnection.php');
  require_once('exceptions/recordnotfoundexception.php');

  /*
    Class HistoricalRideStatus
  */

  class HistoricalRideStatus {
    // attributes
    private $code;
    private $status;

    // getters and setters
    public function getCode() { return $this->code; }
    public function setCode($value) { $this->code = $value; }

    public function getStatus() { return $this->status; }
    public function setStatus($value) { $this->$value; }

    // constructor
    function __construct() {
      // empty object
      if (func_num_args() == 0) {
        $this->code = "";
        $this->status = "";
      }
      // object with data from database
      if (func_num_args() == 1) {
        $id = func_get_arg(0);

				$connection = MySQLConnection::getConnection();
				$query = "select code, status from historicalRides_status_ctg where code = ?";
				$command = $connection->prepare($query);
				$command->bind_param('s', $id);

				$command->execute();
				$command->bind_result($code, $status);
				$found = $command->fetch();

				mysqli_stmt_close($command);
        $connection->close();

				if ($found) {
					$this->code = $code;
					$this->status = $status;
				} else  throw new RecordNotFoundException();
      }
    }

    // methods
    public function toJson() {
      return json_encode(array(
        'code' => $this->code,
        'status' => $this->status
      ));
    }
  }
?>
