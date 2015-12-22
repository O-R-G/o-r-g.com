<?
// namespace stuff
use \Michelf\Markdown;

// 1. split into sections based by '++'
// 2. trim whitespace
// 3. convert from markdown to html
function process_body($b)
{
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
?><section id="body" class="visible">
	<div id="breadcrumbs">
		<ul class="nav-level">
			<li><?
				if(!$uu->id)
				{
				?> O-R-G is a small software company.<?
				}
				else
				{
				?><a href="<? echo $host.$a_url; ?>">O-R-G</a><?
				}
			?></li>
			<ul class="nav-level">
				<span><? echo $name; ?></span>
			</ul>
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