<?php
	//access control
	//allow access from outside the server
	header('Access-Control-Allow-Origin: *');
	//allow methods
	header('Access-Control-Allow-Methods: POST');

	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/studentpassenger.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/university.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/user.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/location.php');

	//POST
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		//check parameters
		if (isset($_POST['lastName']) &&
			isset($_POST['secondLastName']) &&
			isset($_POST['name']) &&
			isset($_POST['birthDate']) &&
			isset($_POST['email']) &&
			isset($_POST['university']) &&
			isset($_POST['cellphone']) &&
			isset($_POST['controlNumber']) &&
			isset($_POST['password']) &&
			isset($_POST['payAccount']) &&
			isset($_POST['latitude']) && 
			isset($_POST['longitude'])&&
			isset($_POST['city'])) 
		{
				//validation
				$errorU = false;

				try
				{
					$u = new University($_POST['university']);
				}
				catch(RecordNotFoundException $ex)
				{
					$errorU = true; //found error
					echo json_encode(array(
						'status' => 3,
						'errorMessage' => 'Invalid University'
					));
				}

				if (!$errorU)
				{
					$sp = new StudentPassenger();

					$city = new City($_POST['city']);

					//assign values
					$sp->setName($_POST['name']);
					$sp->setLastName($_POST['lastName']);
					$sp->setSecondLastName($_POST['secondLastName']);
					$sp->setBirthDate($_POST['birthDate']);
					$sp->setEmail($_POST['email']);
					$sp->setCellphone($_POST['cellphone']);
					$sp->setUniversity($u);
					$sp->setControlNumber($_POST['controlNumber']);
					$sp->setPayAccount($_POST['payAccount']);
					$sp->setCity($city);

					$us = new User();
					$us->setPassword($_POST['password']);

					$sp->setLocation(new Location($_POST['latitude'], $_POST['longitude']));

					//add
					if ($sp->add())
					{


						echo json_encode(array(
							'status' => 0,
							'errorMessage' => 'User added successfully'
						));

						$us->add();

					}
					else
					{
						echo json_encode(array(
							'status' => 3,
							'errorMessage' => 'Could not add user'
						));

					}

				}
			}
		else
			echo json_encode(array(
				'status' => 1,
				'errorMessage' => 'Missing Parameters'
			));


	}

?>
