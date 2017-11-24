function init()
{
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


	var locations = [
      ['Comida China', 32.537645, -117.039985]
    ];

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 15,
      center: new google.maps.LatLng(32.539, -117.040),
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
