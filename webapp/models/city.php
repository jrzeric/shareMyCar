<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/mysqlconnection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/exceptions/recordnotfoundexception.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/state.php');

class City
{
  // Attributes
  private $code;
  private $state;
  private $name;
  private $status;

  // Setters and Getters
  public function getCode() { return $this->code; }
  public function setCode($value) { $this->code = $value; }

  public function getState() { return $this->state; }
  public function setState($value) { $this->state = $value; }

  public function getName() { return $this->name; }
  public function setName($value) { $this->name = $value; }

  public function getStatus() { return $this->status; }
  public function setStatus($value) { $this->status = $value; }

  // Constructor
  function __construct()
  {
    if (func_num_args() == 0) {
      $this->code = 0;
      $this->state = new State();
      $this->name = '';
      $this->status = 0;

    }
    if (func_num_args() == 1) {
      $code = func_get_arg(0);
      $connection = MySQLConnection::getConnection();
      $query = 'SELECT CODE, state, name, status FROM cities_ctg WHERE CODE = ?;';

      $command = $connection->prepare($query);
      $command->bind_param('i', $code);
      $command->execute();

      $command->bind_result($code, $state, $name, $status);
      $found = $command->fetch();

      mysqli_stmt_close($command);
      $connection->close();

      if ($found) {
        $this->code = $code;
        $this->state = new State($state);
        $this->name = $name;
        $this->status = $status;
      } else {
        throw new RecordNotFoundException();
      }
    }
    if (func_num_args() == 4) {
      $arguments = func_get_args();
      $this->code = $arguments[0];
      $this->state = new State($arguments[1]);
      $this->name = $arguments[2];
      $this->status = $arguments[3];
    }
  }

  /**
   * Adds a new city to the database
   *
   * @return bool the bool of the
   */
  public function add()
  {
    $connection = MySQLConnection::getConnection();
    $query = "INSERT INTO cities_ctg (code, state, name, status) values (?, ?, ?, ?);";

    $command = $connection->prepare($query);
    $command->bind_param('issi', $this->code, $this->state, $this->name, $this->status);

    $result = $command->execute();
    mysqli_stmt_close($command);
    $connection->close();

    return $result;
  }

  /**
   * Edits a city in the database
   *
   * @return bool the bool of the
   */
  public function put()
  {
    $connection = MySQLConnection::getConnection();
    $query = "UPDATE cities_ctg SET state = ?, name = ?, status = ? WHERE code = ?;";

    $command = $connection->prepare($query);
    $command->bind_param('ssii', $this->state, $this->name, $this->status, $this->code);

    $result = $command->execute();
    mysqli_stmt_close($command);
    $connection->close();

    return $result;
  }

  /**
   * Chages the status of a city from the database
   *
   * @return bool the bool of the
   */
  public function delete()
  {
    $connection = MySQLConnection::getConnection();
    $query = "UPDATE cities_ctg SET status = 0 WHERE code = ?;";

    $command = $connection->prepare($query);
    $command->bind_param('s', $this->code);

    $result = $command->execute();
    mysqli_stmt_close($command);
    $connection->close();

    return $result;
  }
}
