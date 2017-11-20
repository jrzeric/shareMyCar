<?php
	//allow access
	header('Access-Control-Allow-Access: *');
	//allow methods
	header('Access-Control-Allow-Methods: GET');
	//allow headers
	header('Access-Control-Allow-Headers: email, password');
	//read headers
	$headers = getallheaders();

	//use user class
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/user.php');
	//use security
	require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/security/security.php');
	//check if headers were received
	if (isset($headers['email']) && isset($headers['password'])) {
		//authenticate user
		try {
			//create user
			$user = new User($headers['email'], $headers['password']);
			//diplay
			echo json_encode(array(
				'status' => 0,
				'user' => json_decode($user->toJson()),
				'token' => Security::generateToken($headers['email'])
			));
		}
		catch (InvalidUserException $ex) {
			echo json_encode(array(
			'status' => 2,
			'errorMessage' => $ex->get_message()
		));
		}
	}
	else
		echo json_encode(array(
			'status' => 1,
			'errorMessage' => 'Missing headers'
		));
?>
