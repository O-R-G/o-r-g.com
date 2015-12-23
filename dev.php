<!DOCTYPE html>
<html>
        <head>
                <title><? echo $title; ?></title>
                <link rel="stylesheet" href="<? echo $host; ?>static/css/global.css">
                <link rel="stylesheet" href="<? echo $host; ?>static/css/sf-text.css">
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body>
                <div id="page">

<? ?><script type="text/javascript" src="<? echo $host; ?>static/js/clock.js"></script><?
if(!$uu->id)
{
?>
<div id="canvas-container" class="v-centre">
        <canvas id="clock-canvas"></canvas>
</div>
<script>init_clock("clock-canvas", "centre", "true");</script><?
}
else
{
?>
<div id="canvas-container" class="lower-right">
        <canvas id="clock-canvas"></canvas>
</div>
<script>init_clock("clock-canvas", "lower-right");</script><?
}
?><script type="text/javascript" src="<? echo $host; ?>static/js/global-dev.js"></script><?
if($uu->id)
{
?><script>showHide();</script><?
        if(empty($oo->children_ids($uu->id)))
        {
?><script>showHide();</script><?
        }
}

?>
                </div>
        </body>
</html>
