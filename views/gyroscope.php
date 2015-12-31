<style>
	/* page specific + overrides */

	canvas { 
		margin: 0px;
		width: 100%; 
		height: 100%;		
		position: fixed;
		top:0px;
		/* z-index: -10; */
	}
	#gyroInfo {		  
		position:fixed;
		top:10px;
		left:10px;
	}
	#quatInfo {
		position:fixed;
		bottom:10px;
		right:10px;
		width:120px;
	}
	#mouseInfo {
		position:fixed;
		bottom:10px;
		left:10px;
	}
</style>

<div id="gyroInfo">		
	&Alpha;: <span id="alpha"></span><br>
	&Beta;: <span id="beta"></span><br>
	&Gamma;: <span id="gamma"></span><br>
</div>
    
     
<div id="quatInfo">
	x: <span id="x">x</span><br>
	y: <span id="y">y</span><br>
	z: <span id="z">z</span><br>
	w: <span id="w">w</span><br> 
</div>
    
<div id="mouseInfo">
	X: <span id="userX"></span><br>
        Y: <span id="userY"></span><br>
</div>

<canvas id="gyroCanvas"></canvas>



<script>

// document.getElementById('gyroCanvas').addEventListener('click', function () {
document.addEventListener('click', function () {
	if (document.getElementById('gyroInfo').style.visibility=='hidden') {
		document.getElementById('gyroInfo').style.visibility='visible';
		document.getElementById('quatInfo').style.visibility='visible';
		document.getElementById('mouseInfo').style.visibility='visible';	        
	} else {
		document.getElementById('gyroInfo').style.visibility='hidden';
		document.getElementById('quatInfo').style.visibility='hidden';
		document.getElementById('mouseInfo').style.visibility='hidden';	        
	}
});


var gyro=quatFromAxisAngle(0,0,0,0);

// get orientation info, rolling back if gyro info not available
if (window.DeviceOrientationEvent) {//
    window.addEventListener("deviceorientation", function () {//gyro
        processGyro(event.alpha, event.beta, event.gamma); 
    }, true);
} 



function processGyro(alpha,beta,gamma)
{ 	
	document.getElementById("alpha").innerHTML=alpha.toFixed(5);
	document.getElementById("beta").innerHTML=beta.toFixed(5);
	document.getElementById("gamma").innerHTML =gamma.toFixed(5);
	
	gyro=computeQuaternionFromEulers(alpha,beta,gamma);
	  
	 document.getElementById("x").innerHTML=gyro.x.toFixed(5);
	 document.getElementById("y").innerHTML=gyro.y.toFixed(5);
	 document.getElementById("z").innerHTML=gyro.z.toFixed(5);
	 document.getElementById("w").innerHTML=gyro.w.toFixed(5);
}
	

var canvas = document.getElementById('gyroCanvas');
var context = canvas.getContext('2d');
context.canvas.width  = window.innerWidth;//resize canvas to whatever window dimensions are
context.canvas.height = window.innerHeight;
context.translate(canvas.width / 2, canvas.height / 2); //put 0,0,0 origin at center of screen instead of upper left corner



function computeQuaternionFromEulers(alpha,beta,gamma)//Alpha around Z axis, beta around X axis and gamma around Y axis intrinsic local space in that order(each axis moves depending on how the other moves so processing order is important)
{
	var x = degToRad(beta) ; // beta value
	var y = degToRad(gamma) ; // gamma value
	var z = degToRad(alpha) ; // alpha value

	//precompute to save on processing time
	var cX = Math.cos( x/2 );
	var cY = Math.cos( y/2 );
	var cZ = Math.cos( z/2 );
	var sX = Math.sin( x/2 );
	var sY = Math.sin( y/2 );
	var sZ = Math.sin( z/2 );

	var w = cX * cY * cZ - sX * sY * sZ;
	var x = sX * cY * cZ - cX * sY * sZ;
	var y = cX * sY * cZ + sX * cY * sZ;
	var z = cX * cY * sZ + sX * sY * cZ;

	return makeQuat(x,y,z,w);	  
}

function quaternionMultiply(quaternionArray)// multiplies 2 or more quatoernions together (remember order is important although the code goes from first to last the way to think about the rotations is last to first)
{	
	//var qSoFar = quaternionArray[quaternionArray.length-1];//javascript passes objects by reference so this is troublesome
	var temp = quaternionArray[0];
	var qSoFar ={x:temp.x,y:temp.y,z:temp.z,w:temp.w}; //must copy to not alter original object
	for(var i=1 ;i < quaternionArray.length ;i ++)
	{
		var temp2=quaternionArray[i];
		var next={x:temp2.x,y:temp2.y,z:temp2.z,w:temp2.w};
		//ww,x,y,z
		var w = qSoFar.w * next.w - qSoFar.x * next.x - qSoFar.y * next.y - qSoFar.z * next.z;
		var x = qSoFar.x * next.w + qSoFar.w * next.x + qSoFar.y * next.z - qSoFar.z * next.y;
		var y = qSoFar.y * next.w + qSoFar.w * next.y + qSoFar.z * next.x - qSoFar.x * next.z;
		var z = qSoFar.z * next.w + qSoFar.w * next.z + qSoFar.x * next.y - qSoFar.y * next.x;
		
		qSoFar.x=x;
		qSoFar.y=y;
		qSoFar.z=z;
		qSoFar.w=w;
	}
	
	return qSoFar;
}

