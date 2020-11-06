<?php

$sql = $MySqliLink->query("SELECT `production`, `date` FROM `oi_content` WHERE `id`='".$url_pieces[2]."' LIMIT 1");

while($data = $sql->fetch_array()) {
	$production = $data['production'];
	$date = $data['date'];
	}

$sql = $MySqliLink->query("SELECT `id` FROM `oi_program` WHERE `production`='".$production."' AND `date`='".$date."' LIMIT 1");

while($data = $sql->fetch_array()) {
	$id_from_program = $data['id'];
	}

$sql_delete = $MySqliLink->query("DELETE FROM `oi_content` WHERE `id`='".$url_pieces[2]."'");

?>
<meta http-equiv="refresh" content="1;url=program/edit/<?php echo $id_from_program; ?>">
<div id="loading"></div>