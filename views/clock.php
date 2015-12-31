<? ?><script type="text/javascript" src="<? echo $host; ?>static/js/clock.js"></script><?
if(!$uu->id)
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
if($uu->id)
{
?><script>showHide();</script><?
	if(empty($oo->children_ids($uu->id)))
	{
?><script>showHide();</script><?
	}
} ?>
<!-- 
<script type="text/javascript" src="<? echo $host; ?>static/js/screenfull.js"></script>
<script>
        var e = document.getElementById('clock-canvas');
        e.addEventListener('dblclick', function () {
                if (screenfull.enabled) {
                        screenfull.toggle(e);
                }
        });
</script>
-->

