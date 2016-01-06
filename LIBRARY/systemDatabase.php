<?php

  ////////////////
 //  Database  //
////////////////

function systemDatabase()
{

	$dbMainHost = "db142c.pair.com";
	$dbMainUser = "reinfurt_31";
	$dbMainPass = "e6cnWGr7";
	$dbMainDbse = "reinfurt_servinglibrary";

	$dbConnect = MYSQL_CONNECT($dbMainHost, $dbMainUser, $dbMainPass);
	MYSQL_SELECT_DB($dbMainDbse, $dbConnect);
}
systemDatabase();
?>