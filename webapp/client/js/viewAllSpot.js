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
    	center: new google.maps.LatLng(32.53789771079216,-117.03879654407501),
    	mapTypeId: google.maps.MapTypeId.ROADMAP
  	});

  	// Adds a marker at the center of the map.
  	addHome(home);
  	addUniversity(university);

	var x = new XMLHttpRequest();
	//prepare request
	x.open('GET', 'http://localhost/sharemycar/webapp/apis/spot.php', true);
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
				var spot = new google.maps.LatLng(spots[i].location.latitude, spots[i].location.longitude);
				var texto = spots[i].student.name + spots[i].student.lastName;
				var img = spots[i].student.photo;
				console.log(texto);
				console.log(spot);
				console.log(spots[i]);
				addMarker(spot, texto, img);
			
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
	     icon: 'http://localhost/sharemycar/webapp/img/h.png',
	    map: map
	 });

}

// Adds a marker to the map and push to the array.
function addUniversity(location) 
{
  var marker = new google.maps.Marker(
  {
    position: location,
     icon: 'http://localhost/sharemycar/webapp/img/clien/s.png',
    map: map
  });
}


// Adds a marker to the map and push to the array.
function addMarker(location, texto, img) 
{
	var marker = new google.maps.Marker(
	{
	  position: location,
	  map: map
	});

    var contentString = "<img src = 'img" + img + "' height='42' width='42'>" + texto + '<div class="buttons"><button class="ok" onClick="perron()">Order that shit</button></div>';
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