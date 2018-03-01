<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/models/mysqlconnection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/models/exceptions/recordnotfoundexception.php');

class Profile
{
  // Attributes
  private $code;
  private $name;

  // Setters and Getters
  public function getCode() { return $this->code; }
  public function setCode($value) { $this->code = $value; }

  public function getName() { return $this->name; }
  public function setName($value) { $this->name = $value; }

  // Constructor
  function __construct()
  {
    if (func_num_args() == 0) {
      $this->code = '';
      $this->name = '';
    }
    if (func_num_args() == 1) {
      $code = func_get_arg(0);
      $connection = MySQLConnection::getConnection();
      $query = 'SELECT id, name, city, location, status FROM universities_ctg WHERE id = ?;';

      $command = $connection->prepare($query);
      $command->bind_param('i', $code);
      $command->execute();

      $command->bind_result($code, $name, $city, $location, $status);
      $found = $command->fetch();

      mysqli_stmt_close($command);
      $connection->close();

      if ($found) {
        $this->code = $code;
        $this->name = $name;
      } else {
        throw new RecordNotFoundException();
      }
    }
    if (func_num_args() == 2) {
      $arguments = func_get_args();
      $this->code = $arguments[0];
      $this->name = $arguments[1];
    }
  }
}
