var map;
var spots;



function init() 
{
	var fn = document.getElementById('name');
	var u = document.getElementById('university');
	var r = document.getElementById('role');
	var c = document.getElementById('cellphone');
	var e = document.getElementById('email');
	//var ci = document.getElementById('city');
	fn.innerHTML = sessionStorage.userName + " "+ sessionStorage.userLastName + " " + sessionStorage.userSecondLastName;
	u.innerHTML = sessionStorage.userUniversity;
	r.innerHTML = sessionStorage.userRole;
	c.innerHTML = sessionStorage.userCellPhone;
	e.innerHTML = sessionStorage.userEmail;

	  document.getElementById('profile').style.backgroundImage = "url('"+ sessionStorage.userPhoto +"')";
	  document.getElementById('profile2').style.backgroundImage = "url('"+ sessionStorage.userPhoto +"')";


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
	x.open('GET', 'http://localhost:8080/sharemycar/webapp/apis/spot.php?city='+sessionStorage.userCityId + '&uni='+sessionStorage.userUniversityId, true);
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
				var text = spots[i].student.name + ' ' + spots[i].student.lastName;
				var img = spots[i].student.photo;
				var hour = spots[i].dateTime;
				var id = spots[i].student.id;
				console.log(text);
				console.log(spot);
				console.log(spots[i]);
				addMarker(spot, text, img, hour, id);
			
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


// Adds a marker to the map and push to the array.
function addMarker(location, texto, img, hour,id) 
{
	var marker = new google.maps.Marker(
	{
	  position: location,
	  map: map
	});
  console.log(location.lat());
    var contentString = "<div align = 'center'><img src = '" + img + "' height='42' width='42'><br>" + texto + 
    '<br><label>Driver passes at hour: '+ hour +'</label><br><div class="buttons"><button class="buttonOK" onClick="addTravel(' + id +
    ', '+location.lat()+','+location.lng()+')">Order that shit</button></div></div>';
    var infowindow = new google.maps.InfoWindow({
          	content: contentString
        });

    marker.addListener('click', function() {
          infowindow.open(map, marker);
        });
}//addMarker

function addTravel(driver, latitude, longitude) 
{
  console.log('POSTING spots...');
    //create request
    var x = new XMLHttpRequest();
    //prepare request
    console.log(sessionStorage.userId);
    x.open('POST', 'http://localhost:8080/sharemycar/webapp/apis/historicalride.php', true);
    //form data
    console.log(latitude);
    console.log(longitude);
    console.log(sessionStorage.userLocationLat);
    console.log(sessionStorage.userLocationLon);
    console.log(driver);
    console.log(sessionStorage.userId);
    var fd = new FormData();
    fd.append('endLatitude', sessionStorage.userUniversityLat);
    fd.append('endLongitude', sessionStorage.userUniversityLon);
    fd.append('driver', driver);
    fd.append('passenger', sessionStorage.userId);
    fd.append('beginLatitude', latitude);
    fd.append('beginLongitude', longitude);
    console.log(fd);
    x.send(fd);
    console.log(fd);
    x.onreadystatechange = function() 
    {
      if (x.status == 200 && x.readyState == 4) 
      {
        var JSONdata = JSON.parse(x.responseText); console.log(JSONdata);
        alert(JSONdata.errorMessage);
        if (JSONdata.status == 0) 
        {
          window.location = "homePassenger.html";
        }
        //show buildings
        console.log(x.responseText);
      }//if
    }//x.onreadystatechange
}//RegisterSpots