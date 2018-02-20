
//draw chart axis


function init()
{
	temp = [25, 23, 19, 16];
	drawChartAxis(temp);
	drawChartAxis1(temp);
	drawChartAxis2(temp);
}

function drawChartAxis(temp) {
	//svg parent
	days = ["September", "October", "November", "December"];
	var parent = document.getElementById('chart');
	//y axis
	drawLineClass(parent, null, new Point('15%', '25px'), new Point('15%', '195px'), 'axisline');
	var y = 40;
	for (var i = 0; i <= temp.length-1; i++) {
		drawLineClass(parent, null, new Point('14.5%', y + 'px'), new Point('15.5%', y + 'px'), 'axisline');
		y += 40;
	}
	//x axis

	drawLineClass(parent, null, new Point('15%', '195px'), new Point('88%', '195px'), 'axisline');

	var pix = 23;
	for (var i = 0; i <= days.length-1; i++) {
		writeTextClass(parent, null, new Point(pix + '%', '210px'), days[i], 'xaxistext');
		pix = pix + 18;
	}
	drawChartRect(temp);
}



function drawChartAxis1(temp) {
	//svg parent
	days =  ["September", "October", "November", "December"];
	var parent = document.getElementById('chart1');
	//y axis
	drawLineClass(parent, null, new Point('15%', '25px'), new Point('15%', '195px'), 'axisline');
	var y = 40;
	for (var i = 0; i <= temp.length-1; i++) {
		drawLineClass(parent, null, new Point('14.5%', y + 'px'), new Point('15.5%', y + 'px'), 'axisline');
		writeTextClass(parent, null, new Point('14%', (y + 5) + 'px'), temp[i], 'yaxistext');
		y += 40;
	}
	//x axis

	drawLineClass(parent, null, new Point('15%', '195px'), new Point('88%', '195px'), 'axisline');

	var pix = 23;
	for (var i = 0; i <= days.length-1; i++) {
		writeTextClass(parent, null, new Point(pix + '%', '210px'), days[i], 'xaxistext');
		pix = pix + 18;
	}
	drawChartRect1(temp);
}

function drawChartAxis2(temp) {
	//svg parent
	days =  ["September", "October", "November", "December"];
	var parent = document.getElementById('chart2');
	drawLineClass(parent, null, new Point('15%', '25px'), new Point('15%', '195px'), 'axisline');
	var y = 40;
	for (var i = 0; i <= temp.length-1; i++) {
		drawLineClass(parent, null, new Point('14.5%', y + 'px'), new Point('15.5%', y + 'px'), 'axisline');
		writeTextClass(parent, null, new Point('14%', (y + 5) + 'px'), temp[i], 'yaxistext');
		y += 40;
	}
	//x axis

	drawLineClass(parent, null, new Point('15%', '195px'), new Point('88%', '195px'), 'axisline');

	var pix = 23;
	for (var i = 0; i <= days.length-1; i++) {
		writeTextClass(parent, null, new Point(pix + '%', '210px'), days[i], 'xaxistext');
		pix = pix + 18;
	}

	drawChartRect2(temp);
}

function drawChartRect(temp)
{
	var parent = document.getElementById('chart');
	var x1=23;
	var y1=38;
	var size = 155;
	for(var i=0; i<=temp.length-1; i++)
	{
		writeTextClass(parent, null, new Point(x1 +'%', y1 + 'px'), temp[i], 'label');
		drawRectClass(parent, null, new Point( (x1-2) +'%', (y1+2)+'px'), new Size(3.6 + '%', size), 'bar');
		x1+=18;
		y1+=30;
		size-=30;
	}
}

function drawChartRect1(temp)
{
	var parent = document.getElementById('chart1');
	var x1=23;
	var y1=38;
	var size = 155;
	for(var i=0; i<=temp.length-1; i++)
	{
		writeTextClass(parent, null, new Point(x1 +'%', y1 + 'px'), temp[i], 'label');
		drawRectClass(parent, null, new Point( (x1-2) +'%', (y1+2)+'px'), new Size(3.6 + '%', size), 'bar');
		x1+=18;
		y1+=30;
		size-=30;
	}
}


function drawChartRect2(temp)
{
	var parent = document.getElementById('chart2');
	var x1=23;
	var y1=38;
	var size = 155;
	for(var i=0; i<=temp.length-1; i++)
	{
		writeTextClass(parent, null, new Point(x1 +'%', y1 + 'px'), temp[i], 'label');
		drawRectClass(parent, null, new Point( (x1-2) +'%', (y1+2)+'px'), new Size(3.6 + '%', size), 'bar');
		x1+=18;
		y1+=30;
		size-=30;
	}
}
