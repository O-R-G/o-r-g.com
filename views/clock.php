<? ?><script type="text/javascript" src="<? echo $host; ?>static/js/clock.js"></script><?
if(!$uu->id)
{
?><canvas id="clock-canvas" class="v-centre"></canvas>
<script>init_clock("clock-canvas", "centre", "true");</script><?
}
else
{
?><canvas id="clock-canvas" class="lower-right"></canvas>
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
}