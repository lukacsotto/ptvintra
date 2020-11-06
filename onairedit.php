<?php

$sql_usercheck = $MySqliLink->query("SELECT `permission` FROM `oi_user` WHERE `pass`='".$_SESSION['UserData']['Username']."' LIMIT 1");
while($data_usercheck = $sql_usercheck->fetch_array()) {
	$user_permission = $data_usercheck['permission'];
}

if ($user_permission != 'studio') { echo '<meta http-equiv="refresh" content="0;url=onair/?errorcode=3">'; $display = 'style="display:none;"'; } else { $display = '';

$time = strtotime('06:00');
$napok = Array("vasárnap", "hétfő", "kedd", "szerda", "csütörtök", "péntek", "szombat");

if (isset($_POST['musorhossz'])) {
	$sql_delete = $MySqliLink->query("DELETE FROM `oi_onair` WHERE `date`='".$url_pieces[2]."'");
	$i=0;
	$snn=0;
	foreach ($_POST['musorhossz'] as $musorhossz) {
	
	if (isset($_POST['torol']) and $i == $_POST['torol'] and $_POST['torol'] != 0) { $i--; unset($_POST['torol']); } else {
	
	$sql_write = $MySqliLink->query("INSERT INTO `oi_onair` (`position`, `show_name`, `length`, `date`, `done`) VALUES ('".$i."', '".$_POST['show_name'][$snn]."', '".$musorhossz."', '".$url_pieces[2]."', `done`)");
	
		}
	
	if (isset($_POST['hozzaad']) and $i == $_POST['hozzaad']) {
		$i++;
		$sql_write = $MySqliLink->query("INSERT INTO `oi_onair` (`position`, `show_name`, `length`, `date`, `done`) VALUES ('".$i."', '', '30', '".$url_pieces[2]."', `done`)");
		}
	
	$i++;
	$snn++;
	}
}

if (isset($_GET['done']) and $_GET['done'] == 'true') {
	$sql_write = $MySqliLink->query("UPDATE `oi_onair` SET `done`='1' WHERE `date`='".$url_pieces[2]."' AND `position`='0'");
	}

if (isset($_GET['done']) and $_GET['done'] == 'false') {
	$sql_write = $MySqliLink->query("UPDATE `oi_onair` SET `done`='0' WHERE `date`='".$url_pieces[2]."' AND `position`='0'");
	}

$sql = $MySqliLink->query("SELECT `done` FROM `oi_onair` WHERE `date`='".$url_pieces[2]."' AND `done`='1' LIMIT 1");
if (mysqli_num_rows($sql)==0) { $done = false; } else { $done = true; }

}

?>
<div class="doboz_0 hidden" <?php echo $display; ?>>
<span class="lapcim">Napi műsor szerkesztése itt: <?php echo date("Y.m.d.", strtotime($url_pieces[2])).' ('.$napok[date("w", strtotime($url_pieces[2]))].')'; ?></span><br><hr style="margin-top:0;">
<form id="form1" action="" method="post">
<a class="mainbutton" style="background-color:#35b3db; background:linear-gradient(to bottom, #35b3db 5%, #25a8d1 100%); box-shadow:inset 0px 1px 0px 0px #25a8d1; text-shadow:0px 1px 0px #25a8d1;" href="onair">Vissza</a>
<?php if ($done == false) { echo '<a class="mainbutton" href="onair/edit/'.$url_pieces[2].'/?done=true">Elkészült</a>'; }
	  if ($done == true) { echo '<a class="mainbutton" style="background-color:#30d89b; background:linear-gradient(to bottom, #30d89b 5%, #2dad7f 100%); box-shadow:inset 0px 1px 0px 0px #2dad7f; text-shadow:0px 1px 0px #2dad7f;" href="onair/edit/'.$url_pieces[2].'/?done=false">Elkészült&nbsp;&#10004;</a>'; }
