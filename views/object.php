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
?></section>