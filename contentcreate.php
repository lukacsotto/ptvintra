<?php

function newId($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$repeatloop = true;
while($repeatloop) {
$id = newId();
$sql = $MySqliLink->query("SELECT `id` FROM `oi_content` WHERE `id`='".$id."' LIMIT 1");
if (mysqli_num_rows($sql)==0) { $repeatloop = false; }
}

$sql = $MySqliLink->query("SELECT `production`, `date` FROM `oi_program` WHERE `id`='".$_GET["program"]."' LIMIT 1");
while($data = $sql->fetch_array()) {
	$production = $data['production'];
	$date = $data['date'];
	}

$top_position = 0;
$sql = $MySqliLink->query("SELECT `position` FROM `oi_content` WHERE `production`='".$production."' AND `date`='".$date."'");
while($data = $sql->fetch_array()) {
	if ($data['position'] > $top_position) { $top_position = $data['position']; }
	}
	
$position = $top_position+1;

$iv_string = "";
$v = 0;
    while ($v < 30){
	  $w = 'iv_'.$v;
      $iv_string .= $_POST[$w].'%';
      $v = $v + 1; 
    }

$sql_write = $MySqliLink->query("INSERT INTO `oi_content` (`id`, `position`, `production`, `type`, `date`, `old_date`, `name`, `title`, `headline_selector`, `headline`, `lead`, `interviewee`, `riporter`, `camera`, `editor`, `weather_temp_de0`, `weather_temp_de1`, `weather_temp_du0`, `weather_temp_du1`, `weather_img_de`, `weather_img_du`) VALUES ('".$id."', '".$position."', '".$production."', '".$_GET["type"]."', '".$date."', '".$date."', '".$_POST["name"]."', '".$_POST["title"]."', '".$_POST["headline_selector"]."', '".$_POST["headline"]."', '".$_POST["lead"]."', '".$iv_string."', '".$_POST["riporter"]."', '".$_POST["camera"]."', '".$_POST["editor"]."', '".$_POST["weather_temp_de0"]."', '".$_POST["weather_temp_de1"]."', '".$_POST["weather_temp_du0"]."', '".$_POST["weather_temp_du1"]."', '".$_POST["weather_img_de"]."', '".$_POST["weather_img_du"]."')");

?>
<meta http-equiv="refresh" content="1;url=program/edit/<?php echo $_GET["program"]; ?>">
<div id="loading"></div>