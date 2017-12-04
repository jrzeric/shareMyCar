<?php
	//access control
	//allow access from outside the server
	header('Access-Control-Allow-Origin: *');
	//allow methods
	header('Access-Control-Allow-Methods: POST');

	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/studentdriver.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/university.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/brand.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/model.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/car.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/user.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/city.php');

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
			isset($_POST['payAccount']) &&
			isset($_POST['brand']) &&
			isset($_POST['model']) &&
			isset($_POST['year']) &&
			isset($_POST['licensePlate']) &&
			isset($_POST['password']) &&
			isset($_POST['latitude']) && 
			isset($_POST['longitude']) &&
			isset($_POST['city'])) 
		{
				//validation
				$error = false;
				$errorU = false;
				$errorB = false;
				//building type
				try
				{
					$m = new Model($_POST['model']);
				}
				catch(RecordNotFoundException $ex)
				{
					$error = true; //found error
					echo json_encode(array(
						'status' => 2,
						'errorMessage' => 'Invalid Model'
					));
				}

				try
				{
					$b = new Brand($_POST['brand']);
				}
				catch(RecordNotFoundException $ex)
				{
					$errorB = true; //found error
					echo json_encode(array(
						'status' => 4,
						'errorMessage' => 'Invalid Brand'
					));
				}

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

				if (!$error && !$errorU && !$errorB)
				{

					$city = City::getIdCity($_POST['city']);

					//create building object
					$sd = new StudentDriver();
					$c = new Car();
					$c->setModel($m);
					$c->setBrand($b);
					$c->setYear($_POST['year']);
					$c->setLicensePlate($_POST['licensePlate']);

					//assign values
					$sd->setName($_POST['name']);
					$sd->setLastName($_POST['lastName']);
					$sd->setSecondLastName($_POST['secondLastName']);
					$sd->setBirthDate($_POST['birthDate']);
					$sd->setEmail($_POST['email']);
					$sd->setCellphone($_POST['cellphone']);
					$sd->setUniversity($u);
					$sd->setControlNumber($_POST['controlNumber']);
					$sd->setPayAccount($_POST['payAccount']);
					$sd->setCity($city);

					$us = new User();
					$us->setPassword($_POST['password']);

					$sd->setLocation(new Location($_POST['latitude'], $_POST['longitude']));

					//add
					if ($sd->add())
					{


						echo json_encode(array(
							'status' => 0,
							'errorMessage' => 'User added successfully'
						));

						$c->add();
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
