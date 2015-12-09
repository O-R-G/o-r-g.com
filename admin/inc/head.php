<?
// path to config file
$config = __DIR__."/../../models/config.php";
require_once($config);

// specific to this 'app'
require_once("url.php");
require_once("request.php");

// logged in user via .htaccess, .htpasswd
$user = $_SERVER['REMOTE_USER'];
$db = db_connect($user);

$oo = new Objects();
$mm = new Media();
$ww = new Wires();
$uu = new URL();
$rr = new Request();

$js_back = "javascript:history.back();";

// self
$item = $oo->get($uu->id);

// am i using the ternary operator correctly?
// if this url has an id, get the associated object,
// else, get the root object
$name = $item ? strip_tags($item["name1"]) : "root";

// document title
$title = $db_name." | ".$name;

$nav = $oo->nav_clean($uu->ids);
?><!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title; ?></title>
		<meta charset="utf-8">
		<meta name="description" content="anglophile">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="<? echo $admin_path;?>media/icon.png">
		<link rel="apple-touch-icon-precomposed" href="<? echo $admin_path;?>media/icon.png">
		<link rel="stylesheet" href="<? echo $admin_path; ?>static/main.css">
	</head>
	<body>
		<div id="page" class="flex-container">
			<div id="header-container" class="flex-min">
				<header class="centre">
					<div id="date-container">
						<span id="date"><?php 
							echo strtolower(date("l, d M Y H:i (T)")); 
						?></span>
					</div>
					<div id="nav">
						<a href="<?php echo $admin_path; ?>browse"><?php 
						echo $db_name ?> db</a>
						<div class="nav-level"><?
						$prevd = $nav[0]['depth'];
						foreach($nav as $n)
						{
							$d = $n['depth'];
							$t = $n['type'];					
							if($d > $prevd)
							{
							?><div class="nav-level"><?
							}
							else {
								for($i = 0; $i < $prevd - $d; $i++) {
								?></div><?
								}
							}
							if($t == "parent") {
							?><div class="parent"><?
							} elseif($t == "self") {
							?><div class="self"><?
							} else {
							?><div><? }
							?><a href="<? echo $admin_path.'browse/'.$n['url']; ?>"><?
									echo $n['o']['name1'];
								?></a>
							</div><?
							$prevd = $d;
						}
						?></div>
					</div>
				</header>
			</div>