<?php

$sql = $MySqliLink->query("SELECT `production`, `date`, `hi_text`, `bye_text` FROM `oi_program` WHERE `id`='".$url_pieces[2]."' LIMIT 1");
while($data = $sql->fetch_array()) {
	$production = $data['production'];
	$date = $data['date'];
	$hi_text = $data['hi_text'];
	$bye_text = $data['bye_text'];
	}

$sql = $MySqliLink->query("SELECT `name` FROM `oi_production` WHERE `id`='".$production."' LIMIT 1");
while($data = $sql->fetch_array()) {
	$name_from_production = $data['name'];
	}
	
$sql = $MySqliLink->query("SELECT `director` FROM `oi_program` WHERE `id`='".$url_pieces[2]."' LIMIT 1");
while($data = $sql->fetch_array()) {
		$name_sql = $MySqliLink->query("SELECT `name` FROM `oi_user` WHERE `id`='".$data['director']."' LIMIT 1");
		while($name_data = $name_sql->fetch_array()) {
		$director = $name_data['name'];
		}
	}

$sql = $MySqliLink->query("SELECT `anchorman` FROM `oi_program` WHERE `id`='".$url_pieces[2]."' LIMIT 1");
while($data = $sql->fetch_array()) {
		$name_sql = $MySqliLink->query("SELECT `name` FROM `oi_user` WHERE `id`='".$data['anchorman']."' LIMIT 1");
		while($name_data = $name_sql->fetch_array()) {
		$anchorman = $name_data['name'];
		}
	}
	
$sql = $MySqliLink->query("SELECT `composer` FROM `oi_program` WHERE `id`='".$url_pieces[2]."' LIMIT 1");
while($data = $sql->fetch_array()) {
		$name_sql = $MySqliLink->query("SELECT `name` FROM `oi_user` WHERE `id`='".$data['composer']."' LIMIT 1");
		while($name_data = $name_sql->fetch_array()) {
		$composer = $name_data['name'];
		}
	}

?>
<h1><?php echo $name_from_production; ?>&nbsp;forgatókönyv</h1>
<body style="font-size:17px; background-color:white;" onload="window.print()">
<span><b><?php echo date("Y.m.d", strtotime($date)); ?></b>&nbsp;&nbsp;|&nbsp;&nbsp;<b>Szerkesztő:</b>&nbsp;<?php echo $director; ?>&nbsp;&nbsp;|&nbsp;&nbsp;<b>Műsorvezető:</b>&nbsp;<?php echo $anchorman; ?>&nbsp;&nbsp;|&nbsp;&nbsp;<b>Vágó:</b>&nbsp;<?php echo $composer; ?></span><br><br><br>
<?php

$sql = $MySqliLink->query("SELECT `headline` FROM `oi_content` WHERE `production`='".$production."' AND `date`='".$date."' AND `headline_selector`='igen' ORDER BY `position`");
while($data = $sql->fetch_array()) {
	echo $data['headline'].'<br>';
}

?>
<hr style="height:2px;border-width:0;color:gray;background-color:gray !important;-webkit-print-color-adjust:exact;">
<div style="margin-top:100px;"><?php echo $hi_text; ?></div><br>
<table style="width:100%;">
<?php

$sql = $MySqliLink->query("SELECT `type`, `name`, `headline_selector`, `riporter`, `lead` FROM `oi_content` WHERE `production`='".$production."' AND `date`='".$date."' ORDER BY `position`");
while($data = $sql->fetch_array()) {
	if ($data['headline_selector'] == 'igen') { $headline_selector = 'headline-os hír'; } else { $headline_selector = ''; }
	$name_sql = $MySqliLink->query("SELECT `name` FROM `oi_user` WHERE `id`='".$data['riporter']."' LIMIT 1");
		while($name_data = $name_sql->fetch_array()) {
		$riporter = $name_data['name'];
		}
	$highlighted = 'white';
	if ($data['type'] == 'anyag' or $data['type'] == 'dsz') { $highlighted = 'darkseagreen'; }
	echo '<tr style="background-color:'.$highlighted.' !important; -webkit-print-color-adjust:exact;">
			<th style="padding:10px 10px 0px 10px;">'.$data['name'].'</th>
			<th style="padding:10px 10px 0px 10px;">'.$headline_selector.'</th>
			<th style="padding:10px 10px 0px 10px;">'.$riporter.'</th>
		</tr>
		<tr style="background-color:'.$highlighted.' !important; -webkit-print-color-adjust:exact;">
			<td colspan="3" style="padding:10px;">'.$data['lead'].'</td>
		</tr>';
}

?>
</table><br>
<div><?php echo $bye_text; ?></div><br>
</body>