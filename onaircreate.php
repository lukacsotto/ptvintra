<div id="loading"></div>
<?php

$sql_usercheck = $MySqliLink->query("SELECT `permission` FROM `oi_user` WHERE `pass`='".$_SESSION['UserData']['Username']."' LIMIT 1");
while($data_usercheck = $sql_usercheck->fetch_array()) {
	$user_permission = $data_usercheck['permission'];
}

if ($user_permission != 'studio') { echo '<meta http-equiv="refresh" content="0;url=onair/?errorcode=3">'; } else {

$sql = $MySqliLink->query("SELECT `date` FROM `oi_onair` ORDER BY `date` DESC LIMIT 1");
while($data = $sql->fetch_array()) {
	$lastday = $data['date'];
	}
		
$date = date('Y-m-d',strtotime($lastday . "+1 days"));

$sql_write = $MySqliLink->query("INSERT INTO `oi_onair` (`position`, `date`, `show_name`, `length`, `done`) SELECT `position`, '".$date."', `show_name`, `length`, '0' FROM `oi_onair` WHERE `date`='".$url_pieces[2]."'");

echo '<meta http-equiv="refresh" content="1;url='; if (isset($_GET['open']) and $_GET['open'] == 'true') { echo 'onair/edit/'.$date; } else { echo 'onair'; } echo '">';

}

?>