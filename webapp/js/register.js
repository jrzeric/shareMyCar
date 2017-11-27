var map;
var markers = [];
var latitude = 0;
var longitude = 0;

// Adds a marker to the map and push to the array.
function addMarker(map, location) 
{
        var marker = new google.maps.Marker({
          position: location,
          map: map
        });
        markers.push(marker);

        google.maps.event.addListener(marker, 'click', (function(marker) {
        return function() {
          infowindow.setContent('Esta es tu casa');
          infowindow.open(map, marker);
        }
      }));
      }

function setMapOnAll(map) 
{
    for (var i = 0; i < markers.length; i++) { markers[i].setMap(map); }
}



function clearMarkers() { setMapOnAll(null); }

function showMarkers() { setMapOnAll(map); }

function deleteMarkers() { clearMarkers(); markers = []; }

function getAddress(slot) 
{
  var s = document.getElementById('slot' + slot);
  var address = s.value;
  console.log(address);
  getCoordenates(address, slot);
}

function getCoordenates(address, slot) 
{
  // Create request
	var x = new XMLHttpRequest();
	// Prepare request
	x.open('GET', 'https://maps.googleapis.com/maps/api/geocode/json?address=' + address + '&key=AIzaSyDqZh2WxuTHlURSXiJBNi_5MhrS8M4iVJM', true);
	// Send request
	x.send();
	// Handle readyState change event
	x.onreadystatechange = function() {
		// check status
		//status : 200=OK, 404=Page not found, 500=server denied access
		// readyState : 4=Back with data
		if (x.status == 200 && x.readyState == 4) {
			//show buildings
			showCoordenates(x.responseText, slot);
		}
	}
}

function showCoordenates(data, slot) 
{
  // Parse to JSON
  deleteMarkers();
	var JSONdata = JSON.parse(data);
  var address = JSONdata.results[0].formatted_address;
  latitude = JSONdata.results[0].geometry.location.lat;
  longitude = JSONdata.results[0].geometry.location.lng;
  console.log('Address: ' + address);
  console.log('Latitude: ' + latitude);
  console.log('Longitude: ' + longitude);
  console.log('Slot: ' + slot)
  var myLatlng = new google.maps.LatLng(latitude, longitude);
  console.log('IDK: ' + myLatlng);
  console.log(map);
  map =  new google.maps.Map(document.getElementById('map'), {
      zoom: 15,
      center: new google.maps.LatLng(latitude, longitude),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
  addMarker(map, myLatlng);

  
}



function init()
{
	console.log(latitude + ',' + longitude);
	console.log('Getting brands...');
	//create request
	var x = new XMLHttpRequest();
	//prepare request
	x.open('GET', 'http://localhost/sharemycar/webapp/apis/brand.php', true);
	//send request
	x.send();
	//handle readyState change event
	x.onreadystatechange = function()
	{
		// check status
		// status : 200=OK, 404=Page not found, 500=server denied access
		// readyState : 4=Back with data
		if (x.status == 200 && x.readyState == 4)
		{
			//show buildings
			fillBrands(x.responseText);
		}
	}

	console.log('Getting countries...');
	//create request
	var x2 = new XMLHttpRequest();
	//prepare request
	x2.open('GET', 'http://localhost/sharemycar/webapp/apis/country.php', true);
	//send request
	x2.send();
	//handle readyState change event
	x2.onreadystatechange = function()
	{
		// check status
		// status : 200=OK, 404=Page not found, 500=server denied access
		// readyState : 4=Back with data
		if (x2.status == 200 && x2.readyState == 4)
		{
			//show buildings
			fillCountry(x2.responseText);
		}
	}

	var locations = [[32.537645, -117.039985]];

    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 15,
      center: new google.maps.LatLng(32.539, -117.040),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < markers.length; i++) 
    {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(markers[i][0], markers[i][1]),
        map: map
      });

      /*
      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(markers[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));*/
    }

}


function fillCountry(data)
{
	var select = document.getElementById('countries');
	//console.log(data);
	var JSONdata = JSON.parse(data);
	//get buildings array
	var countries = JSONdata.countries;
	//read buildings
	for(var i = 0; i < countries.length; i++)
	{
		//console.log(brands[i]);
		var option = document.createElement('option');
		option.innerHTML = countries[i].name;
		option.value = countries[i].id;
		//console.log(buildingTypes[i].id);
		/*
		var valueDescription = document.createElement('value');

		valueDescription.value = buildingTypes[i].id;
		option.appendChild(valueDescription);*/
		select.appendChild(option);

	}//for
}

