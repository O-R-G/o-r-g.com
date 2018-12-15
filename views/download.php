<?
        $licenseId = $_GET['key'];
        // $txId = $_GET['tx_id'];

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

					$path = '/out/' . md5($obj['name1'] . $obj['id']) . '/' . trim(ltrim(str_replace('*','', $obj['name1']), '.'));
	        $extension = pathinfo(glob('.' . $path . '.*')[0], PATHINFO_EXTENSION);
	        $download_link = '//' . $_SERVER['HTTP_HOST'] . $path . '.' . $extension;

				} else {
					$valid_key = false;
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
					<span style='color:#F00;'>Your copy of <?= $obj['name1'] ?> is now downloading . . . </span>
					<script>
						setTimeout(function() { location.href="<?= $download_link; ?>" }, 100)
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
