//measurements
var bodyHeight = 0;
var bodyWidth = 0;
var clientHeight = 0 ;
var clientWidth = 0 ;
var scrollTop = 0;
var scrollLeft = 0;

//get measurements
function getMeasurements()
{
	bodyHeight = document.documentElement.offsetHeight; console.log('bodyHeight : ' +bodyHeight);
	bodyWidth = document.documentElement.offsetWidth; console.log('bodyWidth : ' +bodyWidth);
	clientHeight = window.innerHeight; console.log('clientHeight : ' +clientHeight);
	clientWidth = window.innerWidth; console.log('clientWidth : ' +clientWidth);
	scrollTop = window.pageYOffset; console.log('scrollTop : ' + scrollTop);
	scrollLeft = window.pageXOffset; console.log('scrollLeft : ' + scrollLeft);
}
