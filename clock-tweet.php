<?
$host = "http://".$_SERVER["HTTP_HOST"]."/";
?>
<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript" src="<? echo $host; ?>static/js/twitter-ajax.js"></script>
		<script type="text/javascript" src="<? echo $host; ?>static/js/twitter-clock.js"></script>
		<style>
			body {
				margin: 0px;
			}
			#info-container {
				padding: 20px;
			}
			#status {
				padding-bottom: 10px;
			}
		</style>
	</head>
	<body>
		<div id="info-container">
			<div id="status"></div>
			<div id="button">
				<button onclick="tweet();">send a tweet!</button>
			</div>
		</div>
		<div id="canvas-container" class="v-centre">
			<canvas id="clock-canvas"></canvas>
		</div>
		<script>init_clock("clock-canvas", "centre", true);</script>
	</body>
</html>