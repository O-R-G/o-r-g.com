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

$screensaversID = 22;
$appsID = 1;

$fields = array("*");
$tables = array("objects");
$where = array("objects.active = 1","objects.id IN (SELECT wires.toid FROM wires WHERE wires.fromid = $screensaversID AND wires.active = 1) OR objects.id IN (SELECT wires.toid FROM wires WHERE wires.fromid = $appsID AND wires.active = 1)");
$order 	= array("objects.name1");
$res = $oo->get_all($fields, $tables, $where, $order);
?>
<!DOCTYPE html>
<html>
<body><?

	if(!isset($_POST["submit"])) {

		?><form action="upload.php" method="post" enctype="multipart/form-data">
			Select file to upload (.dmg / .zip):
			<input type="file" name="fileToUpload" id="fileToUpload">
			Select O-R-G entry
			<select name="entry">
					<option value="none">NONE</option>
				<? foreach ($res as $entry): ?>
					<option value="<?= $entry['id'] ?>"><?= $entry['name1']; ?></option>
				<? endforeach; ?>
			</select>
			<input type="submit" value="Upload" name="submit">
			<!-- <input type="text" value="email" name="email"> -->
		</form><?

	} else {

		if ($_POST['entry'] == 'none') {
			$target_dir = "../out/";	// permissions 777
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		} else {
			$name1 = '';
			foreach ($res as $entry) {
				if ($entry['id'] == $_POST['entry'])
					$name1 = $entry['name1'];
			}

			$target_dir = "../out/";	// permissions 777
			$target_dir .= md5($name1 . $_POST['entry']);
			$target_dir .= '/';

			if (!file_exists($target_dir)) {
		    mkdir($target_dir, 0777, true);
			}

			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

			// $target_file = $target_dir . str_replace(' ', '-', $name1) . '.' . $imageFileType;
			$target_file = $target_dir . trim(str_replace('*','', $name1)) . '.' . $imageFileType;
		}

		$uploadOk = 1;

		/*
		// Check if file already exists
		if (file_exists($target_file)) {
    			echo "Sorry, file already exists.";
    			$uploadOk = 0;
		}
		*/
		/*
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			echo "Sorry, your file is too large.";
    			$uploadOk = 0;
		}
		*/
		// Allow certain file formats
		if($imageFileType != "dmg" && $imageFileType != "zip") {
            $status = "Sorry, only .dmg and .zip files are allowed.";
    		$uploadOk = 0;
		}
		if ($uploadOk == 0) {
                $status = "Sorry, your file was not uploaded.";
		} else {
    			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
						if ($_POST['entry'] == 'none')
        			$status = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
						else
							$status = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded and is located at $target_file";
    			} else {
    				$status = "Sorry, there was an error uploading your file.";
    			}
		}

		// email confirmation
		// $email = $_POST["email"];
		// $url = "http://o-r-g.com/out/" .  basename( $_FILES["fileToUpload"]["name"]);
	  //       $headers = "From: store@o-r-g.com" . "\r\n" . "Reply-To: store@o-r-g.com" . "\r\n" . "X-Mailer: PHP/" . phpversion();
		//
		// mail($email, $status, $url, $headers);
		//
		// if ($email != "email") $status .= " A confirmation email has been sent to " . $email . ".";
		// mail("reinfurt@o-r-g.com", $status, $url, $headers);

	        echo $status;
 	}
?></body>
</html>
