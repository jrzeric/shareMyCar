function login() {
	console.log('Getting token...');
	var x = new XMLHttpRequest();
	x.open('GET', urlApis + 'login.php', true);
	x.setRequestHeader('user', document.getElementById('user').value);
	x.setRequestHeader('password', document.getElementById('password').value);
	x.send();
	x.onreadystatechange = function() {
		if (x.readyState == 4 && x.status == 200) {
			var JSONdata = JSON.parse(x.responseText); console.log(JSONdata);
			if (JSONdata.status == 0) {
				sessionStorage.authenticated = true;
				sessionStorage.userId = JSONdata.user.id;
				sessionStorage.userName = JSONdata.user.name;
				sessionStorage.token = JSONdata.token;
				window.location = 'admin/index.html';
			}
			else{
				document.getElementById('error').innerHTML = JSONdata.errorMessage;
			}
		}
	}
	
}