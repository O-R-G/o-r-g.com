<?
// path to config file
$config = __DIR__."/../admin/config/config.php";
require_once($config);

// specific to this 'app'
$config_dir = __DIR__."/../config/";
require_once($config_dir."url.php");
require_once($config_dir."request.php");

$db = db_connect("guest");

$oo = new Objects();
$mm = new Media();
$ww = new Wires();
$uu = new URL();
// $rr = new Request();

// self
if($uu->id)
	$item = $oo->get($uu->id);
else
	$item = $oo->get(0);
$name = strip_tags($item["name1"]);

// document title
$item = $oo->get($uu->id);
$title = $item["name1"];
$db_name = "on-run-go";
if ($title)
	$title = $db_name ." | ". $title;
else
	$title = $db_name;

$nav = $oo->nav($uu->ids);

?><!DOCTYPE html>
<html>
	<head>
		<title><? echo $title; ?></title>
		<link rel="stylesheet" href="<? echo $host; ?>static/css/global.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<div id="page"><?
			if(!$uu->id)
			{
			?><header class="column-container hidden"><?
			}
			else
			{
			?><header class="column-container visible"><?
			}
				?><ul>
					<li><a href="<? echo $host; ?>">O-R-G</a></li>
					<ul class="nav-level"><?
				$prevd = $nav[0]['depth'];
				foreach($nav as $n)
				{
					$d = $n['depth'];
					if($d > $prevd)
					{
					?><ul class="nav-level"><?
					}
					else
					{
						for($i = 0; $i < $prevd - $d; $i++)
						{ ?></ul><? }
					}
					?><li>
						<a href="<? echo $host.$n['url']; ?>"><?
							echo $n['o']['name1'];
						?></a>
					</li><?
					$prevd = $d;
				}
				?></ul>
				</ul>
			</header>