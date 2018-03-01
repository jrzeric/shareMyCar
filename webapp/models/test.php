<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/models/mysqlconnection.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/models/exceptions/recordnotfoundexception.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/models/Student.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/models/model.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/models/car.php');

$s = new Student(2);
$m = new Model(1);
$c = new Car();
$c->setDriver($s);
$c->setModel($m);
$c->setLicensePlate('12');
$c->setDriverLicense('12');
$c->setColor('12');
$c->setInsurance('12');
$c->setSpaceCar('12');
$c->setOwner('12');

if($c->add()){
  echo "exito";
}else {
  echo "fallo";
}

?>
