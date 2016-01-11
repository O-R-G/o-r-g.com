<?
// $browse_url = $admin_path."browse".$uu->urls();
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
		?><div class="self-container">
			<div class="self">
				<a href="<? echo $browse_url; ?>"><?php echo $name; ?></a>
			</div>
			<?
			if(!$name)
			{ 
				?>Please select a valid report to generate.<? 
			}
			else
			{
				$id = $item['id'];
				$sql = "SELECT * 
						FROM objects, wires 
						WHERE 
							objects.id=$id AND 
							wires.toid=objects.id AND 
							wires.fromid=1 AND 
							objects.active = (SELECT id FROM objects WHERE name1 LIKE '_Reports') AND 
							wires.active=1 
						LIMIT 1;";
				$res = $db->query($sql);
				if(!$res)
					throw new Exception($db->error);
				$row = $res->fetch_assoc();
			
				if($row)
				{
					$sql = $row['body'];
					$res = $db->query($sql);
					?>
					<div class="table-container">
						<div class="table">
						<div class="table-tr">
							<div class="table-th nowrap">NAME</div>
							<div class="table-th">ADDRESS</div>
							<div class="table-th">EMAIL</div>
							<div class="table-th nowrap">BEGIN / END</div>
						</div><?
					while($obj = $res->fetch_assoc())
					{
						$begin = strtotime($obj['begin']);
						$begin = date('Y M d', $begin); 
						$end = strtotime($obj['end']);
						$end = date('Y M d', $end);
						?><div class="table-tr">
							<div class="table-td"><? echo $obj['name1'].' '.$obj['name2']; ?></div>
							<div class="table-td"><? 
								echo $obj['address1']; ?><br><? 
								echo $obj['city'];
							?></div>
							<div class="table-td"><?
								echo $obj['email']; 
							?></div>
							<div class="table-td"><?
								echo $begin; ?><br><?
								echo $end; 
							?></div>
						</div><?
					}
					?></table>
					</div><?
				}
			}
			?>
		</div>
	</div>
</div>