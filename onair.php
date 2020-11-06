<?php 

$napok = Array("vasárnap", "hétfő", "kedd", "szerda", "csütörtök", "péntek", "szombat"); 
$confirm_copy = "'A napi műsor létre fog jönni a legfrissebb, még nem létező dátummal.'";

?>
<div class="doboz_0">
<span class="lapcim">Napi műsor</span><br><hr style="margin-top:0;">
<?php
if (isset($_GET["errorcode"]) and $_GET["errorcode"] == '3') { echo '<span class="notification" style="text-align:center; background:crimson; color:white;">Ezt a funkciót te nem használhatod!</span>'; }
if (isset($_GET["errorcode"]) and $_GET["errorcode"] == '4') { echo '<span class="notification" style="text-align:center; background:crimson; color:white;">Ez a nap még nem készült el teljesen!</span>'; }
if (isset($_GET["successfully"]) and $_GET["successfully"] == 'toair') { echo '<span class="notification" style="text-align:center; background:cadetblue; color:white;">Az adásfájlok elkészültek!</span>'; }
?>
	<div class="container" style="margin-top:100px; margin-bottom:100px;">
		<div class="row justify-content-center">
			<div class="col-md col-md-offset-4">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Dátum</th>
							<th>Műveletek</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$sql = $MySqliLink->query("SELECT DISTINCT `date` FROM `oi_onair` ORDER BY `date` DESC");
							while($data = $sql->fetch_array()) {
							    echo '
							        <tr>';
										$date_displayed = date("Y.m.d", strtotime($data['date'])).' ('.$napok[date("w", strtotime($data['date']))].')';
										echo '<td>'.$date_displayed.'</td>';
										echo '<td style="text-align:center; width:8.33%"><div class="dropdown">
													<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
													<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
													<a class="dropdown-item" href="onair/edit/'.$data['date'].'">&#9998;&nbsp;&nbsp;&nbsp;Szerkesztés</a>
													<a class="dropdown-item" href="onair/create/'.$data['date'].'" onclick="return confirm('.$confirm_copy.')">&#8634;&nbsp;&nbsp;&nbsp;Másolás új dátumra</a>
													<a class="dropdown-item" href="onair/create/'.$data['date'].'/?open=true" onclick="return confirm('.$confirm_copy.')">&#8634;&nbsp;&nbsp;&nbsp;Másolás és szerkesztés azonnal</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="onair/generate/'.$data['date'].'">&#9655;&nbsp;&nbsp;&nbsp;Adásfájlok generálása</a>
													<a class="dropdown-item" href="onair/list/'.$data['date'].'">&#9776;&nbsp;&nbsp;&nbsp;Megtekintés</a>
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