<?
// namespace stuff
use \Michelf\Markdown;

$about = $oo->get(5);

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

$body = $about["body"];
$b_arr = process_body($body);
?><section id="body"><?
for($i = 0; $i < count($b_arr); $i++)
{
	?><div class="column-container hidden"><? 
		echo $b_arr[$i];
		if($i == 0 && $marr[0])
		{
		?><div><img src="<? echo m_url($marr[0]);?>"></div><?
		}
	?></div><?
} 
?></section>
<script type="text/javascript" src="STATIC/JS/clock.js"></script>
<canvas id="clock-canvas" class="v-centre"></canvas>
<script>init_clock("clock-canvas");</script>
<script type="text/javascript" src="STATIC/JS/global.js"></script>