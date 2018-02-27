<?php
require_once('mysqlconnection.php');
require_once('exceptions/recordnotfoundexception.php');

class Car
{
  private $id;
  private $driver;  // this is an object
  private $model; //this is another object
  private $licensePlate;
  private $driverLicense;
  private $color;
  private $insurance;
  private $spaceCar;
  private $owner;
  private $status;

  public function getId(){ return $this->id; }
  public function setId($value){ $this->id = $value; }
  public function getDriver(){ return $this->driver; }
  public function setDriver($value){ $this->driver = $value; }
  public function getModel(){ return $this->model; }
  public function setModel($value){ $this->model = $value; }
  public function getLicensePlate(){ return $this->licensePlate; }
  public function setLicensePlate($value){ $this->licensePlate = $value; }
  public function getDriverLicense(){ return $this->driverLicense; }
  public function setDriverLicense($value){ $this->driverLicense = $value; }
  public function getColor(){ return $this->color; }
  public function setColor($value){ $this->color = $value; }
  public function getInsurance(){ return $this->insurance; }
  public function setInsurance($value){ $this->insurance = $value; }
  public function getSpaceCar(){ return $this->spaceCar; }
  public function setSpaceCar($value){ $this->spaceCar = $value; }
  public function getOwner(){ return $this->owner; }
  public function setOwner($value){ $this->owner = $value; }
  public function getStatus(){ return $this->status; }
  public function setStatus($value){ $this->status = $value; }

  function __construct()
  {
    if (func_num_args()==0)
    {
      $this->id = 0 ;
      $this->driver = new Driver();
      $this->model = new Model();
      $this->licensePlate = '';
      $this->driverLicense = '';
      $this->color = '';
      $this->insurance = '';
      $this->spaceCar = 0;
      $this->owner = '';
      $this->status = 1;
    }

    if (func_num_args()==1)
    {
      $id = func_get_arg(0);
      $connection = MySQLConnection::getConnection();
      $query = 'SELECT id, driver, model, licencePlate, driverLicence, color, insurance, spaceCar, owner, status FROM cars WHERE id = ?;';
      $command = $connection->prepare($query);
      $command->bind_param('i',$id);
      $command->execute();
      $command->bind_result($id,$driver,$model,$licensePlate,$driverLicense,$color,$insurance,$spaceCar,$owner,$status);
      $found->fetch();
      mysqli_stmt_close($command);
      $connection->close();
      if ($found)
      {
        $this->id = $id;
        $this->driver = new Driver($driver);  // this variable is an object
        $this->model = new Model($model);
        $this->licensePlate = $licensePlate;
        $this->driverLicense = $driverLicense;
        $this->color = $color;
        $this->insurance = $insurance;
        $this->spaceCar = $spaceCar;
        $this->owner = $owner;
        $this->status = $status;
      }
      else
      {
        throw new RecordNotFoundException();
      }
    }

    if (func_num_args()==10)
    {
      $arguments = func_get_args();
      $this->id = $arguments[0];
      $this->driver = new Driver($arguments[1]);  // this variable is an object
      $this->model = new Model($arguments[2]);
      $this->licensePlate = $arguments[3];
      $this->driverLicense = $arguments[4];
      $this->color = $arguments[5];
      $this->insurance = $arguments[6];
      $this->spaceCar = $arguments[7];
      $this->owner = $arguments[8];
      $this->status = $arguments[9];
    }
  }

  /**
   * Adds a new car to the database
   *
   * @return bool the bool of the transsaction
   */
  public function add()
  {
    $connection = MySQLConnection::getConnection();
    $query = "INSERT INTO cars(driver, model, licencePlate, driverLicence, color, insurance, spaceCar, owner) VALUES (?,?,?,?,?,?,?,?);";
    $command = $connection->prepare($query);
    $command->bind_param('iissssis',$this->driver->getId(),$this->model->getId(),$this->licensePlate,$this->driverLicense,$this->color,$this->insurance,$this->spaceCar,$this->owner);
    $result = $command->execute();
    mysqli_stmt_close($command);
    $connection->close();
    return $result;
  }

  /**
   * Edits a car in the database
   *
   * @return bool the bool of the transsaction
   */
  public function put()
  {
    $connection = MySQLConnection::getConnection();
    $query = "UPDATE cars SET driver = ?, model = ?, licencePlate = ?, driverLicence = ?, color = ?, insurance = ?, spaceCar = ?, owner = ?, status = ? WHERE id = ?;";
    $command = $connection->prepare($query);
    $command->bind_param('iissssisii',$this->driver->getId(),$this->model->getId(),$this->licensePlate,$this->driverLicense,$this->color,$this->insurance,$this->spaceCar,$this->owner,$this->status,$this->id);
    $result = $command->execute();
    mysqli_stmt_close($command);
    $connection->close();
    return $result;
  }

  /**
   * Chages the status of a car
   *
   * @return bool the bool of the transsaction
   */
  public function delete()
  {
    $connection = MySQLConnection::getConnection();
    $query = "UPDATE cars SET status = 0 WHERE id = ?;";
    $command = $connection->prepare($query);
    $command->bind_param('i',$this->id);
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
      'driver' => json_decode($this->driver->toJson()),  // this variable is an object
      'model' => json_decode($this->model->toJson()),
      'licensePlate' => $this->licensePlate,
      'driverLicense' => $this->driverLicense,
      'color' => $this->color,
      'insurance' => $this->insurance,
      'spaceCar' => $this->spaceCar,
      'owner' => $this->owner,
      'status' => $this->status
    ));
  }

  /**
   *
   *
   * @return ALL cars data
   */
  public static function getAll()
  {
      $list = array();
      $connection = MySQLConnection::getConnection();
      $query = 'SELECT id, driver, model, licencePlate, driverLicence, color, insurance, spaceCar, owner, status FROM cars;';
      $command = $connection->prepare($query);
      $command->execute();
      $command->bind_result($id,$driver,$model,$licensePlate,$driverLicense,$color,$insurance,$spaceCar,$owner,$status);
      while ($command->fetch())
      {
        array_push($list, new Car($id,new Driver($driver),new Model($model),$licensePlate,$driverLicense,$color,$insurance,$spaceCar,$owner,$status));
      }
      mysqli_stmt_close($command);
      $connection->close();
      return $list;
  }

  /**
   *
   *
   * @return ALL car data in JSON format
   */
  public static function getAllJson()
  {
    $list = array();
    foreach (self::getAll() as $item)
    {
      array_push($list, json_decode($item->toJson()));
    }
    return json_encode(array('cars' => $list));
  }
}
?>
