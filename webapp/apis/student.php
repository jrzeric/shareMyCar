<?php
	//access control
	//allow access from outside the server
	header('Access-Control-Allow-Origin: *');
	//allow methods
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/student.php');
	
	//GET (Read)
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		//parameters
		if (isset($_GET['id'])) {
			try{
				//object
				$s = new Student($_GET['id']);
				//display
				echo json_encode(array(
					'status' => 0,
					'student' => json_decode($s->toJson())
				));
			}
			catch (RecordNotFoundException $ex) {
				echo json_encode(array(
					'status' => 1,
					'errorMessage' => $ex->get_message()
				));
			}
		}else {
			echo Student::getAllJson();
		}
	}
?>