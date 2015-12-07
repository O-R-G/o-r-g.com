<?
require_once("GLOBAL/head.php");
?>
<div id="menu" class="hidden">
	<div id="ex-container">
		<img id="ex" src="MEDIA/SVG/ex.svg">
	</div>
	<div id="about" class="icon-container">on-run-go</div>
	<a href="http://o-r-g.com">
		<div id="wyoscan" class="icon-container">
			<object id="wyoscan-svg" data="MEDIA/SVG/wyoscan.svg" type="image/svg+xml"></object>
		</div>
	</a>
	<div id="jules" class="icon-container">
		<img src="MEDIA/GIF/jules.gif">
	</div>
	<div id="multi" class="icon-container">
		<img src="MEDIA/GIF/multi.gif">
	</div>
</div>

<canvas id="clock-canvas" class="v-centre"></canvas>
<script>init_clock("clock-canvas");</script>
<script type="text/javascript" src="STATIC/JS/global.js"></script>
<script src="STATIC/JS/wyoscan.js"></script>
<script>init_wyoscan('wyoscan-svg');</script>
<?
require_once("GLOBAL/foot.php");
?>