<?php
	
	//access control
	//allow access from outside the server
	header('Access-Control-Allow-Origin: *');
	//allow methods
	header('Access-Control-Allow-Methods: GET');

	require_once($_SERVER['DOCUMENT_ROOT'].'/apis/models/model.php');

	//GET (Read)
	if ($_SERVER['REQUEST_METHOD'] == 'GET') 
	{
		//parameters
		if (isset($_GET['id'])) 
		{
			try {
				//create object
				$m = new Model($_GET['id']);
				//display
				echo json_encode(array(
					'status' => 0,
					'model' => json_decode($m->toJson())
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
			echo Model::getAllMJson($_GET['idAll']);
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