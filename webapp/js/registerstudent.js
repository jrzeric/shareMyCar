function initComboBoxes()
{
	console.log('Getting states...');
	//create request
	var x = new XMLHttpRequest();
	//prepare request
	x.open('GET', 'http://localhost:8080/sharemycar/webapp/apis/state.php', true);
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
			fillStates(x.responseText);
		}
	}

  initMap();

}


function fillStates(data)
{
	var select = document.getElementById('stateSchool');
	select.innerHTML = '';
	var JSONdata = JSON.parse(data);
	//get buildings array
	var states = JSONdata.States;
	//read buildings
	for(var i = 0; i < states.length; i++)
	{
		var option = document.createElement('option');
		option.innerHTML = states[i].name;
		option.value = states[i].id;
		select.appendChild(option);
	}//for
}

function fillCities()
{

  console.log('Getting cities...');
  //create request
  var x = new XMLHttpRequest();
  var idState = document.getElementById('stateSchool').value;
  console.log(idState);
  //prepare request
  x.open('GET', 'http://localhost:8080/sharemycar/webapp/apis/city.php?state=' + idState, true);
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
      var cities = document.getElementById('citySchool');
      cities.innerHTML = '';
      var JSONdata = JSON.parse(x.responseText);
      //get buildings array
      var citiesJSON = JSONdata.cities;
      //read buildings
      for(var i = 0; i < citiesJSON.length; i++)
      {
        //console.log(models[i]);
        var option = document.createElement('option');
        option.innerHTML = citiesJSON[i].name;
        option.value = citiesJSON[i].code;
        cities.appendChild(option);
      }//for
    }//if
  }//onreadystatechange
}



function fillUniversities()
{

  console.log('Getting Universities...');
  //create request
  var x = new XMLHttpRequest();
  var idCity = document.getElementById('citySchool').value;
  //prepare request
  x.open('GET', 'http://localhost:8080/sharemycar/webapp/apis/university.php?city=' + idCity, true);
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
      var universities = document.getElementById('university');
      universities.innerHTML = '';
      var JSONdata = JSON.parse(x.responseText);
      //get buildings array
      var universitiesJSON = JSONdata.Universities;
      //read buildings
      for(var i = 0; i < universitiesJSON.length; i++)
      {
        //console.log(models[i]);
        var option = document.createElement('option');
        option.innerHTML = universitiesJSON[i].name;
        option.value = universitiesJSON[i].id;
        universities.appendChild(option);
      }//for
    }//if
  }//onreadystatechange
  centerCity();

}
