<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/models/mysqlconnection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/models/exceptions/recordnotfoundexception.php');

class Location
{
  // Attributes
  private $latitude;
  private $longitude;

  // Setters and Getters
  public function getLatitude() { return $this->latitude; }
  public function setLatitude($value) { $this->latitude = $value; }

  public function getLongitude() { return $this->longitude; }
  public function setLongitude($value) { $this->longitude = $value; }

  // Constructor
  function __construct()
  {
    if (func_num_args() == 0) {
      $this->latitude = 0.0;
      $this->longitude = 0.0;

    }

    if (func_num_args() == 2) {
      $arguments = func_get_args();
      $this->latitude = $arguments[0];
      $this->longitude = $arguments[1];
    }
  }

  public function toJson()
  {
    return json_encode(array(
      'latitude' => $this->latitude,
      'longitude' => $this->longitude
    ));
  }

}
