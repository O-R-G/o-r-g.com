<?php
require_once("inc/head.php");
// only show the clock on the homepage
if($uu->id)
	require_once("views/object.php");
else
	require_once("views/clock.php");
require_once("inc/foot.php");
?>