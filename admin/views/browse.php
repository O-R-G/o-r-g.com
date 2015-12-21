<?
use \Michelf\Markdown;

$children = $oo->children($uu->id);
?>
<div id="body-container" class="flex-max">
	<div id="body" class="centre">
		<div id="object"><?
			if($name)
			{
			?><div id="object-name"><? echo $name; ?></div>
			<div id="object-actions"><?
				?><a class="button" href="<? echo $admin_path."edit/".$uu->urls(); ?>">EDIT... </a><?
				?><a class="button" href="<? echo $admin_path."delete/".$uu->urls(); ?>">DELETE... </a>
			</div><?
			}
			?>
		</div>
		<div id="children"><?
		$num_children = count($children);
		$pad = floor(log10($num_children)) + 1;
		if($pad < 2)
			$pad = 2;
		for($i = 0; $i < count($children); $i++)
		{
			$c = $children[$i];
			$j = $i + 1;
			$j_pad = str_pad($j, $pad, "0", STR_PAD_LEFT);
			$url = $admin_path."browse/";
			if($uu->urls())
				$url.= $uu->urls()."/";
			$url.= $c["url"];
			?><div class="child">
				<span><? echo $j_pad; ?></span><a href="<? echo $url; ?>"><? echo $c["name1"]; ?></a>
			</div><?
		}
	?></div>	
	</div>
	<div id="object-actions"><?
		?><a class="button" href="<? echo $admin_path."add/".$uu->urls(); ?>">ADD OBJECT... </a><?
		?><a class="button" href="<? echo $admin_path."link/".$uu->urls(); ?>">LINK... </a>
	</div>
</div>