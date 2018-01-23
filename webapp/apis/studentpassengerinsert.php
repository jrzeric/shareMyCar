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

	/*This post only works if the form is sended*/
	//POST
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    /*Check if set those parameters which are:
		    lastName:   		last name of the passenger
		    secondLastName:     second last name of the passenger
		    name:  				name of the passenger
		    birthDate: 			birth date of the passenger
		    email:      		email of the passsenger
		    university:     	id of the university of the passenger
		    cellphone:     		cellphone of the passenger
		    controlNumber:     	matricula of the passenger
		    password:     		password of the passenger
		    payAccount:     	payacount like paypal
		    latitude:     		latitude of that lives the passenger
		    longitude:     		longitude of that lives the passenger
		    city:     			id of the city where lives the passenger
		    */
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
					/*Create an object Spot to verify that exist*/
					$u = new University($_POST['university']);
				}
				/*If doesn't exist so the constructor throws an exception and catch that and show the error*/
				catch(RecordNotFoundException $ex)
				{
					/*the error is caused because the id ingresed doesn't exist in the database*/
					$errorU = true; //found error
					echo json_encode(array(
						'status' => 3,
						'errorMessage' => 'Invalid University'
					));
				}

				if (!$errorU)
				{
					/*Create an object*/
					$sp = new StudentPassenger();


					$city = new City($_POST['city']);

					/*Pass the values to the atributes by the properties*/
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
					/*Pass the object previusly created*/
					$sp->setCity($city);

					/*Create an object user*/
					$us = new User();
					/*Set the password*/
					$us->setPassword($_POST['password']);

					$sp->setLocation(new Location($_POST['latitude'], $_POST['longitude']));

					/*Then execute the method add*/
					if ($sp->add())
					{

						/*This message means the spot was added to the database*/
						echo json_encode(array(
							'status' => 0,
							'errorMessage' => 'User added successfully'
						));
						/*If added succescully then add the user to the database*/
						$us->add();

					}
					else
					{
						/*the error is caused because the connection of the database, or the user 
						writed something wrong*/
						echo json_encode(array(
							'status' => 3,
							'errorMessage' => 'Could not add user'
						));

					}

				}
			}
		else
			/*the error is caused because no exist any parameter sended*/
			echo json_encode(array(
				'status' => 1,
				'errorMessage' => 'Missing Parameters'
			));


	}

?>
