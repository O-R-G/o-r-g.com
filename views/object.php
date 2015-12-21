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
?><section id="body" class="visible">
	<div id="breadcrumbs">
		<ul class="nav-level">
			<li><a href="<? echo $host.$a_url; ?>">O-R-G</a><?
				if(!$uu->id)
				{
				?> is a small software company.<?
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