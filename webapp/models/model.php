<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/mysqlconnection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/exceptions/recordnotfoundexception.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/brand.php');

class Model
{
  private $id;
  private $brand;
  private $name;
  private $status;

  public function getId(){ return $this->id; }
  public function setId($value){ $this->id = $value; }
  public function getBrand(){ return $this->brand; }
  public function setBrand($value){ $this->brand = $value; }
  public function getName(){ return $this->name; }
  public function setName($value){ $this->name = $value; }
  public function getStatus(){ return $this->status; }
  public function setStatus($value){ $this->status = $value; }

  function __construct()
  {
      if (func_num_args()==0) {
        $this->id = 0;
        $this->brand = new Brand();
        $this->name = '';
        $this->status = 1;
      }

      if (func_num_args()==1) {
        $id = func_get_arg(0);
        $connection = MySQLConnection::getConnection();
        $query = 'SELECT id, brand, name, status FROM models_ctg WHERE id = ?;';
        $command = $connection->prepare($query);
        $command->bind_param('s',$id);
        $command->execute();
        $command->bind_result($id,$brand,$name,$status);
        $found = $command->fetch();
        mysqli_stmt_close($command);
        $connection->close();
        if ($found) {
          $this->id = $id;
          $this->brand = new Brand($brand);
          $this->name = $name;
          $this->status = $status;
        }
        else {
          throw new RecordNotFoundException();
        }
      }

      if (func_num_args()==4) {
        $arguments = func_get_args();
        $this->id = $arguments[0];
        $this->brand = new Brand($arguments[1]);
        $this->name = $arguments[2];
        $this->status = $arguments[3];
      }
  }

  /**
   * Adds a new model to the database
   *
   * @return bool the bool of the transsaction
   */
  public function add()
  {
    $connection = MySQLConnection::getConnection();
    $query = "INSERT INTO models_ctg (brand, name, status) VALUES (?, ?, ?);"; // this query is empty
    $command = $connection->prepare($query);
    $command->bind_param('isi' , $this->brand->getId(), $this->name, $this->status); //this also is empty
    $result = $command->execute();
    mysqli_stmt_close($command);
    $connection->close();
    return $result;
  }

  /**
   * Edits a model in the database
   *
   * @return bool the bool of the transsaction
   */
  public function put()
  {
    $connection = MySQLConnection::getConnection();
    $query = "UPDATE models_ctg SET brand = ?, name = ?, status = ? WHERE id = ?;";
    $command = $connection->prepare($query);
    $command->bind_param('isii' , $this->brand->getId(), $this->name, $this->status, $this->id);
    $result = $command->execute();
    mysqli_stmt_close($command);
    $connection->close();
    return $result;
  }

  /**
   * Chages the status of a model
   *
   * @return bool the bool of the transsaction
   */
  public function delete()
  {
    $connection = MySQLConnection::getConnection();
    $query = "UPDATE models_ctg SET status = 0 WHERE id = ?";
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
      'brand' => json_decode($this->brand->toJson()),
      'name' => $this->name,
      'status' => $this->status
    ));
  }

  /**
   *
   *
   * @return ALL models data
   */
  public static function getAll()
  {
    //list
    $list = array();
    $connection = MySQLConnection::getConnection();
    //query
    $query = 'select id, name , status, brand
          from models_ctg';
    //command
    $command = $connection->prepare($query);
    //execute
    $command->execute();
    //bind results
    $command->bind_result($code, $name, $status, $brand);
    //fetch
    while ($command->fetch()) {
      array_push($list, new Model($code, $brand, $name, $status));
    }
    //close statement
    mysqli_stmt_close($command);
    //close connection
    $connection->close();
    //return array
    return $list;
  }

  /**
   *
   *
   * @return ALL model data in JSON format
   */
  public static function getAllJson()
  {
    $list = array();
    foreach (self::getAll() as $item) {
      array_push($list, json_decode($item->toJson()));
    }
    return json_encode(array(
      'status' => 1,
      'models' => $list));
  }


  public static function getAllModelsByBrand($brand)
  {
      //list
      $list = array();
      $connection = MySQLConnection::getConnection();
      //query
      $query = 'select id, name , status, brand
            from models_ctg
            where brand = ?';
      //command
      $command = $connection->prepare($query);
      $command->bind_param('i', $brand);
      //execute
      $command->execute();
      //bind results
      $command->bind_result($code, $name, $status, $brand);
      //echo $found;
      while ($command->fetch()) {
        array_push($list, new Model($code, $brand, $name, $status));
      }
      //close statement
      mysqli_stmt_close($command);
      //close connection
      $connection->close();
      //return array
      return $list;
  }//getAll

  public static function getAllModelsByBrandJson($brand)
  {
      //list
      $list = array();
      //encode to json
      foreach (self::getAllModelsByBrand($brand) as $item) {
        array_push($list, json_decode($item->toJson()));
      }//foreach
      return json_encode(array(
        'status' => '3',
        'models' => $list));
    }



}
?>
