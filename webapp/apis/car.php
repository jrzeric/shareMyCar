<?php
	//access control
	//allow access from outside the server
	header('Access-Control-Allow-Origin: *');
	//allow methods
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
<<<<<<< HEAD

	require_once($_SERVER['DOCUMENT_ROOT'].'/models/car.php');

=======
	require_once($_SERVER['DOCUMENT_ROOT'].'/models/car.php');
>>>>>>> origin/windowAfterValidate
	//GET (Read)
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		//parameters
		if (isset($_GET['id'])) {
			try {
				//create object
				$c = new Car($_GET['id']);
				//display
				echo json_encode(array(
					'status' => 0,
					'Car' => json_decode($c->toJson())
				));
			}
			catch(RecordNotFoundException $ex) {
				echo json_encode(array(
					'status' => 2,
					'errorMessage' => $ex->get_message()
				));
			}
		}
		else {
			echo Car::getAllJson();
		}
	}
<<<<<<< HEAD

=======
>>>>>>> origin/windowAfterValidate
	//POST (Insert)
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		//parameters
		if(isset($_POST['driver']) &&
			isset($_POST['model']) &&
      isset($_POST['licensePlate']) &&
      isset($_POST['driverLicense']) &&
      isset($_POST['color']) &&
      isset($_POST['insurance']) &&
      isset($_POST['spaceCar']) &&
      isset($_POST['owner'])) {
<<<<<<< HEAD

        $error = false;

=======
        $error = false;
>>>>>>> origin/windowAfterValidate
      try {
        $s = new Student($_POST['driver']);
      } catch (RecordNotFoundException $ex) {
        $error = true; //found error
        echo json_encode(array(
          'status' => 3,
          'errorMessage' => 'Invalid driver'
        ));
      }
      try {
				$m = new Model($_POST['model']);
			} catch (RecordNotFoundException $ex) {
				$error = true; //found error
				echo json_encode(array(
					'status' => 3,
					'errorMessage' => 'Invalid model'
				));
			}
<<<<<<< HEAD

      if(!$error){
      $c = new Car();

=======
      if(!$error){
      $c = new Car();
>>>>>>> origin/windowAfterValidate
			$c->setDriver($s);
			$c->setModel($m);
      $c->setLicensePlate($_POST['licensePlate']);
      $c->setDriverLicense($_POST['driverLicense']);
      $c->setColor($_POST['color']);
      $c->setInsurance($_POST['insurance']);
      $c->setSpaceCar($_POST['spaceCar']);
      $c->setOwner($_POST['owner']);
<<<<<<< HEAD

			/*Then execute the method add*/
			if ($c->add()) {

				/*This message means the spot was added to the database*/
				echo json_encode(array(
					'status' => 0,
					'essage' => 'Car added successfully'
=======
			/*Then execute the method add*/
			if ($c->add()) {
				/*This message means the spot was added to the database*/
				echo json_encode(array(
					'status' => 0,
					'message' => 'Car added successfully'
>>>>>>> origin/windowAfterValidate
				));
			}
			else {
				/*the error is caused because the connection of the database, or the user
				writed something wrong*/
				echo json_encode(array(
					'status' => 1,
					'errorMessage' => 'Could not add car',
<<<<<<< HEAD

				));

=======
				));
>>>>>>> origin/windowAfterValidate
			}
		}
  }else {
    echo json_encode(array(
        'status' => 2,
        'errorMessage' => 'Missing Parameters'
      ));
  }
}
<<<<<<< HEAD

=======
>>>>>>> origin/windowAfterValidate
//PUT(update)
if($_SERVER['REQUEST_METHOD'] == 'PUT'){
  //read data
  parse_str(file_get_contents('php://input'),$putData);
  if(isset($putData)){
    //decode json
    //$jsonData =json_decode($putData['data'],true);
    //check parameters
    if(isset($putData['id']) && isset($putData['driver']) && isset($putData['model']) &&
    isset($putData['licensePlate']) && isset($putData['driverLicense']) &&
    isset($putData['color']) && isset($putData['insurance']) &&
    isset($putData['spaceCar']) && isset($putData['owner'])){
      //Error
      $error = false;
<<<<<<< HEAD

=======
>>>>>>> origin/windowAfterValidate
      try {
        $d = new Brand($putData['driver']);
      } catch (RecordNotFoundException $ex) {
        $errorBrand = true; //found error
        echo json_encode(array(
        'status' => 3,
        'errorMessage' => 'Invalid driver'
        ));
      }
      try {
        $m = new Model($putData['model']);
      } catch (RecordNotFoundException $ex) {
        $errorBrand = true; //found error
        echo json_encode(array(
        'status' => 4,
        'errorMessage' => 'Invalid model'
        ));
      }
<<<<<<< HEAD

      if(!$error){
        try{
        $c = new Car();

=======
      if(!$error){
        try{
        $c = new Car();
>>>>>>> origin/windowAfterValidate
        //set values
        $c->setId($putData['id']);
        $c->setDriver($d);
        $c->setModel($m);
        $c->setLicensePlate($putData['licensePlate']);
        $c->setDriverLicense($putData['driverLicense']);
        $c->setColor($putData['color']);
        $c->setInsurance($putData['insurance']);
        $c->setSpaceCar($putData['spaceCar']);
        $c->setOwner($putData['owner']);
        //edit
          if($c->put()){
            echo json_encode(array(
            'status' => 0,
            'message' => 'Car edited succefully'
            ));
          }else{
            echo json_encode(array(
            'status' => 1,
            'errormessage' =>'Could not edit Car'
            ));
          }
        }catch(RecordNotFoundException $ex){
          echo json_encode(array(
          'satus' =>4,
          'errormessage' => 'Invalid car'
          ));
        }
      }
    }else{
      echo json_encode(array(
          'status' =>2,
          'ErrorMessage' => 'Missing parameters'
        ));
    }
  }else{
    echo json_encode(array(
          'status' =>1,
          'ErrorMessage' => 'Missing data parameters'
        ));
  }
<<<<<<< HEAD

}

=======
}
>>>>>>> origin/windowAfterValidate
	//DELETE (delete)
	if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
		//read id
		parse_str(file_get_contents('php://input'), $putData);
		if (isset($putData['id'])) {
			try {
				//create object
				$c = new Car($putData['id']);
				//delete
				if ($c->delete())
					echo json_encode(array(
						'status' => 0,
						'errorMessage' => 'Car deleted successfully'
					));
				else
					echo json_encode(array(
						'status' => 1,
						'errorMessage' => 'Could not delete car'
					));
			}
			catch(RecordNotFoundException $ex) {
				echo json_encode(array(
					'status' => 3,
					'errorMessage' => 'Invalid car id'
				));
			}
		}
		else {
			echo json_encode(array(
				'status' => 2,
				'errorMessage' => 'Missing code parameter'
			));
		}
	}
<<<<<<< HEAD
?>
=======
?>
>>>>>>> origin/windowAfterValidate
