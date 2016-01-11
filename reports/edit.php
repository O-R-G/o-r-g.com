<?php require_once("GLOBAL/head.php"); 
echo "\n\n\n\n<br /><br />\n\n";



if ($action != "update") {



	if ($object) {


		  ///////////////////////
		 //  OBJECT CONTENTS  //
		///////////////////////

		$sql = "SELECT * FROM objects WHERE id = '". $objects[$o] ."' AND active = 1 LIMIT 1";
		$result = MYSQL_QUERY($sql);
		$myrow = MYSQL_FETCH_ARRAY($result);
		?>

		<!-- DISPLAY REWRITTEN FOR TSL SUBSCRIPTIONS -->

		<br />
		<table cellpadding="0" cellspacing="0" border="0">
		<form enctype="multipart/form-data" action="<?php echo $dbAdmin ."edit.php". urlData(); ?>" method="post" style="margin: 0; padding: 0;">
		<input name='id' type='hidden' value='<?php echo $id; ?>'>
		<input name='action' type='hidden' value='update'>

		<tr><td width="90">First Name&nbsp; </td>
		<td><textarea name='name1' cols='40' rows='1'><?php echo $myrow["name1"]; ?></textarea></td></tr>

		<tr><td width="90">Last Name&nbsp; </td>
		<td><textarea name='name2' cols='40' rows='1'><?php echo $myrow["name2"]; ?></textarea></td></tr>

		<tr><td>Address&nbsp; </td>
		<td><textarea name='address1' cols='40' rows='4'><?php echo $myrow["address1"]; ?></textarea></td></tr>

		<tr><td>City&nbsp; </td>
		<td><textarea name='city' cols='40' rows='1'><?php echo $myrow["city"]; ?></textarea></td></tr>

		<tr><td>State&nbsp; </td>
		<td><textarea name='state' cols='40' rows='1'><?php echo $myrow["state"]; ?></textarea></td></tr>

		<tr><td>Zip&nbsp; </td>
		<td><textarea name='zip' cols='40' rows='1'><?php echo $myrow["zip"]; ?></textarea></td></tr>

		<tr><td>Country&nbsp; </td>
		<td><textarea name='country' cols='40' rows='1'><?php echo $myrow["country"]; ?></textarea></td></tr>

		<tr><td>Phone&nbsp; </td>
		<td><textarea name='phone' cols='40' rows='1'><?php echo $myrow["phone"]; ?></textarea></td></tr>

		<tr><td>Email&nbsp; </td>
		<td><textarea name='email' cols='40' rows='1'><?php echo $myrow["email"]; ?></textarea></td></tr>

		<tr><td>Begin&nbsp; </td>
		<td><textarea name='begin' cols='40' rows='1'><?php echo $myrow["begin"]; ?></textarea></td></tr>

		<tr><td>End&nbsp; </td>
		<td><textarea name='end' cols='40' rows='1'><?php echo $myrow["end"]; ?></textarea></td></tr>

		<tr><td>Notes&nbsp; </td>
		<td><textarea name='body' cols='40' rows='7'><?php echo $myrow["body"]; ?></textarea></td></tr>

		<tr><td>TXN ID&nbsp; </td>
		<td><textarea name='notes' cols='20' rows='1'><?php echo $myrow["notes"]; ?></textarea></td></tr>

		</table>

		<br /><br /><br />
		<input name='action' type='hidden' value='update' />
		<input name='cancel' type='button' value='Cancel' onClick="javascript:location.href='<?php echo "browse.php". urlBack(); ?>';" /> 
		<input name='submit' type='submit' value='Update Object' />
		</form><br />&nbsp;
		<?php
	}



} else {



	  /////////////////////
	 //  UPDATE Object  //
	/////////////////////

	$sql = "SELECT * FROM objects WHERE id = '$object' LIMIT 1";
	$result = MYSQL_QUERY($sql);
	$myrow = MYSQL_FETCH_ARRAY($result);

	if (!get_magic_quotes_gpc()) {

		$name1 = 	addslashes($name1);
		$name2 = 	addslashes($name2);
		$address1 = 	addslashes($address1);
		$city = 	addslashes($city);
		$state = 	addslashes($state);
		$zip = 		addslashes($zip);
		$country = 	addslashes($country);
		$phone = 	addslashes($phone);
		$email = 	addslashes($email);
		$begin = 	addslashes($begin);
		$end = 		addslashes($end);
		$body = 	addslashes($body);
		$notes = 	addslashes($notes);
	}


	//  Process variables

	if (!$name1) $name1 = "Untitled";
	$begin = ($begin) ? date("Y-m-d H:i:s", strToTime($begin)) : NULL;
	$end = ($end) ? date("Y-m-d H:i:s", strToTime($end)) : NULL;
	$z = NULL;


	//  Check for differences

	if ($myrow["name1"] 	!= $name1) 	$z .= "name1='$name1', ";
	if ($myrow["name2"] 	!= $name2) 	$z .= "name2='$name2', ";
	if ($myrow["address1"] 	!= $address1) 	$z .= "address1='$address1', ";
	if ($myrow["city"] 	!= $city) 	$z .= "city='$city', ";
	if ($myrow["state"] 	!= $state) 	$z .= "state='$state', ";
	if ($myrow["zip"] 	!= $zip) 	$z .= "zip='$zip', ";
	if ($myrow["country"] 	!= $country) 	$z .= "country='$country', ";
	if ($myrow["phone"] 	!= $phone) 	$z .= "phone='$phone', ";
	if ($myrow["email"] 	!= $email) 	$z .= "email='$email', ";
        if ($myrow["begin"]     != $begin)      $z .= ($begin) ? "begin ='$begin', " : "begin = null, ";
        if ($myrow["end"]       != $end)        $z .= ($end) ? "end ='$end', " : "end = null, ";
	if ($myrow["body"] 	!= $body) 	$z .= "body='$body', ";
	if ($myrow["notes"] 	!= $notes) 	$z .= "notes='$notes', ";


	//  Update edited fields only

	if ($z) {

		$sql = "UPDATE objects SET ". $z ."modified='". date("Y-m-d H:i:s") ."' WHERE id = '$object'";
		$result = MYSQL_QUERY($sql);
	}



	//  Job well done?
	
	if ($z || $m) {

		echo "Successfully updated.<br />";

	} else {

		echo "Nothing was edited, therefore update not required.<br />";
	}
	echo "<br /><br /><a href='". $dbAdmin ."edit.php". urlData() ."'>REFRESH OBJECT</a><br />&nbsp;";
}



require_once("GLOBAL/foot.php"); ?>
