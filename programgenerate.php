<div id="loading"></div>
<?php

// elérési utak config !!! ezek minden esetben a meghajtó betűjellel kezdődnek és egy / jellel zárulnak !!!

$sql = $MySqliLink->query("SELECT `production`, `date` FROM `oi_program` WHERE `id`='".$url_pieces[2]."' LIMIT 1");

while($data = $sql->fetch_array()) {
	$production = $data['production'];
	$date = $data['date'];
	}

switch ($production) {
    case "hirado":
        $tmd = 'H:/template/pannon/hirado/uj_2019/hirado_project/';
		$tcd = 'H:/template/pannon/hirado/uj_2019/hirado_anyag/';
		$gen = 'H:/NYERS/';
        break;
	case "pannonkronika":
        $tmd = 'H:/template/pannon/pannon_kronika/project/';
		$tcd = 'H:/template/pannon/pannon_kronika/anyag/';
		$gen = 'H:/temp/pannonkronika/';
        break;
	case "keptar":
        $tmd = 'H:/template/pannon/keptar/project/';
		$tcd = 'H:/template/pannon/keptar/anyag/';
		$gen = 'H:/Keptar/';
        break;
	default:
	    $tmd = 'H:/template/pannon/hirado/uj_2019/hirado_project/';
		$tcd = 'H:/template/pannon/hirado/uj_2019/hirado_anyag/';
		$gen = 'H:/NYERS/';
	}

// project főkönyvtár és root fájlszerkezet írás

$main_directory_name = date("Ymd", strtotime($date)).'_'.$production;

system('net use H: "\\\\hiradoserver\h" kukorica /user:Administrator /persistent:no>nul 2>&1');
if (!file_exists($gen.$main_directory_name)) {
    mkdir($gen.$main_directory_name, 0777, true);
}

foreach(glob($tmd.'*') as $project_files) {
	if (!file_exists($gen.$main_directory_name.'/'.basename($project_files)) and substr($project_files, -4) != '.ezp') {
		copy($project_files, $gen.$main_directory_name.'/'.basename($project_files));
	}
	if (!file_exists($gen.$main_directory_name.'/'.$main_directory_name.'.ezp') and substr($project_files, -4) == '.ezp') { copy($project_files, $gen.$main_directory_name.'/'.$main_directory_name.'.ezp'); }
}

// datum.etl2

$napok = Array("VASÁRNAP", "HÉTFŐ", "KEDD", "SZERDA", "CSÜTÖRTÖK", "PÉNTEK", "SZOMBAT");

$date_displayed = date("Y.m.d.", strtotime($date)).' '.$napok[date("w", strtotime($date))];

copy($tmd.'datum.etl2', $gen.$main_directory_name.'/datum.etl2');
$file = $gen.$main_directory_name.'/datum.etl2';
$file_new_content = str_replace('#DT',$date_displayed,mb_convert_encoding(file_get_contents($file), 'UTF-8', 'UCS-2LE'));
$file_new_content = mb_convert_encoding($file_new_content, 'UCS-2LE', 'UTF-8');
file_put_contents($file,$file_new_content);

// headline.etl2

$sql = $MySqliLink->query("SELECT `title` FROM `oi_content` WHERE `production`='".$production."' AND `date`='".$date."' AND `headline_selector`='igen' ORDER BY `position`");

$i = 0;

while($data = $sql->fetch_array()) {
	$i++;
	copy($tmd.'headline_1.etl2', $gen.$main_directory_name.'/headline_'.$i.'.etl2');
	$file = $gen.$main_directory_name.'/headline_'.$i.'.etl2';
	$file_new_content = str_replace('#T',mb_strtoupper($data['title']),mb_convert_encoding(file_get_contents($file), 'UTF-8', 'UCS-2LE'));
	$file_new_content = mb_convert_encoding($file_new_content, 'UCS-2LE', 'UTF-8');
	file_put_contents($file,$file_new_content);
	}
	
// demo.etl2

$sql = $MySqliLink->query("SELECT `title` FROM `oi_content` WHERE `production`='".$production."' AND `date`='".$date."' AND `type`='demo' ORDER BY `position`");

$i = 0;

while($data = $sql->fetch_array()) {
	$i++;
	copy($tmd.'demo_1.etl2', $gen.$main_directory_name.'/demo_'.$i.'.etl2');
	$file = $gen.$main_directory_name.'/demo_'.$i.'.etl2';
	$file_new_content = str_replace('#ST',mb_strtoupper($data['title']),mb_convert_encoding(file_get_contents($file), 'UTF-8', 'UCS-2LE'));
	$file_new_content = mb_convert_encoding($file_new_content, 'UCS-2LE', 'UTF-8');
	file_put_contents($file,$file_new_content);
	}

// musorvezeto.etl2 + stab.etl2

