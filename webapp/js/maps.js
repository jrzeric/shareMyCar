var marker;  //variable del marcador
var coords = {lat:22.782226 ,lng: -102.951225}; //coordenadas obtenidas con la geolocalización
var map;
var count = 0;
var markers = [];
var lat;
var lng;
var state;
var city;


function initMap()
{
      //Se crea una nueva instancia del objeto mapa
      map = new google.maps.Map(document.getElementById('map'),
      {
        zoom: 4,
        center:new google.maps.LatLng(coords.lat,coords.lng),
      });

      //Creamos el marcador en el mapa con sus propiedades
      //para nuestro obetivo tenemos que poner el atributo draggable en true
      //position pondremos las mismas coordenas que obtuvimos en la geolocalización
      /*
      marker = new google.maps.Marker({
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP,
        position: new google.maps.LatLng(coords.lat,coords.lng),

      });
      //agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica
      //cuando el usuario a soltado el marcador
      marker.addListener('click', toggleBounce);

      marker.addListener( 'dragend', function (event)
      {
        //escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
        document.getElementById("coords").value = this.getPosition().lat()+","+ this.getPosition().lng();
      });
      */

    // This event listener will call addMarker() when the map is clicked.
    map.addListener('click', function(event)
    {
      addMarker(event.latLng);
    });
}


// Adds a marker to the map and push to the array.
function addMarker(location)
{
  if (count == 0) 
  {
    var marker = new google.maps.Marker(
    {
      position: location,
      map: map
    });
    lat = location.lat();
    lng = location.lng();
    markers.push(marker);
    count = 1;

    var x = new XMLHttpRequest();
    // Prepare request
    x.open('GET', 'https://maps.googleapis.com/maps/api/geocode/sharemycar/webapp/json?latlng=' + lat + ', ' + lng +'&key=AIzaSyDqZh2WxuTHlURSXiJBNi_5MhrS8M4iVJM', true);
    // Send request
    x.send();
    // Handle readyState change event
    x.onreadystatechange = function() {
      // check status
      //status : 200=OK, 404=Page not found, 500=server denied access
      // readyState : 4=Back with data
      if (x.status == 200 && x.readyState == 4) {
        //show buildings
        var results = JSON.parse(x.responseText);
        console.log(results.results[0].address_components[3].long_name);
        city = results.results[0].address_components[3].long_name
      }//if
    }//x.onreadystatechange


  }
  else
  {
    count = 0;
    setMapOnAll(null);
    markers = [];
    addMarker(location);
    console.log(lat);
    console.log(lng);
  }
}//addMarker


function setMapOnAll(map) {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
  setMapOnAll(null);
}


//callback al hacer clic en el marcador lo que hace es quitar y poner la animacion BOUNCE
function toggleBounce() {
  if (marker.getAnimation() !== null) {
    marker.setAnimation(null);
  } else {
    marker.setAnimation(google.maps.Animation.BOUNCE);
  }
}



function centerState() 
{
  var comboState = document.getElementById("stateSchool");
  var selectedStateText = comboState.options[comboState.selectedIndex].text;
  state = selectedStateText;
  // Create request
  var x = new XMLHttpRequest();
  // Prepare request
  x.open('GET', 'https://maps.googleapis.com/maps/api/geocode/sharemycar/webapp/json?address=' + selectedStateText + '&key=AIzaSyDqZh2WxuTHlURSXiJBNi_5MhrS8M4iVJM', true);
  // Send request
  x.send();
  // Handle readyState change event
  x.onreadystatechange = function() {
    // check status
    //status : 200=OK, 404=Page not found, 500=server denied access
    // readyState : 4=Back with data
    if (x.status == 200 && x.readyState == 4) {
      //show buildings
      var results = JSON.parse(x.responseText);
      console.log(results.results[0]);
      map.setZoom(7);
      map.setCenter(results.results[0].geometry.location);
    }//if
  }//x.onreadystatechange


  fillCities();

}


function centerCity() 
{
  var comboCity = document.getElementById("citySchool");
  var selectedCityText = comboCity.options[comboCity.selectedIndex].text;
  console.log(state);
  console.log(selectedCityText);
  // Create request
  var x = new XMLHttpRequest();
  // Prepare request
  x.open('GET', 'https://maps.googleapis.com/maps/api/geocode/sharemycar/webapp/json?address=' + state + ' ' + selectedCityText +'&key=AIzaSyDqZh2WxuTHlURSXiJBNi_5MhrS8M4iVJM', true);
  // Send request
  x.send();
  // Handle readyState change event
  x.onreadystatechange = function() {
    // check status
    //status : 200=OK, 404=Page not found, 500=server denied access
    // readyState : 4=Back with data
    if (x.status == 200 && x.readyState == 4) {
      //show buildings
      var results = JSON.parse(x.responseText);
      map.setZoom(11);
      map.setCenter(results.results[0].geometry.location);
      console.log("Vas a buscar: " + results.results[0].address_components[0].long_name);
      city = results.results[0].address_components[0].long_name;
    }



  }
}


// Carga de la libreria de google maps

function finish()
{
  var txtPassword = document.getElementById('password').value;
  var txtRePassword = document.getElementById('repassword').value;
  //school information
  var txtControlNumber = document.getElementById('controlnumber').value;
  var comboStateSchool = document.getElementById('stateSchool').value;
  //var comboAmpm = document.getElementById('ampm').value;
  if (txtPassword === txtRePassword) {
    var photo = "images/default.png";
    var profile = "USE";
    var turn = 0;
    /*********************Begins to REGISTER Student*********************************/
    //create request
    var x = new XMLHttpRequest();
    //prepare request
    x.open('POST', 'http://localhost/sharemycar/webapp/apis/student.php', true);
    //form data
    var fd = new FormData();
    fd.append('name', document.getElementById('firtname').value);
    fd.append('surname', document.getElementById('lastname').value);
    fd.append('secondSurname', document.getElementById('surname').value);
    fd.append('email', document.getElementById('email').value);
    fd.append('cellPhone', document.getElementById('cellphone').value);
    fd.append('university', document.getElementById('university').value);
    fd.append('controlNumber', document.getElementById('controlnumber').value);
    fd.append('latitude', lat);
    fd.append('longitude', lng);
    fd.append('photo', photo);
    fd.append('city', city);
    fd.append('turn', turn);
    fd.append('profile', profile);
    fd.append('password', txtPassword);
    x.send(fd);
    console.log(fd);
    x.onreadystatechange = function() 
    {
      if (x.status == 200 && x.readyState == 4) 
      {
        var JSONdata = JSON.parse(x.responseText); console.log(JSONdata);
        
        //var message = document.getElementById(spotMessage);
        console.log(JSONdata.message);
        alert(JSONdata.message);
        //alert(JSONdata.errorMessage);
        //show buildings
        console.log(x.responseText);
      }//if
      else
        alert(JSONdata.errorMessage);

    }//x.onreadystatechange
    /**********************End to Register Student xD************************/


  }
  else {
    alert("PASSWORD ISN'T THE SAME");
  }
}
