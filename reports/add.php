<?php 
require_once("GLOBAL/head.php"); 

if($action != "add") 
{
?><!--  ADD NEW OBJECT  -->

You are adding a new object.<br /><br /><br /><br />

<!-- DISPLAY REWRITTEN FOR TSL SUBSCRIPTIONS -->
<form enctype="multipart/form-data" action="<?php echo $dbAdmin ."add.php". urlData(); ?>" method="post" style="margin: 0; padding: 0;">
    <input name='id' type='hidden' value='<?php echo $id; ?>'>
    <input name='action' type='hidden' value='update'>
	<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="90">First Name&nbsp; </td>
            <td><textarea name='name1' cols='40' rows='1'></textarea></td>
        </tr>
		<tr>
			<td width="90">Last Name&nbsp; </td>
			<td><textarea name='name2' cols='40' rows='1'></textarea></td>
		</tr>
		<tr>
			<td>Address&nbsp; </td>
			<td><textarea name='address1' cols='40' rows='4'></textarea></td>
		</tr>
		<tr>
			<td>City&nbsp; </td>
			<td><textarea name='city' cols='40' rows='1'></textarea></td>
		</tr>
		<tr>
			<td>State&nbsp; </td>
			<td><textarea name='state' cols='40' rows='1'></textarea></td>
		</tr>
		<tr>
			<td>Zip&nbsp; </td>
			<td><textarea name='zip' cols='40' rows='1'></textarea></td>
		</tr>
		<tr>
			<td>Country&nbsp; </td>
			<td><textarea name='country' cols='40' rows='1'></textarea></td>
		</tr>
		<tr>
			<td>Phone&nbsp; </td>
			<td><textarea name='phone' cols='40' rows='1'></textarea></td>
		</tr>
		<tr>
			<td>Email&nbsp; </td>
			<td><textarea name='email' cols='40' rows='1'></textarea></td>
		</tr>
		<tr>
			<td>Begin&nbsp; </td>
			<td><textarea name='begin' cols='40' rows='1'><?php echo $myrow["begin"]; ?></textarea></td>
		</tr>
		<tr>
			<td>End&nbsp; </td>
			<td><textarea name='end' cols='40' rows='1'><?php echo $myrow["end"]; ?></textarea></td>
		</tr>
		<tr>
			<td>Notes&nbsp; </td>
			<td><textarea name='body' cols='40' rows='7'></textarea></td>
		</tr>
		<tr>
			<td>TXN ID&nbsp; </td>
			<td><textarea name='notes' cols='20' rows='1'></textarea></td>
		</tr>
	</table>
	<br /><br /><br />
	<input name='action' type='hidden' value='add' />
	<input 
		name='cancel' 
		type='button' 
		value='Cancel' 
		onClick="javascript:location.href='<?php echo "browse.php". urlData();?>';"
	> 
	<input name='submit' type='submit' value='Add Object' />
</form>

<br />&nbsp;
<?php
} 
else
{

  //////////////
 //  OBJECT  //
//////////////
if (!get_magic_quotes_gpc()) 
{
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
if (!$name1) 
	$name1 = "Untitled";
$begin = ($begin) ? date("Y-m-d H:i:s", strToTime($begin)) : NULL;
$end = ($end) ? date("Y-m-d H:i:s", strToTime($end)) : NULL;

//  Add object to database

$sql = "INSERT INTO objects (
			created, modified, 
			name1, name2, 
			address1, city, state, zip, country, 
			phone, email, 
			begin, end, 
			body, notes) 
		VALUES ('"
			.date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."', 
			'$name1', '$name2', 
			'$address1', '$city', '$state', '$zip', '$country', 
			'$phone', '$email', 
			'$begin', '$end', 
			'$body', '$notes'
		)";
$result = MYSQL_QUERY($sql);
$insertId = MYSQL_INSERT_ID();

  /////////////
 //  WIRES  //
/////////////
$sql = "INSERT INTO wires (
			created, modified, 
			fromid, toid
		) 
		VALUES('"
			.date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."', 
			'$object', '$insertId'
		)";
$result = MYSQL_QUERY($sql);

echo "Object added successfully.<br /><br />";
echo "<a href='". $dbAdmin ."browse.php". urlData() ."'>CONTINUE...</a>";
}
require_once("GLOBAL/foot.php"); 
?>