$sql = $MySqliLink->query("SELECT `director` FROM `oi_program` WHERE `id`='".$url_pieces[2]."' LIMIT 1");
while($data = $sql->fetch_array()) {
	$director = $data['director'];
	}

$sql = $MySqliLink->query("SELECT `anchorman` FROM `oi_program` WHERE `id`='".$url_pieces[2]."' LIMIT 1");
while($data = $sql->fetch_array()) {
	$anchorman = $data['anchorman'];
	}
	
$sql = $MySqliLink->query("SELECT `composer` FROM `oi_program` WHERE `id`='".$url_pieces[2]."' LIMIT 1");
while($data = $sql->fetch_array()) {
	$composer = $data['composer'];
	}
	
$sql = $MySqliLink->query("SELECT `name` FROM `oi_user` WHERE `id`='".$director."' LIMIT 1");
while($data = $sql->fetch_array()) {
	$napi_szerkeszto = mb_strtoupper($data['name']);
	}

$sql = $MySqliLink->query("SELECT `name` FROM `oi_user` WHERE `id`='".$anchorman."' LIMIT 1");
while($data = $sql->fetch_array()) {
	$musorvezeto = mb_strtoupper($data['name']);
	}
	
$sql = $MySqliLink->query("SELECT `name` FROM `oi_user` WHERE `id`='".$composer."' LIMIT 1");
while($data = $sql->fetch_array()) {
	$osszeallito = mb_strtoupper($data['name']);
	}

copy($tmd.'musorvezeto.etl2', $gen.$main_directory_name.'/musorvezeto.etl2');
$file = $gen.$main_directory_name.'/musorvezeto.etl2';
$file_new_content = str_replace('#PU',$musorvezeto,mb_convert_encoding(file_get_contents($file), 'UTF-8', 'UCS-2LE'));
$file_new_content = mb_convert_encoding($file_new_content, 'UCS-2LE', 'UTF-8');
file_put_contents($file,$file_new_content);

copy($tmd.'stab.etl2', $gen.$main_directory_name.'/stab.etl2');
$file = $gen.$main_directory_name.'/stab.etl2';
$find = array('#EU','#MV','#CU');
$replace = array(mb_strtoupper($napi_szerkeszto),mb_strtoupper($musorvezeto),mb_strtoupper($osszeallito));
$file_new_content = str_replace($find,$replace,mb_convert_encoding(file_get_contents($file), 'UTF-8', 'UCS-2LE'));
$file_new_content = mb_convert_encoding($file_new_content, 'UCS-2LE', 'UTF-8');
file_put_contents($file,$file_new_content);

// időjárás

$existingweather = false;
$sql = $MySqliLink->query("SELECT * FROM `oi_content` WHERE `production`='".$production."' AND `date`='".$date."' AND `type`='weather'");
while($data = $sql->fetch_array()) {
	if (isset($data)) { $existingweather = true; }
}

if ($production == 'hirado' and $existingweather == true) {

$sql = $MySqliLink->query("SELECT `weather_temp_de0`, `weather_temp_de1`, `weather_temp_du0`, `weather_temp_du1`, `weather_img_de`, `weather_img_du` FROM `oi_content` WHERE `production`='".$production."' AND `date`='".$date."' AND `type`='weather' LIMIT 1");

while($data = $sql->fetch_array()) {
	$weather_temp_de0 = $data['weather_temp_de0'];
	$weather_temp_de1 = $data['weather_temp_de1'];
	$weather_temp_du0 = $data['weather_temp_du0'];
	$weather_temp_du1 = $data['weather_temp_du1'];
	$weather_img_de = $data['weather_img_de'];
	$weather_img_du = $data['weather_img_du'];
	}

// időjárás .psd fájlok bemásolása

copy('weather/'.$weather_img_de.'.psd', $gen.$main_directory_name.'/de.psd');
copy('weather/'.$weather_img_du.'.psd', $gen.$main_directory_name.'/du.psd');

// weather.etl2

copy($tmd.'weather.etl2', $gen.$main_directory_name.'/weather.etl2');
$file = $gen.$main_directory_name.'/weather.etl2';
$find = array('A1','A2','P1','P2');
$replace = array($weather_temp_de0,$weather_temp_de1,$weather_temp_du0,$weather_temp_du1);
$file_new_content = str_replace($find,$replace,mb_convert_encoding(file_get_contents($file), 'UTF-8', 'UCS-2LE'));
$file_new_content = mb_convert_encoding($file_new_content, 'UCS-2LE', 'UTF-8');
file_put_contents($file,$file_new_content);

}

// anyag alapok generálása

$sql = $MySqliLink->query("SELECT `name`, `title`, `interviewee`, `riporter`, `camera`, `editor` FROM `oi_content` WHERE `production`='".$production."' AND `date`='".$date."' AND (`type`='anyag' OR `type`='dsz')");

