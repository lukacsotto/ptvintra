<div id="loading"></div>
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

$SelectStr = "SELECT `production`, `date` FROM `oi_program` WHERE `id`='".$url_pieces[2]."' LIMIT 1";
$result = mysqli_query($MySqliLink,$SelectStr) OR die(" MySqli hiba (" .mysqli_errno($MySqliLink)."):". mysqli_error($MySqliLink));
while($row = mysqli_fetch_array($result))
  {
  $production_from_program = $row['production'];
  $date_from_program = $row['date'];
  }
  
$x = 0;
$sql = $MySqliLink->query("SELECT `position` FROM `oi_content` WHERE `production`='".$production_from_program."' AND `date`='".$date_from_program."'");
while($data = $sql->fetch_array()) {
	if ($data['position'] > $x) { $x = $data['position']; }
	}

if (isset($_POST['id'])) {

$darab = 0;
foreach ($_POST['id'] as $id) {
	$darab++;
}

$x = $x + $darab;

foreach ($_POST['id'] as $id) {
	$repeatloop = true;
	while($repeatloop) {
	$new_id = newId();
	$sql = $MySqliLink->query("SELECT `id` FROM `oi_content` WHERE `id`='".$new_id."' LIMIT 1");
	if (mysqli_num_rows($sql)==0) { $repeatloop = false; }
	}
	
	$sql_write = $MySqliLink->query("INSERT INTO `oi_content` (`id`, `position`, `production`, `type`, `date`, `old_date`, `name`, `title`, `headline_selector`, `headline`, `lead`, `interviewee`, `riporter`, `camera`, `editor`, `weather_temp_de0`, `weather_temp_de1`, `weather_temp_du0`, `weather_temp_du1`, `weather_img_de`, `weather_img_du`) SELECT '".$new_id."', '".$x."', '".$production_from_program."', `type`, '".$date_from_program."', `date`, `name`, `title`, 'nem', `headline`, `lead`, `interviewee`, `riporter`, `camera`, `editor`, `weather_temp_de0`, `weather_temp_de1`, `weather_temp_du0`, `weather_temp_du1`, `weather_img_de`, `weather_img_du` FROM `oi_content` WHERE `id`='".$id."'");
	
	$x--;
}

}

?>
<meta http-equiv="refresh" content="1;url=program/edit/<?php echo $url_pieces[2]; ?>">