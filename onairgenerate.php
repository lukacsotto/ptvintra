<div id="loading"></div>
<?php

$sql = $MySqliLink->query("SELECT `done` FROM `oi_onair` WHERE `date`='".$url_pieces[2]."' AND `done`='1' LIMIT 1");
if (mysqli_num_rows($sql)==0) { echo '<meta http-equiv="refresh" content="0;url=onair/?errorcode=4">'; } else {

// elérési út config !!! ez minden esetben a meghajtó betűjellel kezdődik és egy / jellel zárul !!!

$location = 'X:/ADAS/adasmenet/';

// meghajtó mapping

system('net use X: "\\\\adasgep\d" /user:Administrator /persistent:no>nul 2>&1');

// .air fájl definíció

$time = strtotime('06:00');
$napok = Array("vasárnap", "hétfő", "kedd", "szerda", "csütörtök", "péntek", "szombat");
$datum_cimke = date("Y.m.d", strtotime($url_pieces[2])).' ('.$napok[date("w", strtotime($url_pieces[2]))].')';
$main_file_name = 'GENERALT_'.date("Ymd", strtotime($url_pieces[2]));

$myfile = fopen($location.$main_file_name.'.air', "w");

// .air fájl tartalma

$content = 'wait time 06:00:00.00 [5] active DE '.$datum_cimke."\n".'titleObjOff {Óra} 0'."\n".'titleObjOn {Infócsík} 0'."\n".'logoOn'."\n".'movie 00:00:00.00 D:\ADAS\szignalok\pannon_foszignal_169.mpg'."\n".'titleObjLoad {Következik} 0 next\\'.$url_pieces[2].'\next_1.txt'."\n".'titleObjOn {Következik} 0'."\n".'movie 00:00:00.00 D:\ADAS\szignalok\kovetkezik_alap.mp4'."\n".'titleObjAbort {Következik} 00:00:01.00 [1]'."\n".'movie 00:00:00.00 D:\ADAS\szignalok\pannon_promo_2018.mp4'."\n".'movie 00:00:00.00 D:\ADAS\reklam\ptv_megye_tv_je.mp4'."\n".'movie 00:00:00.00 D:\ADAS\szignalok\pannon_foszignal_169.mpg'."\n\n";

$i = 0;
$reklamszignal_number = 0;
$sql = $MySqliLink->query("SELECT `show_name`, `length`, `position` FROM `oi_onair` WHERE `date`='".$url_pieces[2]."' ORDER BY `position`");
while($data = $sql->fetch_array()) {
	$time = strtotime('+'.$data['length'].' minutes', $time);
	$starttime = strtotime('-'.$data['length'].' minutes', $time);
	$nextfile_number = $data['position'] + 2;
	
	if ($data['show_name'] == 'Képújság napközben') {
		
	$content = $content.'wait follow 0 '.date("H:i", $starttime).' '.$data['show_name']."\n".'titleObjOff {Infócsík} 0'."\n".'titleObjOn {Óra} 0'."\n".'titleObjOn {Futócsik} 0'."\n".'logoOff'."\n".'movie 00:00:00.00 D:\ADAS\kepujsag\kepujsag_alap.sshow'."\n".'repeat block'."\n\n".'wait time 15:00:00.00 [5] active DU '.$datum_cimke."\n".'titleObjOff {Óra} 0'."\n".'titleObjOn {Infócsík} 0'."\n".'logoOn'."\n".'movie 00:00:00.00 D:\ADAS\szignalok\pannon_foszignal_169.mpg'."\n".'titleObjLoad {Következik} 0 next\\'.$url_pieces[2].'\next_'.$nextfile_number.'.txt'."\n".'titleObjOn {Következik} 0'."\n".'movie 00:00:00.00 D:\ADAS\szignalok\kovetkezik_alap.mp4'."\n".'titleObjAbort {Következik} 00:00:01.00 [1]'."\n".'movie 00:00:00.00 D:\ADAS\szignalok\pannon_promo_2018.mp4'."\n".'movie 00:00:00.00 D:\ADAS\reklam\ptv_megye_tv_je.mp4'."\n".'movie 00:00:00.00 D:\ADAS\szignalok\pannon_foszignal_169.mpg'."\n\n";	
		
	} elseif ($data['show_name'] == 'Képújság éjjel') {
		
	$content = $content.'wait follow 0 '.date("H:i", $starttime).' '.$data['show_name']."\n".'titleObjOff {Infócsík} 0'."\n".'titleObjOn {Óra} 0'."\n".'titleObjOn {Futócsik} 0'."\n".'logoOff'."\n".'movie 00:00:00.00 D:\ADAS\kepujsag\kepujsag_alap.sshow'."\n".'repeat block'."\n\n";
	
	} else {
		
	$i++;
	$reklamszignal_number++;
	if ($reklamszignal_number > 3) { $reklamszignal_number = 1; }
	$adverts = '';
	$sql_ads = $MySqliLink->query("SELECT `file` FROM `oi_ads` WHERE `block`='".$i."' ORDER BY `position`");
	while($data_ads = $sql_ads->fetch_array()) {
		$adverts = $adverts.'movie 00:00:00.00 D:\ADAS\reklam\\'.$data_ads['file']."\n";
	}
	
	$content = $content.'wait follow 0 '.date("H:i", $starttime).' '.$data['show_name']."\n".'logoOn'."\n".'movie 00:00:00.00 D:\ADAS\szignalok\pannon_foszignal_169.mpg'."\n".'titleObjLoad {Következik} 0 next\\'.$url_pieces[2].'\next_'.$nextfile_number.'.txt'."\n".'titleObjOn {Következik} 0'."\n".'movie 00:00:00.00 D:\ADAS\szignalok\kovetkezik_alap.mp4'."\n".'titleObjAbort {Következik} 00:00:01.00 [1]'."\n".'logoOff'."\n".'movie 00:00:00.00 D:\ADAS\szignalok\REKLAM_ELEJE_MP4_'.$reklamszignal_number.'.mp4'."\n".$adverts.'movie 00:00:00.00 D:\ADAS\szignalok\REKLAM_VEGE_MP4_'.$reklamszignal_number.'.mp4'."\n".'logoOn'."\n".'movie 00:00:00.00 D:\ADAS\szignalok\pannon_foszignal_169.mpg'."\n\n";
	
	}
	
}

// következik .txt fájlok tartalma és írása

if (!file_exists($location.'next/'.$url_pieces[2])) {
    mkdir($location.'next/'.$url_pieces[2], 0777, true);
}

$todelete = glob($location.'next/'.$url_pieces[2].'/*');
foreach($todelete as $delete){
  if(is_file($delete))
    unlink($delete);
}

$i = 0;
$sql = $MySqliLink->query("SELECT `show_name` FROM `oi_onair` WHERE `date`='".$url_pieces[2]."' ORDER BY `position`");
while($data = $sql->fetch_array()) {
	
	$nextcontent = '';
	$time = strtotime('06:00');
	
	$sql_last = $MySqliLink->query("SELECT `length` FROM `oi_onair` WHERE `date`='".$url_pieces[2]."' and `position`<'".$i."' ORDER BY `position`");
	while($data_last = $sql_last->fetch_array()) {
	$time = strtotime('+'.$data_last['length'].' minutes', $time);
}
	
	$sql_next = $MySqliLink->query("SELECT `show_name`, `length` FROM `oi_onair` WHERE `date`='".$url_pieces[2]."' and `position`>='".$i."' ORDER BY `position`");
	while($data_next = $sql_next->fetch_array()) {
	$time = strtotime('+'.$data_next['length'].' minutes', $time);
	$starttime = strtotime('-'.$data_next['length'].' minutes', $time);
	
	if ($data_next['show_name'] == 'Képújság napközben') {
	
	$nextcontent = $nextcontent.date("H:i", $starttime).' '.$data_next['show_name'].'<NL><NL>';
	
	} else {
		
	$nextcontent = $nextcontent.date("H:i", $starttime).' '.$data_next['show_name'].'<NL>';
		
	}
	
	}
	
	$x = $i+1;
	$nextfile = fopen($location.'next/'.$url_pieces[2].'/next_'.$x.'.txt', "w");
	$nextcontent = iconv('UTF-8', 'Windows-1250//TRANSLIT', $nextcontent);
	fwrite($nextfile, $nextcontent);
	fclose($nextfile);
	
	$i++;
}

// .air fájl írása

$content = iconv('UTF-8', 'Windows-1250//TRANSLIT', $content);
fwrite($myfile, $content);
fclose($myfile);

echo '<meta http-equiv="refresh" content="1;url=onair/?successfully=toair">';
}
?>