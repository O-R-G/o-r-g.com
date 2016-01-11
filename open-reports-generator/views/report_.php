<?php 

// Output CSV and exit

if($csv) 
{
	require_once("GLOBAL/config.php");
	dbConnectMain(1);

	$sql = "SELECT body 
			FROM objects 
			WHERE 
				objects.id = $object 
				AND objects.active = 1 
			LIMIT 1;";
	$result = MYSQL_QUERY($sql);
	$myrow = MYSQL_FETCH_ARRAY($result);
	$sqlQuery = $myrow["body"];

	// Run report
	$sql = $sqlQuery;
	$result = MYSQL_QUERY($sql);
	$csv = "";

	while($myrow = MYSQL_FETCH_ARRAY($result)) 
	{
		$csv .= $myrow['name1'] . "," . $myrow['name2'] . ",". $myrow['address1'] . "," . $myrow['city'] . "," . $myrow['state'] . "," . $myrow['zip']. "," . $myrow['country'];
	}
	echo $csv;
	exit();
}

	// Output emails and exit

	if ($emails) {

		require_once("GLOBAL/config.php");
		dbConnectMain(1);

		$sql = "SELECT body FROM objects WHERE objects.id = $object AND objects.active = 1 LIMIT 1;";
	        $result = MYSQL_QUERY($sql);
        	$myrow = MYSQL_FETCH_ARRAY($result);
	        $sqlQuery = $myrow["body"];

        	// Run report

	        $sql = $sqlQuery;
        	$result = MYSQL_QUERY($sql);
		$emails = "";

		while ( $myrow = MYSQL_FETCH_ARRAY($result) ) {

			if ($myrow['email']) $emails .= $myrow['email'] . "\n\r";
		}

		echo nl2br($emails);
		exit();
	}
	
	// Generate Report

require_once("GLOBAL/head.php"); 

if(!$object)
{
	// Nothing to report
	echo  "Please select a valid report to generate.<br />";
	$result = NULL;
} 
else 
{
	// Custom report selected?
	$sql = "SELECT * 
			FROM objects, wires 
			WHERE 
				objects.id=$object AND 
				wires.toid=objects.id AND 
				wires.fromid=1 AND 
				objects.active = (SELECT id FROM objects WHERE name1 LIKE '_Reports') AND 
				wires.active=1 
			LIMIT 1;";
	$result = MYSQL_QUERY($sql);
	$myrow = MYSQL_FETCH_ARRAY($result);

    if($myrow) 
    {
		// Yes, run custom report
		$sqlQuery = $myrow["body"];
		$sql = $sqlQuery;
		$result = MYSQL_QUERY($sql);
		$report = TRUE;
		if(!$result)
		{
			echo "Please select a valid custom report to generate.<br />";
			echo $sqlQuery;
		} 

	} 
	else
	{
		// No, retrieve discreet information
		$sql = "SELECT * 
				FROM objects 
				WHERE 
					objects.id = $object AND 
					objects.active = 1 
				LIMIT 1;";
		$result = MYSQL_QUERY($sql);
	}

	// Display table format
	$html  = "<table cellpadding='10' border='1' width='900px'>";

	// Column headers
	$html .= "<tr style='background-color:#CCCCCC;'>";
	$html .= "<td width='200px'>NAME</td>";
	$html .= "<td width='300px'>ADDRESS</td>";
	$html .= "<td width='300px'>EMAIL</td>";
	$html .= "<td width='100px'>BEGIN / END</td>";
	$html .= "</tr>";

		// Data
	
		while ( $myrow = MYSQL_FETCH_ARRAY($result) ) {

			$html .= "<tr style='background-color:#" . (($rowcolor % 2) ? "E9E9E9" : "EFEFEF") . ";'>";
			$html .= "<td>" . $myrow['name1'] . " " . $myrow['name2'] . "</td>";
			$html .= "<td>" . $myrow['address1'] . "<br />" . $myrow['city'] . " " . $myrow['state'] . " " . $myrow['zip'] . "<br />" . $myrow['country'] . "</td>";
			$html .= "<td>" . $myrow['email'] . "</td>";
			$html .= "<td>" . date("Y M j", strToTime($myrow['begin'])) . "<br />" . date("Y M j", strToTime($myrow['end'])) . "</td>";
			$html .= "</tr>";
		
			$rowcolor++;
			$rownumber++;
		}

		$html .= "</table>";
		$html .= "<br />$rownumber total results found."; 
		echo $html;
	}

	echo "<br /><br />";
	if ($report) echo "<a href='report.php?object=$object&csv=1' target='_new'>EXPORT CSV . . .</a>&nbsp;&nbsp;";
	if ($report) echo "<a href='report.php?object=$object&emails=1' target='_new'>EXPORT EMAILS . . .</a>&nbsp;&nbsp;";
	echo "<a href='browse.php" . urlBack() . "'>GO BACK . . .</a>&nbsp;&nbsp;";

require_once("GLOBAL/foot.php"); 
?>
