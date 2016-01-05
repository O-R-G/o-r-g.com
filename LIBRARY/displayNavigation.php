<?php



  //////////////////
 //  Navigation  //
//////////////////

function displayNavigation( $path = "0", $limit = null, $selection = null, $pageName = "main",  $moremenuLimit = null, $moremenuCounter = null, $moremenu = null, $stub = FALSE ) {


	//  Handle recursion 

	$limitNext = ($limit === null) ? null : $limit - 1;
	$obj   = explode(",", $path);
	$depth = count($obj) - 1;
	$first = $obj[1];
	$final = $obj[$depth];

	$target = null;	
	for ($i = 1; $i < count($obj); $i++) {

		if ($i > 1) $target .= ",";
		$target .= $obj[$i];
	}
	if (!$target) $target = $path;
	

	// Check for selection

	$selected = false;
	$selects  = explode(",", $selection);
	for ($i = 0; $i < count($selects); $i++) {

		if ($selection && $selects[$i] == $final) $selected = true;
	}


	//  Pull from current node

	$sql = "
		SELECT * FROM objects 
		WHERE id = '$final' 
		AND active = 1 
		LIMIT 1
		";
	$res = MYSQL_QUERY($sql);
	$row = MYSQL_FETCH_ARRAY($res);

	$name = nl2br($row["name1"]);
	$rank = nl2br($row["rank"]);
	$deck = nl2br($row["deck"]);
	$body = nl2br($row["body"]);
	$bodyParts = explode("|", $body);
	
	
	//  Check if $obj is a root
	
	if ($final == 0) $name = "";
	if ( substr($name, 0, 1) == "+" ) $name = ""; 
	
	
	//  Display current node
		
	if ( (substr($name, 0, 1) != "." && substr($name, 0, 1) != "_") && ( $moremenuCounter <= $moremenuLimit || $moremenu ) ) {
	
		$html  = "\n<li class='list";
		$html .= ($selected || $final == 0) ? "Active" : "Static";
		$html .= "'>";
		$html .= "<a href='";

		// Check if URL and whether full or partial
				
		$checkURL = substr($row["url"], -1); 
		$hasFullURL = FALSE;
		if ( 	($checkURL == '0') || 
				($checkURL == '1') || 
				($checkURL == '2') || 						
				($checkURL == '3') || 
				($checkURL == '4') || 
				($checkURL == '5') || 
				($checkURL == '6') || 
				($checkURL == '7') || 
				($checkURL == '8') || 
				($checkURL == '9') )
				$hasFullURL = TRUE;
				// echo $hasFullURL;
				
		if ($row['url']) { 
		
			if ( $hasFullURL ) {
			
				$html .= $row['url'];
				
			} else {
			
				$html .=  $row['url'] .".html?id=". $row["objectsId"];
			}
						
		} else {
		
			if ($selected) {
			
				$html .= "main.html";			
			} else {
			
				$html .= $pageName . ".html?id=$target";			
			}
		}

		$html .= "' style='display: block; padding-left: ". ($depth * 50) ."px;'>";
		if ($body) $html .= $rank . "—";	
		$html .= $name;	
		$html .= "</a></li>";
		echo $html;
	
	
		//  Find children of current node
	
		if ( (($limit > 0 || $limit === null) || $selected) && !$stub ) {
	
			$sql = "
				SELECT objects.id AS objectsId FROM wires, objects 
				WHERE wires.fromid = '$final' AND wires.toid = objects.id 
				AND wires.active = 1 AND objects.active = 1 
				ORDER BY objects.rank, end DESC, begin DESC, name1, name2, objects.modified DESC, objects.created DESC
				";
			$res = MYSQL_QUERY($sql);
			while ($row = MYSQL_FETCH_ARRAY($res)) {	

				$moremenuCounter++;	
				$tmp = $path .",". $row["objectsId"];
				$limitTemp = ($selected) ? $limit : $limitNext;
				displayNavigation($tmp, $limitTemp, $selection, $pageName, $moremenuLimit, $moremenuCounter, $moremenu);
			}
		}
	} else { 
		if ( ( $moremenuCounter >= $moremenuLimit ) && ( !$moremenu ) ) {

			$html .= "\n		<li class='listActive'><a href='". $pageName .".html?id=". $selection ."&moremenu=1' style='display: block;'>More . . .</a></li>";
			echo $html;
			exit;
		}
	}
}



?>