var map;
var marker;

function getTravels() 
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


	console.log('Getting travels...');
	//create request
	var x = new XMLHttpRequest();
	//prepare request
	x.open('GET', 'http://localhost:8080/sharemycar/webapp/apis/scheduletravel.php?notificationDriver='+sessionStorage.userId, true);
	//
	/*
	x.setRequestHeader('username', sessionStorage.userId);
	x.setRequestHeader('token', sessionStorage.token);

	console.log(sessionStorage.userId);
	console.log(sessionStorage.token);
	*/
	//send request
	x.send();
	//handle readyState change event
	x.onreadystatechange = function() {
		// check status
		// status : 200=OK, 404=Page not found, 500=server denied access
		// readyState : 4=Back with data
		if (x.status == 200 && x.readyState == 4) {
			//show buildings
			showTravels(x.responseText);
		}
	}
}

function showTravels(data) {

	//buildings element
	var table = document.getElementById('container');
	//clear
	//table.innerHTML = '';
	//parse to JSON
	console.log(data);
	var JSONdata = JSON.parse(data); 
	//get buildings array
	var travels = JSONdata.travels; 
	//read buildings
	var div = document.getElementById('travels');
	var rowHeader = document.createElement('tr');
	var name = document.createElement('th');
	var image = document.createElement('th');
	var paymentAmount = document.createElement('th');
	var status = document.createElement('th');
	name.innerHTML = "Name";
	image.innerHTML = "Image";
	paymentAmount.innerHTML = "Payment Amount";
	status.innerHTML = "Status";
	rowHeader.appendChild(name);
	rowHeader.appendChild(image);
	rowHeader.appendChild(paymentAmount);
	rowHeader.appendChild(status);
	table.appendChild(rowHeader);


	for(var i = 0; i < travels.length; i++) 
	{
		var img = document.createElement('img');
		img.src = travels[i].passenger.photo;
		img.style.width = "50px";
		console.log(travels[i]);
		//create row
		var row = document.createElement('tr');
		//create id cell
		var cellId = document.createElement('td');
		cellId.innerHTML = travels[i].passenger.name + travels[i].passenger.lastName;
		//create name cell
		var cellName = document.createElement('td');
		cellName.appendChild(img);
		//cellName.innerHTML = travels[i].passenger.photo;
		//create location cell
		var cellLocation = document.createElement('td');
		cellLocation.innerHTML = travels[i].paymentAmount;
		//create location cell
		var cellType = document.createElement('td');
		cellType.innerHTML = travels[i].status.status;

		var cellView = document.createElement('td');
		var beginPoint = new google.maps.LatLng(travels[i].beginLatitude, travels[i].beginLong);
		cellView.innerHTML = travels[i].status.status;
		
		//add cells to row
		row.appendChild(cellId);
		row.appendChild(cellName);
		row.appendChild(cellLocation);
		row.appendChild(cellType);
		//add row to table
		table.appendChild(row);
		
	}//for
	//div.appendChild(table);
	
}

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
    marker = new google.maps.Marker(
    {
      position: location,
      icon: 'http://localhost:8080/sharemycar/webapp/client/img/car.png',
      map: map
    });
    markers.push(marker);
    var coordinate = [location.lat(), location.lng()];
    coordinates.push(coordinate);
    console.log(location.lat() + ', ' + location.lng())
    console.log(coordinates);
    console.log(markers);
    //alert(location);

}//addMarker