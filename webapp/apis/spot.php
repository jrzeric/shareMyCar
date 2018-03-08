<?php
	header('Access-Control-Allow-Origin: *');
	//allow methods
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/spot.php');

	//GET (Read)
	if ($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		//parameters
		if (isset($_GET['id']) && isset($_GET['driver']))
		{
			try {
				//create object
				$s = new Spot($_GET['id'],$_GET['driver']);
				//display
				echo json_encode(array(
					'status' => 0,
					'Spot' => json_decode($s->toJson())
				));
			}
			catch (RecordNotFoundException $ex) {
				echo json_encode(array(
					'status' => 1,
					'errorMessage' => $ex->get_message()
				));
			}
		}
		else{
			if(isset($_GET['universityid'])){
				try {
					echo Spot::getSpotUniversityJson($_GET['universityid']);

				} catch (Exception $ex) {
					echo json_encode(array(
						'status' => 1,
						'errorMessage' => $ex->get_message()
					));
				}
			} else {
				if(isset($_GET['driver']) && isset($_GET['day'])) {
					try {
						echo Spot::getSpotDriverByDayJson($_GET['driver'], $_GET['day']);
					} catch (Exception $ex) {
						echo json_encode(array(
							'status' => 1,
							'errorMessage' => $ex->get_message()
						));
					}
				}
				else
				{
					if ($_GET['getLastId']){
						$lastSpot = Spot::getLastSpot();
						echo $lastSpot->toJson();
					}
					else{
						echo json_encode(array(
						'status' => 2,
						'errorMessage' => 'Missing parameters'
					));
					}

				}

			}

		}
	}
	//POST
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		//check parameters
		if (isset($_POST['driver']) &&
			isset($_POST['latitude']) &&
			isset($_POST['longitude']) &&
			isset($_POST['pay']) &&
			isset($_POST['hour']) &&
			isset($_POST['day']) ) {
			//error
			$error = false;
			try {
				$st = new Student($_POST['driver']);
			}
			catch (RecordNotFoundException $ex) {
				echo json_encode(array(
					'status' => 2,
					'errorMessage' => 'Invalid Driver'
				));
				$error = true; //found error
			}
			if (!$error) {
				//create empty object
				$s = new Spot();
				//set values
				$s->setDriver($st);
				$s->setLocation(new Location($_POST['latitude'], $_POST['longitude']));
				$s->setPay($_POST['pay']);
				$s->setHour($_POST['hour']);
				$s->setDay($_POST['day']);
				//add
				if ($s->add()){
					echo json_encode(array(
						'status' => 0,
						'message' => 'Spot added successfully'
					));
				}else{
					echo json_encode(array(
						'status' => 3,
						'message' => 'Could not add Spot'
					));
				}
			}
		}
		else
			echo json_encode(array(
				'status' => 1,
				'errorMessage' => 'Missing parameters'
			));
	}

	if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
		//read data
		parse_str(file_get_contents('php://input'), $putData);
		if (isset($putData['id']) &&
				isset($putData['driver']) &&
				isset($putData['pay']) &&
				isset($putData['hour']) &&
				isset($putData['day'])) {
					try {
						$s = new Spot($putData['id'],$putData['driver']);

						//set values
						$s->setPay($putData['pay']);
						$s->setHour($putData['hour']);
						$s->setDay($putData['day']);
						//add
						if ($s->put())
							echo json_encode(array(
								'status' => 0,
								'message' => 'Spot edited successfully'
							));
						else
							echo json_encode(array(
								'status' => 5,
								'errorMessage' => 'Could not edit spot'
							));
					}
					catch (RecordNotFoundException $ex) {
						echo json_encode(array(
							'status' => 4,
							'errorMessage' => 'Invalid spot id'
						));
					}
				}
			else
				echo json_encode(array(
					'status' => 1,
					'errorMessage' => 'Missing data parameter'
				));
		}
	//DELETE (delete)
	if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
		//read id
		parse_str(file_get_contents('php://input'), $putData);
		if (isset($putData['id']) && isset($putData['driver'])) {
			try {
				//create object
				$s = new Spot($putData['id'],$putData['driver']);
				//delete
				if ($s->delete())
					echo json_encode(array(
						'status' => 0,
						'errorMessage' => 'Spot finished'
					));
				else
					echo json_encode(array(
						'status' => 3,
						'errorMessage' => 'Could not finished spot'
					));
			}
			catch(RecordNotFoundException $ex) {
				echo json_encode(array(
					'status' => 2,
					'errorMessage' => 'Invalid parameters'
				));
			}
		}
		else {
			echo json_encode(array(
				'status' => 1,
				'errorMessage' => 'Missing parameters'
			));
		}
	}
?>
