<?php

$SelectStr = "SELECT `production`, `date` FROM `oi_program` WHERE `id`='".$url_pieces[2]."' LIMIT 1";
$result = mysqli_query($MySqliLink,$SelectStr) OR die(" MySqli hiba (" .mysqli_errno($MySqliLink)."):". mysqli_error($MySqliLink));
while($row = mysqli_fetch_array($result))
  {
  $production_from_program = $row['production'];
  $date_from_program = $row['date'];
  }

$sql = $MySqliLink->query("SELECT `name` FROM `oi_production` WHERE `id`='".$production_from_program."' LIMIT 1");
while($data = $sql->fetch_array()) {
	$name_from_production = $data['name'];
}

?>
<div class="doboz_0">
<span class="lapcim"><?php echo 'Anyagok kiválasztása ide: '.$name_from_production.' - '.date("Y.m.d.", strtotime($date_from_program)); ?></span><br><hr style="margin-top:0;">
<form action="compilation/save/<?php echo $url_pieces[2]; ?>" method="post">
<a class="mainbutton" style="background-color:#35b3db; background:linear-gradient(to bottom, #35b3db 5%, #25a8d1 100%); box-shadow:inset 0px 1px 0px 0px #25a8d1; text-shadow:0px 1px 0px #25a8d1;" href="program/edit/<?php echo $url_pieces[2]; ?>">Mégsem</a>
<input class="mainbutton" style="background-color:#30d89b; background:linear-gradient(to bottom, #30d89b 5%, #2dad7f 100%); box-shadow:inset 0px 1px 0px 0px #2dad7f; text-shadow:0px 1px 0px #2dad7f;" type="submit" value="Mentés">
	<div class="container" style="margin-top:100px; margin-bottom:100px;">
		<div class="row justify-content-center">
			<div class="col-md col-md-offset-4">
				<table class="table table-striped" style="font-size:14px;">
					<thead>
						<tr>
							<th>Dátum</th>
							<th>Anyag neve</th>
							<th>Headline</th>
							<th>Szerkesztő</th>
							<th>Felkonf.</th>
							<th>Kiválasztom</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$sql = $MySqliLink->query("SELECT `id`, `type`, `date`, `name`, `headline_selector`, `riporter`, `lead` FROM `oi_content` WHERE `production`='hirado' AND `date` > NOW() - INTERVAL 14 DAY AND (`type`='anyag' OR `type`='dsz') ORDER BY `date` DESC");
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
							        <tr class="table-'.$contentcolor.'">
										<td style="width:10%;">'.date("Y.m.d", strtotime($data['date'])).'</td>
							            <td style="width:20%;">'.$data['name'].'</td>
										<td>'.$data['headline_selector'].'</td>';
										$SelectName = "SELECT `name` FROM `oi_user` WHERE `id`='".$data['riporter']."' LIMIT 1";
										$resultName = mysqli_query($MySqliLink,$SelectName) OR die(" MySqli hiba (" .mysqli_errno($MySqliLink)."):". mysqli_error($MySqliLink));
										while($rowName = mysqli_fetch_array($resultName))
										{
										echo '<td style="width:12%;">'.$rowName[0].'</td>';
										}
										echo '<td>'.$data['lead'].'</td>
										<td style="text-align:center; width:8.33%"><input type="checkbox" style="width:20px; height:20px;" name="id[]" value="'.$data['id'].'"></td>
							        </tr>
							    ';
                            }
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<a class="mainbutton" style="background-color:#35b3db; background:linear-gradient(to bottom, #35b3db 5%, #25a8d1 100%); box-shadow:inset 0px 1px 0px 0px #25a8d1; text-shadow:0px 1px 0px #25a8d1;" href="program/edit/<?php echo $url_pieces[2]; ?>">Mégsem</a>
<input class="mainbutton" style="background-color:#30d89b; background:linear-gradient(to bottom, #30d89b 5%, #2dad7f 100%); box-shadow:inset 0px 1px 0px 0px #2dad7f; text-shadow:0px 1px 0px #2dad7f;" type="submit" value="Mentés"><br><br><br>
</form>
</div>