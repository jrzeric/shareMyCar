var users = [];
var coordinates = [];
var pointer = 0;
var map;
var marker;
var markers = [];
var ids = [];
var dates = [];

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

	/*
    marker = new google.maps.Marker(
    {
      position: new google.maps.LatLng(lat, lon),
      icon: 'http://localhost:8080/sharemycar/webapp/client/img/carIT.png',
      map: map
    });

    var contentString = "Tu posicion actual";
    var infowindow = new google.maps.InfoWindow({
          	content: contentString
        });

    marker.addListener('click', function() {
          infowindow.open(map, marker);
        });*/

}


function ViewError (error) 
{
	alert(error.code);
}	


function init()
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
  	loadLocation();

	var x = new XMLHttpRequest();
	//prepare request
	x.open('GET', 'http://localhost:8080/sharemycar/webapp/apis/scheduletravel.php?driver='+sessionStorage.userId, true);
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
			passengers = JSONdata.passengers; 
			var loc = new google.maps.LatLng(passengers[0].beginLatitude, passengers[0].beginLongitude);
			addMarkerCar(loc);
			//read buildings
			for(var i = 0; i < passengers.length; i++) 
			{
				var spot = new google.maps.LatLng(passengers[i].beginLatitude, passengers[i].beginLongitude);
				console.log(spot);
				console.log(passengers[i]);
				var text = passengers[i].passenger.name + ' ' + passengers[i].passenger.lastName;
				addMarkerPassenger(spot, passengers[i].passenger.photo, text);

				var div = document.getElementById('cont');
				var table = document.createElement('table');
				var row = document.createElement('tr');
				var data = document.createElement('td');
				var img = document.createElement('img');
				var row2 = document.createElement('tr');
				var data1 = document.createElement('td');
				var data2 = document.createElement('td');
				//console.log(passengers.passenger.photo);
				//console.log(passengers.passenger);
				img.src = passengers[i].passenger.photo;
				img.style.width = "50px";
				data.rowSpan = 2;
				data1.innerHTML = passengers[i].passenger.name + ' ' + passengers[i].passenger.lastName;
				data2.innerHTML = passengers[i].passenger.cellphone;
				row2.appendChild(data2);
				data.appendChild(img);
				row.appendChild(data);
				row.appendChild(data1);
				row2.appendChild(data2);
				table.appendChild(row);
				table.appendChild(row2);
				users.push(passengers[i].passenger);
				coordinates.push(spot);
				ids.push(passengers[i].id);
				console.log(users);
				console.log(coordinates);
				console.log(ids);
				div.appendChild(table);

			}//for
		}	
	}
	putSpots();
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
function addMarker(location) 
{
    var marker = new google.maps.Marker(
    {
      position: location,
      icon: 'http://localhost:8080/sharemycar/webapp/client/img/car.png',
      map: map
    });
}//addMarker

function addMarkerPassenger(location, img, texto) 
{
    var marker = new google.maps.Marker(
    {
      position: location,
      icon: 'http://localhost:8080/sharemycar/webapp/client/img/pass.png',
      map: map
    });
    // Adds a marker to the map and push to the array.

  //console.log(location.lat());
    var contentString = "<div align = 'center'><img src = '" + img + "' width='42'><br>" + texto + 
    '<br><br></div>';
    console.log(contentString);
    var infowindow = new google.maps.InfoWindow({
          	content: contentString
        });

    marker.addListener('click', function() {
          infowindow.open(map, marker);
        });
    markers.push(marker);
}//addMarker

function addMarkerCar(location) 
{
    marker = new google.maps.Marker(
    {
      position: location,
      icon: 'http://localhost:8080/sharemycar/webapp/client/img/carIT.png',
      map: map
    });
}//addMarker


function putSpots() 
{
	var x = new XMLHttpRequest();
	//prepare request
	x.open('GET', 'http://localhost:8080/sharemycar/webapp/apis/spot.php?idAll='+sessionStorage.userId, true);
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
				var spot = new google.maps.LatLng(spots[i].location.latitude, spots[i].location.longitude);
				console.log(spot);
				console.log(spots[i]);
				addMarker(spot);
			
			}//for
		}	
	}
}

function next() 
{
	setMapOnAll();
}

