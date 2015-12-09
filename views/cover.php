<?

// TODO: figure out how to includ this in head.php 
require_once("LIBRARY/php-md-lib/Michelf/Markdown.inc.php");
use \Michelf\Markdown;
// end TODO


function process_body($b)
{
	$b = htmlentities($b);
	$b_arr = explode("++", $b);
	foreach($b_arr as &$b)
	{
		$b = trim($b);
		$b = Markdown::defaultTransform($b);
	}
	return $b_arr;
}

if(!$uu->id)
{
	// if on the homepage, show the clock
	?><script type="text/javascript" src="STATIC/JS/clock.js"></script>
	<canvas id="clock-canvas" class="v-centre"></canvas>
	<script>init_clock("clock-canvas");</script>
	<script type="text/javascript" src="STATIC/JS/global.js"></script><?
}
else
{
	$oarr = $oo->get($uu->id);
	$body = $oarr["body"];
	$b_arr = process_body($body);
	$marr = $oo->media($uu->id);
	?><section id="body"><?
	for($i = 0; $i < count($b_arr); $i++)
	{
	?><div class="column-container"><? 
		echo $b_arr[$i];
		if($i == 0 && $marr[0])
		{
		?><div><img src="<? echo m_url($marr[0]);?>"></div><?
		}
	?></div><?
	} 
	?></section><?
}