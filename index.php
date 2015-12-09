<?
require_once("GLOBAL/head.php");
require_once("LIBRARY/displayMedia.php");
require_once("LIBRARY/php-md-lib/Michelf/Markdown.inc.php");
use \Michelf\Markdown;

// menu variables
$path = "0";
$limit = 1;
$selection = $idFull;
$pageName = "index";
$stub = FALSE;
$breadcrumbsMode = FALSE; 
$multiColumn = 20;


// mmm what to do about this?
$hide_clock = get_cookie("hide_clock");

// 
$rootid = $ids[0];

if(!$id)
{
// show clock
?><canvas id="clock-canvas" class="v-centre"></canvas>
<script>init_clock("clock-canvas");</script>
<script type="text/javascript" src="STATIC/JS/global.js"></script>
<div class="column-container hidden"><?
}
else
{
	?><div class="column-container visible"><?
}
?><div id="menu">
		<div><a href="http://dev.o-r-g.com">O-R-G</a></div><?
		displayNavigation(	$path,
							$limit,
							$selection,
							$pageName,
							$stub,
							$breadcrumbsMode,
							$multiColumn);	
	?></div>
<?
if($id)
{
	// sql objects plus media plus rootname
	$sql = "SELECT
				objects.id AS objectsId,
				objects.name1,
				objects.deck,
				objects.body,
				objects.notes,
				objects.active,
				objects.end,
				objects.rank as objectsRank,
				(SELECT objects.name1
				FROM objects
				WHERE objects.id = $rootid) AS rootname,
				media.id AS mediaId,
				media.object AS mediaObject,
				media.type,
				media.caption,
				media.active AS mediaActive,
				media.rank
			FROM objects
			LEFT JOIN media
			ON
				objects.id = media.object
				AND media.active = 1
			WHERE
				objects.id = $id
				AND objects.active
			ORDER BY media.rank";

	$result = MYSQL_QUERY($sql);
	$images[] = "";
	$image_files[] = "";
	$caption[] = "";
	$i = 0; 
	$id_last = 0;

	while($myrow = MYSQL_FETCH_ARRAY($result))
	{
		if($myrow['mediaActive'] != null)
		{
			$m_file = "MEDIA/";
			$m_file.= str_pad($myrow["mediaId"], 5, "0", STR_PAD_LEFT);
			$m_file.= ".".$myrow["type"];
			$m_caption = $myrow["caption"];
	 		$m_style = "width: 100%;";
			$image_files[$i] = $m_file;

			$images[$i] .= "<div ";
			$images[$i] .= "id='image".$i."' ";
			$images[$i] .= "style='".$icStyle."' ";
			$images[$i] .= ">";
		
			$images[$i].= displayMedia($m_file, $m_caption, $m_style);
		
			$images[$i].= "</div>";
			$id_last = $myrow['objectsId'];
		}
		$i++;
	}
		$body = $obj['body'];
		$body = htmlentities($body);
		// $body = nl2br($body);
		$body = explode("++", $body);
		$i = 0;
		for($i = 0; $i < count($body) - 1; $i++)
		{
			$b = trim($body[$i]);
			$b = Markdown::defaultTransform($b);
			echo $b;
			if($i == 0)
				echo $images[0];
			?></div>
			<div class="column-container visible"><?
		}
		$b = trim($body[$i]);
		$b = Markdown::defaultTransform($b);
		echo $b;
	?></div><?
}
?></div><?
require_once("GLOBAL/foot.php");
?>