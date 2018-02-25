var map;
var spots;
var meet;
var valid = 0;

var latAndLng = [];
var markers = [];
//var coordinates = [[sessionStorage.userLocationLat, sessionStorage.userLocationLon]];
//Declaracion de variables
var priceTimeAndNumber = [];

function init()
{
  	map = new google.maps.Map(document.getElementById('map'),
  	{
    	zoom: 10,
    	center: new google.maps.LatLng(32.537063, -117.048211),
    	mapTypeId: google.maps.MapTypeId.ROADMAP
  	});

    // This event listener will call addMarker() when the map is clicked.
    map.addListener('click', function(event)
    {
      addMarker(event.latLng);
    });


  	// Adds a marker at the center of the map.
  	addHome();
  	addUniversity();
}


// Adds a marker to the map and push to the array.
function addHome()
{
  var location = new google.maps.LatLng(32.537063, -117.048211);
	var marker = new google.maps.Marker(
	{
	    position: location,
	     icon: '/images/iconhome.png',
	    map: map
	 });

}

// Adds a marker to the map and push to the array.
function addUniversity()
{
  var location = new google.maps.LatLng(32.460157, -116.825552);
  var marker = new google.maps.Marker(
  {
    position: location,
     icon: '/images/iconschool.png',
    map: map
  });
}



// Adds a marker to the map and push to the array.
function addMarker(location)
{
  valid++;
	var marker = new google.maps.Marker(
	{
	  position: location,
    icon: '/images/iconspot.png',
	  map: map
	});
  var lat = location.lat();
  var lng = location.lng();
  console.log(contentString);
  var contentString = "<div align = 'center'><br><label>Time at you pass: </label><br><input id='time"+valid+"' type='time'><br><br><label>Price of this spot: </label><br><input id='price"+valid+"' type='number' min='10' max='200' step='any'><div class='buttons'><button id='buttonSave"+valid+"' class='buttons__addSpot'" + 'onClick="addTravel('+lat+', '+lng+', '+valid+')" >Save</button> <button class="buttons__removeSpot" onClick="removeSpot('+valid+')">Remove</button></div></div>';
    var infowindow = new google.maps.InfoWindow({
          	content: contentString
        });

    marker.addListener('click', function() {
          infowindow.open(map, marker);
        });
    var arrayLatLng = [lat, lng];
    latAndLng.push(arrayLatLng);
    markers.push(marker);
    console.log(markers);
}//addMarker


function addTravel(latitude, longitude, number)
{
  var spotTime = 'time'+number;
  var spotPrice = 'price'+number;
  var spotButton = 'buttonSave'+number;
  var time = document.getElementById(spotTime).value;
  //Reasign the style and function to the boton 
  document.getElementById(spotButton).innerHTML = "Modify";
  document.getElementById(spotButton).className = "buttons__modifySpot";
  document.getElementById(spotButton).onclick = function() { modifySpot(number); }
  var price = document.getElementById(spotPrice).value;
  console.log("Time: " + time + ", " + "Price: " + price);
  console.log("Latitude: " + latitude + ", " + "Longitude: " + longitude);
  if (time == '' || price == '') { alert('Time or price are empty');}
  var arrayPriceTimeNumber = [price, time, number];
  priceTimeAndNumber.push(arrayPriceTimeNumber);  
  console.log(priceTimeAndNumber);
}//RegisterSpots-


function modifySpot(number)
{
  var spotTime = 'time'+number;
  var spotPrice = 'price'+number;
  var time = document.getElementById(spotTime).value;
  var price = document.getElementById(spotPrice).value;
  console.log("Time: " + time + ", " + "Price: " + price);
  if (time == '' || price == '') { alert('Time or price are empty');}
  priceTimeAndNumber[number-1][0] = time;
  priceTimeAndNumber[number-1][1] = price;
  console.log(priceTimeAndNumber);

}

function removeSpot(number)
{
  setMapOnAll(null);
  priceTimeAndNumber.splice(number-1, 1);
  latAndLng.splice(number-1, 1);
  markers = [];
  for (var i = 0; i < priceTimeAndNumber.length; i++) 
  {
    addMarkerWithInfo(latAndLng[i][0], latAndLng[i][1], priceTimeAndNumber[i][0], priceTimeAndNumber[i][1], priceTimeAndNumber[i][2]);
  }
  console.log(priceTimeAndNumber);
}

function setMapOnAll(map) {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
  setMapOnAll(null);
}

function addMarkerWithInfo(lat, lng, price, time, number)
{
  var location = new google.maps.LatLng(lat, lng);
  var marker = new google.maps.Marker(
  {
    position: location,
    icon: '/images/iconspot.png',
    map: map
  });
  console.log(contentString);
  var contentString = "<div align = 'center'><br><label>Time at you pass: </label><br><input id='time"+number+"' type='time' value="+time+"><br><br><label>Price of this spot: </label><br><input id='price"+number+"' type='number' min='10' max='200' step='any' value="+price+"><div class='buttons'><button id='buttonSave"+number+"' class='buttons__modifySpot'" + 'onClick="modifySpot('+number+')" >Modify</button> <button class="buttons__removeSpot" onClick="removeSpot('+number+')">Remove</button></div></div>';
    var infowindow = new google.maps.InfoWindow({
            content: contentString
        });

    marker.addListener('click', function() {
          infowindow.open(map, marker);
        });
    markers.push(marker);
    console.log(markers);
}//addMarker