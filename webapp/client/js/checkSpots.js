var map;
var spots;



function init() 
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

  	var home = new google.maps.LatLng(sessionStorage.userLocationLat, sessionStorage.userLocationLon);
  	var university = new google.maps.LatLng(sessionStorage.userUniversityLat, sessionStorage.userUniversityLon);

  	console.log(sessionStorage.userLocationLat);

  	map = new google.maps.Map(document.getElementById('map'), 
  	{
    	zoom: 10,
    	center: new google.maps.LatLng(sessionStorage.userLocationLat, sessionStorage.userLocationLon),
    	mapTypeId: google.maps.MapTypeId.ROADMAP
  	});

  	// Adds a marker at the center of the map.
  	addHome(home);
  	addUniversity(university);

	var x = new XMLHttpRequest();
	//prepare request
	x.open('GET', 'http://localhost/sharemycar/webapp/apis/spot.php?idAll='+sessionStorage.userId, true);
	x.send();
	//handle readyState change event
	x.onreadystatechange = function() 
	{
		if (x.status == 200 && x.readyState == 4) 
		{
			console.log(x.responseText);
			var JSONdata = JSON.parse(x.responseText); 
			if (JSONdata.status == 2 ) 
			{
				
				document.getElementById('icon').src = 'img/info.png';
				var message = document.getElementById('message');
				message.innerHTML = "Seems that you don't have any spots, ";
				var createA = document.createElement('a');
        		createA.innerHTML = "could you add some spot?";
        		createA.setAttribute('href', "registerSpots.html");
        		message.appendChild(createA);
	
			}
			//get buildings array
			spots = JSONdata.spotLocations; 
			//read buildings
			for(var i = 0; i < spots.length; i++) 
			{
				var spot = new google.maps.LatLng(spots[i].location.latitude, sessionStorage.userLocationLon);
				console.log(spot);
				console.log(spots[i]);
				addMarker(spot, i, spots[i].dateTime);
			
			}//for
		}	
	}

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


// Adds a marker to the map and push to the array.
function addMarker(location, texto, hora) 
{
	var marker = new google.maps.Marker(
	{
	  position: location,
	  map: map
	});

    var contentString = 'Spot number: ' + (texto + 1) + ' at ' + hora;
    var infowindow = new google.maps.InfoWindow({
          	content: contentString
        });

    marker.addListener('click', function() {
          infowindow.open(map, marker);
        });
}//addMarker