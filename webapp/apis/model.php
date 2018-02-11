<?php

	//access control
	//allow access from outside the server
	header('Access-Control-Allow-Origin: *');
	//allow methods
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/model.php');

	//GET (Read)
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		//parameters
		if (isset($_GET['id'])) {
			try {
				//create object
				$m = new Model($_GET['id']);
				//display
				echo json_encode(array(
					'status' => 0,
					'model' => json_decode($m->toJson())
				));
			}
			catch(RecordNotFoundException $ex) {
				echo json_encode(array(
					'status' => 2,
					'errorMessage' => $ex->get_message()
				));
			}
		}
		else if (isset($_GET['idBrand'])) {
			try {
				//create object
				$b = new Brand($_GET['idBrand']);
				echo Model::getAllModelsByBrandJson($_GET['idBrand']);
			}
			catch(RecordNotFoundException $ex) {
				echo json_encode(array(
					'status' => 4,
					'errorMessage' => $ex->get_message()
				));
			}
		}
		else{
			echo Model::getAllJson();
		}
	}

	//POST (Insert)
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		//parameters
		if (isset($_POST['brand']) &&
			isset($_POST['name'])) {
			$errorBrand = false;
			try {
				$b = new Brand($_POST['brand']);
			} catch (RecordNotFoundException $ex) {
				$errorBrand = true; //found error
				echo json_encode(array(
					'status' => 3,
					'errorMessage' => 'Invalid Brand'
				));
			}
			if (!$errorBrand) {
				$m = new Model();
				//assign values
				$m->setName($_POST['name']);
				$m->setStatus(1);
				$m->setBrand($b);

				/*Then execute the method add*/
				if ($m->add()) {

					/*This message means the spot was added to the database*/
					echo json_encode(array(
						'status' => 0,
						'errorMessage' => 'Model added successfully'
					));
				}
				else{
					/*the error is caused because the connection of the database, or the user
					writed something wrong*/
					echo json_encode(array(
						'status' => 1,
						'errorMessage' => 'Could not add Model'
					));

				}
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
			if (isset($jsonData['id']) &&
				isset($jsonData['name']) &&
				isset($jsonData['brand']) &&
				isset($jsonData['status'])) {
				$errorBrand = false;
				try {
					$b = new Brand($jsonData['brand']);
				} catch (RecordNotFoundException $ex) {
					$errorBrand = true; //found error
					echo json_encode(array(
					'status' => 3,
					'errorMessage' => 'Invalid Brand'
					));
				}
				if (!$errorBrand) {
					try {
						$m = new Model($jsonData['id']);
						//set values
						$m->setName($jsonData['name']);
						$m->setStatus($jsonData['status']);
						$m->setBrand($b);
							//add
							if ($m->put())
								echo json_encode(array(
									'status' => 0,
									'errorMessage' => 'Model updated successfully'
								));
							else
								echo json_encode(array(
									'status' => 1,
									'errorMessage' => 'Could not update Model'
								));
							}
						catch (RecordNotFoundException $ex) {
							echo json_encode(array(
								'status' => 2,
								'errorMessage' => 'Invalid Model id'
							));
						}
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
		if (isset($putData['id'])) {
			try {
				//create object
				$m = new Model($putData['id']);
				//delete
				if ($m->delete())
					echo json_encode(array(
						'status' => 0,
						'errorMessage' => 'Model deleted successfully'
					));
				else
					echo json_encode(array(
						'status' => 1,
						'errorMessage' => 'Could not delete the Model'
					));
			}
			catch(RecordNotFoundException $ex) {
				echo json_encode(array(
					'status' => 3,
					'errorMessage' => 'Invalid Model id'
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
