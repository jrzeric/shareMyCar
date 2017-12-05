<?php
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/studentdriver.php');

	$id = $_POST['idForm'];
	$role = $_POST['roleForm'];
	if (isset($_FILES['profile'])) 
	{
		$nombre_temporal = $_FILES['profile']['tmp_name'];
		$nombre = $_FILES['profile']['name'];
		$now = date("FjYgia");
		echo $now;
		$nombre = $now.$nombre;
		if(move_uploaded_file($nombre_temporal, '../files/profilesImages/'.$nombre))
		{
			StudentDriver::images('../files/profilesImages/'.$nombre, $id);
			if ($role == 'Passenger') 
			{
				header('Location: ../client/homePassenger.html');	
			}
			else
				header('Location: ../client/homeDriver.html');	
		}
		else echo "Intenta nuevamente mas tarde";
	
	}
	else echo "Intenta nuevamente mas tarde";
?>