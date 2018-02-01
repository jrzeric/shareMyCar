<?php

require_once('mysqlconnection.php');
require_once('exceptions/recordnotfoundexception.php');

class Location
{
  // Attributes
  private $id;
  private $latitude;
  private $longitude;
  private $status;

  // Setters and Getters
  public function getId() { return $this->id; }
  public function setId($value) { $this->id = $value; }

  public function getLatitude() { return $this->latitude; }
  public function setLatitude($value) { $this->latitude = $value; }

  public function getLongitude() { return $this->longitude; }
  public function setLongitude($value) { $this->longitude = $value; }

  public function getStatus() { return $this->status; }
  public function setStatus($value) { $this->status = $value; }

  // Constructor
  function __construct()
  {
    if (func_num_args() == 0) {
      $this->id = 0;
      $this->latitude = 0.0;
      $this->longitude = 0.0;
      $this->status = 0;

    }
    if (func_num_args() == 1) {
      $id = func_get_arg(0);
      $connection = MySQLConnection::getConnection();
      $query = 'SELECT id, latitude, longitude, status FROM location_ctg WHERE id = ?;';

      $command = $connection->prepare($query);
      $command->bind_param('i', $id);
      $command->execute();

      $command->bind_result($id, $longitude, $latitude, $status);
      $found = $command->fetch();

      mysqli_stmt_close($command);
      $connection->close();

      if ($found) {
        $this->id = $id;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->status = $status;
      } else {
        throw new RecordNotFoundException();
      }
    }
    if (func_num_args() == 4) {
      $arguments = func_get_args();
      $this->id = $arguments[0];
      $this->latitude = $arguments[1];
      $this->longitude = $arguments[2];
      $this->status = $arguments[3];
    }
  }

  /**
   * Adds a new location to the database
   *
   * @return bool the bool of the
   */
  public function add()
  {
    $connection = MySQLConnection::getConnection();
    $query = "INSERT INTO location_ctg (id, latitude, longitude, status) values (?, ?, ?, ?);";

    $command = $connection->prepare($query);
    $command->bind_param('iddi', $this->id, $this->latitude, $this->longitude, $this->status);

    $result = $command->execute();
    mysqli_stmt_close($command);
    $connection->close();

    return $result;
  }

  /**
   * Edits a location in the database
   *
   * @return bool the bool of the
   */
  public function put()
  {
    $connection = MySQLConnection::getConnection();
    $query = "UPDATE location_ctg SET latitude = ?, longitude = ?, status = ? WHERE id = ?;";

    $command = $connection->prepare($query);
    $command->bind_param('ddii', $this->latitude, $this->longitude, $this->status, $this->id);

    $result = $command->execute();
    mysqli_stmt_close($command);
    $connection->close();

    return $result;
  }

  /**
   * Changes a location status from the database
   *
   * @return bool the bool of the
   */
  public function delete()
  {
    $connection = MySQLConnection::getConnection();
    $query = "UPDATE location_ctg SET status = 0 WHERE id = ?;";

    $command = $connection->prepare($query);
    $command->bind_param('i', $this->id);

    $result = $command->execute();
    mysqli_stmt_close($command);
    $connection->close();

    return $result;
  }
}
