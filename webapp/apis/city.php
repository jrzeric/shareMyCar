<?php
	//access control
	//allow access from outside the server
	header('Access-Control-Allow-Origin: *');
	//allow methods
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/city.php');

	//GET (Read)
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		//parameters
		if (isset($_GET['id'])) {
			try{
				//object
				$c = new City($_GET['id']);
				//display
				echo json_encode(array(
					'status' => 0,
					'city' => json_decode($c->toJson())
				));
			}
			catch (RecordNotFoundException $ex) {
				echo json_encode(array(
					'status' => 1,
					'errorMessage' => $ex->get_message()
				));
			}
		}
		else {
			if (isset($_GET['state'])) {
				try
				{
					echo City::getAllCitiesByStateJson($_GET['state']);
				}//try
				catch (RecordNotFoundException $ex) {
					echo json_encode(array(
						'status' => 1,
						'errorMessage' => $ex->get_message()
					));
				}//catch
			}//if
			else
				echo City::getAllJson();
		}
	}
?>
