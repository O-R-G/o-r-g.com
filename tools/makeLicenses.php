<?
$config = $_SERVER["DOCUMENT_ROOT"];
$config = $config."/open-records-generator/config/config.php";
require_once($config);

// specific to this 'app'
$config_dir = $root."config/";
require_once($config_dir."url.php");
require_once($config_dir."request.php");

$db = db_connect("main");

$oo = new Objects();
$mm = new Media();
$ww = new Wires();
$uu = new URL();

$screensaversID = 22;
$appsID = 1;

$fields = array("*");
$tables = array("objects");
$where = array("objects.active = 1","objects.id IN (SELECT wires.toid FROM wires WHERE wires.fromid = $screensaversID AND wires.active = 1) OR objects.id IN (SELECT wires.toid FROM wires WHERE wires.fromid = $appsID AND wires.active = 1)");
$order 	= array("objects.name1");
$res = $oo->get_all($fields, $tables, $where, $order);

// return true on successful insertion
function insertCode($licenseEntryId, $code) {
  global $oo;
  global $ww;

  $insert = array(
    "name1" => $code,
    "url" => $code
  );

  // create new
  foreach($insert as $key => $value)
    $insert[$key] = "'".addslashes($value)."'";

  $code_id = $oo->insert($insert);
  if ($code_id == 0)
    return false;

  $ww->create_wire($licenseEntryId, $code_id);
  return true;
}
?>
<!DOCTYPE html>
<html>
<body>
<?

	if(!isset($_POST["submit"])) {

		?><form action="makeLicenses.php" method="post" enctype="multipart/form-data">
			Enter a code (ex. A84GVF or 3219), or a range (ex. 6842-6845):
			<input type="text" name="codes" id="codes">
			Select O-R-G entry
			<select name="entry">
				<? foreach ($res as $entry): ?>
					<option value="<?= $entry['id'] ?>"><?= $entry['name1']; ?></option>
				<? endforeach; ?>
			</select>
			<input type="submit" value="Upload" name="submit">
		</form><?

	} else {
    $obj_id = $_POST['entry'];

    $licenseEntryId = -1;

    // find licenses entry!
    $children = $oo->children($obj_id);
    foreach($children as $child) {
      if ($child['name1'] == '.Licenses') {
        $licenseEntryId = $child['id'];
      }
    }

    if ($licenseEntryId == -1) {
      echo 'Cannot add licenses. Try another entry.';
    } else {
      $inputCode = $_POST['codes'];
      $codeRange = explode("-", $inputCode);

      // only one entry
      if (sizeof($codeRange) == 1) {
          $code = trim($codeRange[0]);
          $success = insertCode($licenseEntryId, $code);
          if ($success)
            echo 'Successfuly added.';
          else
            echo 'Something happened. Try again.';
      } else {
        // match if range (must be integer)
         echo is_int($codeRange[0]);
        if ((is_numeric($codeRange[0]) && is_numeric($codeRange[1])) && (intval($codeRange[1]) > intval($codeRange[0]))) {
          for ($code = intval($codeRange[0]); $code <= intval($codeRange[1]); $code++) {
            insertCode($licenseEntryId, $code);
          }
          echo 'Successfuly added.';
        } else {
          echo 'Invalid range. Try again.';
        }
      }
    }
	}
?>
</body>
</html>
