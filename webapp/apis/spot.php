<?php
  // access Control
  // allow access from aoutside the server
  header('Access-Control-Allow-Origin: *');
  // alloww Methods
  header('Access-Control-Allow-Methods: GET, POST, PUT');

  require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/spot.php');
  require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/studentdriver.php');
  require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/location.php');

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
    }
    else if (isset($_GET['idAll'])) 
    {
      try 
      {
        echo Spot::getAllSJson($_GET['idAll']);
      }
      catch (RecordNotFoundException $ex) 
      {
        echo json_encode(array(
          'status' => 2,
          'errorMessage' => $ex->get_message()
        ));
      }
    }
    else if(isset($_GET['city']) && isset($_GET['uni']))
    {
      try 
      {
        echo Spot::getAllSCJson($_GET['city'], isset($_GET['uni']));
      }
      catch (RecordNotFoundException $ex) 
      {
        echo json_encode(array(
          'status' => 2,
          'errorMessage' => $ex->get_message()
        ));
      }

    }

    else 
    {
      echo json_encode(array(
          'status' => 3,
          'errorMessage' => 'Missing parameters'
        ));
      }
    }




  //POST
  if ($_SERVER['REQUEST_METHOD'] == 'POST') 
  {
    if (isset($_POST['student']) &&
        isset($_POST['slot']) &&
        isset($_POST['latitude']) &&
        isset($_POST['longitude']) &&
        isset($_POST['time']) &&
        isset($_POST['price']) ) 
    {
     try 
      {
        // create object
        $s = new StudentDriver($_POST['student']);

      } 
      catch (RecordNotFoundException $ex) 
      {
          echo json_encode(array(
            'status' => 2,
            'errorMessage' => $ex->get_message()
          ));
      }

      $sp = new Spot();
      $sp->setStudent($s);
      $sp->setLocation(new Location($_POST['latitude'], $_POST['longitude']));
      $sp->setSlot($_POST['slot']);
      $sp->setTime($_POST['time']);
      $sp->setPrice($_POST['price']);
      //add
      if ($sp->add())
      {
          echo json_encode(array(
              'status' => 0,
              'errorMessage' => 'Spot added successfully'
            ));

      }
      else
      {
          echo json_encode(array(
              'status' => 3,
              'errorMessage' => 'Could not add spot'
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
?>
