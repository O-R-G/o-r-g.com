<style>
	/* page specific + overrides */

	body {
		background-color:#000; 
		color:#666;
	}
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

<script src='static/js/gyroscope.js'></script>

