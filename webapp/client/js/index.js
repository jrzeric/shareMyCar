var sideLeftMenuVisible = false;
var sideRightMenuVisible = false;
function showMenu(){
	if (!sideLeftMenuVisible){
		sideLeftMenuVisible = true;
		document.getElementById('sidemenu').style.display = 'inline';
		document.getElementById('header').style.width = '80%';
		document.getElementById('header').style.float = 'right';
		document.getElementById('container').style.width = '78%';
		document.getElementById('container').style.float = 'right';
		//document.getElementById('profile2').style.backgroundImage = "url('img/default.png')";
	}
	else{
		sideLeftMenuVisible = false;
		document.getElementById('sidemenu').style.display = 'none';
		document.getElementById('header').style.width = '100%';
		document.getElementById('container').style.width = '98%';
		document.getElementById('container').style.float = 'left';
	}
}

function showMenu2()
{
	if (!sideRightMenuVisible){
		sideRightMenuVisible = true;
		document.getElementById('sidemenu2').style.display = 'inline';
		document.getElementById('header').style.width = '80%';
		document.getElementById('header').style.float = 'left';
		document.getElementById('container').style.width = '78%';
		document.getElementById('container').style.float = 'left';
		//document.getElementById('profile2').style.backgroundImage = "url('img/default.png')";
	}
	else{
		sideRightMenuVisible = false;
		document.getElementById('sidemenu2').style.display = 'none';
		document.getElementById('header').style.width = '100%';
		document.getElementById('container').style.width = '98%';
		document.getElementById('container').style.float = 'right';
	}
}


function logout()
{
	sessionStorage.clear();
	window.location = '../index.html';
}
