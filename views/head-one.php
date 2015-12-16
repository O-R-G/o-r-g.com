<?php
// path to config file
$config = __DIR__."/../models/config.php";
require_once($config);

// specific to this 'app'
require_once("url.php");
require_once("request.php");

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
		<link rel="shortcut icon" href="<? echo $host;?>static/icon.png">
		<link rel="stylesheet" href="<? echo $host; ?>STATIC/CSS/global.css">
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
				?><a href="<? echo $host?>about">What is O-R-G?</a>
			</header>