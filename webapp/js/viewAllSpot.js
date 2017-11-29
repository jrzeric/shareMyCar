var map;
var spots;



function init() 
{
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
	x.open('GET', 'http://localhost:8080/sharemycar/webapp/apis/spot.php', true);
	x.send();
	//handle readyState change event
	x.onreadystatechange = function() 
	{
		if (x.status == 200 && x.readyState == 4) 
		{
			console.log(x.responseText);
			var JSONdata = JSON.parse(x.responseText); 
			//get buildings array
			spots =JSONdata.spotLocations; 
			//read buildings
			for(var i = 0; i < spots.length; i++) 
			{
				var spot = new google.maps.LatLng(spots[i].location.latitude, sessionStorage.userLocationLon);
				var texto = spots[i].student.name + spots[i].student.lastName;
				console.log(texto);
				console.log(spot);
				console.log(spots[i]);
				addMarker(spot, texto);
			
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
function addMarker(location, texto) 
{
	var marker = new google.maps.Marker(
	{
	  position: location,
	  map: map
	});

    var contentString = texto + '<div class="buttons"><button class="ok" onClick="perron()">Order that shit</button></div>';
    var infowindow = new google.maps.InfoWindow({
          	content: contentString
        });

    marker.addListener('click', function() {
          infowindow.open(map, marker);
        });
}//addMarker

function perron() 
{
	alert('Ya jala');
}