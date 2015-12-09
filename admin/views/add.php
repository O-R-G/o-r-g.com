<?
$b_url = $admin_path.'browse/'.$uu->urls();
$vars = array("name1", "deck", "body", "notes", "begin", "end", "url", "rank");
$kvars = array();
$kvars["name1"] = "text";
$kvars["deck"] = "textarea";
$kvars["body"] = "textarea";
$kvars["notes"] = "textarea";
$kvars["begin"] = "datetime-local";
$kvars["end"] = "datetime-local";
$kvars["url"] = "text";
$kvars["rank"] = "number";

$f = array();
$dt_fmt = "Y-m-d H:i:s";
?><div id="body-container">
	<div id="body" class="centre"><?
		// show form
		if($rr->submit != "add") 
		{
			$form_url = $admin_path."add";
			if($uu->urls())
				$form_url.="/".$uu->urls();
		?><div class="self-container">
			<div class="self">You are adding a new object.</div>
		</div>
		<div id="form-container">
			<form 
				enctype="multipart/form-data" 
				action="<? echo $form_url; ?>" 
				method="post"
			>
				<div class="form"><?
				// object data
				foreach($vars as $var)
				{
					?><div class="field">
						<div class="field-name"><? echo $var; ?></div>
						<div><?
						if($kvars[$var] == "textarea")
						{
						?><textarea name='<? echo $var; ?>' class='large'></textarea><?
						}
						else
						{
						?><input 
							name='<? echo $var; ?>' 
							type='<? echo $kvars[$var]; ?>'
						><?
						}
						?></div>
					</div><?
				}
				//  upload new images
				for ($j = 0; $j < $max_uploads; $j++)
				{
					?><div class="field">
						<div class="field-name">image <? echo $j+1; ?></div>
						<div>
							<input type='file' name='uploads[]'>
							<textarea name="captions[]" class="caption"></textarea>
						</div>
					</div><?
				}
				?></div>
				<div class="button-container">
					<input 
						name='cancel' 
						value='cancel'
						type='button' 
						onClick="<? echo $js_back; ?>"
					>
					<input name='submit' value='add' type='submit'>
				</div>
			</form>
		</div><?
		}
		// process form
		else
		{
			// objects
			foreach($vars as $var)
				$f[$var] = addslashes($rr->$var);
			$siblings = $oo->children_ids($uu->id);
			$toid = insert_object($f, $siblings);
			if($toid)
			{
				// wires
				$ww->create_wire($uu->id, $toid);
				// media
				process_media($toid);

			?><div class="self-container">
				<div class="self">
					<p>record added successfully</p>
					<p><a href="<? echo $b_url; ?>">continue... </a></p>
				</div>
			</div><?
			}
			else
			{
			?><p>record not created, <a href="<? echo $js_back; ?>">try again</a></p><?
			}
		} 
	?></div>
</div>