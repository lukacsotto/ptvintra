<div id="loading"></div>
<?php

// elérési út config !!! ez minden esetben a meghajtó betűjellel kezdődik és egy / jellel zárul !!!

$promp = 'S:/';

// súgófájl írás

$sql = $MySqliLink->query("SELECT `production`, `date`, `hi_text`, `bye_text` FROM `oi_program` WHERE `id`='".$url_pieces[2]."' LIMIT 1");

while($data = $sql->fetch_array()) {
	$production = $data['production'];
	$date = $data['date'];
	$hi_text = $data['hi_text'];
	$bye_text = $data['bye_text'];
	}

$main_file_name = date("Ymd", strtotime($date)).'_'.$production;

system('net use S: "\\\\sugo\sugo" kukorica /user:Administrator /persistent:no>nul 2>&1');

$myfile = fopen($promp.$main_file_name.'.txt', "w");
$txt = $hi_text."\n\n\n\n\n";

$sql = $MySqliLink->query("SELECT `type`, `lead` FROM `oi_content` WHERE `production`='".$production."' AND `date`='".$date."' ORDER BY `position`");
while($data = $sql->fetch_array()) {
	switch ($data['type']) {
		case "anyag":
			$tipus = 'ANYAG: ';
			break;
		case "dsz":
			$tipus = 'DSZ: ';
			break;
		default:
			$tipus = '';
	}
	$txt = $txt.$tipus.$data['lead']."\n\n\n\n\n";
}

$txt = $txt.$bye_text."\n\n\n\n\n\n\n";
fwrite($myfile, $txt);
fclose($myfile);

?>
<meta http-equiv="refresh" content="1;url=production/edit/<?php echo $production; ?>/?successfully=toprompter">