<?
$request = $_SERVER['REQUEST_URI'];
$requestclean = strtok($request,"?");
$uri = explode('/', $requestclean);

$view = "views/";
$show_clock = true;

/* ------------------------------------------------------
        handle url:
        + /dev > gyroscope (plus hide the clock)
        + /thx > download
        + everything else > object-fullscreen
------------------------------------------------------ */
if($uri[1] == "dev" || $uri[1] == "dev.php") {
        $view.= "gyroscope.php";
        $show_clock = false;
}
else if($uri[1] == "thx" || $uri[1] == "thx.php")
        $view.= "download.php";
else
        $view.= "object.php";
if($uri[1] == 'shop' && $uri[2] == 'download-link')
    $view = 'views/download-link.php';
// show subscribe form
if($uri[1] == "subscribe")
	$showsubscribe = true;

// show the things
require_once("views/head.php");
require_once($view);
if ($show_clock)
       require_once("views/clock.php");
require_once("views/foot.php");
?>
