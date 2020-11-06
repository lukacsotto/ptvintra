<?php

$sql = $MySqliLink->query("SELECT `name` FROM `oi_production` WHERE `id`='".$url_pieces[2]."' LIMIT 1");
while($data = $sql->fetch_array()) {
	$name_from_production = $data['name'];
}

?>
<div class="doboz_0">
<span class="lapcim"><?php echo $name_from_production; ?> szerkesztése</span><br><hr style="margin-top:0;">
<a class="mainbutton" href="program/options/emptyform/?production=<?php echo $url_pieces[2]; ?>">Új nap</a><br>
<?php
if (isset($_GET["successfully"]) and $_GET["successfully"] == 'generate') { echo '<span class="notification" style="background:cadetblue; color:white;">A fájlok generálása sikeres volt!</span>'; }
if (isset($_GET["successfully"]) and $_GET["successfully"] == 'toprompter') { echo '<span class="notification" style="background:cadetblue; color:white;">A súgófájl elkészült!</span>'; }
?>
	<div class="container" style="margin-top:100px; margin-bottom:100px;">
		<div class="row justify-content-center">
			<div class="col-md col-md-offset-4">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Műsor dátuma</th>
							<th>Felelős szerkesztő</th>
							<th>Műsorvezető</th>
							<th>Összeállító</th>
							<th>Műveletek</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$confirm_delete = "'Biztosan törlöd?'";
							$sql = $MySqliLink->query("SELECT `id`, `date`, `director`, `anchorman`, `composer` FROM `oi_program` WHERE `production`='".$url_pieces[2]."' ORDER BY `date` DESC");
							while($data = $sql->fetch_array()) {
							    echo '
							        <tr>';
										$date_displayed = date("Y.m.d", strtotime($data['date']));
										echo '<td>'.$date_displayed.'</td>';
										$SelectName = "SELECT `name` FROM `oi_user` WHERE `id`='".$data[2]."' LIMIT 1";
										$resultName = mysqli_query($MySqliLink,$SelectName) OR die(" MySqli hiba (" .mysqli_errno($MySqliLink)."):". mysqli_error($MySqliLink));
										while($rowName = mysqli_fetch_array($resultName))
										{
										echo "<td>".$rowName[0]."</td>";
										}
										$SelectName = "SELECT `name` FROM `oi_user` WHERE `id`='".$data[3]."' LIMIT 1";
										$resultName = mysqli_query($MySqliLink,$SelectName) OR die(" MySqli hiba (" .mysqli_errno($MySqliLink)."):". mysqli_error($MySqliLink));
										while($rowName = mysqli_fetch_array($resultName))
										{
										echo "<td>".$rowName[0]."</td>";
										}
										$SelectName = "SELECT `name` FROM `oi_user` WHERE `id`='".$data[4]."' LIMIT 1";
										$resultName = mysqli_query($MySqliLink,$SelectName) OR die(" MySqli hiba (" .mysqli_errno($MySqliLink)."):". mysqli_error($MySqliLink));
										while($rowName = mysqli_fetch_array($resultName))
										{
										echo "<td>".$rowName[0]."</td>";
										}
										echo '<td style="text-align:center; width:8.33%"><div class="dropdown">
													<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
													<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
													<a class="dropdown-item" href="program/options/'.$data['id'].'">&#9998;&nbsp;&nbsp;&nbsp;Alapadatok szerkesztése</a>
													<a class="dropdown-item" href="program/edit/'.$data['id'].'">&#9776;&nbsp;&nbsp;&nbsp;Anyaglista</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="program/generate/'.$data['id'].'">&#9655;&nbsp;&nbsp;&nbsp;Edius-fájlok generálása</a>
													<a class="dropdown-item" href="program/script/'.$data['id'].'" target="_blank">&#128221;&nbsp;&nbsp;&nbsp;Forgatókönyv nyomtatás</a>
													<a class="dropdown-item" href="program/toprompter/'.$data['id'].'">&#128488;&nbsp;&nbsp;&nbsp;Súgózás</a>
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