<?php
// access Control
// allow access from aoutside the server
header('Access-Control-Allow-Origin: *');
// alloww Methods
header('Access-Control-Allow-Methods: GET, PUT');

require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/historicalridestatus.php');

// GET
// GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (isset($_GET['code'])) {
    try {
      // create object
      $rs = new HistoricalRideStatus($_GET['code']);
      // display
      echo json_encode(array(
        'status' => 0,
        'status' => json_decode($rs->toJson())
      ));
    } catch (RecordNotFoundException $ex) {
      echo json_encode(array(
        'status' => 1,
        'errorMessage' => $ex->get_message()
      ));
    }
  } else {
    echo json_encode(array(
      'status' => 2,
      'errorMessage' => 'Missing parameters'
    ));
  }


}
?>
