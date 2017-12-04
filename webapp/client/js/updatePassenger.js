function init()
{
	document.getElementById('image').src = sessionStorage.userPhoto;
	document.getElementById('image').style.width = "100px";
	//img.src = sessionStorage.userPhoto;
	document.getElementById('idForm').value = sessionStorage.userId;
	document.getElementById('roleForm').value = sessionStorage.userRole;
  	//id.value = sessionStorage.userId;
  	var fn = document.getElementById('name');
	var u = document.getElementById('university');
	var r = document.getElementById('role');
	var c = document.getElementById('cellphone');
	var e = document.getElementById('email');
	//var ci = document.getElementById('city');
	/*
	fn.value = sessionStorage.userName;
	u.value = sessionStorage.userUniversity;
	r.value = sessionStorage.userRole;
	c.value = sessionStorage.userCellPhone;
	e.value = sessionStorage.userEmail;*/
}