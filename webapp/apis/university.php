<?php

	//access control
	//allow access from outside the server
	header('Access-Control-Allow-Origin: *');
	//allow methods
	header('Access-Control-Allow-Methods: GET');

	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/university.php');

	//GET (Read)
	if ($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		//parameters
		if (isset($_GET['id']))
		{
			try {
				//create object
				$u = new University($_GET['id']);
				//display
				echo json_encode(array(
					'status' => 0,
					'university' => json_decode($u->toJson())
				));
			}
			catch (RecordNotFoundException $ex) {
				echo json_encode(array(
					'status' => 1,
					'errorMessage' => $ex->get_message()
				));
			}
		}
		else if(isset($_GET['idAll']))
		{
			echo university::getAllUJson($_GET['idAll']);
		}
		else
		{
			echo json_encode(array(
					'status' => 1,
					'errorMessage' => 'Missing parameters'
				));
		}
		}
?>
