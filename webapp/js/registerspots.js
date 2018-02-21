var map;
var spots;
var meet;
var valid = 0;

var markers = [];
//var coordinates = [[sessionStorage.userLocationLat, sessionStorage.userLocationLon]];
//Declaracion de variables
var coordinates = [];
var valid = 1;

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
  var contentString = "<div align = 'center'><br><label>Time at you pass: </label><br><input id='time"+valid+"' type='time'><br><br><label>Price of this spot: </label><br><input id='price"+valid+"' type='number' min='10' max='200' step='any'><div class='buttons'><button class='buttons__addSpot'" + 'onClick="addTravel('+lat+', '+lng+', '+valid+')">Save</button> <button class="buttons__removeSpot" onClick="removeSpot()">Remove</button></div></div>';
    var infowindow = new google.maps.InfoWindow({
          	content: contentString
        });

    marker.addListener('click', function() {
          infowindow.open(map, marker);
        });
}//addMarker


function addTravel(latitude, longitude, number)
{
  var spotTime = 'time'+number;
  var spotPrice = 'price'+number;
  var time = document.getElementById(spotTime).value;
  var price = document.getElementById(spotPrice).value;
  console.log("Time: " + time + ", " + "Price: " + price);
  console.log("Latitude: " + latitude + ", " + "Longitude: " + longitude);
  if (time == '' || price == '') { alert('Time or price are empty');}
}//RegisterSpots-
