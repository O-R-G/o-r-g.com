<?
use \Michelf\Markdown;
?>
<div id="body-container" class="flex-max">
	<div id="body" class="centre">
		<div id="object-name"><? echo $name; ?></div>
		<div class="button-container"><?
			if($item)
			{
			?><a class="button" href="<? echo $admin_path."edit/".$uu->urls(); ?>">EDIT... </a><?
			?><a class="button" href="<? echo $admin_path."delete/".$uu->urls(); ?>">DELETE... </a><?
			}
			?><a class="button" href="<? echo $admin_path."add/".$uu->urls(); ?>">ADD... </a><?
			?><a class="button" href="<? echo $admin_path."link/".$uu->urls(); ?>">LINK... </a>
		</div><?
		// object contents
		if($item)
		{
			$keys = array_keys($item);
			foreach($keys as $k)
			{
				if($item[$k])
				{
				?><div class="field">
					<div class="field-name"><? echo $k; ?></div>
					<div class="field-value"><? echo Markdown::defaultTransform($item[$k]); ?></div>
				</div><?
				}
			}
			$media_ids = $oo->media_ids($uu->id);
			foreach($media_ids as $m_id)
			{
				$m = $mm->get($m_id);
				$m_url = m_url($m);
				?><div class="field">
					<div class="field-name"><? echo end(explode("/", $m_url)); ?></div>
					<div class='preview'>
						<img src="<? echo $m_url; ?>">
					</div>
					<div class='caption'><? echo $m['caption']; ?></div>
				</div><?
			}
		}
	?></div>
</div>