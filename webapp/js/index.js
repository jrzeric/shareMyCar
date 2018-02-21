sideMenuVisible = false;

//show menu
function showMenu() {
	//menu closed
	if (!sideMenuVisible) {
		sideMenuVisible = true;
    	document.getElementById("sidemenu").style.width = "20%";
    	document.getElementById("content").style.width = "80%";
    	document.getElementById("content").style.marginLeft = "20%";
    	//document.getElementClassName("reports").style.marginLeft = "20%";
    	var nav = document.getElementById('nav').clientHeight;
    	document.getElementById("sidemenu").style.marginTop = nav+"px";

	}
	else {
		sideMenuVisible = false;
    	document.getElementById("sidemenu").style.width = "0";
    	document.getElementById("content").style.marginLeft= "0";
    	document.getElementById("content").style.width = "100%";
    	document.getElementById("nav").style.marginLeft = "0px";
	}
}
