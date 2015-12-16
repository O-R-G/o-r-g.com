<?php
$uri = explode('/', $_SERVER['REQUEST_URI']);
if($uri[1] == "one")
{
	require_once("views/head-one.php");
	require_once("views/clock.php");
	require_once("views/foot.php");
}
else if($uri[1] == "two")
{
	require_once("views/head-one.php");
	require_once("views/clock-two.php");
	require_once("views/foot.php");
}
else
{
	require_once("views/head.php");
	// only show the clock on the homepage
	if($uu->id)
		require_once("views/object.php");
	else
		require_once("views/clock.php");
	require_once("views/foot.php");
}
?>