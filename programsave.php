<?php

$sql = $MySqliLink->query("SELECT `production` FROM `oi_program` WHERE `id`='".$url_pieces[2]."' LIMIT 1");

while($data = $sql->fetch_array()) {
	$production_from_program = $data['production'];
	}

$existingdate_onproduction = false;
$sql = $MySqliLink->query("SELECT `date` FROM `oi_program` WHERE `production`='".$production_from_program."'");
while($data = $sql->fetch_array()) {
	if ($data['date'] == $_POST["date"] and $_POST["date"] != $_GET["previousdate"]) { $existingdate_onproduction = true; }
	}

if ($existingdate_onproduction == true) 
	{ 
		
		$sql_write = $MySqliLink->query("UPDATE `oi_program` SET `director`='".$_POST["director"]."', `anchorman`='".$_POST["anchorman"]."', `composer`='".$_POST["composer"]."', `hi_text`='".$_POST["hi_text"]."', `bye_text`='".$_POST["bye_text"]."' WHERE `id`='".$url_pieces[2]."'");
		echo '<meta http-equiv="refresh" content="0;url=program/options/'.$url_pieces[2].'/?errorcode=2">';

	} else {

		$sql_write = $MySqliLink->query("UPDATE `oi_program` SET `date`='".$_POST["date"]."', `director`='".$_POST["director"]."', `anchorman`='".$_POST["anchorman"]."', `composer`='".$_POST["composer"]."', `hi_text`='".$_POST["hi_text"]."', `bye_text`='".$_POST["bye_text"]."' WHERE `id`='".$url_pieces[2]."'");
		echo '<meta http-equiv="refresh" content="1;url=production/edit/'.$production_from_program.'">';
		echo '<div id="loading"></div>';
		
			}

?>