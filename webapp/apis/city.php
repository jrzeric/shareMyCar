<?php

	//access control
	//allow access from outside the server
	header('Access-Control-Allow-Origin: *');
	//allow methods
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

	require_once($_SERVER['DOCUMENT_ROOT'].'/models/city.php');

	//GET (Read)
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		//parameters
		if (isset($_GET['code'])) {
			try{
				//create object
				$c = new City($_GET['code']);
				//display
				echo json_encode(array(
					'status' => 0,
					'city' => json_decode($c->toJson())
				));
			}
			catch(RecordNotFoundException $ex) {
				echo json_encode(array(
					'status' => 2,
					'errorMessage' => $ex->get_message()
				));
			}
		}
		else if ($_GET['codeState']) {
			try{
				//create object
				$s = new State($_GET['codeState']);
				echo City::getAllCitiesByStateJson($_GET['codeState']);
			}
			catch(RecordNotFoundException $ex) {
				echo json_encode(array(
					'status' => 4,
					'errorMessage' => $ex->get_message()
				));
			}
		}
		else{
			echo City::getAllJson();
		}
	}

	//POST (Insert)
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		//parameters
		if (isset($_POST['code']) &&
			isset($_POST['name']) &&
			isset($_POST['state'])){
			$errorState = false;
			try {
				$s = new State($_POST['state']);
			} catch (RecordNotFoundException $ex) {
				$errorState = true; //found error
				echo json_encode(array(
					'status' => 3,
					'errorMessage' => 'Invalid State'
				));
			}
			if (!$errorState) {
				$c = new City();
				//assign values
				$c->setCode($_POST['code']);
				$c->setName($_POST['name']);
				$c->setStatus(1);
				$c->setState($s);

				/*Then execute the method add*/
				if ($c->add()) {

					/*This message means the spot was added to the database*/
					echo json_encode(array(
						'status' => 0,
						'errorMessage' => 'City added successfully'
					));
				}	else {
					/*the error is caused because the connection of the database, or the user
					writed something wrong*/
					echo json_encode(array(
						'status' => 1,
						'errorMessage' => 'Could not add City'
					));

				}
			}
		} else {
			echo json_encode(array(
					'status' => 2,
					'errorMessage' => 'Missing Parameters'
				));
		}
	}



	//PUT (update)
	if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
		//read data
		parse_str(file_get_contents('php://input'), $putData);
		if (isset($putData['data'])) {
			//decode json
			$jsonData = json_decode($putData['data'], true);
			//check parameters
			if (isset($jsonData['code']) &&
				isset($jsonData['name']) &&
				isset($jsonData['state']) &&
				isset($jsonData['status'])) {
				$errorState = false;
				try {
					$s = new State($jsonData['state']);
				} catch (RecordNotFoundException $ex) {
					$errorState = true; //found error
					echo json_encode(array(
					'status' => 3,
					'errorMessage' => 'Invalid State'
					));
				}
				if (!$errorState) {
					try {
						$c = new City($jsonData['code']);
						//set values
						$c->setName($jsonData['name']);
						$c->setStatus($jsonData['status']);
						$c->setState($s);
							//add
							if ($c->put())
								echo json_encode(array(
									'status' => 0,
									'errorMessage' => 'City updated successfully'
								));
							else
								echo json_encode(array(
									'status' => 1,
									'errorMessage' => 'Could not update city'
								));
					} catch (RecordNotFoundException $ex) {
							echo json_encode(array(
								'status' => 2,
								'errorMessage' => 'Invalid City id'
							));
            }
          }
        } else
				echo json_encode(array(
					'status' => 3,
					'errorMessage' => 'Missing parameters'
				));
    }
  }


	//DELETE (delete)
	if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
		//read id
		parse_str(file_get_contents('php://input'), $putData);
		if (isset($putData['code'])) {
			try {
				//create object
				$c = new City($putData['code']);
				//delete
				if ($c->delete())
					echo json_encode(array(
						'status' => 0,
						'errorMessage' => 'City deleted successfully'
					));
				else
					echo json_encode(array(
						'status' => 1,
						'errorMessage' => 'Could not delete the City'
					));
			}
			catch(RecordNotFoundException $ex) {
				echo json_encode(array(
					'status' => 3,
					'errorMessage' => 'Invalid city id'
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
?>
