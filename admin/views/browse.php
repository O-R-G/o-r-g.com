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
		foreach($children as $c)
		{
			$url = $admin_path."browse/".$uu->urls().$c["url"];
			?><div class="child">
				<a href="<? echo $url; ?>"><? echo $c["name1"]; ?></a>
			</div><?
		}
	?></div>	
	</div>
	<div id="object-actions"><?
		?><a class="button" href="<? echo $admin_path."add/".$uu->urls(); ?>">ADD... </a><?
		?><a class="button" href="<? echo $admin_path."link/".$uu->urls(); ?>">LINK... </a>
	</div>
</div>