$csere = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ő'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ű'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ő'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'ü'=>'u', 'ű'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', ' '=>'_', '.'=>'', ':'=>'', '?'=>'', '!'=>'' );

while($data = $sql->fetch_array()) {
	// anyag könyvtár írás
	$content_directory_name = strtr($data['name'], $csere);
	
	if (!file_exists($gen.$main_directory_name.'/'.$content_directory_name)) {
    mkdir($gen.$main_directory_name.'/'.$content_directory_name, 0777, true);
	}
	
	// anyag .ezp fájl bemásolás
	$content_name = $content_directory_name.'_'.date("Ymd", strtotime($date));
	if (!file_exists($gen.$main_directory_name.'/'.$content_directory_name.'/'.$content_name.'.ezp')) { copy($tcd.'alap.ezp', $gen.$main_directory_name.'/'.$content_directory_name.'/'.$content_name.'.ezp'); }
	
	// téma felirat
	copy($tcd.'temafelirat.etl2', $gen.$main_directory_name.'/'.$content_directory_name.'/temafelirat.etl2');
	$file = $gen.$main_directory_name.'/'.$content_directory_name.'/temafelirat.etl2';
	$file_new_content = str_replace('#SE',mb_strtoupper($data['title']),mb_convert_encoding(file_get_contents($file), 'UTF-8', 'UCS-2LE'));
	$file_new_content = mb_convert_encoding($file_new_content, 'UCS-2LE', 'UTF-8');
	file_put_contents($file,$file_new_content);
	
	// stáb
	$riporter = $data['riporter'];
	$camera = $data['camera'];
	$editor = $data['editor'];
	
	$stab_sql = $MySqliLink->query("SELECT `name` FROM `oi_user` WHERE `id`='".$riporter."' LIMIT 1");
	while($stab_data = $stab_sql->fetch_array()) {
	$szerkeszto = mb_strtoupper($stab_data['name']);
	}
	
	$stab_sql = $MySqliLink->query("SELECT `name` FROM `oi_user` WHERE `id`='".$camera."' LIMIT 1");
	while($stab_data = $stab_sql->fetch_array()) {
	$operator = mb_strtoupper($stab_data['name']);
	}
	
	$stab_sql = $MySqliLink->query("SELECT `name` FROM `oi_user` WHERE `id`='".$editor."' LIMIT 1");
	while($stab_data = $stab_sql->fetch_array()) {
	$vago = mb_strtoupper($stab_data['name']);
	}
	
	copy($tcd.'stab.etl2', $gen.$main_directory_name.'/'.$content_directory_name.'/stab.etl2');
	$file = $gen.$main_directory_name.'/'.$content_directory_name.'/stab.etl2';
	$find = array('#EU','#CM','#CU');
	$replace = array(mb_strtoupper($szerkeszto),mb_strtoupper($operator),mb_strtoupper($vago));
	$file_new_content = str_replace($find,$replace,mb_convert_encoding(file_get_contents($file), 'UTF-8', 'UCS-2LE'));
	$file_new_content = mb_convert_encoding($file_new_content, 'UCS-2LE', 'UTF-8');
	file_put_contents($file,$file_new_content);
	
	// névinzertek
	$interviewee_pieces = explode("%", $data['interviewee']);
	$i = 0;
	$x = 0;
	
	while($x <= 29) {
	$i++;
	copy($tcd.'nevinzert.etl2', $gen.$main_directory_name.'/'.$content_directory_name.'/nevinzert_'.$i.'.etl2');
	$file = $gen.$main_directory_name.'/'.$content_directory_name.'/nevinzert_'.$i.'.etl2';
	if (empty($interviewee_pieces[$x+2])) { $comma = ''; } else { $comma = ','; }
	$find = array('#NA','#TY','#LS2');
	$replace = array(mb_strtoupper($interviewee_pieces[$x]),mb_strtoupper($interviewee_pieces[$x+1]).$comma,mb_strtoupper($interviewee_pieces[$x+2]));
	$file_new_content = str_replace($find,$replace,mb_convert_encoding(file_get_contents($file), 'UTF-8', 'UCS-2LE'));
	$file_new_content = mb_convert_encoding($file_new_content, 'UCS-2LE', 'UTF-8');
	file_put_contents($file,$file_new_content);
	$x = $x + 3;
	}
	
	// nullás render fájlok írása (egyelőre csak Híradóban)
	if ($production == 'hirado') {
	
	if (!file_exists('H:/_RENDER/'.date("Ymd", strtotime($date)).'_'.$content_directory_name.'.mp4')) {
    fopen('H:/_RENDER/'.date("Ymd", strtotime($date)).'_'.$content_directory_name.'.mp4', "w");
	}
	
	}
}

?>
<meta http-equiv="refresh" content="1;url=production/edit/<?php echo $production; ?>/?successfully=generate">