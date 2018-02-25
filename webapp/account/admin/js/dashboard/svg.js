//Point class
function Point(x, y) {
	if (typeof x  !== 'undefined') this.x = x;
	if (typeof y  !== 'undefined') this.y = y;
}

//Size class
function Size(width, height) {
	if (typeof width  !== 'undefined') this.width = width;
	if (typeof height  !== 'undefined') this.height = height;
}

//draw text class
function writeTextClass(svgParent, id, point, innerText, cssClass) {
	var t = document.createElementNS('http://www.w3.org/2000/svg', 'text');
	if (id != null) t.setAttribute('id', id);
	t.setAttribute('x', point.x);
	t.setAttribute('y', point.y);
	t.setAttribute('class', cssClass);
	t.innerHTML = innerText;
	svgParent.appendChild(t);
}

//draw text style
function writeTextStyle(svgParent, id, point, innerText, fontSize, backgroundColor) {
	var t = document.createElementNS('http://www.w3.org/2000/svg', 'text');
	if (id != null) t.setAttribute('id', id);
	t.setAttribute('x', point.x);
	t.setAttribute('y', point.y);
	t.style.fontSize = fontSize + 'pt';
	t.style.fill = backgroundColor;
	t.innerHTML = innerText;
	svgParent.appendChild(t);
}

//draw line class
function drawLineClass(svgParent, id, startingPoint, endingPoint, cssClass) {
	var l = document.createElementNS('http://www.w3.org/2000/svg', 'line');
	if (id != null) l.setAttribute('id', id);
	l.setAttribute('x1', startingPoint.x);
	l.setAttribute('y1', startingPoint.y);
	l.setAttribute('x2', endingPoint.x);
	l.setAttribute('y2', endingPoint.y);
	l.setAttribute('class', cssClass);
	svgParent.appendChild(l);
}

//draw rectangle class
function drawRectClass(svgParent, id, point, size, cssClass) {
	var r = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
	if (id != null) r.setAttribute('id', id);
	r.setAttribute('x', point.x);
	r.setAttribute('y', point.y);
	r.setAttribute('width', size.width);
	r.setAttribute('height', size.height);
	r.setAttribute('class', cssClass);
	svgParent.appendChild(r);
}

//draw rectangle style
function drawRectStyle(svgParent, id, point, size, backgroundColor) {
	var r = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
	if (id != null) r.setAttribute('id', id);
	r.setAttribute('x', point.x);
	r.setAttribute('y', point.y);
	r.setAttribute('width', size.width);
	r.setAttribute('height', size.height);
	r.style.fill = backgroundColor;
	svgParent.appendChild(r);
}

//draw path class
function drawPathClass(svgParent, id, path, transform, cssClass) {
	var p = document.createElementNS('http://www.w3.org/2000/svg', 'path');
	if (id != null) p.setAttribute('id', id);
	p.setAttribute('d', path);
	p.setAttribute('class', cssClass);
	if (transform != null) p.setAttribute('transform', transform);
	svgParent.appendChild(p);
}

//draw path style
function drawPathStyle(svgParent, id, path, transform, backgroundColor) {
	var p = document.createElementNS('http://www.w3.org/2000/svg', 'path');
	if (id != null) p.setAttribute('id', id);
	p.setAttribute('d', path);
	p.style.fill = backgroundColor;
	p.style.strokeWidth = '1px';
	p.style.stroke = backgroundColor;
	if (transform != null) p.setAttribute('transform', transform);
	svgParent.appendChild(p);
}

//show image
function showImage(svgParent, id, source, point, cssClass) {
	var i = document.createElementNS('http://www.w3.org/2000/svg', 'image');
	if (id != null) i.setAttribute('id', id);
	i.setAttributeNS('http://www.w3.org/1999/xlink','href', source);
	i.setAttribute('x', point.x);
	i.setAttribute('y', point.y);
	i.setAttribute('class', cssClass);
	svgParent.appendChild(i);
}

function drawPathClass(svgParent, id, path,transform,backgroundColor) {
  var p = document.createElementNS('http://www.w3.org/2000/svg', 'path');
  if (id != null) p.setAttribute('id', id);
  p.setAttribute('d', path);
  if (transform != null) p.setAttribute('style', transform);
  p.style.fill = backgroundColor;
  p.style.strokeWidth = '1px';
  svgParent.appendChild(p);
}