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
$sql = $MySqliLink->query("SELECT `id` FROM `oi_program` WHERE `id`='".$id."' LIMIT 1");
if (mysqli_num_rows($sql)==0) { $repeatloop = false; }
}

$existingdate_onproduction = false;
$sql = $MySqliLink->query("SELECT `date` FROM `oi_program` WHERE `production`='".$_GET["production"]."'");
while($data = $sql->fetch_array()) {
	if ($data['date'] == $_POST["date"]) { $existingdate_onproduction = true; }
	}

if ($existingdate_onproduction == true) 
	{ 

$sql = $MySqliLink->query("SELECT `date` FROM `oi_program` WHERE `production`='".$_GET["production"]."' ORDER BY `date` DESC LIMIT 1");
while($data = $sql->fetch_array()) {
	$lastday = $data['date'];
	}
		
$date = date('Y-m-d',strtotime($lastday . "+1 days"));
		
$sql_write = $MySqliLink->query("INSERT INTO `oi_program` (`id`, `production`, `date`, `hi_text`, `bye_text`, `director`, `anchorman`, `composer`) VALUES ('".$id."', '".$_GET["production"]."', '".$date."', '".$_POST["hi_text"]."', '".$_POST["bye_text"]."', '".$_POST["director"]."', '".$_POST["anchorman"]."', '".$_POST["composer"]."')");
echo '<meta http-equiv="refresh" content="0;url=program/options/'.$id.'/?errorcode=1">';

	} else {
	
$sql_write = $MySqliLink->query("INSERT INTO `oi_program` (`id`, `production`, `date`, `hi_text`, `bye_text`, `director`, `anchorman`, `composer`) VALUES ('".$id."', '".$_GET["production"]."', '".$_POST["date"]."', '".$_POST["hi_text"]."', '".$_POST["bye_text"]."', '".$_POST["director"]."', '".$_POST["anchorman"]."', '".$_POST["composer"]."')");
echo '<meta http-equiv="refresh" content="1;url=production/edit/'.$_GET["production"].'">';
echo '<div id="loading"></div>';
	
	}

?>