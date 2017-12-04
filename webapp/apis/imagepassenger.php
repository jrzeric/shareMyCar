<?php
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/studentpassenger.php');

	$id = $_POST['id'];
	if (isset($_FILES['studentId'])) 
	{
		$nombre_temporal = $_FILES['studentId']['tmp_name'];
		$nombre = $_FILES['studentId']['name'];
		$now = date("F j Y g i a");
		$nombre = $now.$nombre;
		if(move_uploaded_file($nombre_temporal, '../files/studentIds/'.$nombre))
		{
			StudentPassenger::images('../files/studentIds/'.$nombre, $id);	
			header('Location: ../client/homePassenger.html');
		}
	}
	else echo "Intenta nuevamente mas tarde";
?>