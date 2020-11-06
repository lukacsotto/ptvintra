<?php

if (isset($_POST['update'])) {
        foreach($_POST['positions'] as $position) {
           $index = $position[0];
           $newPosition = $position[1];

           $MySqliLink->query("UPDATE `oi_content` SET `position` = '$newPosition' WHERE `id`='$index'");
        }

        exit('success');
    }

$SelectStr = "SELECT `production`, `date` FROM `oi_program` WHERE `id`='".$url_pieces[2]."' LIMIT 1";
$result = mysqli_query($MySqliLink,$SelectStr) OR die(" MySqli hiba (" .mysqli_errno($MySqliLink)."):". mysqli_error($MySqliLink));
  
while($row = mysqli_fetch_array($result))
  {
  $production_from_program = $row['production'];
  $date_from_program = $row['date'];
  }

$sql = $MySqliLink->query("SELECT `name`, `type` FROM `oi_production` WHERE `id`='".$production_from_program."' LIMIT 1");
while($data = $sql->fetch_array()) {
	$name_from_production = $data['name'];
	$type_from_production = $data['type'];
}

$existingweather = false;
$alert_existingweather = "'Nem írhatsz be két időjárást! Szerkeszd a meglévőt, vagy töröld, mielőtt újat hoznál létre.'";
$sql = $MySqliLink->query("SELECT `type` FROM `oi_content` WHERE `production`='".$production_from_program."' AND `date`='".$date_from_program."'");
while($data = $sql->fetch_array()) {
  if ($data['type'] == 'weather') { $existingweather = true; }
 }
 
?>
<div class="doboz_0">
<span class="lapcim"><?php echo $name_from_production.' - '.date("Y.m.d.", strtotime($date_from_program)); ?></span><br><hr style="margin-top:0;">
<a class="mainbutton" style="background-color:#35b3db; background:linear-gradient(to bottom, #35b3db 5%, #25a8d1 100%); box-shadow:inset 0px 1px 0px 0px #25a8d1; text-shadow:0px 1px 0px #25a8d1;" href="production/edit/<?php echo $production_from_program; ?>">Vissza</a>
<?php if ($type_from_production == 'osszeallitas') { echo '<a class="mainbutton" style="background-color:#30d89b; background:linear-gradient(to bottom, #30d89b 5%, #2dad7f 100%); box-shadow:inset 0px 1px 0px 0px #2dad7f; text-shadow:0px 1px 0px #2dad7f;" href="compilation/select/'.$url_pieces[2].'">Anyagválasztás</a>&nbsp;'; } ?>
<a class="mainbutton" href="content/edit/emptyform/?program=<?php echo $url_pieces[2]; ?>&type=anyag">Új anyag</a>
<a class="mainbutton" href="content/edit/emptyform/?program=<?php echo $url_pieces[2]; ?>&type=dsz">Új D+sz</a>
<a class="mainbutton" href="content/edit/emptyform/?program=<?php echo $url_pieces[2]; ?>&type=demo">Új beolvasás</a>
<a <?php if ($existingweather == true) { echo 'href="javascript:void(0)" onclick="alert('.$alert_existingweather.')"'; } else { echo 'href="content/edit/emptyform/?program='.$url_pieces[2].'&type=weather"'; } ?> class="mainbutton" <?php if ($production_from_program != 'hirado') { echo 'style="display:none;"'; } ?>>Új időjárás</a><br>
	<div class="container" style="margin-top:100px; margin-bottom:100px;">
		<div class="row justify-content-center">
			<div class="col-md col-md-offset-4">
				<table class="table table-striped" style="font-size:14px;">
					<thead>
						<tr>
							<?php if ($type_from_production == 'osszeallitas') { echo '<th>Dátum</th>'; } ?>
							<th>Anyag neve</th>
							<th>Headline</th>
							<th>Szerkesztő</th>
							<th>Felkonf.</th>
							<th>Műveletek</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$confirm_delete = "'Biztosan törlöd?'";
							$sql = $MySqliLink->query("SELECT `id`, `position`, `type`, `old_date`, `name`, `headline_selector`, `riporter`, `lead` FROM `oi_content` WHERE `production`='".$production_from_program."' AND `date`='".$date_from_program."' ORDER BY `position`");
							while($data = $sql->fetch_array()) {
								switch ($data['type']) {
									case "anyag":
										$contentcolor = 'danger';
										break;
									case "dsz":
										$contentcolor = 'warning';
										break;
									case "demo":
										$contentcolor = 'light';
										break;
									case "weather":
										$contentcolor = 'primary';
										break;
									default:
										$contentcolor = 'light';
								}
							    echo '
							        <tr data-index="'.$data['id'].'" data-position="'.$data['position'].'" class="table-'.$contentcolor.'">';
							            if ($type_from_production == 'osszeallitas') { echo '<td style="width:10%;">'.date("Y.m.d", strtotime($data['old_date'])).'</td>'; }
										echo '<td style="width:20%;">'.$data['name'].'</td>
										<td>'.$data['headline_selector'].'</td>';
										$SelectName = "SELECT `name` FROM `oi_user` WHERE `id`='".$data['riporter']."' LIMIT 1";
										$resultName = mysqli_query($MySqliLink,$SelectName) OR die(" MySqli hiba (" .mysqli_errno($MySqliLink)."):". mysqli_error($MySqliLink));
										while($rowName = mysqli_fetch_array($resultName))
										{
										echo '<td style="width:12%;">'.$rowName[0].'</td>';
										}
										echo '<td>'.$data['lead'].'</td>
										<td style="text-align:center; width:8.33%"><div class="dropdown">
													<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
													<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
													<a class="dropdown-item" href="content/edit/'.$data['id'].'">&#9998;&nbsp;&nbsp;&nbsp;Szerkesztés</a>
													<a class="dropdown-item" href="content/delete/'.$data['id'].'" onclick="return confirm('.$confirm_delete.')">&#10060;&nbsp;&nbsp;&nbsp;Törlés</a>
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
</div>
	<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <?php 
	
	$sql_usercheck = $MySqliLink->query("SELECT `permission` FROM `oi_user` WHERE `pass`='".$_SESSION['UserData']['Username']."' LIMIT 1");
	while($data_usercheck = $sql_usercheck->fetch_array()) {
	$user_permission = $data_usercheck['permission'];
	}
	
	if (($user_permission == 'studio' and $type_from_production == 'hirmusor') or ($user_permission == 'studio' and $type_from_production == 'magazin') or ($user_permission == 'studio' and $type_from_production == 'osszeallitas') or ($user_permission == 'hirado' and $type_from_production == 'hirmusor') or ($user_permission == 'hirado' and $type_from_production == 'magazin') or ($user_permission == 'hirado' and $type_from_production == 'osszeallitas') or ($user_permission == 'magazin' and $type_from_production == 'magazin')) { include 'movecontent.php'; } 
	
	?>