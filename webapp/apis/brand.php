<?php
	//access control
	//allow access from outside the server
	header('Access-Control-Allow-Origin: *');
	//allow methods
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/brand.php');

	//GET (Read)
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		//parameters
		if (isset($_GET['id'])) {
			try {
				//create object
				$b = new Brand($_GET['id']);
				//display
				echo json_encode(array(
					'status' => 0,
					'brand' => json_decode($b->toJson())
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
			echo Brand::getAllJson();
		}
	}

	//POST (Insert)
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		//parameters
		if (isset($_POST['name']) &&
			isset($_POST['image'])) {
			/*Create an object Brand*/
			$b = new Brand();

			/*Pass the values to the atributes
			by the properties*/
			//assign values
			$b->setName($_POST['name']);
			$b->setImage($_POST['image']);
			$b->setStatus(1);

			/*Then execute the method add*/
			if ($b->add()) {

				/*This message means the spot was added to the database*/
				echo json_encode(array(
					'status' => 0,
					'errorMessage' => 'Brand added successfully'
				));
			}
			else {
				/*the error is caused because the connection of the database, or the user
				writed something wrong*/
				echo json_encode(array(
					'status' => 1,
					'errorMessage' => 'Could not add brand'
				));

			}
		}
		else {
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
				isset($jsonData['image']) &&
				isset($jsonData['status'])) {
					//create empty object
				try {
					$b = new Brand($jsonData['id']);
					//set values
					$b->setName($jsonData['name']);
					$b->setImage($jsonData['image']);
					$b->setStatus($jsonData['status']);
					//add
					if ($b->put())
						echo json_encode(array(
							'status' => 0,
							'errorMessage' => 'Brand updated successfully'
						));
					else
						echo json_encode(array(
							'status' => 1,
							'errorMessage' => 'Could not update Brand'
						));
				}
				catch (RecordNotFoundException $ex) {
					echo json_encode(array(
						'status' => 2,
						'errorMessage' => 'Invalid Brand id'
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
		if (isset($putData['id'])) {
			try {
				//create object
				$b = new Brand($putData['id']);
				//delete
				if ($b->delete())
					echo json_encode(array(
						'status' => 0,
						'errorMessage' => 'Brand deleted successfully'
					));
				else
					echo json_encode(array(
						'status' => 1,
						'errorMessage' => 'Could not delete Brand'
					));
			}
			catch(RecordNotFoundException $ex) {
				echo json_encode(array(
					'status' => 3,
					'errorMessage' => 'Invalid Brand id'
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
