var sideMenuVisible = false;
function showMenu(){
	if (!sideMenuVisible){
		sideMenuVisible = true;
		document.getElementById('sidemenu').style.display = 'inline';
		document.getElementById('header').style.width = '80%';
		document.getElementById('header').style.float = 'right';
	}
	else{
		sideMenuVisible = false;
		document.getElementById('sidemenu').style.display = 'none';
		document.getElementById('header').style.width = '100%';
	}
}
function logout(){
	window.location = '../index.html';
}
