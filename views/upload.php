<!DOCTYPE html>
<html>
<body><?

	if(!isset($_POST["submit"])) {

		?><form action="upload.php" method="post" enctype="multipart/form-data">
			Select file to upload (.dmg / .zip):
			<input type="file" name="fileToUpload" id="fileToUpload">
			<input type="submit" value="Upload" name="submit">
		</form><?

	} else {

		$target_dir = "../out/";	// permissions 777
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
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
			echo "Sorry, only .dmg and .zip files are allowed.";
    			$uploadOk = 0;
		}
		if ($uploadOk == 0) {
    			echo "Sorry, your file was not uploaded.";
		} else {
    			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        			echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    			} else {
				echo "Sorry, there was an error uploading your file.";
    			}
		}
	}
?></body>
</html>
