<?
$md = __DIR__."/../../LIBRARY/php-md-lib/Michelf/Markdown.inc.php";
require_once($md);
use \Michelf\Markdown;
?>
<div id="body-container" class="flex-max">
	<div id="body" class="centre">
		<div><? echo $name; ?></div>
		<div class="button-container"><?
			if($item)
			{
			?><a class="button" href="<? echo $admin_path."edit/".$uu->urls(); ?>">edit</a><?
			?><a class="button" href="<? echo $admin_path."delete/".$uu->urls(); ?>">delete</a><?
			}
			?><a class="button" href="<? echo $admin_path."add/".$uu->urls(); ?>">add</a><?
			?><a class="button" href="<? echo $admin_path."link/".$uu->urls(); ?>">link</a>
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
					<div><? echo Markdown::defaultTransform($item[$k]); ?></div>
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