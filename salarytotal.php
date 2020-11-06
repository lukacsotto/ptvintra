<?php

$sql_usercheck = $MySqliLink->query("SELECT `id`, `permission` FROM `oi_user` WHERE `pass`='".$_SESSION['UserData']['Username']."' LIMIT 1");
while($data_usercheck = $sql_usercheck->fetch_array()) {
	$user_online = $data_usercheck['id'];
	$user_permission = $data_usercheck['permission'];
}

$access = false;
if ($user_online == $_GET['user']) { $access = true; }
if ($user_permission == 'studio') { $access = true; } 

$sql_namedisplayed = $MySqliLink->query("SELECT `name` FROM `oi_user` WHERE `id`='".$_GET['user']."' LIMIT 1");
while($data_namedisplayed = $sql_namedisplayed->fetch_array()) {
	$namedisplayed = $data_namedisplayed['name'];
}

$honapok = Array("", "január", "február", "március", "április", "május", "június", "július", "augusztus", "szeptember", "október", "november", "december"); 
$datedisplayed = date("Y.", strtotime($_GET['date'])).' '.$honapok[date("n", strtotime($_GET['date']))];

if ($access != true) { $display_notification = ''; $display = 'style="display:none;"'; } else { $display_notification = 'display:none;'; $display = '';

// Díjak

$hirado_director_price = 7000;
$hirado_anchorman_price = 1500;
$hirado_composer_price = 4500;
$hirado_anyag_riporter_price = 4000;
$hirado_demo_riporter_price = 500;
$hirado_anyag_camera_price = 2500;
$hirado_demo_camera_price = 1000;
$hirado_anyag_editor_price = 1200;
$hetnap_director_price = 2000;
$hetnap_anchorman_price = 1000;
$hetnap_composer_price = 2000;
$pannonkronika_director_price = 3000;
$pannonkronika_anchorman_price = 3000;
$pannonkronika_composer_price = 5000;
$keptar_director_price = 3000;
$keptar_anchorman_price = 3000;
$keptar_composer_price = 5000;
$magazin_director_price = 3000;
$magazin_anchorman_price = 1000;
$magazin_composer_price = 2000;
$magazin_anyag_riporter_price = 4500;
$magazin_anyag_camera_price = 2800;
$magazin_anyag_editor_price = 1500;


//***
// Híradó felelős szerkesztő
$sql = $MySqliLink->query("SELECT COUNT(*) FROM `oi_program` WHERE `production`='hirado' AND `director`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
$row = mysqli_fetch_array($sql);
$hirado_director = $row[0];
$hirado_director_sum = $hirado_director*$hirado_director_price;

// Híradó műsorvezető
$sql = $MySqliLink->query("SELECT COUNT(*) FROM `oi_program` WHERE `production`='hirado' AND `anchorman`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
$row = mysqli_fetch_array($sql);
$hirado_anchorman = $row[0];
$hirado_anchorman_sum = $hirado_anchorman*$hirado_anchorman_price;

// Híradó összeállító
$sql = $MySqliLink->query("SELECT COUNT(*) FROM `oi_program` WHERE `production`='hirado' AND `composer`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
$row = mysqli_fetch_array($sql);
$hirado_composer = $row[0];
$hirado_composer_sum = $hirado_composer*$hirado_composer_price;

// Híradó anyag (vagy dsz) szerkesztő
$sql = $MySqliLink->query("SELECT COUNT(*) FROM `oi_content` WHERE `production`='hirado' AND (`type`='anyag' OR `type`='dsz') AND `riporter`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
$row = mysqli_fetch_array($sql);
$hirado_anyag_riporter = $row[0];
$hirado_anyag_riporter_sum = $hirado_anyag_riporter*$hirado_anyag_riporter_price;

// Híradó demo szerkesztő
$sql = $MySqliLink->query("SELECT COUNT(*) FROM `oi_content` WHERE `production`='hirado' AND `type`='demo' AND `riporter`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
$row = mysqli_fetch_array($sql);
$hirado_demo_riporter = $row[0];
$hirado_demo_riporter_sum = $hirado_demo_riporter*$hirado_demo_riporter_price;

// Híradó anyag (vagy dsz) operatőr
$sql = $MySqliLink->query("SELECT COUNT(*) FROM `oi_content` WHERE `production`='hirado' AND (`type`='anyag' OR `type`='dsz') AND `camera`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
$row = mysqli_fetch_array($sql);
$hirado_anyag_camera = $row[0];
$hirado_anyag_camera_sum = $hirado_anyag_camera*$hirado_anyag_camera_price;

// Híradó demo operatőr
$sql = $MySqliLink->query("SELECT COUNT(*) FROM `oi_content` WHERE `production`='hirado' AND `type`='demo' AND `camera`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
$row = mysqli_fetch_array($sql);
$hirado_demo_camera = $row[0];
$hirado_demo_camera_sum = $hirado_demo_camera*$hirado_demo_camera_price;

// Híradó anyag (vagy dsz) vágó
$sql = $MySqliLink->query("SELECT COUNT(*) FROM `oi_content` WHERE `production`='hirado' AND (`type`='anyag' OR `type`='dsz') AND `editor`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
$row = mysqli_fetch_array($sql);
$hirado_anyag_editor = $row[0];
$hirado_anyag_editor_sum = $hirado_anyag_editor*$hirado_anyag_editor_price;

// Híradó összesen
$hirado_sum = $hirado_director_sum+$hirado_anchorman_sum+$hirado_composer_sum+$hirado_anyag_riporter_sum+$hirado_demo_riporter_sum+$hirado_anyag_camera_sum+$hirado_demo_camera_sum+$hirado_anyag_editor_sum;


//***
// 7 Nap felelős szerkesztő
$sql = $MySqliLink->query("SELECT COUNT(*) FROM `oi_program` WHERE `production`='7nap' AND `director`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
$row = mysqli_fetch_array($sql);
$hetnap_director = $row[0];
$hetnap_director_sum = $hetnap_director*$hetnap_director_price;

// 7 Nap műsorvezető
$sql = $MySqliLink->query("SELECT COUNT(*) FROM `oi_program` WHERE `production`='7nap' AND `anchorman`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
$row = mysqli_fetch_array($sql);
$hetnap_anchorman = $row[0];
$hetnap_anchorman_sum = $hetnap_anchorman*$hetnap_anchorman_price;

// 7 Nap összeállító
$sql = $MySqliLink->query("SELECT COUNT(*) FROM `oi_program` WHERE `production`='7nap' AND `composer`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
$row = mysqli_fetch_array($sql);
$hetnap_composer = $row[0];
$hetnap_composer_sum = $hetnap_composer*$hetnap_composer_price;

// 7 Nap összesen
$hetnap_sum = $hetnap_director_sum+$hetnap_anchorman_sum+$hetnap_composer_sum;


//***
// Pannon Krónika felelős szerkesztő
$sql = $MySqliLink->query("SELECT COUNT(*) FROM `oi_program` WHERE `production`='pannonkronika' AND `director`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
$row = mysqli_fetch_array($sql);
$pannonkronika_director = $row[0];
$pannonkronika_director_sum = $pannonkronika_director*$pannonkronika_director_price;

// Pannon Krónika műsorvezető
$sql = $MySqliLink->query("SELECT COUNT(*) FROM `oi_program` WHERE `production`='pannonkronika' AND `anchorman`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
$row = mysqli_fetch_array($sql);
$pannonkronika_anchorman = $row[0];
$pannonkronika_anchorman_sum = $pannonkronika_anchorman*$pannonkronika_anchorman_price;

// Pannon Krónika összeállító
$sql = $MySqliLink->query("SELECT COUNT(*) FROM `oi_program` WHERE `production`='pannonkronika' AND `composer`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
$row = mysqli_fetch_array($sql);
$pannonkronika_composer = $row[0];
$pannonkronika_composer_sum = $pannonkronika_composer*$pannonkronika_composer_price;

// Pannon Krónika összesen
$pannonkronika_sum = $pannonkronika_director_sum+$pannonkronika_anchorman_sum+$pannonkronika_composer_sum;


//***
// Képtár felelős szerkesztő
$sql = $MySqliLink->query("SELECT COUNT(*) FROM `oi_program` WHERE `production`='keptar' AND `director`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
$row = mysqli_fetch_array($sql);
$keptar_director = $row[0];
$keptar_director_sum = $keptar_director*$keptar_director_price;

// Képtár műsorvezető
$sql = $MySqliLink->query("SELECT COUNT(*) FROM `oi_program` WHERE `production`='keptar' AND `anchorman`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
$row = mysqli_fetch_array($sql);
$keptar_anchorman = $row[0];
$keptar_anchorman_sum = $keptar_anchorman*$keptar_anchorman_price;

// Képtár összeállító
$sql = $MySqliLink->query("SELECT COUNT(*) FROM `oi_program` WHERE `production`='keptar' AND `composer`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
$row = mysqli_fetch_array($sql);
$keptar_composer = $row[0];
$keptar_composer_sum = $keptar_composer*$keptar_composer_price;

// Képtár összesen
$keptar_sum = $keptar_director_sum+$keptar_anchorman_sum+$keptar_composer_sum;


//***
// Magazin loop
$sql_magazin = $MySqliLink->query("SELECT `id`, `name` FROM `oi_production` WHERE `type`='magazin' AND `id`!='keptar'");
	$magazin_sum = 0;
	while($data_magazin = $sql_magazin->fetch_array()) {

// Magazin felelős szerkesztő
$sql = $MySqliLink->query("SELECT COUNT(*) FROM `oi_program` WHERE `production`='".$data_magazin['id']."' AND `director`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
$row = mysqli_fetch_array($sql);
${$data_magazin['id'].'_director'} = $row[0];
${$data_magazin['id'].'_director_sum'} = ${$data_magazin['id'].'_director'}*$magazin_director_price;

// Magazin műsorvezető
$sql = $MySqliLink->query("SELECT COUNT(*) FROM `oi_program` WHERE `production`='".$data_magazin['id']."' AND `anchorman`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
$row = mysqli_fetch_array($sql);
${$data_magazin['id'].'_anchorman'} = $row[0];
${$data_magazin['id'].'_anchorman_sum'} = ${$data_magazin['id'].'_anchorman'}*$magazin_anchorman_price;

// Magazin összeállító
$sql = $MySqliLink->query("SELECT COUNT(*) FROM `oi_program` WHERE `production`='".$data_magazin['id']."' AND `composer`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
$row = mysqli_fetch_array($sql);
${$data_magazin['id'].'_composer'} = $row[0];
${$data_magazin['id'].'_composer_sum'} = ${$data_magazin['id'].'_composer'}*$magazin_composer_price;

// Magazin anyag (vagy dsz) szerkesztő
$sql = $MySqliLink->query("SELECT COUNT(*) FROM `oi_content` WHERE `production`='".$data_magazin['id']."' AND (`type`='anyag' OR `type`='dsz') AND `riporter`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
$row = mysqli_fetch_array($sql);
${$data_magazin['id'].'_anyag_riporter'} = $row[0];
${$data_magazin['id'].'_anyag_riporter_sum'} = ${$data_magazin['id'].'_anyag_riporter'}*$magazin_anyag_riporter_price;

// Magazin anyag (vagy dsz) operatőr
$sql = $MySqliLink->query("SELECT COUNT(*) FROM `oi_content` WHERE `production`='".$data_magazin['id']."' AND (`type`='anyag' OR `type`='dsz') AND `camera`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
$row = mysqli_fetch_array($sql);
${$data_magazin['id'].'_anyag_camera'} = $row[0];
${$data_magazin['id'].'_anyag_camera_sum'} = ${$data_magazin['id'].'_anyag_camera'}*$magazin_anyag_camera_price;

// Magazin anyag (vagy dsz) vágó
$sql = $MySqliLink->query("SELECT COUNT(*) FROM `oi_content` WHERE `production`='".$data_magazin['id']."' AND (`type`='anyag' OR `type`='dsz') AND `editor`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
$row = mysqli_fetch_array($sql);
${$data_magazin['id'].'_anyag_editor'} = $row[0];
${$data_magazin['id'].'_anyag_editor_sum'} = ${$data_magazin['id'].'_anyag_editor'}*$magazin_anyag_editor_price;

// Magazin összesen
${$data_magazin['id'].'_sum'} = ${$data_magazin['id'].'_director_sum'}+${$data_magazin['id'].'_anchorman_sum'}+${$data_magazin['id'].'_composer_sum'}+${$data_magazin['id'].'_anyag_riporter_sum'}+${$data_magazin['id'].'_anyag_camera_sum'}+${$data_magazin['id'].'_anyag_editor_sum'};
	
// Minden magazin összesen
$magazin_sum = $magazin_sum+${$data_magazin['id'].'_sum'};
	
	}


//***
// Egyéb feladatok összegző
$otherworks_sum = 0;
$sql = $MySqliLink->query("SELECT `multiplier`, `price` FROM `oi_otherworks` WHERE `user`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
while($data = $sql->fetch_array()) {
	$actual_price = $data['multiplier']*$data['price'];
	$otherworks_sum = $otherworks_sum+$actual_price;
}


//***
// Összegző
$total = $hirado_sum+$hetnap_sum+$pannonkronika_sum+$keptar_sum+$magazin_sum+$otherworks_sum;

}

?>
<div class="doboz_0">
<span class="lapcim" style="font-size:30px;"><b><?php echo $namedisplayed; ?></b> elszámolása ekkor: <b><?php echo $datedisplayed; ?></b></span><br><hr style="margin-top:0;">
<form id="form0" action="salary/total" method="get">
<label>&#9776;&nbsp;&nbsp;&nbsp;Munkatárs & elszámolási időszak váltása&nbsp;&nbsp;</label><br>
<select name="user" style="width:40%;">
<?php
	$sql_user = $MySqliLink->query("SELECT `id`, `name` FROM `oi_user` WHERE `id`!='notselected' AND `id`!='felhasznalo' ORDER BY `name`");
	while($data_user = $sql_user->fetch_array()) {
	if ($_GET['user'] == $data_user['id']) { $actual_user = 'selected'; } else { $actual_user = ''; }
	echo '<option value="'.$data_user['id'].'" '.$actual_user.'>'.$data_user['name'].'</option>';
	}
?>
</select>&nbsp;&nbsp;&nbsp;
<input type="month" name="date" style="width:40%; height:50px;" value="<?php echo $_GET['date'] ?>">&nbsp;&nbsp;&nbsp;
<input type="submit" value="Ugrás" style="height:50px; width:100px;">
</form>
<span class="notification" style="text-align:center; background:crimson; color:white; margin-top:50px; <?php echo $display_notification; ?>">Ejnye! A saját házad táján sertepertélj ;)</span>
<div <?php echo $display; ?>>
	<div class="container" style="margin-top:100px; margin-bottom:100px;">
		<div class="row justify-content-center">
			<div class="col-md col-md-offset-4">
				<table class="table">
					<thead>
						<tr class="table-light">
							<td class="table-success" style="text-align:right;" colspan="2"><b style="font-size:25px;">Kalkulált fizetés:</b></td>
							<td style="background:aquamarine;"><b style="font-size:25px;"><?php echo number_format($total, 0, ',', ' '); ?></b></td>
						</tr>
						<tr>
							<th style="width:50%;">Feladat</th>
							<th style="width:5%; text-align:center;">Alkalom</th>
							<th style="width:15%;">Összeg (Ft)</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="table-success" colspan="3"><b>Híradó</b></td>
						</tr>
						<tr class="table-light">
							<td>Felelős szerkesztő</td>
							<td style="text-align:center;"><b><?php echo $hirado_director; ?></b></td>
							<td style="background:lightpink;"><b><?php echo number_format($hirado_director_sum, 0, ',', ' '); ?></b></td>
						</tr>
						<tr class="table-light">
							<td>Műsorvezető</td>
							<td style="text-align:center;"><b><?php echo $hirado_anchorman; ?></b></td>
							<td style="background:lightpink;"><b><?php echo number_format($hirado_anchorman_sum, 0, ',', ' '); ?></b></td>
						</tr>
						<tr class="table-light">
							<td>Összeállító</td>
							<td style="text-align:center;"><b><?php echo $hirado_composer; ?></b></td>
							<td style="background:lightpink;"><b><?php echo number_format($hirado_composer_sum, 0, ',', ' '); ?></b></td>
						</tr>
						<tr class="table-light">
							<td>Anyag és D+sz szerkesztő</td>
							<td style="text-align:center;"><b><?php echo $hirado_anyag_riporter; ?></b></td>
							<td style="background:lightpink;"><b><?php echo number_format($hirado_anyag_riporter_sum, 0, ',', ' '); ?></b></td>
						</tr>
						<tr class="table-light">
							<td>Demo szerkesztő</td>
							<td style="text-align:center;"><b><?php echo $hirado_demo_riporter; ?></b></td>
							<td style="background:lightpink;"><b><?php echo number_format($hirado_demo_riporter_sum, 0, ',', ' '); ?></b></td>
						</tr>
						<tr class="table-light">
							<td>Anyag és D+sz operatőr</td>
							<td style="text-align:center;"><b><?php echo $hirado_anyag_camera; ?></b></td>
							<td style="background:lightpink;"><b><?php echo number_format($hirado_anyag_camera_sum, 0, ',', ' '); ?></b></td>
						</tr>
						<tr class="table-light">
							<td>Demo operatőr</td>
							<td style="text-align:center;"><b><?php echo $hirado_demo_camera; ?></b></td>
							<td style="background:lightpink;"><b><?php echo number_format($hirado_demo_camera_sum, 0, ',', ' '); ?></b></td>
						</tr>
						<tr class="table-light">
							<td>Anyag és D+sz vágó</td>
							<td style="text-align:center;"><b><?php echo $hirado_anyag_editor; ?></b></td>
							<td style="background:lightpink;"><b><?php echo number_format($hirado_anyag_editor_sum, 0, ',', ' '); ?></b></td>
						</tr>
						<tr class="table-light">
							<td class="table-success" style="text-align:right;" colspan="2"><b>Híradó összesen:</b></td>
							<td style="background:cadetblue;"><b><?php echo number_format($hirado_sum, 0, ',', ' '); ?></b></td>
						</tr>
						<tr>
							<td class="table-success" colspan="3"><b>7 Nap</b></td>
						</tr>
						<tr class="table-light">
							<td>Felelős szerkesztő</td>
							<td style="text-align:center;"><b><?php echo $hetnap_director; ?></b></td>
							<td style="background:lightpink;"><b><?php echo number_format($hetnap_director_sum, 0, ',', ' '); ?></b></td>
						</tr>
						<tr class="table-light">
							<td>Műsorvezető</td>
							<td style="text-align:center;"><b><?php echo $hetnap_anchorman; ?></b></td>
							<td style="background:lightpink;"><b><?php echo number_format($hetnap_anchorman_sum, 0, ',', ' '); ?></b></td>
						</tr>
						<tr class="table-light">
							<td>Összeállító</td>
							<td style="text-align:center;"><b><?php echo $hetnap_composer; ?></b></td>
							<td style="background:lightpink;"><b><?php echo number_format($hetnap_composer_sum, 0, ',', ' '); ?></b></td>
						</tr>
						<tr class="table-light">
							<td class="table-success" style="text-align:right;" colspan="2"><b>7 Nap összesen:</b></td>
							<td style="background:cadetblue;"><b><?php echo number_format($hetnap_sum, 0, ',', ' '); ?></b></td>
						</tr>
						<tr>
							<td class="table-success" colspan="3"><b>Pannon Krónika</b></td>
						</tr>
						<tr class="table-light">
							<td>Felelős szerkesztő</td>
							<td style="text-align:center;"><b><?php echo $pannonkronika_director; ?></b></td>
							<td style="background:lightpink;"><b><?php echo number_format($pannonkronika_director_sum, 0, ',', ' '); ?></b></td>
						</tr>
						<tr class="table-light">
							<td>Műsorvezető</td>
							<td style="text-align:center;"><b><?php echo $pannonkronika_anchorman; ?></b></td>
							<td style="background:lightpink;"><b><?php echo number_format($pannonkronika_anchorman_sum, 0, ',', ' '); ?></b></td>
						</tr>
						<tr class="table-light">
							<td>Összeállító</td>
							<td style="text-align:center;"><b><?php echo $pannonkronika_composer; ?></b></td>
							<td style="background:lightpink;"><b><?php echo number_format($pannonkronika_composer_sum, 0, ',', ' '); ?></b></td>
						</tr>
						<tr class="table-light">
							<td class="table-success" style="text-align:right;" colspan="2"><b>Pannon Krónika összesen:</b></td>
							<td style="background:cadetblue;"><b><?php echo number_format($pannonkronika_sum, 0, ',', ' '); ?></b></td>
						</tr>
						<tr>
							<td class="table-success" colspan="3"><b>Képtár</b></td>
						</tr>
						<tr class="table-light">
							<td>Felelős szerkesztő</td>
							<td style="text-align:center;"><b><?php echo $keptar_director; ?></b></td>
							<td style="background:lightpink;"><b><?php echo number_format($keptar_director_sum, 0, ',', ' '); ?></b></td>
						</tr>
						<tr class="table-light">
							<td>Műsorvezető</td>
							<td style="text-align:center;"><b><?php echo $keptar_anchorman; ?></b></td>
							<td style="background:lightpink;"><b><?php echo number_format($keptar_anchorman_sum, 0, ',', ' '); ?></b></td>
						</tr>
						<tr class="table-light">
							<td>Összeállító</td>
							<td style="text-align:center;"><b><?php echo $keptar_composer; ?></b></td>
							<td style="background:lightpink;"><b><?php echo number_format($keptar_composer_sum, 0, ',', ' '); ?></b></td>
						</tr>
						<tr class="table-light">
							<td class="table-success" style="text-align:right;" colspan="2"><b>Képtár összesen:</b></td>
							<td style="background:cadetblue;"><b><?php echo number_format($keptar_sum, 0, ',', ' '); ?></b></td>
						</tr>
						<?php
						$sql_magazin = $MySqliLink->query("SELECT `id`, `name` FROM `oi_production` WHERE `type`='magazin' AND `id`!='keptar' ORDER BY FIELD(id, 'pecsikor', 'kozpont', 'palya', 'baranyagazdasaga', 'hozam');");
						while($data_magazin = $sql_magazin->fetch_array()) {
						echo '<tr>
							<td class="table-success" colspan="3"><b>'.$data_magazin['name'].'</b></td>
						</tr>
						<tr class="table-light">
							<td>Felelős szerkesztő</td>
							<td style="text-align:center;"><b>'.${$data_magazin['id'].'_director'}.'</b></td>
							<td style="background:lightpink;"><b>'.number_format(${$data_magazin['id'].'_director_sum'}, 0, ',', ' ').'</b></td>
						</tr>
						<tr class="table-light">
							<td>Műsorvezető</td>
							<td style="text-align:center;"><b>'.${$data_magazin['id'].'_anchorman'}.'</b></td>
							<td style="background:lightpink;"><b>'.number_format(${$data_magazin['id'].'_anchorman_sum'}, 0, ',', ' ').'</b></td>
						</tr>
						<tr class="table-light">
							<td>Összeállító</td>
							<td style="text-align:center;"><b>'.${$data_magazin['id'].'_composer'}.'</b></td>
							<td style="background:lightpink;"><b>'.number_format(${$data_magazin['id'].'_composer_sum'}, 0, ',', ' ').'</b></td>
						</tr>
						<tr class="table-light">
							<td>Anyag szerkesztő</td>
							<td style="text-align:center;"><b>'.${$data_magazin['id'].'_anyag_riporter'}.'</b></td>
							<td style="background:lightpink;"><b>'.number_format(${$data_magazin['id'].'_anyag_riporter_sum'}, 0, ',', ' ').'</b></td>
						</tr>
						<tr class="table-light">
							<td>Anyag operatőr</td>
							<td style="text-align:center;"><b>'.${$data_magazin['id'].'_anyag_camera'}.'</b></td>
							<td style="background:lightpink;"><b>'.number_format(${$data_magazin['id'].'_anyag_camera_sum'}, 0, ',', ' ').'</b></td>
						</tr>
						<tr class="table-light">
							<td>Anyag vágó</td>
							<td style="text-align:center;"><b>'.${$data_magazin['id'].'_anyag_editor'}.'</b></td>
							<td style="background:lightpink;"><b>'.number_format(${$data_magazin['id'].'_anyag_editor_sum'}, 0, ',', ' ').'</b></td>
						</tr>
						<tr class="table-light">
							<td class="table-success" style="text-align:right;" colspan="2"><b>'.$data_magazin['name'].' összesen:</b></td>
							<td style="background:cadetblue;"><b>'.number_format(${$data_magazin['id'].'_sum'}, 0, ',', ' ').'</b></td>
						</tr>';
						}
						?>
						<tr class="table-light" style="border-top:5px solid #d4d4d4;">
							<td class="table-success" style="text-align:right;" colspan="2"><b style="font-size:20px;">Egyéb feladatok összesen:</b></td>
							<td style="background:cadetblue;"><b><?php echo number_format($otherworks_sum, 0, ',', ' '); ?></b></td>
						</tr>
						<tr class="table-light">
							<td class="table-success" style="text-align:right;" colspan="2"><b style="font-size:25px;">Kalkulált fizetés:</b></td>
							<td style="background:aquamarine;"><b style="font-size:25px;"><?php echo number_format($total, 0, ',', ' '); ?></b></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div>