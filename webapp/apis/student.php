<?php
	//access control
	//allow access from outside the server
	header('Access-Control-Allow-Origin: *');
	//allow methods
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

	/*header('Access-Control-Allow-Headers: email, password');
	//read headers
	$headers = getallheaders();*/

	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/student.php');

	//GET (Read)
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		//parameters
		if (isset($_GET['id'])) {
			try{
				//object
				$s = new Student($_GET['id']);
				$s->studentHasCar($_GET['id']);
				//
				if ($s->getDriver()) 
				{
					echo json_encode(array(
						'status' => 0,
						'student' => json_decode($s->toJsonDriver())
					));
				}
				//
				else
				{
					echo json_encode(array(
						'status' => 0,
						'student' => json_decode($s->toJsonPassenger())
					));
				}

			}
			catch (RecordNotFoundException $ex) {
				echo json_encode(array(
					'status' => 1,
					'errorMessage' => $ex->get_message()
				));
			}
		}
		else {
			if (isset($_GET['idStatus'])) 
			{
				if (Student::updateStatus($_GET['idStatus'])) 
				{
					echo json_encode(array(
						'status' => 1,
						'message' => 'You will be a driver'
					));
				}
				else
				{
					echo Student::getAllJson();
				}
			}
		}
	}

	//POST (insert)
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		if (isset($_POST['name']) &&
			isset($_POST['surname']) &&
			isset($_POST['secondSurname']) &&
			isset($_POST['email']) &&
			isset($_POST['cellPhone']) &&
			isset($_POST['university']) &&
			isset($_POST['controlNumber']) &&
			isset($_POST['latitude']) &&
			isset($_POST['longitude']) &&
			isset($_POST['photo']) &&
			isset($_POST['city']) &&
			isset($_POST['turn']) &&
			isset($_POST['password']) &&
			isset($_POST['profile'])) {
			//error
			$error = false;
			//university id
			try {
				$u = new University($_POST['university']);
			}
			catch(RecordNotFoundException $ex){
				echo json_encode(array(
					'status' => 2,
					'errorMessage' => 'Invalid universityId'
				));
				$error = true; //found error
			}

			try{
				$c = City::getCityByName($_POST['city']);
			}
			catch(RecordNotFoundException $ex){
				echo json_encode(array(
					'status' => 2,
					'errorMessage' => 'Invalid city name'
				));
				$error = true; //found error
			}

			try{
				$p = new Profile($_POST['profile']);
			}
			catch(RecordNotFoundException $ex){
				echo json_encode(array(
					'status' => 2,
					'errorMessage' => 'Invalid profileId'
				));
				$error = true; //found error
			}

			//add student
			if (!$error) {
				//object
				$s = new Student();
				//set values
				$s->setName($_POST['name']);
				$s->setSurName($_POST['surname']);
				$s->setSecondSurname($_POST['secondSurname']);
				$s->setEmail($_POST['email']);
				$s->setCellPhone($_POST['cellPhone']);
				$s->setUniversity($u);
				$s->setControlNumber($_POST['controlNumber']);
				$s->setLatitude($_POST['latitude']);
				$s->setLongitude($_POST['longitude']);
				$s->setPhoto($_POST['photo']);
				$s->setCity($c);
				$s->setTurn($_POST['turn']);
				$s->setProfile($p);
				$s->setPassword($_POST['password']);
				//add
				if ($s->add()){
					echo json_encode(array(
						'status' => 0,
						'message' => 'Student added successfully'
					));
				}else{
					echo json_encode(array(
						'status' => 3,
						'errorMessage' => 'Could not add student'
					));
				}
			}
		}
		else{
			echo json_encode(array(
				'status' => 1,
				'errorMessage' => 'Missing parameters'
			));
		}
	}
?>
