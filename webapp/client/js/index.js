var sideMenuVisible = false;
function showMenu(){
	if (!sideMenuVisible){
		sideMenuVisible = true;
		document.getElementById('sidemenu').style.display = 'inline';
		document.getElementById('header').style.width = '80%';
		document.getElementById('header').style.float = 'right';
		document.getElementById('container').style.width = '78%';
		document.getElementById('container').style.float = 'right';
		//document.getElementById('profile2').style.backgroundImage = "url('img/default.png')";
	}
	else{
		sideMenuVisible = false;
		document.getElementById('sidemenu').style.display = 'none';
		document.getElementById('header').style.width = '100%';
		document.getElementById('container').style.width = '98%';
		document.getElementById('container').style.float = 'left';
	}
}
function logout()
{
	sessionStorage.clear();
	window.location = '../index.html';
}
