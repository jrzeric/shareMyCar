<?php

	//access control
	//allow access from outside the server
	header('Access-Control-Allow-Origin: *');
	//allow methods
	header('Access-Control-Allow-Methods: GET');

	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/state.php');

	//GET (Read)
	if ($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		//parameters
		if (isset($_GET['id']))
		{
			try {
				//create object
				$s = new State($_GET['id']);
				//display
				echo json_encode(array(
					'status' => 0,
					'state' => json_decode($s->toJson())
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
			echo State::getAllSJson($_GET['idAll']);
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
