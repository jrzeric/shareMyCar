<?php
	//access control
	//allow access from outside the server
	header('Access-Control-Allow-Origin: *');
	//allow methods
	header('Access-Control-Allow-Methods: GET');

	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/reports.php');
	
	//GET (Read)
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		//parameters
		if(isset($_GET['id'])){
			try{
				//create a object
				$r = new Report($_GET['id']);
				//display
				echo json_encode(array(
					'status' => 0,
					'report' => json_decode($r->toJson())
				));	
			}
			catch(RecordNotFoundException $ex){
				echo json_encode(array(
					'status' => 1,
					'errorMessage' => $ex->get_message()
				));
			}
		}
		else{
			echo Report::getAllJson();
		}
	}
?>