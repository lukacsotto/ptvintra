<?php

$sql = $MySqliLink->query("SELECT `type`, `name`, `title`, `headline_selector`, `headline`, `lead`, `interviewee`, `riporter`, `camera`, `editor`, `production`, `date`, `weather_temp_de0`, `weather_temp_de1`, `weather_temp_du0`, `weather_temp_du1`, `weather_img_de`, `weather_img_du` FROM `oi_content` WHERE `id`='".$url_pieces[2]."' LIMIT 1");

while($data = $sql->fetch_array()) {
	$type = $data['type'];
	$name = $data['name'];
	$title = $data['title'];
	$headline_selector = $data['headline_selector'];
	$headline = $data['headline'];
	$lead = $data['lead'];
	$interviewee = $data['interviewee'];
	$riporter = $data['riporter'];
	$camera = $data['camera'];
	$editor = $data['editor'];
	$production = $data['production'];
	$date = $data['date'];
	$weather_temp_de0 = $data['weather_temp_de0'];
	$weather_temp_de1 = $data['weather_temp_de1'];
	$weather_temp_du0 = $data['weather_temp_du0'];
	$weather_temp_du1 = $data['weather_temp_du1'];
	$weather_img_de = $data['weather_img_de'];
	$weather_img_du = $data['weather_img_du'];
	}

if (isset($_GET["type"])) {
	switch ($_GET["type"]) {
		case "anyag":
			$type = 'anyag';
			break;
		case "dsz":
			$type = 'dsz';
			break;
		case "demo":
			$type = 'demo';
			break;
		case "weather":
			$type = 'weather';
			break;
		default:
			$type = $type;
	}
}
$iv_records = explode("%", $interviewee);

$sql = $MySqliLink->query("SELECT `id` FROM `oi_program` WHERE `production`='".$production."' AND `date`='".$date."' LIMIT 1");
while($data = $sql->fetch_array()) {
	$id_from_program = $data['id'];
	}
	
