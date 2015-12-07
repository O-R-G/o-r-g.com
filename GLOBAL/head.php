<?
date_default_timezone_set("America/New_York");
require_once("LIBRARY/systemDatabase.php");

// parse $id
$id = $_REQUEST['id'];
if(!$id)
	$id = 0;
else {
	$ids = explode(",", $id);
	$idFull = $id;
	$id = end($ids);
}

$sql = "SELECT * from objects where id = $id";
$res = MYSQL_QUERY($sql);
$obj = MYSQL_FETCH_ARRAY($res);
$name = $obj['name1'] ? $obj['name1'] : "on-run-go";
?>
<!DOCTYPE html>
<html>
	<head>
		<title><? echo $name; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="STATIC/CSS/global.css">
		<script type="text/javascript" src="STATIC/JS/clock.js"></script>
	</head>
	<body>