function inverseQuaternion(q)
{
	return makeQuat(q.x,q.y,q.z,-q.w);
}

function degToRad(deg)// Degree-to-Radian conversion
{
	 return deg * Math.PI / 180; 
}

function makeRect(width,height,depth)//returns a 3D box like object centered around the origin. There are more than 8 points for this cube as it is being made by chaining together a strip of triangles so points are redundant at least 3x. Confusing for now (sorry) but this odd structure comes in handy later for transitioning into webgl
{
	var newObj={};
	var hw=width/2;
	var hh=height/2;
	var hd=depth/2;
	newObj.vertices=[  [-hw,hh,hd],[hw,hh,hd],[hw,-hh,hd],//first triangle
					  [-hw,hh,hd],[-hw,-hh,hd],[hw,-hh,hd],//2 triangles make front side
					  [-hw,hh,-hd],[-hw,hh,hd],[-hw,-hh,-hd], //left side
					  [-hw,hh,hd],[-hw,-hh,hd],[-hw,-hh,-hd],
					  [hw,hh,-hd],[hw,hh,hd],[hw,-hh,-hd], //right side
					  [hw,hh,hd],[hw,-hh,hd],[hw,-hh,-hd],
					  [-hw,hh,-hd],[hw,hh,-hd],[hw,-hh,-hd],//back
					  [-hw,hh,-hd],[-hw,-hh,-hd],[hw,-hh,-hd],
					  [-hw,hh,-hd],[hw,hh,-hd],[hw,hh,hd],//top
					  [-hw,hh,-hd],[-hw,hh,hd],[hw,hh,hd],
					  [-hw,-hh,-hd],[hw,-hh,-hd],[hw,-hh,hd],//bottom
					  [-hw,-hh,-hd],[-hw,-hh,hd],[hw,-hh,hd]
	];
	
	return newObj;
}

function makeLine(width,height,depth) {

	// returns a 3D like object centered around the origin
	// adapted from makeRect

	var newObj={};
	var hw=width/2;
	var hh=height/2;
	var hd=depth/2;
	newObj.vertices=[  
		[-hw,hh,-hd],[-hw,hh,hd],[-hw,-hh,-hd] // left side
	];

	return newObj;
}

var cube=makeRect(canvas.width/5,canvas.width/5,canvas.width/5);
cube.color="purple";
var xAxis=makeRect(440,10,10);
xAxis.color="green";
var yAxis=makeRect(10,440,10);
yAxis.color="red";
var zAxis=makeRect(10,10,440);
zAxis.color="blue";

var hourAxis=makeLine(200,10,10);
hourAxis.color="green";
var minAxis=makeLine(10,200,1);
minAxis.color="red";
var secAxis=makeLine(10,1,200);
secAxis.color="blue";



function renderObj(obj,q) // renders an object as a series of triangles
{
	var rotatedObj=rotateObject(obj,q);
	context.lineWidth = 1;
	context.strokeStyle = obj.color;
	
	function scaleByZ(val,z)
	{
		var focalLength=900; // [900] should probably be a global but oh well
		var scale= focalLength/((-z)+focalLength);
		return val*scale;
	}
	
	for(var i=0 ; i<obj.vertices.length ; i+=3)
	{
		for (var k=0;k<3;k++)
		{
		  var vertexFrom=rotatedObj.vertices[i+k];
		  var temp=i+k+1;
		  if(k==2) 
			  temp=i;
			  
		  var vertexTo=rotatedObj.vertices[temp];		
		  context.beginPath();
		  context.moveTo(scaleByZ(vertexFrom[0],vertexFrom[2]), ( -scaleByZ(vertexFrom[1],vertexFrom[2])));
		  context.lineTo(scaleByZ(vertexTo[0],vertexTo[2]), ( -scaleByZ(vertexTo[1],vertexTo[2])));
		  context.stroke();

		// circle	       

		// 1. scale
		// http://stackoverflow.com/questions/2172798/how-to-draw-an-oval-in-html5-canvas

		context.save(); // save state
		context.beginPath();
	        // context.translate(0, 0);
	        // context.scale(200*this.fakeBeta, 100);
	        context.scale(100, 100);
        	context.arc(0, 0, 1, 0, 2 * Math.PI, false);
	        context.restore(); // restore to original state
        	context.stroke();
			
		}
	}
}

function rotateObject(obj,q) //object , quternion to rotate rotates obeject
{
	var newObj={};
	newObj.vertices=[];
	
	for(var i=0 ; i<obj.vertices.length ; i++)
	{
	  newObj.vertices.push(rotatePointViaQuaternion(obj.vertices[i],q));
	}
	return newObj;
}

