var width; // canvas width
var height; // canvas height
var r; // clock radius
var hands = new Array(); // hand info

var handTimer; 

var colours = new Array(); // colour info
colours['bg'] = 'rgba(0, 0, 0, 0.0)';
colours['h'] = '#00F';
colours['m'] = '#00F';
colours['s'] = '#00F';
colours['circle'] = '#00F';
colours['circleopen'] = '#000';

var lineWidths = new Array();

var canvas; // canvas
var context; // canvas context
var center = new Array(); // center coordinates

var pos = "centre";


function init_clock(canvasId, canvasPos, canvasHands)
{
	canvas = document.getElementById(canvasId);
	if(canvasPos)
		pos = canvasPos;
	// set_size();
	if(canvasHands)
		handTimer = window.setInterval(function() {draw_clock()}, 50);
	else
	{
		set_size();
		fill_bg();
		draw_circle();
	}
	window.onresize = 
		function(event) {
			set_size();
			fill_bg();
			draw_circle();
			if(handTimer)
			{
				draw_hands();
			}
		};
	window.addEventListener("deviceorientation", function(e) {
		var tilt = 0 - e.gamma;
		device_orientation_handler(tilt);
	}, false);
}

function device_orientation_handler(tilt)
{
	canvas.style.transform = " rotate("+ tilt +"deg)";
	canvas.style.webkitTransform  = " rotate("+ tilt +"deg)";
}

function draw_clock()
{
	fill_bg();
	draw_circle();
	draw_hands();
}

function clear_hands()
{
	window.clearInterval(handTimer);
	handTimer = false;
	fill_bg();
	draw_circle(colours.circleopen);
}

function fill_bg()
{
	// set_size(250,250);
	set_size();
	
	context = canvas.getContext('2d');
	context.strokeStyle = colours.bg;
	context.fillStyle = colours.bg;
	context.fillRect(0, 0, width*2, height*2);
}

// set size variables
function set_size(width, height)
{
	if(!width)
	{
		if(pos == "lower-right")
		{
			if(window.innerWidth > 768)
				width = window.innerWidth * 0.33;
			else
				width = window.innerWidth * 0.5;
			height = width;
		}
		else
		{
			width = window.innerWidth;
			if (!height)
				height = window.innerHeight * 0.9;
		}
	}
	var min = Math.min(width, height);
	r = min * 0.8;
	
	// set the hand lengths
	hands['h'] = r * 0.5;
	hands['m'] = r * 0.9;
	hands['s'] = r * 0.95;
	
	devAdjust = 1.0;
 
	// set the line widths
	lineWidths['h'] = min * 0.015 * devAdjust;
	lineWidths['m'] = min * 0.015 * devAdjust;
	lineWidths['s'] = min * 0.007 * devAdjust;
	lineWidths['circle'] = min * 0.015* devAdjust;
	
	// make the canvas not look horrible on retina screens
	canvas.width = width*2;
	canvas.height = height*2;
	canvas.style.width = width.toString().concat('px');
	canvas.style.height = height.toString().concat('px');
	
	// set the center x and y coordinates
	center['x'] = width;
	center['y'] = height;
}

function draw_circle(colour)
{
	context.lineCap = 'round';
	// context.strokeStyle = colours.circle;
	if (colour) {
		context.strokeStyle = colour;
	} else {
		context.strokeStyle = colours.circle;
	}
	context.lineWidth = lineWidths.circle;
	context.beginPath();
	context.arc(center.x, center.y, r, 0, 2*Math.PI);
	context.stroke();
}

function fill_circle()
{
	context.lineCap = 'round';
	context.fillStyle = "#ff0000";
	context.strokeStyle = "#ff0000";
	context.lineWidth = lineWidths.circle;
	context.beginPath();
	context.arc(center.x, center.y, r, 0, 2*Math.PI);
	context.stroke();
	context.fill();
}

function draw_hands()
{
	var d = new Date();
	var h = d.getHours();
	var m = d.getMinutes();
	var s = d.getSeconds();
	var ms = d.getMilliseconds();
	
	var rad = new Array();
	rad['h'] = (((h % 12) + m / 60.0) / 6.0) * Math.PI - (Math.PI / 2.0);
	rad['m'] = (m + s / 60.0) / 30.0 * Math.PI - (Math.PI / 2.0);
	rad['s'] = s / 30.0 * Math.PI - (Math.PI / 2.0);
	
	// smooth second hand (uses milliseconds)
	// rad['s'] = (s + ms / 1000.0) / 30.0 * Math.PI - (Math.PI / 2.0);
	
	for(k in rad)
	{
		context.beginPath();
		context.strokeStyle = colours[k];
		context.lineWidth = lineWidths[k];
		context.moveTo(center.x, center.y);
		context.lineTo(Math.cos(rad[k]) * hands[k] + center.x, Math.sin(rad[k]) * hands[k] + center.y);
		context.stroke();
	}
}
