<?
        $name = $_GET['name'];
        $key = $_GET['key'];
	$licenseId = $key;
        // $txId = $_GET['tx_id'];

	// dev links
	// http://o-r-g.com/thx?name=A+%2ANew%2A+Program+for+Graphic+Design&key=833e9166990fdf78d11c6981b7ca4e85
	// http://o-r-g.com/thx?name=A+%2ANew%2A+Program+for+Graphic+Design+sample&key=833e9166990fdf78d11c6981b7ca4e85
	// http://o-r-g.com/thx?name=A+%2ANew%2A+Program+for+Graphic+Design&key=DEMONEW
	// http://o-r-g.com/thx?name=A+%2APre-%2A+Program+for+Graphic+Design&key=41bff5943154e9f2fcf6936406484d77
	// http://o-r-g.com/thx?name=A+%2APre-%2A+Program+for+Graphic+Design+sample&key=41bff5943154e9f2fcf6936406484d77
	// http://o-r-g.com/thx?name=A+%2APre-%2A+Program+for+Graphic+Design&key=DEMOPRE

	?><script>
	// if iOS, serve .epub not .dmg
	// feature detection not sniffing (more robust)
	function iOS() {
		return [
    		'iPad Simulator',
    		'iPhone Simulator',
    		'iPod Simulator',
    		'iPad',
    		'iPhone',
    		'iPod'
  		].includes(navigator.platform)
  		// iPad on iOS 13 detection
  		|| (navigator.userAgent.includes("Mac") && "ontouchend" in document)
	}
	var ios = iOS();
	console.log(ios);
	</script><?

	if (preg_match('/^[a-f0-9]{32}$/', $key)) {

		// download link

		// if $key valid md5 hash (32 alphanum digits) then paypal download
		// accessed from an email link sent in lib/paypalIPNemail 

                $path = '/out/' . $key . '/' . trim(ltrim(str_replace('*','', $name), '.'));	
                if (pathinfo(glob('.' . $path . '.*')[0], PATHINFO_EXTENSION) == "zip") $extension=".zip";
                $download_path = '//' . $_SERVER['HTTP_HOST'] . $path;	// minus extension

		$valid_key = true;
	
	} else {

		// download code 

		$is_download = true;
		$valid_key = true;
		
		$fields = array("*");
		$tables = array("objects");
		$where = array("objects.active = 1","objects.name1 = '$licenseId'");
		$order 	= array("objects.name1");
		$res = $oo->get_all($fields, $tables, $where, $order);

		if (sizeof($res) > 0) {
			$licenseEntryId = $res[0]['id'];
			$fields = array("*");
			$tables = array("objects");
			$where = array("objects.active = 1","objects.id IN (SELECT wires.fromid FROM wires WHERE wires.toid = $licenseEntryId AND wires.active = 1)");
			$order 	= array("objects.name1");
			$resLicense = $oo->get_all($fields, $tables, $where, $order);

			$licensesEntryId = $resLicense[0]['id'];
			$fields = array("*");
			$tables = array("objects");
			$where = array("objects.active = 1","objects.id IN (SELECT wires.fromid FROM wires WHERE wires.toid = $licensesEntryId AND wires.active = 1)");
			$order 	= array("objects.name1");
			$obj_arr = $oo->get_all($fields, $tables, $where, $order);

			$obj = $obj_arr[0];
			$name = $obj['name1'];

			# md5 hash
	                $key = md5($obj['name1'] . $obj['id']);
	                $path = '/out/' . $key . '/' . trim(ltrim(str_replace('*','', $name), '.'));	
	                if (pathinfo(glob('.' . $path . '.*')[0], PATHINFO_EXTENSION) == "zip") $extension=".zip";
                	$download_path = '//' . $_SERVER['HTTP_HOST'] . $path;	// minus extension

		} else {
			$valid_key = false;
		}
	}
?>

<section id="body" class="visible">
	<div id="breadcrumbs">
		<ul class="nav-level">
			<li><a href="http://o-r-g.com/">O-R-G</a></li>
			<ul class="nav-level">
				<span>Thx</span>
			</ul>
		</ul>
	</div>
	<div class="column-container-container">
		<div class="column-container">
			<p>
				<? if ($valid_key): ?>
					<span style='color:#F00;'>Your copy of <?= $name ?> is now downloading . . . </span>
					<script>
							
						extension="<?= $extension; ?>";
						if (!extension) {
							console.log('no extension specified');
							if (ios) {
								extension=".epub";
							} else {
								extension=".dmg";
							}
						}
						url="<?= $download_path; ?>" + extension;
						console.log(url);
						setTimeout(function() { location.href=url }, 100)
					</script>
				<? else: ?>
					<span style='color:#F00;'>Invalid key . . . </span>
				<? endif; ?>
				<br /><br />

				<a href='mailto:support@o-r-g.com'>Problems, questions, etc.?</a> Otherwise, please enjoy.
			</p>
		</div>
	</div>
</section>
