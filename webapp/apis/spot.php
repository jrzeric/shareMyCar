<?php
  // access Control
  // allow access from aoutside the server
  header('Access-Control-Allow-Origin: *');
  // alloww Methods
  header('Access-Control-Allow-Methods: GET, POST, PUT');

  /*Require of the classes*/
  require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/spot.php');
  require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/studentdriver.php');
  require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/models/location.php');

  // GET
  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    /*Verify that id is declared*/
    if (isset($_GET['id'])) {
      try {
        // create object
        /*Create an object Spot to verify that exist*/
        $spot = new Spot($_GET['id']);
        // display
        /*display the object created*/
        echo json_encode(array(
          'status' => 0,
          'spot' => json_decode($spot->toJson())
        ));
        /*If doesn't exist so the constructor throws an exception and catch that and show the error*/
      } catch (RecordNotFoundException $ex) {
        /*the error is caused because the id ingresed doesn't exist in the database*/
        echo json_encode(array(
          'status' => 1,
          'errorMessage' => $ex->get_message()
        ));
      }
    }
    /*If id doesn't sended so check if idAll is contained
      idAll is an ID of the driver, so this part returns 
      all spots of a driver*/
    else if (isset($_GET['idAll'])) 
    {
      try 
      {
        /*Calls a static method and verify the existence of spot 
        for that driver*/
        echo Spot::getAllSJson($_GET['idAll']);
      }
      catch (RecordNotFoundException $ex) 
      {
        /*the error is caused because the driver doesn't have any spots registered*/
        echo json_encode(array(
          'status' => 2,
          'errorMessage' => $ex->get_message()
        ));
      }
    }
    /*If doesn't sended idAll so check city and uni is contaided
      both refers at the city and university of the student passenger
      get all spots that exist in the city of the passenger and go to the university of the same*/
    else if(isset($_GET['city']) && isset($_GET['uni']))
    {
      try 
      {
        /*Calls a static method and verify the existence of spots 
        for the city that go to the university of the passenger*/
        echo Spot::getAllSCJson($_GET['city'], isset($_GET['uni']));
      }
      catch (RecordNotFoundException $ex) 
      {
        /*the error is caused because any driver have any spots registered of 
        the city that go of the university*/
        echo json_encode(array(
          'status' => 2,
          'errorMessage' => $ex->get_message()
        ));
      }

    }

    else 
    {
      /*the error is caused because no exist any parameter sended*/
      echo json_encode(array(
          'status' => 3,
          'errorMessage' => 'Missing parameters'
        ));
      }
    }



  /*This post only works if the form is sended*/
  //POST
  if ($_SERVER['REQUEST_METHOD'] == 'POST') 
  {
    /*Check if set those parameters which are:
    student:   means the driver
    slot:      the number of the spot
    latitude:  latitude of the spot
    longitude: longitude of the spot
    time:      time at the driver passes of that spot
    price:     price of that spot until the university
    */
    if (isset($_POST['student']) &&
        isset($_POST['slot']) &&
        isset($_POST['latitude']) &&
        isset($_POST['longitude']) &&
        isset($_POST['time']) &&
        isset($_POST['price']) ) 
    {
     try 
      {
        /*Creates an object with the class Student driver to verify 
        if exist in the database*/
        // create object
        $s = new StudentDriver($_POST['student']);

      } 
      catch (RecordNotFoundException $ex) 
      {
        /*the error is caused because the id ingresed doesn't exist in the database*/
          echo json_encode(array(
            'status' => 2,
            'errorMessage' => $ex->get_message()
          ));
      }
      /*Create a new object spot*/
      $sp = new Spot();
      /*The student created previously passed by the property*/
      /*Then pass the parameters to the atributes by the properties*/
      $sp->setStudent($s);
      $sp->setLocation(new Location($_POST['latitude'], $_POST['longitude']));
      $sp->setSlot($_POST['slot']);
      $sp->setTime($_POST['time']);
      $sp->setPrice($_POST['price']);
      //add
      /*Then execute the method add*/
      if ($sp->add())
      {
        /*This message means the spot was added to the database*/
          echo json_encode(array(
              'status' => 0,
              'errorMessage' => 'Spot added successfully'
            ));

      }
      else
      {
        /*the error is caused because the connection of the database*/
          echo json_encode(array(
              'status' => 3,
              'errorMessage' => 'Could not add spot'
            ));

      }
    } 
    else 
    {
      /*the error is caused because no exist any parameter sended*/
      echo json_encode(array(
              'status' => 1,
              'errorMessage' => 'Missing parameters'
            ));
    }
  }
?>
