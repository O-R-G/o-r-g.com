<? ?><script type="text/javascript" src="<? echo $host; ?>static/js/clock.js"></script><?
if(!$uu->id && $uri[1] != "thx")
{
?>
<div id="canvas-container" class="v-centre">
	<canvas id="clock-canvas"></canvas>
</div>
<script>init_clock("clock-canvas", "centre", "true");</script><?
}
else
{
?>
<div id="canvas-container" class="lower-right">
	<canvas id="clock-canvas"></canvas>
</div>
<script>init_clock("clock-canvas", "lower-right");</script><?
}
?><script type="text/javascript" src="<? echo $host; ?>static/js/global.js"></script><?
if($uu->id || $uri[1] == "thx")
{
?><script>showHide();</script><?
	if(empty($oo->children_ids($uu->id)) || $uri[1] == "thx")
	{
?><script>showHide();</script><?
	}
} ?>
