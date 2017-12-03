<?php
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/studentpassenger.php');

	$id = 1;
	if (isset($_FILES['studentId']) && isset($_FILES['driverLicense'])) 
	{
		$nombre_temporal = $_FILES['studentId']['tmp_name'];
		$nombre_temporal1 = $_FILES['driverLicense']['tmp_name'];
		$nombre = $_FILES['studentId']['name'];
		$nombre1 = $_FILES['driverLicense']['name'];
		$now = date("F j Y g i a");
		$nombre = $now.$nombre;
		$nombre1 = $now.$nombre1;
		if(move_uploaded_file($nombre_temporal, '../files/studentIds/'.$nombre))
		{
			echo "shit";
			move_uploaded_file($nombre_temporal1, '../files/driverLicenses/'.$nombre1);
		}
		else echo "Intenta nuevamente mas tarde";
	
	}
	else if (isset($_FILES['studentId'])) 
	{
		echo "shit1";
		$nombre_temporal = $_FILES['studentId']['tmp_name'];
		$nombre = $_FILES['studentId']['name'];
		$now = date("F j Y g i a");
		$nombre = $now.$nombre;
		if(move_uploaded_file($nombre_temporal, '../files/studentIds/'.$nombre))
		{
			echo "shit2";
			if (isset($_FILES['photo'])) 
			{
				echo "shit3";
				$nombre_temporal1 = $_FILES['photo']['tmp_name'];
				$nombre1 = $_FILES['photo']['name'];
				$nombre1 = $now.$nombre1;
				move_uploaded_file($nombre_temporal1, '../files/profileImages/'.$nombre1);
				StudentPassenger::PhotoAndId($id, '../files/profileImages/'.$nombre1, '../files/studentIds/'.$nombre);	
			}
			else
			{
				//StudentPassenger::PhotoAndId($id, '../files/profileImages/'.$nombre1, '../files/studentIds/'.$nombre);
				echo "shit";
			}
		}
	}
	else echo "Intenta nuevamente mas tarde";
?>