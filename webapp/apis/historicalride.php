<?php
	//access control
	//allow access from outside the server
	header('Access-Control-Allow-Origin: *');
	//allow methods
	header('Access-Control-Allow-Methods: POST');

	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/studentdriver.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/studentpassenger.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/historicalride.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/scheduletravel.php');

	if ($_SERVER['REQUEST_METHOD'] == 'GET') 
	{
		if (isset($_GET['id']))
		{
			try {
				//create object
				$st = new HistoricalRide($_GET['id']);
				//display
				echo json_encode(array(
					'status' => 0,
					'historicalride' => json_decode($st->toJson())
				));
			}
			catch (RecordNotFoundException $ex) {
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

	//POST
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		//check parameters
		if (isset($_POST['endLatitude']) &&
			isset($_POST['endLongitude']) &&
			isset($_POST['driver']) &&
			isset($_POST['passenger']) &&
			isset($_POST['beginLatitude']) &&
			isset($_POST['beginLongitude']))
		{
				//validation
				$errorSD = false;
				$errorSP = false;
				//building type
				try
				{
					$sd = new StudentDriver($_POST['driver']);
				}
				catch(RecordNotFoundException $ex)
				{
					$errorSD = true; //found error
					echo json_encode(array(
						'status' => 2,
						'errorMessage' => 'Invalid StudentDriver'
					));
				}

				try
				{
					$sp = new StudentPassenger($_POST['passenger']);
				}
				catch(RecordNotFoundException $ex)
				{
					$errorSP = true; //found error
					echo json_encode(array(
						'status' => 3,
						'errorMessage' => 'Invalid Passenger'
					));
				}

				if (!$errorSD && !$errorSP)
				{

					$hr = new HistoricalRide();
					$hr->setDriver($sd);

					$st = new ScheduleTravel();
					$st->setBeginLatitude($_POST['beginLatitude']);
					$st->setBeginLongitude($_POST['beginLongitude']);
					$st->setPassenger($sp);

					$hr->setEndLatitude($_POST['endLatitude']);
					$hr->setEndLongitude($_POST['endLongitude']);

					//add
					if ($hr->add())
					{


						echo json_encode(array(
							'status' => 0,
							'errorMessage' => 'User added successfully'
						));

						$st->add();

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