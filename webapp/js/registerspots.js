var map;
var spots;
var meet;
var valid = 0;
var id = sessionStorage.userId;
var day = "Monday";

var priceTimeAndNumber = [];
var latAndLng = [];
var markers = [];
//var coordinates = [[sessionStorage.userLocationLat, sessionStorage.userLocationLon]];
//Declaracion de variables

function init()
{
  console.log(sessionStorage.userLatitude + ", " + sessionStorage.userLongitude);
    map = new google.maps.Map(document.getElementById('map'),
    {
      zoom: 10,
      center: new google.maps.LatLng(sessionStorage.userLatitude, sessionStorage.userLongitude),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    // This event listener will call addMarker() when the map is clicked.
    map.addListener('click', function(event)
    {
      addMarker(event.latLng);
    });

  var x = new XMLHttpRequest();
  //prepare request
  x.open('GET', 'http://localhost:8080/sharemycar/webapp/apis/spot.php?driver='+id+'&day=Monday', true);//ONLY FOR TEST CHANGE THIS AFTER FOR ID REGISTERED IN SESION
  x.send();
  //handle readyState change event
  x.onreadystatechange = function()
  {
    if (x.status == 200 && x.readyState == 4)
    {
      var JSONdata = JSON.parse(x.responseText);
      console.log(x.responseText);
      //get buildings array
      var spots = JSONdata.Spots;
      console.log(spots);
      //read buildings
      for(var i = 0; i < spots.length; i++)
      {
        var hour = spots[i].hour;
        var id = spots[i].id;
        var price = spots[i].pay;
        addMarkerWithInfo(spots[i].location.latitude, spots[i].location.longitude, price, hour, id);
      }//for
    }
  }


    // Adds a marker at the center of the map.
    addHome();
    addUniversity();
}


// Adds a marker to the map and push to the array.
function addHome()
{
  var location = new google.maps.LatLng(sessionStorage.userLatitude, sessionStorage.userLongitude);
  var marker = new google.maps.Marker(
  {
      position: location,
       icon: '../../images/iconhome.png',
      map: map
   });

}

// Adds a marker to the map and push to the array.
function addUniversity()
{
  var location = new google.maps.LatLng(sessionStorage.userUniversityLat, sessionStorage.userUniversityLon);
  var marker = new google.maps.Marker(
  {
    position: location,
     icon: '../../images/iconschool.png',
    map: map
  });
}



// Adds a marker to the map and push to the array.
function addMarker(location)
{
  if (valid < 6)
  {
    valid++;
    var marker = new google.maps.Marker(
    {
      position: location,
      icon: '../../images/iconspot.png',
      map: map
    });
    var lat = location.lat();
    var lng = location.lng();
    console.log(contentString);
    var contentString = "<div align = 'center'><br><label>Time at you pass: </label><br><input id='time"+valid+"' type='time'><br><br><label>Price of this spot: </label><br><input id='price"+valid+"' type='number' min='10' max='200' step='any'><br><label id='message"+valid+"'></label><br><div class='buttons'><button id='buttonSave"+valid+"' class='buttons__addSpot'" + 'onClick="addTravel('+lat+', '+lng+', '+valid+')" >Save</button> <button class="buttons__removeSpot" id="buttonRemove"'+valid+' onClick="removeSpot('+valid+')">Remove</button></div></div>';
      var infowindow = new google.maps.InfoWindow({
              content: contentString
          });

      marker.addListener('click', function() {
            infowindow.open(map, marker);
          });
      var arrayLatLng = [lat, lng];
      latAndLng.push(arrayLatLng);
      markers.push(marker);
      console.log(markers);
  }
  else
    alert("The number of spots must be less or equals than 6");
}//addMarker


function addTravel(latitude, longitude, number)
{
  var spotTime = 'time'+number;
  var spotMessage = 'message'+number;
  var spotPrice = 'price'+number;
  var spotButton = 'buttonSave'+number;
  var spotButtonRemove = 'buttonRemove'+number;
  var spotMessage = 'message'+number;
  var spotPrice = 'price'+number;
  var spotButton = 'buttonSave'+number;
  var spotButtonRemove = 'buttonRemove'+number;
  var time = document.getElementById(spotTime).value;
  var price = document.getElementById(spotPrice).value;
  console.log("Time: " + time + ", " + "Price: " + price);
  console.log("Latitude: " + latitude + ", " + "Longitude: " + longitude);
  if (time == '' || price == '') { alert('Time or price are empty');}

      //Reasign the style and function to the boton
      document.getElementById(spotButton).innerHTML = "Modify";
      document.getElementById(spotButton).className = "buttons__modifySpot";
        var arrayPriceTimeNumber = [price, time, number];
      priceTimeAndNumber.push(arrayPriceTimeNumber);
      /*********************Begins to REGISTER SPOT*********************************/
        //create request
      var x = new XMLHttpRequest();
      //prepare request
      x.open('POST', 'http://localhost:8080/sharemycar/webapp/apis/spot.php', true);
      //form data
      var fd = new FormData();
      fd.append('driver', id);//ONLY FOR TEST CHANGE THIS AFTER FOR ID REGISTERED IN SESION
      fd.append('latitude', latitude);
      fd.append('longitude', longitude);
      fd.append('hour', time);
      fd.append('pay', price);
      fd.append('day', day);
      console.log(fd);
      x.send(fd);
      console.log(fd);
      x.onreadystatechange = function()
      {
        if (x.status == 200 && x.readyState == 4)
        {
          var JSONdata = JSON.parse(x.responseText); console.log(JSONdata);
          var message = document.getElementById(spotMessage);
          message.innerHTML = JSONdata.message;
          //alert(JSONdata.errorMessage);
          //show buildings
          console.log(x.responseText);
        }//if
      }//x.onreadystatechange
        /**********************End to Register Spot xD************************/

      /************Begins to get the last id of the spot************************/
      //create request
      var x1 = new XMLHttpRequest();
      //prepare request
      x1.open('GET', 'http://localhost:8080/sharemycar/webapp/apis/spot.php?getLastId=1', true);
      x1.onreadystatechange = function()
      {
        if (x.status == 200 && x.readyState == 4)
        {
          var JSONdata = JSON.parse(x.responseText);
          console.log(x1.responseText);
          //get buildings array
          var spots = JSONdata.Spots;
          console.log(spots);
          //read buildings
          for(var i = 0; i < spots.length; i++)
          {
            var id = spots[i].id;
            document.getElementById(spotButton).onclick = function() { modifySpot(id); }
            document.getElementById(spotButtonRemove).onclick = function() { remsoveSpot(id); }
          }//for
        }//if
      }//x1.onreadystatechange


      /***************End to get the last id of the spot************************/

          document.getElementById(spotButton).onclick = function() { modifySpot(number); }
      console.log(priceTimeAndNumber);
}//RegisterSpots-


function modifySpot(number)
{
  var spotTime = 'time'+number;
  var spotPrice = 'price'+number;
  console.log(number);
  console.log(day);
  console.log(id);
  var time = document.getElementById(spotTime).value;
  var price = document.getElementById(spotPrice).value;
  console.log("Time: " + time + ", " + "Price: " + price);
  if (time == '' || price == '') { alert('Time or price are empty');}
  //priceTimeAndNumber[number-1][0] = time;
  //priceTimeAndNumber[number-1][1] = price;

  /*********************Begins to MODIFY SPOT*********************************/
  //create request
  var x = new XMLHttpRequest();
  //prepare request
  x.open('PUT', 'http://localhost:8080/sharemycar/webapp/apis/spot.php', true);
  //form data
  var fd = new FormData();
  fd.append('id', number);
  fd.append('driver', id);//ONLY FOR TEST CHANGE THIS AFTER FOR ID REGISTERED IN SESION
  fd.append('pay', price);
  fd.append('hour', time);
  fd.append('day', day);
  console.log(fd);
  x.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  x.send(fd);
  console.log(fd);
  x.onreadystatechange = function()
  {
    if (x.status == 200 && x.readyState == 4)
    {
      var JSONdata = JSON.parse(x.responseText); console.log(JSONdata);
      var message = document.getElementById(spotMessage);
      message.innerHTML = JSONdata.message;
      //alert(JSONdata.errorMessage);
      //show buildings
      console.log(x.responseText);
    }//if
  }//x.onreadystatechange
    /**********************End to MODIFY Spot xD************************/


}

function removeSpot(number)
{
    /*********************Begins to REMOVE SPOT*********************************/
    //create request
  var x = new XMLHttpRequest();
  //prepare request
  x.open('DELETE', 'http://localhost:8080/sharemycar/webapp/apis/spot.php', true);
  var data = {
    id: number,
    driver: id
  };
  var fd = new FormData();
  fd.append('data', data);//ONLY FOR TEST CHANGE THIS AFTER FOR ID REGISTERED IN SESION
  console.log(data);
  x.send(fd);
  x.onreadystatechange = function()
  {
    if (x.status == 200 && x.readyState == 4)
    {
      var JSONdata = JSON.parse(x.responseText); console.log(JSONdata);
      var message = document.getElementById(spotMessage);
      message.innerHTML = JSONdata.message;
      //alert(JSONdata.errorMessage);
      //show buildings
      console.log(x.responseText);
    }//if
  }//x.onreadystatechange
    /**********************End to Remove Spot xD************************/

  setMapOnAll(null);
  priceTimeAndNumber.splice(number-1, 1);
  latAndLng.splice(number-1, 1);
  markers = [];
  for (var i = 0; i < priceTimeAndNumber.length; i++)
  {
    addMarkerWithInfo(latAndLng[i][0], latAndLng[i][1], priceTimeAndNumber[i][0], priceTimeAndNumber[i][1], priceTimeAndNumber[i][2]);
  }
  console.log(priceTimeAndNumber);
}

function setMapOnAll(map) {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
  setMapOnAll(null);
}

function addMarkerWithInfo(lat, lng, price, time, number)
{
  var location = new google.maps.LatLng(lat, lng);
  var marker = new google.maps.Marker(
  {
    position: location,
    icon: '../../images/iconspot.png',
    map: map
  });
  console.log(contentString);
  var contentString = "<div align = 'center'><br><label>Time at you pass: </label><br><input id='time"+number+"' type='time' value="+time+"><br><br><label>Price of this spot: </label><br><input id='price"+number+"' type='number' min='10' max='200' step='any' value="+price+"><br><label id='message"+number+"'></label><br><div class='buttons'><button id='buttonSave"+number+"' class='buttons__modifySpot'" + 'onClick="modifySpot('+number+')" >Modify</button> <button class="buttons__removeSpot" id="buttonRemove"'+number+' onClick="removeSpot('+number+')">Remove</button></div></div>';
    var infowindow = new google.maps.InfoWindow({
            content: contentString
        });

    marker.addListener('click', function() {
          infowindow.open(map, marker);
        });
    markers.push(marker);
    console.log(markers);
}//addMarker


function changeDay()
{
  day = document.getElementById("days").value;
  setMapOnAll(null);

  var x = new XMLHttpRequest();
  //prepare request
  x.open('GET', 'http://localhost:8080/sharemycar/webapp/apis/spot.php?driver='+id+'&day='+day, true);
  x.send();
  //handle readyState change event
  x.onreadystatechange = function()
  {
    if (x.status == 200 && x.readyState == 4)
    {
      var JSONdata = JSON.parse(x.responseText);
      console.log(x.responseText);
      //get buildings array
      var spots = JSONdata.Spots;
      console.log(spots);
      //read buildings
      for(var i = 0; i < spots.length; i++)
      {
        var hour = spots[i].hour;
        var id = spots[i].id;
        var price = spots[i].pay;
        addMarkerWithInfo(spots[i].location.latitude, spots[i].location.longitude, price, hour, id);
      }//for
    }
  }

}
