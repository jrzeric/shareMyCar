<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require_once($_SERVER['DOCUMENT_ROOT'].'/models/users.php');

//GET (Read)
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  //parameters
  if (isset($_GET['user']) && isset($_GET['password'])) {
    try{
      //create object
      $user = new Users($_GET['user'],$_GET['password']);
      //display
      echo json_encode(array(
        'status' => 0,
        'user' => json_decode($user->toJson())
      ));
    }
    catch(RecordNotFoundException $ex) {
      echo json_encode(array(
        'status' => 2,
        'errorMessage' => $ex->get_message()
      ));
    }
  }
  else{
    echo State::getAllJson();
  }
}

?>
