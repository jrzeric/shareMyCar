var map;

function initPassenger() 
{

	var fn = document.getElementById('name');
	var u = document.getElementById('university');
	var r = document.getElementById('role');
	var c = document.getElementById('cellphone');
	var e = document.getElementById('email');
	//var ci = document.getElementById('city');
	fn.value = sessionStorage.userName;
	u.value = sessionStorage.userUniversity;
	r.value = sessionStorage.userRole;
	c.value = sessionStorage.userCellPhone;
	e.value = sessionStorage.userEmail;
	console.log(sessionStorage.userUniversityLon);
  	var home = new google.maps.LatLng(sessionStorage.userLocationLat, sessionStorage.userLocationLon);
  	var university = new google.maps.LatLng(sessionStorage.userUniversityLat, sessionStorage.userUniversityLon);

	map = new google.maps.Map(document.getElementById('map'),
	{
      zoom: 10,
      center: new google.maps.LatLng(sessionStorage.userLocationLat, sessionStorage.userLocationLon),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

  	addHome(home);
  	addUniversity(university);

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
	document.getElementById('profile').style.backgroundImage = "url('img/default.png')";
	document.getElementById('profile2').style.backgroundImage = "url('img/default.png')";
	//var ci = document.getElementById('city');
	fn.innerHTML = sessionStorage.userName + ' ' + sessionStorage.userLastName + ' ' + sessionStorage.userSecondLastName;
	u.innerHTML = sessionStorage.userUniversity;
	r.innerHTML = sessionStorage.userRole;
	c.innerHTML = sessionStorage.userCellPhone;
	e.innerHTML = sessionStorage.userEmail;
	console.log(sessionStorage.userUniversityLon);
  	var home = new google.maps.LatLng(sessionStorage.userLocationLat, sessionStorage.userLocationLon);
  	var university = new google.maps.LatLng(sessionStorage.userUniversityLat, sessionStorage.userUniversityLon);
	if (sessionStorage.userRole == 'Driver')
	{
		/*
		var b = document.getElementById('brand');
		var m = document.getElementById('model');
		var y = document.getElementById('year');
		var lp = document.getElementById('licensePlate');
		var dl = document.getElementById('DriverLicense');

		b.innerHTML = sessionStorage.userCarBrand;
		m.innerHTML = sessionStorage.userCarModel;
		y.innerHTML = sessionStorage.userYear;
		lp.innerHTML = sessionStorage.userLicensePlate;
		dl.innerHTML = sessionStorage.userDriverLicense;
		*/
	}//if

	map = new google.maps.Map(document.getElementById('map'),
	{
      zoom: 10,
      center: new google.maps.LatLng(sessionStorage.userLocationLat, sessionStorage.userLocationLon),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

  	addHome(home);
  	addUniversity(university);

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
    icon: 'http://localhost/sharemycar/webapp/client/img/h.png',
    map: map
  });
}

// Adds a marker to the map and push to the array.
function addUniversity(location) 
{
  var marker = new google.maps.Marker(
  {
    position: location,
    icon: 'http://localhost/sharemycar/webapp/client/img/s.png',
    map: map
  });
}