?>
<div class="doboz_0">
<span class="lapcim">Tartalom szerkesztése</span><br><hr style="margin-top:0;">
<form action="content/<?php if ($url_pieces[2] == 'emptyform') { echo 'create/?program='.$_GET["program"].'&type='.$_GET["type"]; } else { echo 'save/'.$url_pieces[2]; } ?>" method="post">
  <a class="mainbutton" style="background-color:#35b3db; background:linear-gradient(to bottom, #35b3db 5%, #25a8d1 100%); box-shadow:inset 0px 1px 0px 0px #25a8d1; text-shadow:0px 1px 0px #25a8d1;" href="program/edit/<?php if ($url_pieces[2] == 'emptyform') { echo $_GET["program"]; } else { echo $id_from_program; } ?>">Mégsem</a>
  <input class="mainbutton" style="background-color:#30d89b; background:linear-gradient(to bottom, #30d89b 5%, #2dad7f 100%); box-shadow:inset 0px 1px 0px 0px #2dad7f; text-shadow:0px 1px 0px #2dad7f;" type="submit" value="Mentés"><br><br><br>
  <div id ="hideifweather" style="<?php if ($type == 'weather') { echo 'display:none;'; } ?>">
  <label for="name">&#9776;&nbsp;&nbsp;&nbsp;Munkacím</label><br>
  <input type="text" id="name" name="name" value="<?php if ($type == 'weather') { echo 'Időjárás'; } else { echo $name; } ?>"><br>
  <label for="title">&#9776;&nbsp;&nbsp;&nbsp;Felirat</label><br>
  <input type="text" id="title" name="title" value="<?php echo $title; ?>"><br><hr>
  <label for="headline-selector">&#9776;&nbsp;&nbsp;&nbsp;Headline-os legyen?</label>
  <input type="radio" id="headline-selector-1" name="headline_selector" style="margin-left:30px;" value="igen" <?php if ($headline_selector == 'igen') { echo "checked"; } ?>>
  <label for="headline-selector-1">Igen</label>
  <input type="radio" id="headline-selector-0" name="headline_selector" style="margin-left:20px;" value="nem" <?php if ($headline_selector == 'nem') { echo "checked"; } ?>>
  <label for="headline-selector-0">Nem</label><br>
  <div id="headline-blokk" class="<?php if ($headline_selector == 'igen') { echo "show"; } else { echo "hide"; } ?>">
  <label for="headline">&#9776;&nbsp;&nbsp;&nbsp;Headline szövege</label><br>
  <input type="text" id="headline" name="headline" value="<?php echo $headline; ?>"><br>
  </div><br><hr style="margin-top:0.4rem;">
  </div>
  <label for="lead">&#9776;&nbsp;&nbsp;&nbsp;Felkonf</label>
  <textarea id="lead" name="lead" rows="8" style="margin:8px 0;"><?php echo $lead; ?></textarea><br><hr>
  <div id="showifweather" style="<?php if ($type != 'weather') { echo 'display:none;'; } ?>">
  <label for="weather_temp">&#9776;&nbsp;&nbsp;&nbsp;Délelőtti hőmérséklet</label><br>
  <input type="text" id="weather_temp_de0" name="weather_temp_de0" maxlength="2" size="2" style="width:10%;" value="<?php echo $weather_temp_de0; ?>">&nbsp;-&nbsp;<input type="text" id="weather_temp_de1" name="weather_temp_de1" maxlength="2" size="2" style="width:10%;" value="<?php echo $weather_temp_de1; ?>"><br>
  <label for="weather_img">&#9776;&nbsp;&nbsp;&nbsp;Délelőtti időjárás ábrája</label><br>
  <?php
  $x = 1;
  while ($x <= 11) {
  if ($weather_img_de == $x) { $checked_img = 'checked'; } else { $checked_img = ''; }
  echo '<label>
  <input type="radio" id="weather_img_de" name="weather_img_de" value="'.$x.'" '.$checked_img.'>
  <img src="elements/weather_img/'.$x.'.png">
  </label>&nbsp;';
  $x++;
  }
  ?>
  <br><hr>
  <label for="weather_temp">&#9776;&nbsp;&nbsp;&nbsp;Délutáni hőmérséklet</label><br>
  <input type="text" id="weather_temp_du0" name="weather_temp_du0" maxlength="2" size="2" style="width:10%;" value="<?php echo $weather_temp_du0; ?>">&nbsp;-&nbsp;<input type="text" id="weather_temp_du1" name="weather_temp_du1" maxlength="2" size="2" style="width:10%;" value="<?php echo $weather_temp_du1; ?>"><br>
  <label for="weather_img">&#9776;&nbsp;&nbsp;&nbsp;Délutáni időjárás ábrája</label><br>
  <?php
  $x = 1;
  while ($x <= 11) {
  if ($weather_img_du == $x) { $checked_img = 'checked'; } else { $checked_img = ''; }
  echo '<label>
  <input type="radio" id="weather_img_du" name="weather_img_du" value="'.$x.'" '.$checked_img.'>
  <img src="elements/weather_img/'.$x.'.png">
  </label>&nbsp;';
  $x++;
  }
  ?>
  </div>
  <div id ="hideifweather" style="<?php if ($type == 'weather') { echo 'display:none;'; } ?>">
  <label for="riporter">&#9776;&nbsp;&nbsp;&nbsp;Szerkesztő&nbsp;&nbsp;</label>
  <select id="riporter" name="riporter" style="width:22%;">
    <?php
	$sql = $MySqliLink->query("SELECT `id`, `name` FROM `oi_user` WHERE `type` LIKE '%riporter%' ORDER BY `name`");
	while($data = $sql->fetch_array()) {
	$actual_riporter = "";
	if ($data['id'] == $riporter) { $actual_riporter = "selected"; }
	echo '<option value="'.$data['id'].'" '.$actual_riporter.'>'.$data['name'].'</option>';
	}
	?>
  </select>
  <label for="camera" style="margin-left:40px;">&#9776;&nbsp;&nbsp;&nbsp;Operatőr&nbsp;&nbsp;</label>
  <select id="camera" name="camera" style="width:22%;">
    <?php
	$sql = $MySqliLink->query("SELECT `id`, `name` FROM `oi_user` WHERE `type` LIKE '%camera%' ORDER BY `name`");
	while($data = $sql->fetch_array()) {
	$actual_camera = "";
	if ($data['id'] == $camera) { $actual_camera = "selected"; }
	echo '<option value="'.$data['id'].'" '.$actual_camera.'>'.$data['name'].'</option>';
	}
	?>
  </select>
  <label for="editor" style="margin-left:40px;">&#9776;&nbsp;&nbsp;&nbsp;Vágó&nbsp;&nbsp;</label>
  <select id="editor" name="editor" style="width:22%;">
    <?php
	$sql = $MySqliLink->query("SELECT `id`, `name` FROM `oi_user` WHERE `type` LIKE '%editor%' ORDER BY `name`");
	while($data = $sql->fetch_array()) {
	$actual_editor = "";
	if ($data['id'] == $editor) { $actual_editor = "selected"; }
	echo '<option value="'.$data['id'].'" '.$actual_editor.'>'.$data['name'].'</option>';
	}
	?>
  </select><br>
  </div>
    <label style="<?php if ($type == 'demo' or $type == 'weather') { echo 'display:none;'; } ?> cursor:pointer;" id="open-interviewee">&#9776;&nbsp;&nbsp;&nbsp;Megszólaló(k)&nbsp;<span id="arrow-element">&#8628;</span></label><br>
  <div id="interviewee-blokk" class="hide">
  <?php
  switch ($type) {
    case "anyag":
        $mv = 30;
        break;
	case "dsz":
        $mv = 3;
        break;
	case "demo":
        $mv = 0;
        break;
	case "weather":
        $mv = 0;
        break;
	default:
	    $mv = 30;
	}
  $v = 0;
  $msz = 0;
    while ($v < 30){
	  if ($v >= $mv) { $iv_display = 'display:none;'; } else { $iv_display = ''; }
	  if ($v == 0 or $v == 3 or $v == 6 or $v == 9 or $v == 12 or $v == 15 or $v == 18 or $v == 21 or $v == 24 or $v == 27) { $msz = $msz + 1; echo '<span style="'.$iv_display.' font-style:italic;"><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$msz.'. megszólaló:<br></span>'; }
      echo '<input type="text" id="interviewee" name="iv_'.$v.'" style="'.$iv_display.' width:28%; margin:20px;" value="'.$iv_records[$v].'">';
	  $v = $v + 1;
    }
  ?>
  </div>
  <br><br><br>
  <a class="mainbutton" style="background-color:#35b3db; background:linear-gradient(to bottom, #35b3db 5%, #25a8d1 100%); box-shadow:inset 0px 1px 0px 0px #25a8d1; text-shadow:0px 1px 0px #25a8d1;" href="program/edit/<?php if ($url_pieces[2] == 'emptyform') { echo $_GET["program"]; } else { echo $id_from_program; } ?>">Mégsem</a>
  <input class="mainbutton" style="background-color:#30d89b; background:linear-gradient(to bottom, #30d89b 5%, #2dad7f 100%); box-shadow:inset 0px 1px 0px 0px #2dad7f; text-shadow:0px 1px 0px #2dad7f;" type="submit" value="Mentés"><br><br><br>
</form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
	$("#headline-selector-1").click(function(){
	$("#headline-blokk").removeClass("hide").addClass("show");
	});
	$("#headline-selector-0").click(function(){
	$("#headline-blokk").removeClass("show").addClass("hide");
	});
	$("#open-interviewee").click(function(){
	$("#interviewee-blokk").toggleClass("hide show");
	});
	$("#open-interviewee").click(function(){
	$("#arrow-element").toggleClass("arrow-flip");
	});
});
</script>