?>
	<div class="container" style="margin-top:100px; margin-bottom:100px;">
		<div class="row justify-content-center">
			<div class="col-md col-md-offset-4">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Blokk</th>
							<th>Műsor</th>
							<th>Hossz</th>
							<th>Műveletek</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$i=0;
							$sql = $MySqliLink->query("SELECT `position`, `show_name`, `length` FROM `oi_onair` WHERE `date`='".$url_pieces[2]."' ORDER BY `position`");
							while($data = $sql->fetch_array()) {
								$i++; 
								$time = strtotime('+'.$data['length'].' minutes', $time);
								$starttime = strtotime('-'.$data['length'].' minutes', $time);
							    echo '
							        <tr>';
										echo '<td style="vertical-align:middle; width:12%;"><b>'.date("H:i", $starttime).' - '.date("H:i", $time).'</b></td>';
										echo '<td style="width:70%;">
												<input list="show" name="show_name[]" value="'.$data['show_name'].'" style="width:100%; height:38px; margin:0; color:#606060;">
												<datalist id="show">';
										$sql_showlist = $MySqliLink->query("SELECT `name`, `description` FROM `oi_showlist` ORDER BY `name`");
										while($data_showlist = $sql_showlist->fetch_array()) {
										if (empty($data_showlist['description'])) { $hyphen = ''; } else { $hyphen = ' - '; }
										echo '<option value="'.$data_showlist['name'].$hyphen.$data_showlist['description'].'">';
										}								
										echo '</datalist>
											  </td>';
										echo '<td style="width:12%;">
												<select name="musorhossz[]" id="musorhossz_'.$i.'" style="pointer-events:auto; height:38px; padding-top:0px; padding-bottom:0px;">
													<option value="5">5</option>
													<option value="15">15</option>
													<option value="30">30</option>
													<option value="60">60</option>
													<option value="90">90</option>
													<option value="120">120</option>
													<option value="180">Képú.</option>
												</select>
												<script>document.getElementById("musorhossz_'.$i.'").value = "'.$data['length'].'";</script>
											  </td>';
										echo '<td style="text-align:center; width:8.33%"><div class="dropdown">
													<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
													<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
													<button name="hozzaad" class="dropdown-item" style="cursor:pointer;" type="submit" value="'.$data['position'].'">&#10133;&nbsp;&nbsp;&nbsp;Új blokk</button>
													<button name="torol" class="dropdown-item" style="cursor:pointer;" type="submit" value="'.$data['position'].'">&#10060;&nbsp;&nbsp;&nbsp;Törlés</button>
													</div>
												  </div></td>
							        </tr>
							    ';
                            }
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</form>
<a class="mainbutton" style="background-color:#35b3db; background:linear-gradient(to bottom, #35b3db 5%, #25a8d1 100%); box-shadow:inset 0px 1px 0px 0px #25a8d1; text-shadow:0px 1px 0px #25a8d1;" href="onair">Vissza</a>
<?php if ($done == false) { echo '<a class="mainbutton" href="onair/edit/'.$url_pieces[2].'/?done=true">Elkészült</a>'; }
	  if ($done == true) { echo '<a class="mainbutton" style="background-color:#30d89b; background:linear-gradient(to bottom, #30d89b 5%, #2dad7f 100%); box-shadow:inset 0px 1px 0px 0px #2dad7f; text-shadow:0px 1px 0px #2dad7f;" href="onair/edit/'.$url_pieces[2].'/?done=false">Elkészült&nbsp;&#10004;</a>'; }
?>
<br><br><br>
</div>
<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script>
	$(window).scroll(function() {
  sessionStorage.scrollTop = $(this).scrollTop();
});

$(document).ready(function() {
  if (sessionStorage.scrollTop != "undefined") {
    $(window).scrollTop(sessionStorage.scrollTop);
  }
  $('div.hidden').animate({opacity:1}).removeClass('hidden');
  $("input[name='show_name[]']").change(function(){
	$('#form1 input').attr('readonly', 'readonly');
	$('#form1 select').css("pointer-events", "none");
	$('#form1').submit();
	});
  $("select[name='musorhossz[]']").change(function(){
	$('#form1 input').attr('readonly', 'readonly');
	$('#form1 select').css("pointer-events", "none");
	$('#form1').submit();
	});
});
</script>