<?php
require_once('mysqlconnection.php');
require_once('historicalridestatus.php');
require_once('exceptions/recordnotfoundexception.php');

/*
  Class HistoricalRide
*/

class HistoricalRide {
  // attributes
  private $id;
  private $beginLatitude;
  private $beginLongitude;
  private $endLatitude;
  private $endLongitude;
  private $driver;
  private $passenger;
  //private $paymentAmount;
  private $requested_at;
  private $mettint_at;
  private $pickedUp_at;
  private $arrived_at;
  private $status;

  // getters and setters
  public function getId() { return $this->id; }
  public function setId($value) { $this->$value; }

  public function getBeginlatitude() { return $this->beginLatitude; }
  public function setBeginLatitude($value) { $this->beginLatitude = $value; }

  private function getBeginLongitude() { return $this->beginLongitude; }
  private function setBeginLongitude($value) { $this->beginLongitude = $value; }

  private function getEndLatitude() { return $this->endLatitude; }
  private function setEndLatitude($value) { $this->endLatitude = $value; }

  private function getEndLongitude() { return $this->endLongitude; }
  private function setEndLongitude($value) { $this->endLatitude = $value; }

  private function getDriver() { return $this->driver; }
  private function setDriver($value) { $this->driver = $value; }

  private function getPassenger() { return $this->passenger; }
  private function setPassenger($value) { $this->passenger = $value; }

  private function getRequestedAt() { return $this->requested_at; }
  private function setRequestedAt($value) { $this->requested_at = $value; }

  private function getmettintAt() { return $this->mettint_at; }
  private function setmettintAt($value) { $this->mettint_at = $value; }

  private function getPickedUpAt() { return $this->pickedUp_at; }
  private function setPickedUpAt($value) { $this->pickedUp_at = $value; }

  private function getArrivedAt() { return $this->arrived_at; }
  private function setArrivedAt($value) { $this->arrived_at = $value; }

  private function getStatus() { return $this->status; }
  private function setStatus($value) { $this->status = $value; }

  // constructor
  function __construct() {
    // empty object
    if(func_num_args() == 0) {
      $this->id = 0;
      $this->beginLatitude = 0.0;
      $this->beginLongitude = 0.0;
      $this->endLatitude = 0.0;
      $this->endLongitude = 0.0;
      $this->driver = 0;
      $this->passenger = 0;
      $this->requested_at = "";
      $this->mettint_at = "";
      $this->pickedUp_at = "";
      $this->arrived_at = "";
      $this->status = "";
    }
    // object with data from database
    if (func_num_args() == ) {

    }
  }
}
?>
