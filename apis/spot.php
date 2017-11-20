<?php
  // access Control
  // allow access from aoutside the server
  header('Access-Control-Allow-Origin: *');
  // alloww Methods
  header('Access-Control-Allow-Methods: GET, PUT');

  require_once($_SERVER['DOCUMENT_ROOT'].'/apis/models/spot.php');

  // GET
  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
      try {
        // create object
        $spot = new Spot($_GET['id']);
        // display
        echo json_encode(array(
          'status' => 0,
          'spot' => json_decode($spot->toJson())
        ));
      } catch (RecordNotFoundException $ex) {
        echo json_encode(array(
          'status' => 1,
          'errorMessage' => $ex->get_message()
        ));
      }
    } else {
      echo Spot::getAllJson();
    }


  }
?>
