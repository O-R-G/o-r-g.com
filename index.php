<?
require_once("GLOBAL/head.php");

$path = "0";
$limit = 1;
$selection = $idFull;
$pageName = "index";
$stub = FALSE;
$breadcrumbsMode = FALSE; 
$multiColumn = 20;

$hide_clock = get_cookie("hide_clock");

if(!$hide_clock)
{
?><div class="column-container hidden"><?
}
else
{
?><div class="column-container visible"><?
}
?><div id="ex-container">
		<img id="ex" src="MEDIA/SVG/ex.svg">
	</div>
	<div id="menu">
		<div><a href="http://dev.o-r-g.com">O-R-G</a></div><?
		displayNavigation(	$path,
							$limit,
							$selection,
							$pageName,
							$stub,
							$breadcrumbsMode,
							$multiColumn);	
	?></div>
</div>
<?
if(!$id)
{
?><canvas id="clock-canvas" class="v-centre"></canvas>
<script>init_clock("clock-canvas");</script>
<script type="text/javascript" src="STATIC/JS/global.js"></script><?
}
else
{
}
require_once("GLOBAL/foot.php");
?>