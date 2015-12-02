<!DOCTYPE html>
<html>
	<head>
		<title>on-run-go</title>
		<link rel="stylesheet" href="STATIC/CSS/global.css">
		<script type="text/javascript" src="STATIC/JS/clock.js"></script>
	</head>
	<body>
		<div id="about" class="icon-container hidden">?</div>
		<div id="wyoscan" class="icon-container hidden">
			<object id="wyoscan-svg" data="MEDIA/SVG/wyoscan.svg" type="image/svg+xml"></object>
		</div>
		<div id="jules" class="icon-container hidden">
			<img src="MEDIA/GIF/jules.gif">
		</div>
		<div id="multi" class="icon-container hidden">
			<img src="MEDIA/GIF/multi.gif">
		</div>
		<canvas id="clock-canvas"></canvas>
		<script>init_clock("clock-canvas");</script>
		<script type="text/javascript" src="STATIC/JS/global.js"></script>
		<script src="STATIC/JS/wyoscan.js"></script>
		<script>setup('wyoscan-svg');</script>
	</body>
</html>