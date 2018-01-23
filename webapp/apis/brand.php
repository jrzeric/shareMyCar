<?php
	//access control
	//allow access from outside the server
	header('Access-Control-Allow-Origin: *');
	//allow methods
	header('Access-Control-Allow-Methods: GET');

	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/brand.php');

	//GET (Read)
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		/*Verify that id is declared*/
		if (isset($_GET['id'])) {
			try {
				/*Create an object Spot to verify that exist*/
				$b = new Brand($_GET['id']);
				//display
				/*display the object created previously*/
				echo json_encode(array(
					'status' => 0,
					'brand' => json_decode($b->toJson())
				));
			}
			/*If doesn't exist so the constructor throws an exception and catch that and show the error*/
			catch (RecordNotFoundException $ex) {
				/*the error is caused because the id ingresed doesn't exist in the database*/
				echo json_encode(array(
					'status' => 1,
					'errorMessage' => $ex->get_message()
				));
			}
		}
		else {
			/*if we don't recive paramerts will show all brands*/
			echo Brand::getAllJson();
		}

	}

?>
