<?php

require_once('mysqlconnection.php');
require_once('exceptions/recordnotfoundexception.php');
require_once('city.php');
require_once('location.php');

class University
{
  // Attributes
  private $id;
  private $name;
  private $city;
  private $location;
  private $status;

  // Setters and Getters
  public function getId() { return $this->id; }
  public function setId($value) { $this->id = $value; }

  public function getName() { return $this->name; }
  public function setName($value) { $this->name = $value; }

  public function getCity() { return $this->city; }
  public function setCity($value) { $this->city = $value; }

  public function getLocation() { return $this->location; }
  public function setLocation($value) { $this->location = $value; }

  public function getStatus() { return $this->status; }
  public function setStatus($value) { $this->status = $value; }

  // Constructor
  function __construct()
  {
    if (func_num_args() == 0) {
      $this->id = 0;
      $this->name = '';
      $this->city = new City();
      $this->location = new Location();
      $this->status = 0;
    }
    if (func_num_args() == 1) {
      $id = func_get_arg(0);
      $connection = MySQLConnection::getConnection();
      $query = 'SELECT id, name, city, location, status FROM universities_ctg WHERE id = ?;';

      $command = $connection->prepare($query);
      $command->bind_param('i', $id);
      $command->execute();

      $command->bind_result($id, $name, $city, $location, $status);
      $found = $command->fetch();

      mysqli_stmt_close($command);
      $connection->close();

      if ($found) {
        $this->id = $id;
        $this->name = $name;
        $this->city = new City($city);
        $this->location = new Location($location);
        $this->status = $status;
      } else {
        throw new RecordNotFoundException();
      }
    }
    if (func_num_args() == 5) {
      $arguments = func_get_args();
      $this->id = $arguments[0];
      $this->name = $arguments[1];
      $this->city = new City($arguments[2]);
      $this->location = new Location($arguments[3]);
      $this->status = $arguments[4];
    }
  }

  /**
   * Adds a new university to the database
   *
   * @return bool the bool of the
   */
  public function add()
  {
    $connection = MySQLConnection::getConnection();
    $query = "INSERT INTO universities_ctg (id, name, city, location, status) values (?, ?, ?, ?, ?);";

    $command = $connection->prepare($query);
    $command->bind_param('isiii', $this->id, $this->name, $this->city, $this->location, $this->status);

    $result = $command->execute();
    mysqli_stmt_close($command);
    $connection->close();

    return $result;
  }

  /**
   * Edits a university in the database
   *
   * @return bool the bool of the
   */
  public function put()
  {
    $connection = MySQLConnection::getConnection();
    $query = "UPDATE universities_ctg SET name = ?, city = ?, location = ?, status = ? WHERE id = ?;";

    $command = $connection->prepare($query);
    $command->bind_param('siiii', $this->name, $this->city, $this->location, $this->status, $this->id);

    $result = $command->execute();
    mysqli_stmt_close($command);
    $connection->close();

    return $result;
  }

  /**
   * Changes the status for a university from the database
   *
   * @return bool the bool of the
   */
  public function delete()
  {
    $connection = MySQLConnection::getConnection();
    $query = "UPDATE universities_ctg SET status = 0 WHERE id = ?;";

    $command = $connection->prepare($query);
    $command->bind_param('i', $this->id);

    $result = $command->execute();
    mysqli_stmt_close($command);
    $connection->close();

    return $result;
  }
}
