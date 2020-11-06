<?php

$iv_string = "";
$v = 0;
    while ($v < 30){
	  $w = 'iv_'.$v;
      $iv_string .= $_POST[$w].'%';
      $v = $v + 1; 
    }

$sql_write = $MySqliLink->query("UPDATE `oi_content` SET `name`='".$_POST["name"]."', `title`='".$_POST["title"]."', `headline_selector`='".$_POST["headline_selector"]."', `headline`='".$_POST["headline"]."', `lead`='".$_POST["lead"]."', `interviewee`='".$iv_string."', `riporter`='".$_POST["riporter"]."', `camera`='".$_POST["camera"]."', `editor`='".$_POST["editor"]."', `weather_temp_de0`='".$_POST["weather_temp_de0"]."', `weather_temp_de1`='".$_POST["weather_temp_de1"]."', `weather_temp_du0`='".$_POST["weather_temp_du0"]."', `weather_temp_du1`='".$_POST["weather_temp_du1"]."', `weather_img_de`='".$_POST["weather_img_de"]."', `weather_img_du`='".$_POST["weather_img_du"]."' WHERE `id`='".$url_pieces[2]."'");

$sql = $MySqliLink->query("SELECT `production`, `date` FROM `oi_content` WHERE `id`='".$url_pieces[2]."' LIMIT 1");

while($data = $sql->fetch_array()) {
	$production = $data['production'];
	$date = $data['date'];
	}

$sql = $MySqliLink->query("SELECT `id` FROM `oi_program` WHERE `production`='".$production."' AND `date`='".$date."' LIMIT 1");

while($data = $sql->fetch_array()) {
	$id_from_program = $data['id'];
	}

?>
<meta http-equiv="refresh" content="1;url=program/edit/<?php echo $id_from_program; ?>">
<div id="loading"></div>