function rotatePointViaQuaternion(pointRa,q)
{
	var tempQuot = {'x':pointRa[0], 'y':pointRa[1], 'z':pointRa[2], 'w':0 };
	var rotatedPoint=quaternionMultiply([ q , tempQuot, conjugateQuot(q)]);//inverseQuaternion(q) also works 

	return [rotatedPoint.x,rotatedPoint.y,rotatedPoint.z];
	
	function conjugateQuot(qq)
	{
		return makeQuat(-qq.x,-qq.y,-qq.z,qq.w);//return {"x":-qq.x,"y":-qq.y,"z":-qq.z,"w": qq.w};
	}
}

// is this in the wrong place?
	  
var userQuat=quatFromAxisAngle(0,0,0,0);//a quaternion to represent the users finger swipe movement - default is no rotation


// ** user input **

var prevTouchX = -1; // -1 is flag for no previous touch info
var prevTouchY = -1;


// touch

document.addEventListener("touchStart", touchStartFunc, true);//?misspelled
document.addEventListener("touchmove", touchmoveFunc, true);
document.addEventListener("touchend", touchEndFunc, true);


function touchStartFunc(e)
{
	prevTouchY=e.touches[0].clientY;
	prevTouchX=e.touches[0].clientX;
}

function touchmoveFunc(e)
{
	if( navigator.userAgent.match(/Android/i) ) //stupid android bug cancels touch move if it thinks there's a swipe happening
	{   
	  e.preventDefault();
	}
	userXYmove(e.touches[0].clientX,e.touches[0].clientY);
}

function touchEndFunc(e)
{
  prevTouchX = -1;
  prevTouchY = -1;
}

// mouse

document.addEventListener("mousedown", mouseDownFunc, true);
document.addEventListener("mousemove", mouseMoveFunc, true);
document.addEventListener("mouseup", mouseUpFunc, true);

function mouseDownFunc(e)
{
  prevTouchX = e.clientX;
  prevTouchY = e.clientY;
}

function mouseMoveFunc(e)
{
	if (prevTouchX!= -1)
		userXYmove(e.clientX,e.clientY);
}

function mouseUpFunc(e)
{
  prevTouchX = -1;
  prevTouchY = -1;
}
	
function userXYmove(x,y)
{

	document.getElementById("userX").innerHTML=x;
	document.getElementById("userY").innerHTML=y;
	
	if(prevTouchX != -1 ) //need valid prevTouch info to calculate swipe
	{
	  var xMovement=x-prevTouchX;
	  var yMovement=y-prevTouchY;
	  //var xMovementQuat=quatFromAxisAngle(1,0,0,y/200);//movement on y rotates x and vice versa
	  //var yMovementQuat=quatFromAxisAngle(0,1,0,x/200);//200 is there to scale the movement way down to an intuitive amount
	 //userQuot=quaternionMultiply([yMovementQuat,xMovementQuat]);//use reverse order
	 
	 
	 var xMovementQuat=quatFromAxisAngle(1,0,0,yMovement/200);//movement on y rotates x and vice versa
	 var yMovementQuat=quatFromAxisAngle(0,1,0,xMovement/200);//200 is there to scale the movement way down to an intuitive amount	 
	  userQuat=quaternionMultiply([gyro,yMovementQuat,xMovementQuat,inverseQuaternion(gyro),userQuat]);//use reverse order

	}
	prevTouchY=y;
	prevTouchX=x;
}





// utility

function makeQuat(x,y,z,w)//simple utitlity to make quaternion object
{
	return  {"x":x,"y":y,"z":z,"w":w};
}

function quatFromAxisAngle(x,y,z,angle)
{
	var q={};
    var half_angle = angle/2;
    q.x = x * Math.sin(half_angle);
    q.y = y * Math.sin(half_angle);
    q.z = z * Math.sin(half_angle);
    q.w = Math.cos(half_angle);
	return q;
}

	
// render loop, in place of setInterval or other callback

function renderLoop() 
{
  requestAnimationFrame( renderLoop );//better than set interval as it pauses when browser isn't active
  //context.clearRect(0, 0, canvas.width, canvas.height);//clear screen
  context.clearRect( -canvas.width/2, -canvas.height/2, canvas.width, canvas.height);//clear screen x, y, width, height
  
  //create some fake data in case web page isn't being accessed from a mobile or gyro enabled device
  if(!( window.DeviceOrientationEvent && 'ontouchstart' in window))
  {
	this.fakeAlpha = (this.fakeAlpha || 0)+ .0;//z axis - use 0 to turn off rotation
	this.fakeBeta = (this.fakeBeta || 0)+ .7;//x axis
	this.fakeGamma = (this.fakeGamma || 0)+ .5;//y axis
	processGyro(this.fakeAlpha,this.fakeBeta,this.fakeGamma);
  }
  
  // renderObj(cube,quaternionMultiply([inverseQuaternion(gyro),userQuat]));
  // renderObj(xAxis,inverseQuaternion(gyro));
  // renderObj(yAxis,inverseQuaternion(gyro));
  // renderObj(zAxis,inverseQuaternion(gyro));
  renderObj(hourAxis,inverseQuaternion(gyro));
  renderObj(minAxis,inverseQuaternion(gyro));
  renderObj(secAxis,inverseQuaternion(gyro));
}
renderLoop();

</script>
