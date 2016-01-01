<?
// have to use root file path because of something called
// fopen wrappers? 
// see 'notes' on this page: 
// http://php.net/manual/en/function.file-get-contents.php
$license_file = $admin_root."static/gnu.txt";
$license = file_get_contents($license_file);
?><div id="body-container">
	<div id="body" class="centre">
		<div class="self-container">
			<div class="self">Open Records Generator</div> 
			<div class="self">Version 2.9.5</div>
			<div>7 August 2014</div>
			<a href="http://www.o-r-g.com/" target="_blank">O R G inc.</a>
			<div>
				<textarea class="large"><? echo $license; ?></textarea>
			</div>
		</div>
	</div>
</div>