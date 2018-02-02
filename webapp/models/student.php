<?php
require_once('mysqlconnection.php');
require_once('exceptions/recordnotfoundexception.php');

class Student
{
  //Attributes
  private $id;
  private $profile;  // this variable is an object
  private $name;
  private $email;
  private $cellPhone;
  private $university;  // this variable is an object
  private $licenceNumber;
  private $location; // this variable is an object
  private $photo;
  private $city; // this variable is an object
  private $turn;
  private $status;
  private $surname; // this have a problem with name ?
  private $secondSurname; // SUR o USR NAME ?

  public function getId(){ return $this->id; }
  public function setId($value){ $this->id = $value; }
  public function getProfile(){ return $this->profile; }
  public function setProfile($value){ $this->profile = $value; }
  public function getName(){ return $this->name; }
  public function setName($value){ $this->name = $value; }
  public function getEmail(){ return $this->email; }
  public function setEmail($value){ $this->email = $value; }
  public function getCellPhone(){ return $this->cellPhone; }
  public function setCellPhone($value){ $this->cellPhone = $value; }
  public function getUniversity(){ return $this->university; }
  public function setUniversity($value){ $this->university = $value; }
  public function getLicenceNumber(){ return $this->licenceNumber; }
  public function setLicenceNumber($value){ $this->licenceNumber = $value; }
  public function getLocation(){ return $this->location; }
  public function setLocation($value){ $this->location = $value; }
  public function getPhoto(){ return $this->photo; }
  public function setPhoto($value){ $this->photo = $value; }
  public function getCity(){ return $this->city; }
  public function setCity($value){ $this->city = $value; }
  public function getTurn(){ return $this->turn; }
  public function setTurn($value){ $this->turn = $value; }
  public function getStatus(){ return $this->status; }
  public function setStatus($value){ $this->status = $value; }
  public function getSurName(){ return $this->surname; }
  public function setSurName($value){ $this->surname = $value; }
  public function getSecondSurName(){ return $this->secondSurname; }
  public function setSecondSurName($value){ $this->secondSurname = $value; }

  function __construct()
  {
    if (func_num_args()==0)
    {
      $this->id = 0;
      $this->profile = new Profile();  // this variable is an object
      $this->name = '';
      $this->email = '';
      $this->cellPhone = '';
      $this->university = new University();  // this variable is an object
      $this->licenceNumber = '';
      $this->location = new Location(); // this variable is an object
      $this->photo = '';
      $this->city = new City(); // this variable is an object
      $this->turn = 0;
      $this->status = 1;
      $this->surname = ''; // this have a problem with name ?
      $this->secondSurname = ''; // SUR o USR NAME ?
    }

    if (func_num_args()==1)
    {
      $id = func_get_arg(0);
      $connection = MySQLConnection::getConnection();
      $query = 'SELECT id, profile, surname, secondSurname, name, email, cellPhone, university, licenceNumber, location, photo, city, turn, status FROM students WHERE id = ?;';
      $command = $connection->prepare($query);
      $command->bind_param('s',$id);
      $command->execute();
      $command->bind_result($id,$profile,$surname,$secondSurname,$name,$email,$cellPhone,$university,$licenceNumber,$location,$photo,$city,$turn,$status);
      $found->fetch();
      mysqli_stmt_close($command);
      $connection->close();
      if ($found)
      {
        $this->id = $id;
        $this->profile = new Profile($profile);  // this variable is an object
        $this->name = $name;
        $this->email = $email;
        $this->cellPhone = $cellPhone;
        $this->university = new University($university);  // this variable is an object
        $this->licenceNumber = $licenceNumber;
        $this->location = new Location($location); // this variable is an object
        $this->photo = $photo;
        $this->city = new City($city); // this variable is an object
        $this->turn = $turn;
        $this->status = $state;
        $this->surname = $surname; // this have a problem with name ?
        $this->secondSurname = $secondSurname; // SUR o USR NAME ?
      }
      else
      {
        throw new RecordNotFoundException();
      }
    }

    if (func_num_args()==14)
    {
      $arguments = func_get_args();
      $this->id = $arguments[0];
      $this->profile = new Profile($arguments[1]);  // this variable is an object
      $this->name = $arguments[2];
      $this->email = $arguments[3];
      $this->cellPhone = $arguments[4];
      $this->university = new University($arguments[5]);  // this variable is an object
      $this->licenceNumber = $arguments[6];
      $this->location = new Location($arguments[7]); // this variable is an object
      $this->photo =$arguments[8];
      $this->city = new City($arguments[9]); // this variable is an object
      $this->turn = $arguments[10];
      $this->status = $arguments[11];
      $this->surname = $arguments[12]; // this have a problem with name ?
      $this->secondSurname = $arguments[13]; // SUR o USR NAME ?
    }
  }

  /**
   * Adds a new student to the database
   *
   * @return bool the bool of the transsaction
   */
  public function add()
  {
    $connection = MySQLConnection::getConnection();
    $query = ""; // this query is empty
    $command = $connection->prepare($query);
    $command->bind_param(); //this also is empty
    $result = $command->execute();
    mysqli_stmt_close($command);
    $connection->close();
    return $result;
  }

  /**
   * Edits a student in the database
   *
   * @return bool the bool of the transsaction
   */
  public function put()
  {
    $connection = MySQLConnection::getConnection();
    $query = "";
    $command = $connection->prepare($query);
    $command->bind_param();
    $result = $command->execute();
    mysqli_stmt_close($command);
    $connection->close();
    return $result;
  }

  /**
   * Chages the status of a student
   *
   * @return bool the bool of the transsaction
   */
  public function delete()
  {
    $connection = MySQLConnection::getConnection();
    $query = "";
    $command = $connection->prepare($query);
    $command->bind_param();
    $result = $command->execute();
    mysqli_stmt_close($command);
    $connection->close();
    return $result;
  }

  /**
   *
   *
   * @return JSON of all data
   */
  public function toJson()
  {
    return json_encode(array(
      'id' => $this->id,
      'profile' => $this->profile,
      'name' => $this->name,
      'email' => $this->email,
      'cellPhone' => $this->cellPhone,
      'university' => $this->university,
      'licenceNumber' => $this->licenceNumber,
      'location' => $this->location,
      'photo' => $this->photo,
      'city' => $this->city,
      'turn' => $this->turn,
      'status' => $this->status,
      'surname' => $this->surname,
      'secondSurname' => $this->secondSurname
    ));
  }

  /**
   *
   *
   * @return ALL student data
   */
  public static function getAll()
  {
    $list = array();
    $connection = MySQLConnection::getConnection();
    $query = 'SELECT id, profile, surname, secondSurname, name, email, cellPhone, university, licenceNumber, location, photo, city, turn, status FROM students WHERE id = ?;';
    $command = $connection->prepare($query);
    $command->bind_param('s',$id);
    $command->execute();
    $command->bind_result($id,$profile,$surname,$secondSurname,$name,$email,$cellPhone,$university,$licenceNumber,$location,$photo,$city,$turn,$status);
    while ($command->fetch())
    {
      array_push($list, new Student($id,$profile,$surname,$secondSurname,$name,$email,$cellPhone,$university,$licenceNumber,$location,$photo,$city,$turn,$status));
    }
    mysqli_stmt_close($command);
    $connection->close();
    return $list;
  }

  /**
   *
   *
   * @return ALL student data in JSON format
   */
  public static function getAllJson()
  {
    $list = array();
    foreach (self::getAll() as $item)
    {
      array_push($list, json_decode($item->toJson()));
    }
    return json_encode(array('students' => $list));
  }
}
?>
