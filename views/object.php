<?
// namespace stuff
use \Michelf\Markdown;

// 1. don't mess up quotes / em-dashes / etc
// 2. split into sections based by '++'
// 3. trim whitespace
// 4. convert from markdown to html
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
$oarr = $oo->get($uu->id);
$body = $oarr["body"];
$b_arr = process_body($body);
$marr = $oo->media($uu->id);

$ancestors = $oo->ancestors($uu->id);
$a_url = "";
?><section id="body" class="visible">
	<div id="breadcrumbs"><?
		for($i = 0; $i < count($ancestors); $i++)
		{
			$a = $oo->get($ancestors[$i]);
			$a_url.= $a["url"];
		?><ul class="nav-level">
			<li><a href="<? echo $host.$a_url; ?>"><? echo $a["name1"]; ?></a></li>
		</ul><?
			$a_url.= "/";
		}
		?><ul class="nav-level"><?
			$a_url.= $item["url"];
			?><a href="<? echo $host.$a_url; ?>"><? echo $name; ?></a>
		</ul>
	</div><?
for($i = 0; $i < count($b_arr); $i++)
{
	if($i % 2 == 0)
	{
	?><div class="column-container-container"><?
	}
	?><div class="column-container"><? 
		echo $b_arr[$i];
		if($i == 0 && $marr[0])
		{
		?><div><img src="<? echo m_url($marr[0]);?>"></div><?
		}
	?></div><?
	if($i % 2 == 1)
	{
	?></div><?
	}
} 
?></section>