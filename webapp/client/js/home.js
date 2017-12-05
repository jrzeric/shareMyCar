var map;
var lat1 = 0;
var lon1 = 1;

function setLat(valor) 
{
	lat1 = valor;
	return lat1;
}

function setLon(valor) 
{
	lon = valor;
	return lat1;
}

function loadLocation () 
{
	//inicializamos la funcion y definimos  el tiempo maximo ,las funciones de error y exito.
	navigator.geolocation.getCurrentPosition(viewMap,ViewError,{timeout:1000});
}

//Funcion de exito
function viewMap (position) 
{
	
	lon = position.coords.longitude;	//guardamos la longitud
	lat = position.coords.latitude;		//guardamos la latitud

    var marker = new google.maps.Marker(
    {
      position: new google.maps.LatLng(lat, lon),
      map: map
    });

    var contentString = "Tu posicion actual";
    var infowindow = new google.maps.InfoWindow({
          	content: contentString
        });

    marker.addListener('click', function() {
          infowindow.open(map, marker);
        });

}


function ViewError (error) 
{
	alert(error.code);
}	




function initPassenger() 
{

	console.log("Aqui voy");


	var fn = document.getElementById('name');
	var u = document.getElementById('university');
	var r = document.getElementById('role');
	var c = document.getElementById('cellphone');
	var e = document.getElementById('email');
	//var ci = document.getElementById('city');
	fn.innerHTML = sessionStorage.userName +" "+ sessionStorage.userLastName + " " + sessionStorage.userSecondLastName;
	u.innerHTML = sessionStorage.userUniversity;
	r.innerHTML = sessionStorage.userRole;
	c.innerHTML = sessionStorage.userCellPhone;
	e.innerHTML = sessionStorage.userEmail;

	

	document.getElementById('profile').style.backgroundImage = "url('"+ sessionStorage.userPhoto +"')";
	document.getElementById('profile2').style.backgroundImage = "url('"+ sessionStorage.userPhoto +"')";

  	var home = new google.maps.LatLng(sessionStorage.userLocationLat, sessionStorage.userLocationLon);
  	var university = new google.maps.LatLng(sessionStorage.userUniversityLat, sessionStorage.userUniversityLon);

	map = new google.maps.Map(document.getElementById('map'),
	{
      zoom: 10,
      center: new google.maps.LatLng(sessionStorage.userLocationLat, sessionStorage.userLocationLon),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var posicionActual = new google.maps.LatLng(lat1, lon1);

  	addHome(home);
  	addUniversity(university);
  	loadLocation();


}

function spotRegister()
{
	window.location = 'spots.html';
}

function initDriver() 
{

	var fn = document.getElementById('name');
	var u = document.getElementById('university');
	var r = document.getElementById('role');
	var c = document.getElementById('cellphone');
	var e = document.getElementById('email');
	document.getElementById('profile').style.backgroundImage = "url('"+ sessionStorage.userPhoto +"')";
	document.getElementById('profile2').style.backgroundImage = "url('"+ sessionStorage.userPhoto +"')";
	//var ci = document.getElementById('city');
	fn.innerHTML = sessionStorage.userName + ' ' + sessionStorage.userLastName + ' ' + sessionStorage.userSecondLastName;
	u.innerHTML = sessionStorage.userUniversity;
	r.innerHTML = sessionStorage.userRole;
	c.innerHTML = sessionStorage.userCellPhone;
	e.innerHTML = sessionStorage.userEmail;
	console.log(sessionStorage.userUniversityLon);
  	var home = new google.maps.LatLng(sessionStorage.userLocationLat, sessionStorage.userLocationLon);
  	var university = new google.maps.LatLng(sessionStorage.userUniversityLat, sessionStorage.userUniversityLon);

	var b = document.getElementById('brand');
	var m = document.getElementById('model');
	var y = document.getElementById('year');
	var lp = document.getElementById('lp');
	
	document.getElementById('profile3').style.backgroundImage = "url('" + sessionStorage.carImage + "')";
	document.getElementById('profile4').style.backgroundImage = "url('" + sessionStorage.carImage + "')";

	b.innerHTML = sessionStorage.userCarBrand;
	m.innerHTML = sessionStorage.userCarModel;
	y.innerHTML = sessionStorage.userYear;
	lp.innerHTML = sessionStorage.userLicensePlate;

	map = new google.maps.Map(document.getElementById('map'),
	{
      zoom: 10,
      center: new google.maps.LatLng(sessionStorage.userLocationLat, sessionStorage.userLocationLon),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

  	addHome(home);
  	addUniversity(university);
  	loadLocation();

}

function spotRegister()
{
	window.location = 'spots.html';
}

// Adds a marker to the map and push to the array.
function addHome(location) 
{
  var marker = new google.maps.Marker(
  {
    position: location,
    icon: 'http://localhost:8080/sharemycar/webapp/client/img/h.png',
    map: map
  });
}

// Adds a marker to the map and push to the array.
function addUniversity(location) 
{
  var marker = new google.maps.Marker(
  {
    position: location,
    icon: 'http://localhost:8080/sharemycar/webapp/client/img/s.png',
    map: map
  });
}
