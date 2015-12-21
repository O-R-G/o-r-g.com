<?
use \Michelf\Markdown;

$ancestors = $oo->ancestors($uu->id);
$children = $oo->children($uu->id);
$num_children = count($children);
?>
<div id="body-container" class="flex-max">
	<div id="body" class="centre"><?
		
		// ancestors
		$a_url = $admin_path."browse/";
		foreach($ancestors as $a)
		{
			$ancestor = $oo->get($a);
			$a_url.= $ancestor["url"];
		?><div class="ancestor"><a href="<? echo $a_url; ?>"><? echo $ancestor["name1"]; ?></a></div><?
		}
		
		// self
		if($uu->id)
		{
		?><div id="object"><?
			if($name)
			{
			?><div id="object-name"><? echo $name; ?></div>
			<div>
				<a class="button" href="<? echo $admin_path."edit/".$uu->urls(); ?>">EDIT... </a>
				<a class="button" href="<? echo $admin_path."delete/".$uu->urls(); ?>">DELETE... </a>
			</div><?
			}
			?>
		</div><?
		}
		
		// children
		if($num_children)
		{
		?><div id="children"><?
		$pad = floor(log10($num_children)) + 1;
		if($pad < 2)
			$pad = 2;
			for($i = 0; $i < $num_children; $i++)
			{
				$c = $children[$i];
				$j = $i + 1;
				$j_pad = str_pad($j, $pad, "0", STR_PAD_LEFT);
				
				// this is to avoid adding an extra slash
				// in child urls of the root object
				$url = $admin_path."browse/";
				if($uu->urls())
					$url.= $uu->urls()."/";
				$url.= $c["url"];
				
			?><div class="child">
				<span><? echo $j_pad; ?></span><a href="<? echo $url; ?>"><? echo $c["name1"]; ?></a>
			</div><?
			}
		?></div><?
		}
		
		// actions	
		?><div id="object-actions">
			<a class="button" href="<? echo $admin_path."add/".$uu->urls(); ?>">ADD OBJECT... </a>
			<a class="button" href="<? echo $admin_path."link/".$uu->urls(); ?>">LINK... </a>
		</div>
	</div>
</div>