function setMapOnAll()
{
	if (pointer == markers.length) 
	{
		//alert('mierda');
		var loc = new google.maps.LatLng(sessionStorage.userUniversityLat, sessionStorage.userUniversityLon);
		addMarkerCar(loc);
		var now = new Date().toLocaleString(); 

		for (var i = 0; i < users.length; i++) 
		{
			do
			{
				var price;
				var pause = false;
    			var price = prompt("Please enter the Payment Amount by "+users[i].name+users[i].lastName+": ", "0");
    			if (price == null || price == "") 
    			{
        			alert('Enter a value please');
        			pause = true
    			} 
    			else 
    			{

    			}
			}while(pause);
		    //create request
		    var x = new XMLHttpRequest();
		    //prepare request
		    console.log(sessionStorage.userId);
		    x.open('POST', 'http://localhost:8080/sharemycar/webapp/apis/scheduletravel.php', true);
		    //form data
		    var fd = new FormData();
		    fd.append('arrived_at', now);
		    fd.append('paymentAmount', price);
		    fd.append('id', ids[i]);
		    fd.append('pickedUp_at', dates[i]);
		    console.log(fd);
		    x.send(fd);
		    console.log(fd);
		    x.onreadystatechange = function() 
		    {
		      if (x.status == 200 && x.readyState == 4) 
		      {

		        var JSONdata = JSON.parse(x.responseText); console.log(JSONdata);
		        var message = document.getElementById('message');
		        //message.innerHTML = JSONdata.errorMessage;
		        //alert(JSONdata.errorMessage);
		        //show buildings
		        console.log(x.responseText);
		      }//if
		    }//x.onreadystatechange
		}//FOR
		
	}//if
	else
	{
		var currentdate = new Date(); 
		var date = formatDate(currentdate);
		console.log(date);
		dates.push(currentdate);
		console.log(currentdate);
		marker.setMap(null);
		var loc = new google.maps.LatLng(users[pointer].beginLatitude, users[pointer].beginLongitude);
		addMarkerCar(loc);
		for (var i = 0; i < markers.length; i++) { markers[i].setMap(null); }
		pointer++;
		for (var i = pointer; i < markers.length; i++) { markers[i].setMap(map); }
		var div = document.getElementById('cont');
		div.innerHTML = '';
		for (var i = pointer; i < users.length; i++) 
		{ 
				var table = document.createElement('table');
				var row = document.createElement('tr');
				var data = document.createElement('td');
				var img = document.createElement('img');
				var row2 = document.createElement('tr');
				var data1 = document.createElement('td');
				var data2 = document.createElement('td');
				//console.log(passengers.passenger.photo);
				//console.log(passengers.passenger);
				img.src = passengers[i].passenger.photo;
				img.style.width = "50px";
				data.rowSpan = 2;
				data1.innerHTML = passengers[i].passenger.name + ' ' + passengers[i].passenger.lastName;
				data2.innerHTML = passengers[i].passenger.cellphone;
				row2.appendChild(data2);
				data.appendChild(img);
				row.appendChild(data);
				row.appendChild(data1);
				row2.appendChild(data2);
				table.appendChild(row);
				table.appendChild(row2);
				div.appendChild(table);
				console.log(users);
				console.log(coordinates);
		}
	}
	
}


function clearMarkers() { setMapOnAll(null); }

function showMarkers() { setMapOnAll(map); }

function deleteMarkers() { clearMarkers(); markers = []; }

function formatDate(dateVal) 
{
    var newDate = new Date(dateVal);

    var sMonth = padValue(newDate.getMonth() + 1);
    var sDay = padValue(newDate.getDate());
    var sYear = newDate.getFullYear();
    var sHour = newDate.getHours();
    var sMinute = padValue(newDate.getMinutes());
    var sAMPM = "AM";

    var iHourCheck = parseInt(sHour);

    if (iHourCheck > 12) {
        sAMPM = "PM";
        sHour = iHourCheck - 12;
    }
    else if (iHourCheck === 0) {
        sHour = "12";
    }

    sHour = padValue(sHour);

    return sDay + "-" + sMonth + "-" + sYear + " " + sHour + ":" + sMinute + " " + sAMPM;
}

function padValue(value) {
    return (value < 10) ? "0" + value : value;
}