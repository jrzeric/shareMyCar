<?php
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/studentdriver.php');

	$id = $_POST['id'];
	if (isset($_FILES['studentId']) && isset($_FILES['driverLicense'])) 
	{
		$nombre_temporal = $_FILES['studentId']['tmp_name'];
		$nombre_temporal1 = $_FILES['driverLicense']['tmp_name'];
		$nombre = $_FILES['studentId']['name'];
		$nombre1 = $_FILES['driverLicense']['name'];
		$now = date("FjYgia");
		$nombre = $now.$nombre;
		$nombre1 = $now.$nombre1;
		if(move_uploaded_file($nombre_temporal, '../files/studentIds/'.$nombre))
		{
			
			if(move_uploaded_file($nombre_temporal1, '../files/driverLicenses/'.$nombre1))
			{
				//echo "chingon";
				StudentDriver::images('../files/driverLicenses/'.$nombre1, '../files/studentIds/'.$nombre, $id);
				header('Location: ../client/homeDriver.html');	
			}
			else
			{
				//echo "te la pelaste";
			}
		}
		else echo "Intenta nuevamente mas tarde";
	
	}
	else echo "Intenta nuevamente mas tarde";
?>