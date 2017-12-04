function getAddress(slot) {
  var s = document.getElementById('slot' + slot);
  var address = s.value;
  console.log(address);
  getCoordenates(address, slot);
}

function getCoordenates(address, slot) {
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

function showCoordenates(data, slot) {
  // Parse to JSON
	var JSONdata = JSON.parse(data);
	console.log(JSONdata);
	console.log(JSONdata.results[0].address_components[2].long_name);
  var address = JSONdata.results[0].formatted_address;
  var latitude = JSONdata.results[0].geometry.location.lat;
  var lontigude = JSONdata.results[0].geometry.location.lng;
  console.log('Address: ' + address);
  console.log('Latitude: ' + latitude);
  console.log('Longitude: ' + lontigude);
  console.log('Slot: ' + slot)
  
}
