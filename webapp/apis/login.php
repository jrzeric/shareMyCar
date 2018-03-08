<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

  //allow headers
  header('Access-Control-Allow-Headers: email, password');
  //read headers
  $headers = getallheaders();

require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/users.php');

//GET (Read)
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  //parameters
  if (isset($headers['email']) && isset($headers['password'])) {
    try{
      //create object
      $user = new Users($headers['email'], $headers['password']);
      $user->studentHasCar($headers['email']);
      //display
      if ($user->getDriver()) 
      {
        echo json_encode(array(
          'status' => 1,
          'user' => json_decode($user->toJsonDriver())
          ));
      }
      else
      {
        echo json_encode(array(
          'status' => 0,
          'user' => json_decode($user->toJsonPassenger())
          ));
      }

    }
    catch(RecordNotFoundException $ex) {
      echo json_encode(array(
        'status' => 2,
        'errorMessage' => $ex->get_message()
      ));
    }
  }
}

?>
