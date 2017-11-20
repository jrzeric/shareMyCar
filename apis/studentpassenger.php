<?php
	//access control
	//allow access from outside the server
	header('Access-Control-Allow-Origin: *');
	//allow methods
	header('Access-Control-Allow-Methods: GET, PUT');
	//allow headers
	header('Access-Control-Allow-Headers: email, token');


	require_once($_SERVER['DOCUMENT_ROOT'].'/apis/models/studentpassenger.php');

	//use files
	require_once($_SERVER['DOCUMENT_ROOT'].'/apis/security/security.php');

	//validate token
	$headers = getallheaders(); //get headers
	if (isset($headers['email']) && isset($headers['token'])) {
		if ($headers['token'] != Security::generateToken($headers['email'])) {
			echo json_encode(array(
				'status' => 2,
				'errorMessage' => 'Invalid security headers'
			));
			die(); //en process
		}
	}
	else {
		echo json_encode(array(
			'status' => 1,
			'errorMessage' => 'Missing security headers'
		));
		die(); //en process
	}

	//GET (Read)
	if ($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		//parameters
		if (isset($_GET['id']))
		{
			try
			{
				//create object
				$sd = new StudentPassenger($_GET['id']);
				//display
				echo json_encode(array(
					'status' => 0,
					'student' => json_decode($sd->toJson())
				));
			}
			catch (RecordNotFoundException $ex)
			{
				echo json_encode(array(
					'status' => 1,
					'errorMessage' => $ex->get_message()
				));
			}
		}
		else
		{
			echo json_encode(array(
					'status' => 1,
					'errorMessage' => 'Missing parameters'
				));
		}
	}

	//PUT
	if ($_SERVER['REQUEST_METHOD'] == 'PUT')
	{

		//read parameters
		parse_str(file_get_contents('php://input'), $putData);
		//check parameters
		if (isset($putData['data']))
		{
			//encode data parameter
			$jsonData = json_decode($putData['data'], true);
			//check parameters
			//check parameters
			if (isset($jsonData['lastName']) &&
				isset($jsonData['secondLastName']) &&
				isset($jsonData['name']) &&
				isset($jsonData['birthDate']) &&
				isset($jsonData['email']) &&
				isset($jsonData['university']) &&
				isset($jsonData['cellphone']) &&
				isset($jsonData['controlNumber']) &&
				isset($jsonData['studentId']) &&
				isset($jsonData['payAccount']) &&
				isset($jsonData['id']))
			{
					//validation
					$error = false;
					$errorU = false;
					//building type
					try
					{
						$sd = new StudentPassenger($jsonData['id']);
					}
					catch(RecordNotFoundException $ex)
					{
						$error = true; //found error
						echo json_encode(array(
							'status' => 1,
							'errorMessage' => $ex->get_message()
						));
					}

					try
					{
						$u = new University($jsonData['university']);
					}
					catch(RecordNotFoundException $ex)
					{
						$errorU = true; //found error
						echo json_encode(array(
							'status' => 3,
							'errorMessage' => 'Invalid University'
						));
					}

					if (!$error && !$errorU)
					{
						//assign values
						$sd->setName($jsonData['name']);
						$sd->setLastName($jsonData['lastName']);
						$sd->setSecondLastName($jsonData['secondLastName']);
						$sd->setBirthDate($jsonData['birthDate']);
						$sd->setEmail($jsonData['email']);
						$sd->setCellphone($jsonData['cellphone']);
						$sd->setUniversity($u);
						$sd->setControlNumber($jsonData['controlNumber']);
						$sd->setStudentId($jsonData['studentId']);
						$sd->setPayAccount($jsonData['payAccount']);

						//add
						if ($sd->update())
							echo json_encode(array(
								'status' => 0,
								'errorMessage' => 'User updated successfully'
							));

						else
							echo json_encode(array(
								'status' => 3,
								'errorMessage' => 'Could not update user'
							));
					}
			}

			else
				echo json_encode(array(
					'status' => 1,
					'errorMessage' => 'Missing Parameters'
				));

		}

	}

?>
