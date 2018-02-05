<?php

	//access control
	//allow access from outside the server
	header('Access-Control-Allow-Origin: *');
	//allow methods
	header('Access-Control-Allow-Methods: GET, POST');

	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/state.php');

	//GET (Read)
	if ($_SERVER['REQUEST_METHOD'] == 'GET'){
		//parameters
		if (isset($_GET['id'])){
			try{
				//create object
				$s = new State($_GET['id']);
				//display
				echo json_encode(array(
					'status' => 0,
					'state' => json_decode($s->toJson())
				));
			}
			catch(RecordNotFoundException $ex){
				echo json_encode(array(
					'status' => 2,
					'errorMessage' => $ex->get_message()
				));
			}
		}
		else{
			echo State::getAllJson();
		}
	}
	
	//POST (Insert)
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		//parameters
		if (isset($_POST['code']) &&
			isset($_POST['name'])){
			/*Create an object state*/
			$s = new State();

			/*Pass the values to the atributes
			by the properties*/
			//assign values
			$s->setCode($_POST['code']);
			$s->setName($_POST['name']);
			$s->setStatus(1);

			/*Then execute the method add*/
			if ($s->add()){

				/*This message means the spot was added to the database*/
				echo json_encode(array(
					'status' => 0,
					'errorMessage' => 'State added successfully'
				));
			}
			else{
				/*the error is caused because the connection of the database, or the user 
				writed something wrong*/
				echo json_encode(array(
					'status' => 1,
					'errorMessage' => 'Could not add State'
				));

			}
		}
		else{
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
				isset($jsonData['status'])) {
					//create empty object
				try {
					$s = new State($jsonData['code']);						
					//set values
					$s->setName($jsonData['name']);
					$s->setStatus($jsonData['status']);
					//add
					if ($s->put())
						echo json_encode(array(
							'status' => 0,
							'errorMessage' => 'State updated successfully'
						));
					else
						echo json_encode(array(
							'status' => 1,
							'errorMessage' => 'Could not update state'
						));
				}
				catch (RecordNotFoundException $ex) {
					echo json_encode(array(
						'status' => 2,
						'errorMessage' => 'Invalid state id'
					));
				}
			}
			else
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
				$b = new State($putData['code']);
				//delete
				if ($b->delete())
					echo json_encode(array(
						'status' => 0,
						'errorMessage' => 'State deleted successfully'
					));
				else
					echo json_encode(array(
						'status' => 1,
						'errorMessage' => 'Could not delete state'
					));
			}
			catch(RecordNotFoundException $ex) {
				echo json_encode(array(
					'status' => 3,
					'errorMessage' => 'Invalid state id'
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
