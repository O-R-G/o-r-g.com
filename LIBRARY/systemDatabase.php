<?php
  ////////////////
 //  Database  //
////////////////
function systemDatabase() 
{
	$dbMainHost = "db153.pair.com";
	$dbMainUser = "reinfurt_42_r";
	$dbMainPass = "8hPxYMS9";
	$dbMainDbse = "reinfurt_onrungo";

	$dbConnect = MYSQL_CONNECT($dbMainHost, $dbMainUser, $dbMainPass);
	MYSQL_SELECT_DB($dbMainDbse, $dbConnect);
}
systemDatabase();
?>