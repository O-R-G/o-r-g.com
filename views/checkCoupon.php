<?
$config = $_SERVER["DOCUMENT_ROOT"];
$config = $config."/open-records-generator/config/config.php";
require_once($config);

// specific to this 'app'
$config_dir = $root."config/";
require_once($config_dir."url.php");
require_once($config_dir."request.php");

$db = db_connect("guest");

$oo = new Objects();
$mm = new Media();
$ww = new Wires();
$uu = new URL();

$id = $_GET['id'];
$type = $_GET['type'];
$code = $_GET['code'];

$fields = array("*");
$tables = array("objects");
$where 	= array("objects.url = '".$id."'");
$order 	= array("objects.rank", "objects.begin", "objects.end", "objects.name1");
$res = $oo->get_all($fields, $tables, $where, $order);

$obj = $res[0];
$codesRaw = $obj['notes'];
$codesLines = explode("\n", $codesRaw);

$output = array(
   "valid" => false
 );

// check Notes
foreach($codesLines as $codesLine) {
  if ($type == 'screensaver') {
    // Example: 2390-2391,free
    $codeMeta = explode(",", $codesLine);
    $codeRange = explode("-", $codeMeta[0]);

    // any match (not necessarily integer)
    if (sizeof($codeRange) == 1) {
      if (trim($codeRange[0]) == $code) {
        $output['valid'] = trim($codeMeta[1]);
      }
    } else {
      // match if range (must be integer)
      if (intval($codeRange[0]) <= intval($code) && intval($code) <= intval($codeRange[1])) {
        $output['valid'] = trim($codeMeta[1]);
      }
    }

    if ($output['valid'] != false && sizeof($codeMeta) == 3) {
      $output['meta'] = trim($codeMeta[2]);
    }
  }

  if ($output['valid'])
    break;
}

// check .License
$licenseEntryId = -1;
$children = $oo->children($obj['id']);
foreach($children as $child) {
  if ($child['name1'] == '.Licenses') {
    $licenseEntryId = $child['id'];
  }
}

if ($licenseEntryId != -1) {
  $licenses = $oo->children($licenseEntryId);
  foreach($licenses as $license) {
    if ($license['name1'] == $code) {
      $output['valid'] = 'license';
      if ($type == 'screensaver') {
        $path = '/out/' . md5($obj['name1'] . $obj['id']) . '/' . $obj['name1'];
        $extension = pathinfo(glob('..' . $path . '.*')[0], PATHINFO_EXTENSION);
        $output['meta'] = '//' . $_SERVER['HTTP_HOST'] . $path . '.' . $extension;
      } else if ($type == 'ios-app') {
        $output['meta'] = $license['notes'];
      }
    }
  }
}

echo json_encode($output);
?>
