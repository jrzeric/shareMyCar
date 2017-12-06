<?php
	//access control
	//allow access from outside the server
	header('Access-Control-Allow-Origin: *');
	//allow methods
	header('Access-Control-Allow-Methods: GET');

	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/scheduletravel.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/city.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/city.php');

	//GET (Read)
	if ($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		//parameters
		if (isset($_GET['id']))
		{
			try {
				//create object
				$c = new ScheduleTravel($_GET['id']);
				//display
				echo json_encode(array(
					'status' => 0,
					'scheduletravel' => json_decode($c->toJson())
				));
			}
			catch (RecordNotFoundException $ex) {
				echo json_encode(array(
					'status' => 2,
					'errorMessage' => $ex->get_message()
				));
			}
		}
		else if(isset($_GET['driver']))
		{
			try
			{
				echo ScheduleTravel::getAllJson($_GET['driver']);
			}
			catch (RecordNotFoundException $ex) 
      		{
        		echo json_encode(array(
          			'status' => 3,
          			'errorMessage' => $ex->get_message()
        			));
			}
		}

		else if(isset($_GET['notificationDriver']))
		{
			try
			{
				echo ScheduleTravel::travelsDriverJson($_GET['notificationDriver']);
			}
			catch (RecordNotFoundException $ex) 
      		{
        		echo json_encode(array(
          			'status' => 4,
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
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		//check parameters
		if (isset($_POST['arrived_at']) &&
			isset($_POST['paymentAmount']) &&
			isset($_POST['id']) &&
			isset($_POST['pickedUp_at']))
		{

			//$this->ride->getArrivedAt(), $this->paymentAmount, $this->pickedUp_at, $this->id, $this->ride->getId()

				//validation
				$errorSD = false;
				//building type
				try
				{
					$st = new ScheduleTravel($_POST['id']);
				}
				catch(RecordNotFoundException $ex)
				{
					$errorSD = true; //found error
					echo json_encode(array(
						'status' => 2,
						'errorMessage' => 'Invalid HistoricalRide'
					));
				}

				if (!$errorSD)
				{
					$st->setPickedUpAt($_POST['arrived_at']);
					$st->setPaymentAmount($_POST['paymentAmount']);
					$st->getRide()->setArrivedAt($_POST['arrived_at']);
					//echo $st->getRide()->getArrivedAt();
					//echo $st->getRide()->getId();
					//echo $st->getId();

					//add
					if ($st->update())
					{


						echo json_encode(array(
							'status' => 0,
							'errorMessage' => 'User added successfully'
						));

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