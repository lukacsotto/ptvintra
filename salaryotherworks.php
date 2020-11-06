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

$date = $_GET['date'].'-01';

$sql_check = $MySqliLink->query("SELECT * FROM `oi_otherworks` WHERE `user`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
if (mysqli_num_rows($sql_check)==0) { $sql_write = $MySqliLink->query("INSERT INTO `oi_otherworks` (`position`, `work`, `multiplier`, `price`, `user`, `date`) VALUES ('0', '', '1', '0', '".$_GET['user']."', '".$date."')"); }

if (isset($_POST['work'])) {
	$sql_delete = $MySqliLink->query("DELETE FROM `oi_otherworks` WHERE `user`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."'");
	$i=0;
	$snn=0;
	
	foreach ($_POST['work'] as $work) {
	
	if (isset($_POST['torol']) and $i == $_POST['torol'] and $_POST['torol'] != 0) { $i--; unset($_POST['torol']); } else {
	
	$sql_write = $MySqliLink->query("INSERT INTO `oi_otherworks` (`position`, `work`, `multiplier`, `price`, `user`, `date`) VALUES ('".$i."', '".$work."', '".$_POST['multiplier'][$snn]."', '".$_POST['price'][$snn]."', '".$_GET['user']."', '".$date."')");
	
		}
	
	if (isset($_POST['hozzaad']) and $i == $_POST['hozzaad']) {
		$i++;
		$sql_write = $MySqliLink->query("INSERT INTO `oi_otherworks` (`position`, `work`, `multiplier`, `price`, `user`, `date`) VALUES ('".$i."', '', '1', '0', '".$_GET['user']."', '".$date."')");
		}
	
	$i++;
	$snn++;
	}
}

}

?>
<div class="doboz_0 hidden">
<span class="lapcim" style="font-size:30px;"><b><?php echo $namedisplayed; ?></b> egyéb elvégzett feladatai ekkor: <b><?php echo $datedisplayed; ?></b></span><br><hr style="margin-top:0;">
<form id="form0" action="salary/otherworks" method="get">
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
<form id="form1" action="" method="post" <?php echo $display; ?>>
	<div class="container" style="margin-top:100px; margin-bottom:100px;">
		<div class="row justify-content-center">
			<div class="col-md col-md-offset-4">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Feladat</th>
							<th>Szorzó</th>
							<th>Összeg</th>
							<th>Műveletek</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$sql = $MySqliLink->query("SELECT `position`, `work`, `multiplier`, `price` FROM `oi_otherworks` WHERE `user`='".$_GET['user']."' AND DATE_FORMAT(date, '%Y-%m')='".$_GET['date']."' ORDER BY `position`");
							while($data = $sql->fetch_array()) {
							    echo '<tr>';
										echo '<td style="width:70%;"><input type="text" name="work[]" value="'.$data['work'].'" style="width:100%; height:38px; margin:0; color:#606060;"></td>';
										echo '<td style="width:10%;"><input type="text" name="multiplier[]" value="'.$data['multiplier'].'" style="width:100%; height:38px; margin:0; color:#606060;"></td>';
										echo '<td style="width:15%;"><input type="text" name="price[]" value="'.$data['price'].'" style="width:100%; height:38px; margin:0; color:#606060;"></td>';
										echo '<td style="text-align:center; width:8.33%"><div class="dropdown">
													<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
													<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
													<button name="hozzaad" class="dropdown-item" style="cursor:pointer;" type="submit" value="'.$data['position'].'">&#10133;&nbsp;&nbsp;&nbsp;Hozzáadás</button>
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
  $("input[type='text']").change(function(){
	$('#form1 input').attr('readonly', 'readonly');
	$('#form1').submit();
	});
});
</script>