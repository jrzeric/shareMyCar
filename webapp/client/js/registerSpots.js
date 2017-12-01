var map;
var markers = [];
//var coordinates = [[sessionStorage.userLocationLat, sessionStorage.userLocationLon]];
//Declaracion de variables
var coordinates = [];
var valid = 1;

function init() 
{

  var home = new google.maps.LatLng(sessionStorage.userLocationLat, sessionStorage.userLocationLon);
  var university = new google.maps.LatLng(sessionStorage.userUniversityLat, sessionStorage.userUniversityLon);

  map = new google.maps.Map(document.getElementById('map'), 
  {
    zoom: 10,
    center: new google.maps.LatLng(sessionStorage.userLocationLat, sessionStorage.userLocationLon),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });

  // This event listener will call addMarker() when the map is clicked.
  map.addListener('click', function(event) 
  {
    addMarker(event.latLng);
  });

  // Adds a marker at the center of the map.
  addHome(home);
  addUniversity(university);
}

// Adds a marker to the map and push to the array.
function addHome(location) 
{
  var marker = new google.maps.Marker(
  {
    position: location,
    icon: 'http://localhost:8080/sharemycar/webapp/img/h.png',
    map: map
  });
}

// Adds a marker to the map and push to the array.
function addUniversity(location) 
{
  var marker = new google.maps.Marker(
  {
    position: location,
    icon: 'http://localhost:8080/sharemycar/webapp/img/s.png',
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
      map: map
    });
    markers.push(marker);
    var coordinate = [location.lat(), location.lng()];
    coordinates.push(coordinate);
    console.log(location.lat() + ', ' + location.lng())
    console.log(coordinates);
    console.log(markers);
    alert(location);
  }
  else
  {
    alert('No puedes agregar mas puntos de encuentro');
  }

}//addMarker

// Sets the map on all markers in the array.
function setMapOnAll(map) 
{
  for (var i = 0; i < markers.length; i++) { markers[i].setMap(map); }
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() 
{
  setMapOnAll(null);
}

// Shows any markers currently in the array.
function showMarkers() 
{
  setMapOnAll(map);
}

// Deletes all markers in the array by removing references to them.
function deleteMarkers() 
{
  clearMarkers();
  markers = [];
  valid = 0;
  coordinates = [];
}

function registerSpots()
{
  console.log('POSTING spots...');
  for (var i = 0; i < coordinates.length; i++) 
  {
    //create request
    var x = new XMLHttpRequest();
    //prepare request
    console.log(sessionStorage.userId);
    x.open('POST', 'http://localhost:8080/sharemycar/webapp/apis/spot.php', true);
    //form data
    var fd = new FormData();
    fd.append('student', sessionStorage.userId);
    fd.append('slot', i);
    fd.append('latitude', coordinates[i][0]);
    fd.append('longitude', coordinates[i][1]);
    console.log(fd);
    x.send(fd);
    console.log(fd);
    x.onreadystatechange = function() 
    {
      if (x.status == 200 && x.readyState == 4) 
      {

        var JSONdata = JSON.parse(x.responseText); console.log(JSONdata);
        alert(JSONdata.errorMessage);
        //show buildings
        console.log(x.responseText);
      }//if
    }//x.onreadystatechange
  }//For
}//RegisterSpots