function init()
{
	console.log('Getting brands...');
	//create request
	var x = new XMLHttpRequest();
	//prepare request
	x.open('GET', 'http://localhost:8080/sharemycar/webapp/apis/brand.php', true);
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
}


function showOptions(role)
{
	if(role =='Driver')
	{
	    document.getElementById('driver').style.visibility = "visible";
	    document.getElementById('button').style.visibility = "visible";
	    document.getElementById('button').onclick = function() { registerCar(); }
	}
	else if(role =='Passenger')
	{
		document.getElementById('driver').style.visibility = "hidden";
	    document.getElementById('button').style.visibility = "visible";
	    document.getElementById('button').onclick = function() { passenger(); }
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
	x.open('GET', 'http://localhost:8080/sharemycar/webapp/apis/model.php?idBrand=' + idBrand, true);
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


function registerCar()
{
	console.log('POSTING car...');
	//create request
	var x = new XMLHttpRequest();
	//prepare request
	x.open('POST', 'http://localhost:8080/sharemycar/webapp/apis/car.php', true);
	//form data
	var fd = new FormData();
	//values
	console.log(sessionStorage.userId);
	fd.append('driver', sessionStorage.userId);
	fd.append('model', document.getElementById('models').value);
	fd.append('licensePlate', document.getElementById('licenseplate').value);
	fd.append('driverLicense', document.getElementById('driverlicense').value);
	fd.append('color', document.getElementById('color').value);
	fd.append('insurance', document.getElementById('insurance').value);
	fd.append('spaceCar', document.getElementById('space').value);
	fd.append('owner', document.getElementById('owner').value);

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
				alert(JSONdata.message);
				window.location = 'account/driver/spots.php';
				passenger();
			}
			else
			{
				alert(JSONdata.errorMessage);
			}
			//show buildings
			console.log(x.responseText);
		}
	}
}


function passenger()
{
	console.log('POSTING car...');
	//create request
	var x = new XMLHttpRequest();
	//prepare request
	x.open('GET', 'http://localhost:8080/sharemycar/webapp/apis/student.php?idStatus='+sessionStorage.userId, true);
	console.log(sessionStorage.userId);
	//send
	x.send();
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
				alert(JSONdata.message);
			}
			else
			{
				alert(JSONdata.errorMessage);
			}
			//show buildings
			console.log(x.responseText);
		}
	}
	alert("You'll be a passenger");
}

