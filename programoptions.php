<?php

if ($url_pieces[2] == 'emptyform') {
	
	$production = $_GET["production"];
	$date = date("Y-m-d");
	
	$sql = $MySqliLink->query("SELECT `hi_text`, `bye_text`, `director`, `anchorman`, `composer` FROM `oi_production` WHERE `id`='".$production."' LIMIT 1");

	while($data = $sql->fetch_array()) {
		$hi_text = $data['hi_text'];
		$bye_text = $data['bye_text'];
		$director = $data['director'];
		$anchorman = $data['anchorman'];
		$composer = $data['composer'];
	}
	
} else {

$sql = $MySqliLink->query("SELECT `production`, `date`, `hi_text`, `bye_text`, `director`, `anchorman`, `composer` FROM `oi_program` WHERE `id`='".$url_pieces[2]."' LIMIT 1");

while($data = $sql->fetch_array()) {
	$production = $data['production'];
	$date = $data['date'];
	$hi_text = $data['hi_text'];
	$bye_text = $data['bye_text'];
	$director = $data['director'];
	$anchorman = $data['anchorman'];
	$composer = $data['composer'];
	}

}

$existingcontent_ondate = false;
$sql = $MySqliLink->query("SELECT `date` FROM `oi_content` WHERE `production`='".$production."'");
while($data = $sql->fetch_array()) {
	if ($data['date'] == $date) { $existingcontent_ondate = true; }
	}

$sql = $MySqliLink->query("SELECT `name` FROM `oi_production` WHERE `id`='".$production."' LIMIT 1");
while($data = $sql->fetch_array()) {
	$name_from_production = $data['name'];
	}

$date_displayed = date("Y.m.d.", strtotime($date));

?>
<div class="doboz_0">
<span class="lapcim"><?php if ($url_pieces[2] == 'emptyform') { echo 'Új '.$name_from_production; } else { echo $name_from_production.' adatai: '.$date_displayed; } ?></span><br><hr style="margin-top:0;">
<form action="program/<?php if ($url_pieces[2] == 'emptyform') { echo 'create/?production='.$production; } else { echo 'save/'.$url_pieces[2].'/?previousdate='.$date; } ?>" method="post">
  <a class="mainbutton" style="background-color:#35b3db; background:linear-gradient(to bottom, #35b3db 5%, #25a8d1 100%); box-shadow:inset 0px 1px 0px 0px #25a8d1; text-shadow:0px 1px 0px #25a8d1;" href="production/edit/<?php echo $production; ?>">Mégsem</a>
  <input class="mainbutton" style="background-color:#30d89b; background:linear-gradient(to bottom, #30d89b 5%, #2dad7f 100%); box-shadow:inset 0px 1px 0px 0px #2dad7f; text-shadow:0px 1px 0px #2dad7f;" type="submit" value="Mentés"><br><br><br>
  <label for="date">&#9776;&nbsp;&nbsp;&nbsp;Dátum</label><br>
  <?php if (isset($_GET["errorcode"])) { 
  if ($_GET["errorcode"] == "1") { echo '<span style="color:red; display:inline-block; margin:10px 0 10px 0;">Már létezett adástükör a megadott dátummal ebben a műsorban. Ezért a tükör a legfrissebb, még ki nem osztott dátummal jött létre:</span><br>'; } 
  if ($_GET["errorcode"] == "2") { echo '<span style="color:red; display:inline-block; margin:10px 0 10px 0;">Olyan dátumra változtatnád meg a napot, amivel már létezik adástükör ebben a műsorban.</span><br>'; } 
  } ?>
  <input type="date" id="date" name="date" style="margin:8px 0; width:30%;" value="<?php echo $date; ?>" <?php if ($existingcontent_ondate == true and $url_pieces[2] != 'emptyform') { echo 'readonly'; } ?>><br><hr style="margin-bottom:30px;">
  <label for="director">&#9776;&nbsp;&nbsp;&nbsp;Szerkesztő&nbsp;&nbsp;</label>
  <select id="director" name="director" style="width:20%;">
    <?php
	$sql = $MySqliLink->query("SELECT `id`, `name` FROM `oi_user` WHERE `type` LIKE '%director%' ORDER BY `name`");
	while($data = $sql->fetch_array()) {
	$actual_director = "";
	if ($data['id'] == $director) { $actual_director = "selected"; }
	echo '<option value="'.$data['id'].'" '.$actual_director.'>'.$data['name'].'</option>';
	}
	?>
  </select>
  <label for="anchorman" style="margin-left:15px;">&#9776;&nbsp;&nbsp;&nbsp;Műsorvezető&nbsp;&nbsp;</label>
  <select id="anchorman" name="anchorman" style="width:20%;">
    <?php
	$sql = $MySqliLink->query("SELECT `id`, `name` FROM `oi_user` WHERE `type` LIKE '%anchorman%' ORDER BY `name`");
	while($data = $sql->fetch_array()) {
	$actual_anchorman = "";
	if ($data['id'] == $anchorman) { $actual_anchorman = "selected"; }
	echo '<option value="'.$data['id'].'" '.$actual_anchorman.'>'.$data['name'].'</option>';
	}
	?>
  </select>
  <label for="composer" style="margin-left:15px;">&#9776;&nbsp;&nbsp;&nbsp;Összeállító&nbsp;&nbsp;</label>
  <select id="composer" name="composer" style="width:20%;">
    <?php
	$sql = $MySqliLink->query("SELECT `id`, `name` FROM `oi_user` WHERE `type` LIKE '%composer%' ORDER BY `name`");
	while($data = $sql->fetch_array()) {
	$actual_composer = "";
	if ($data['id'] == $composer) { $actual_composer = "selected"; }
	echo '<option value="'.$data['id'].'" '.$actual_composer.'>'.$data['name'].'</option>';
	}
	?>
  </select><br><hr style="margin-top:30px;">
  <label for="hi_text">&#9776;&nbsp;&nbsp;&nbsp;Beköszönés szövege</label>
  <textarea id="hi_text" name="hi_text" rows="4" style="margin:8px 0;"><?php echo $hi_text; ?></textarea><br>
  <label for="bye_text">&#9776;&nbsp;&nbsp;&nbsp;Elköszönés szövege</label>
  <textarea id="bye_text" name="bye_text" rows="4" style="margin:8px 0;"><?php echo $bye_text; ?></textarea><br><br><br><br>
  <a class="mainbutton" style="background-color:#35b3db; background:linear-gradient(to bottom, #35b3db 5%, #25a8d1 100%); box-shadow:inset 0px 1px 0px 0px #25a8d1; text-shadow:0px 1px 0px #25a8d1;" href="production/edit/<?php echo $production; ?>">Mégsem</a>
  <input class="mainbutton" style="background-color:#30d89b; background:linear-gradient(to bottom, #30d89b 5%, #2dad7f 100%); box-shadow:inset 0px 1px 0px 0px #2dad7f; text-shadow:0px 1px 0px #2dad7f;" type="submit" value="Mentés"><br><br><br>
</form>
</div>