function fillStates()
{

	console.log('Getting states...');
	//create request
	var x = new XMLHttpRequest();
	var idCountry = document.getElementById('countries').value;
	//prepare request
	x.open('GET', 'http://localhost/sharemycar/webapp/apis/state.php?idAll=' + idCountry, true);
	//send request
	x.send();
	//handle readyState change event
	x.onreadystatechange = function()
	{
		// check status
		// status : 200=OK, 404=Page not found, 500=server denied access
		// readyState : 4=Back with data
		if (x.status == 200 && x.readyState == 4)
		{
			var select = document.getElementById('states');
			select.innerHTML = '';
			var select2 = document.getElementById('cities');
			select2.innerHTML = '';
			//console.log(x.responseText);
			var JSONdata = JSON.parse(x.responseText);
			//get buildings array
			var states = JSONdata.states;
			//read buildings
			for(var i = 0; i < states.length; i++)
			{
				//console.log(models[i]);
				var option = document.createElement('option');
				option.innerHTML = states[i].name;
				option.value = states[i].id;
				//console.log(buildingTypes[i].id);
				/*
				var valueDescription = document.createElement('value');

				valueDescription.value = buildingTypes[i].id;
				option.appendChild(valueDescription);*/
				select.appendChild(option);

			}//for
		}
	}
}

function fillCities()
{

	console.log('Getting cities...');
	//create request
	var x = new XMLHttpRequest();
	var idState = document.getElementById('states').value;
	//prepare request
	x.open('GET', 'http://localhost/sharemycar/webapp/apis/city.php?idAll=' + idState, true);
	//send request
	x.send();
	//handle readyState change event
	x.onreadystatechange = function()
	{
		// check status
		// status : 200=OK, 404=Page not found, 500=server denied access
		// readyState : 4=Back with data
		if (x.status == 200 && x.readyState == 4)
		{
			var select = document.getElementById('cities');
			select.innerHTML = '';
			//console.log(x.responseText);
			var JSONdata = JSON.parse(x.responseText);
			//get buildings array
			var cities = JSONdata.cities;
			//read buildings
			for(var i = 0; i < cities.length; i++)
			{
				//console.log(models[i]);
				var option = document.createElement('option');
				option.innerHTML = cities[i].name;
				option.value = cities[i].id;
				//console.log(buildingTypes[i].id);
				/*
				var valueDescription = document.createElement('value');

				valueDescription.value = buildingTypes[i].id;
				option.appendChild(valueDescription);*/
				select.appendChild(option);

			}//for
		}
	}
}

function fillUniversities()
{

	console.log('Getting Universities...');
	//create request
	var x = new XMLHttpRequest();
	var idCity = document.getElementById('cities').value;
	//prepare request
	x.open('GET', 'http://localhost/sharemycar/webapp/apis/university.php?idAll=' + idCity, true);
	//send request
	x.send();
	//handle readyState change event
	x.onreadystatechange = function()
	{
		// check status
		// status : 200=OK, 404=Page not found, 500=server denied access
		// readyState : 4=Back with data
		if (x.status == 200 && x.readyState == 4)
		{
			var select = document.getElementById('universities');
			select.innerHTML = '';
			//console.log(x.responseText);
			var JSONdata = JSON.parse(x.responseText);
			//get buildings array
			var universities = JSONdata.universities;
			//read buildings
			for(var i = 0; i < universities.length; i++)
			{
				//console.log(models[i]);
				var option = document.createElement('option');
				option.innerHTML = universities[i].name;
				option.value = universities[i].id;
				//console.log(buildingTypes[i].id);
				/*
				var valueDescription = document.createElement('value');

				valueDescription.value = buildingTypes[i].id;
				option.appendChild(valueDescription);*/
				select.appendChild(option);

			}//for
		}
	}
}

function latlon()
{
	var x = new XMLHttpRequest();
	var university = document.getElementById('universities').value;
	x.open('GET', 'http://localhost/sharemycar/webapp/apis/university.php?id=' + university, true);
	//send request
	x.send();
	//handle readyState change event
	x.onreadystatechange = function()
	{
		// check status
		// status : 200=OK, 404=Page not found, 500=server denied access
		// readyState : 4=Back with data
		if (x.status == 200 && x.readyState == 4)
		{
			var latitude = document.getElementById('latitude');
			var longitude = document.getElementById('longitude');
			//console.log(x.responseText);
			var JSONdata = JSON.parse(x.responseText);
			//get buildings array
			var university = JSONdata.university;
			//read buildings
			latitude.innerHTML = university.location.latitude;
			longitude.innerHTML = university.location.longitude;
		}
	}

}

function fillBrands(data)
{
	var select = document.getElementById('brands');
	//console.log(data);
	var JSONdata = JSON.parse(data);
	//get buildings array
	var brands =JSONdata.brands;
	//read buildings
	for(var i = 0; i < brands.length; i++)
	{
		//console.log(brands[i]);
		var option = document.createElement('option');
		option.innerHTML = brands[i].name;
		option.value = brands[i].id;
		//console.log(buildingTypes[i].id);
		/*
		var valueDescription = document.createElement('value');

		valueDescription.value = buildingTypes[i].id;
		option.appendChild(valueDescription);*/
		select.appendChild(option);

	}//for
}

