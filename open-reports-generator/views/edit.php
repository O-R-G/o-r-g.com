<?
$browse_url = $admin_path.'browse/'.$uu->urls();

$vars = array(	"name1", "name2", 
				"address1", "city", "state", "zip", "country",
				"phone", "email",
				"begin", "end", "body", "notes");

$var_info = array();

$var_info["input-type"] = array();
$var_info["input-type"]["name1"] = "text";
$var_info["input-type"]["name2"] = "text";
$var_info["input-type"]["address1"] = "textarea";
$var_info["input-type"]["city"] = "text";
$var_info["input-type"]["state"] = "text";
$var_info["input-type"]["zip"] = "number";
$var_info["input-type"]["country"] = "text";
$var_info["input-type"]["phone"] = "text";
$var_info["input-type"]["email"] = "text";
$var_info["input-type"]["begin"] = "datetime-local";
$var_info["input-type"]["end"] = "datetime-local";
$var_info["input-type"]["body"] = "textarea";
$var_info["input-type"]["notes"] = "text";

$var_info["label"] = array();
$var_info["label"]["name1"] = "First Name";
$var_info["label"]["name2"] = "Last Name";
$var_info["label"]["address1"] = "Address";
$var_info["label"]["city"] = "City";
$var_info["label"]["state"] = "State";
$var_info["label"]["zip"] = "Zip";
$var_info["label"]["country"] = "Country";
$var_info["label"]["phone"] = "Phone";
$var_info["label"]["email"] = "Email";
$var_info["label"]["begin"] = "Begin";
$var_info["label"]["end"] = "End";
$var_info["label"]["body"] = "Notes";
$var_info["label"]["notes"] = "TXN ID";

?><div id="body-container">
	<div id="body"><?
	// TODO: this code is duplicated in 
	// + add.php 
	// + browse.php
	// + edit.php
	// + link.php
	// ancestors
	$a_url = $admin_path."browse";
	for($i = 0; $i < count($uu->ids)-1; $i++)
	{
		$a = $uu->ids[$i];
		$ancestor = $oo->get($a);
		$a_url.= "/".$ancestor["url"];
		?><div class="ancestor">
			<a href="<? echo $a_url; ?>"><? echo $ancestor["name1"]; ?></a>
		</div><?
	}
if ($rr->action != "update" && $uu->id)
{
	// get existing image data
	$medias = $oo->media($uu->id);
	$num_medias = count($medias);
	
	// add associations to media arrays:
	// $medias[$i]["file"] is url of media file
	// $medias[$i]["display"] is url of display file (diff for pdfs)
	// $medias[$i]["type"] is type of media (jpg, 
	for($i = 0; $i < $num_medias; $i++)
	{
		$m_padded = "".m_pad($medias[$i]['id']);
		$medias[$i]["file"] = $media_path . $m_padded . "." . $medias[$i]["type"];
		if ($medias[$i]["type"] == "pdf")
			$medias[$i]["display"] = $admin_path."media/pdf.png";
		else
			$medias[$i]["display"] = $medias[$i]["file"];
	}
// object contents
?><div id="form-container">
		<div class="self">
			<a href="<? echo $browse_url; ?>"><?php echo $name; ?></a>
		</div>
		<form
			method="post"
			enctype="multipart/form-data" 
			action="<?php echo htmlspecialchars($admin_path.'edit/'.$uu->urls()); ?>" 
		>
			<div class="form"><?php
				// show object data
				foreach($vars as $var)
				{
				?><div class="field"><?
					if($var_info["input-type"][$var] == "datetime-local")
					{
						// datetime-local requires a very specific format
						// eg: 2016-01-08T22:34:47
						// http://www.w3.org/TR/html-markup/datatypes.html#form.data.datetime-local
						$phpdate = strtotime($item[$var]);
						$mysqldate = date('Y-m-d\Th:m:s', $phpdate);
					?><span class="field-name"><? echo $var_info["label"][$var]; ?></span>
					<span>
						<input 
							name='<? echo $var; ?>' 
							type='<? echo $var_info["input-type"][$var]; ?>'
							value='<? echo $mysqldate; ?>'
						>
					</span><?
					}
					else
					{
					?><div class="field-name"><? echo $var_info["label"][$var]; ?></div>
					<div><?
						if($var_info["input-type"][$var] == "textarea")
						{
						?><textarea name='<? echo $var; ?>' class='medium'><?
							if($item[$var])
								echo $item[$var];
						?></textarea><?
						}
						else
						{
						?><input name='<? echo $var; ?>' 
								type='<? echo $var_info["input-type"][$var]; ?>'
								value='<? echo $item[$var]; ?>'><?
						}
					?></div><?
					}
				?></div><?
				}
				?><div class="button-container">
					<input
						type='hidden'
						name='action'
						value='update'
					>	
					<input 
						type='button' 
						name='cancel' 
						value='Cancel' 
						onClick="<? echo $js_back; ?>" 
					>
					<input 
						type='submit'
						name='submit'  
						value='Update Object'
					>
				</div>
			</div>
		</form>
	</div>
<?php
}
// THIS CODE NEEDS TO BE FACTORED OUT SO HARD
// basically the same as what is happening in add.php
else 
{	
	// objects
	foreach($vars as $var)
	{
		$$var = addslashes($rr->$var);
		$item[$var] = addslashes($item[$var]);
	}

	//  process variables
	if (!$name1) 
		$name1 = "untitled";
	$begin = ($begin) ? date("Y-m-d H:i:s", strToTime($begin)) : NULL;
	$end = ($end) ? date("Y-m-d H:i:s", strToTime($end)) : NULL;
	if(!$url)
		$url = slug($name1);
	
	// check that the desired URL is valid
	// URL is valid if it is not the same as any of its siblings
	// siblings are all the children of any of this object's direct
	// parents (object could be linked elsehwere -- any updated
	// URL cannot conflict with those siblings, either)
	$siblings = $oo->siblings($uu->id);
	$valid_url = true;
	foreach($siblings as $s_id)
	{
		$valid_url = ($url != $oo->get($s_id)["url"]);
		if(!$valid_url)
			break;
	}
	?><div class="self-container">
		<p><a href="<? echo $browse_url; ?>"><?php echo $name; ?></a></p><?
	if($valid_url)
	{
		// check for differences
		foreach($vars as $var)
		{
			if($item[$var] != $$var)
				$arr[$var] = $$var ? "'".$$var."'" : "null";
		}
	
		// update if modified
		$updated = false;
		if($arr)
		{
			$arr["modified"] = "'".date("Y-m-d H:i:s")."'";
			$updated = $oo->update($uu->id, $arr);
		}

		// Job well done?
		if($updated)
		{
		?><p>Record successfully updated.</p><?
		}
		else
		{
		?><p>Nothing was edited, therefore update not required.</p><?
		}
	}
	else
	{
		?><p>Record not updated, <a href="<? echo $js_back; ?>">try again</a>.</p><?
	}
	?></div><?
} 
?></div>
</div>