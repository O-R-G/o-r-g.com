<?
date_default_timezone_set("America/New_York");
require_once("twitterConnect.php");

$root = $_SERVER["DOCUMENT_ROOT"]."/";
$media_dir = $root."media/png/";
$time = date("H.i.s");
$type = ".png";

$img = $_REQUEST['img'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);

$data = base64_decode($img);

// filename
$file = $media_dir.$time.$type;

// save image
file_put_contents($file, $data);

$can_tweet = true;

$tweet_url = "https://twitter.com/org_clock/status/";

if($connection && $can_tweet)
{
	$media = $connection->upload('media/upload', ['media' => $file]);
	// to add text, use 'status' => 'TWEET TEXT'
	$parameters = [
		// 'status' => $time
		'media_ids' => implode(',', [$media->media_id_string]),
	];
	$result = $connection->post('statuses/update', $parameters);

	$can_tweet = false;
	echo "<a href='".$tweet_url.$result->id_str."' target='new'>here's your tweet</a><br>";
}
else
	echo "tweet not sent.<br>";

// delete generated image
unlink($file);
?>