function fillModels()
{

	console.log('Getting models...');
	//create request
	var x = new XMLHttpRequest();
	var idBrand = document.getElementById('brands').value;
	//prepare request
	x.open('GET', 'http://localhost/sharemycar/webapp/apis/model.php?idAll=' + idBrand, true);
	//send request
	x.send();
	//handle readyState change event
	x.onreadystatechange = function()
	{
		// check status
		// status : 200=OK, 404=Page not found, 500=server denied access
		// readyState : 4=Back with data
		if (x.status == 200 && x.readyState == 4)
		{
			var select = document.getElementById('models');
			select.innerHTML = '';
			//console.log(x.responseText);
			var JSONdata = JSON.parse(x.responseText);
			//get buildings array
			var models =JSONdata.models;
			//read buildings
			for(var i = 0; i < models.length; i++)
			{
				//console.log(models[i]);
				var option = document.createElement('option');
				option.innerHTML = models[i].name;
				option.value = models[i].id;
				//console.log(buildingTypes[i].id);
				/*
				var valueDescription = document.createElement('value');

				valueDescription.value = buildingTypes[i].id;
				option.appendChild(valueDescription);*/
				select.appendChild(option);

			}//for
		}
	}

}



/*MAP*/
function miniMap()
{
    var locations = [
      ['Bondi Beach', -33.890542, 151.274856, 4],
      ['Coogee Beach', -33.923036, 151.259052, 5],
      ['Cronulla Beach', -34.028249, 151.157507, 3],
      ['Manly Beach', -33.80010128657071, 151.28747820854187, 2],
      ['Maroubra Beach', -33.950198, 151.259302, 1]
    ];

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(-33.92, 151.25),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
}



/*POST Passenger*/
function postPassenger() 
{
	console.log('POSTING passenger...');
	//create request
	var x = new XMLHttpRequest();
	//prepare request
	x.open('POST', 'http://localhost/sharemycar/webapp/apis/studentpassengerinsert.php', true);
	//form data
	var fd = new FormData();
	//values
	fd.append('lastName', document.getElementById('lastname').value);
	fd.append('secondLastName', document.getElementById('secondlastname').value);
	fd.append('name', document.getElementById('firstname').value);
	fd.append('birthDate', document.getElementById('dateofbirth').value);
	fd.append('email', document.getElementById('email').value);
	fd.append('university', document.getElementById('universities').value);
	fd.append('cellphone', document.getElementById('phonenumber').value);
	fd.append('controlNumber', document.getElementById('controlNumber').value);
	fd.append('password', document.getElementById('password').value);
	fd.append('studentId', document.getElementById('studentId').value);
	fd.append('payAccount', document.getElementById('payAccount').value);
	fd.append('latitude', latitude);
	fd.append('longitude', longitude);

	console.log(fd);
	//send
	x.send(fd);
	console.log(fd);
	//handle readyState change event
	x.onreadystatechange = function() {
		// check status
		// status : 200=OK, 404=Page not found, 500=server denied access
		// readyState : 4=Back with data
		if (x.status == 200 && x.readyState == 4) 
		{
			var JSONdata = JSON.parse(x.responseText); console.log(JSONdata);
			if(JSONdata.status == 0)
			{
				document.getElementById('message').innerHTML = JSONdata.errorMessage;
			}
			else
			{
				document.getElementById('message').innerHTML = JSONdata.errorMessage;
			}
			//show buildings
			console.log(x.responseText);
		}
	}
}

/*POST Passenger*/
function postDriver() 
{
	console.log('POSTING passenger...');
	//create request
	var x = new XMLHttpRequest();
	//prepare request
	x.open('POST', 'http://localhost/sharemycar/webapp/apis/studentdriverinsert.php', true);
	//form data
	var fd = new FormData();
	//values
	fd.append('lastName', document.getElementById('lastname').value);
	fd.append('secondLastName', document.getElementById('secondlastname').value);
	fd.append('name', document.getElementById('firstname').value);
	fd.append('birthDate', document.getElementById('dateofbirth').value);
	fd.append('email', document.getElementById('email').value);
	fd.append('university', document.getElementById('universities').value);
	fd.append('cellphone', document.getElementById('phonenumber').value);
	fd.append('controlNumber', document.getElementById('controlNumber').value);
	fd.append('password', document.getElementById('password').value);
	fd.append('studentId', document.getElementById('studentId').value);
	fd.append('payAccount', document.getElementById('payAccount').value);
	fd.append('latitude', latitude);
	fd.append('longitude', longitude);
	fd.append('brand', document.getElementById('brands').value);
	fd.append('model', document.getElementById('models').value);
	fd.append('year', document.getElementById('year').value);
	fd.append('licensePlate', document.getElementById('licensePlate').value);
	fd.append('driverLicense', document.getElementById('driverLicense').value);

	console.log(fd);
	//send
	x.send(fd);
	console.log(fd);
	//handle readyState change event
	x.onreadystatechange = function() {
		// check status
		// status : 200=OK, 404=Page not found, 500=server denied access
		// readyState : 4=Back with data
		if (x.status == 200 && x.readyState == 4) 
		{
			var JSONdata = JSON.parse(x.responseText); console.log(JSONdata);
			if(JSONdata.status == 0)
			{
				document.getElementById('message').innerHTML = JSONdata.errorMessage;
			}
			else
			{
				document.getElementById('message').innerHTML = JSONdata.errorMessage;
			}
			//show buildings
			console.log(x.responseText);
		}
	}
}