<?php 

$sql = $MySqliLink->query("SELECT `done` FROM `oi_onair` WHERE `date`='".$url_pieces[2]."' AND `done`='1' LIMIT 1");
if (mysqli_num_rows($sql)==0) { $hidecontent = 'style="display:none;"'; echo '<meta http-equiv="refresh" content="0;url=onair/?errorcode=4">'; } else { $hidecontent = ''; }

$time = strtotime('06:00');
$napok = Array("vasárnap", "hétfő", "kedd", "szerda", "csütörtök", "péntek", "szombat"); 

?>
<div class="doboz_0" <?php echo $hidecontent; ?>>
<span class="lapcim">Napi műsor itt: <?php echo date("Y.m.d.", strtotime($url_pieces[2])).' ('.$napok[date("w", strtotime($url_pieces[2]))].')'; ?></span><br><hr style="margin-top:0;">
<a class="mainbutton" style="background-color:#35b3db; background:linear-gradient(to bottom, #35b3db 5%, #25a8d1 100%); box-shadow:inset 0px 1px 0px 0px #25a8d1; text-shadow:0px 1px 0px #25a8d1;" href="onair">Vissza</a><br>
	<div class="container" style="margin-top:100px; margin-bottom:100px;">
		<div class="row justify-content-center">
			<div class="col-md col-md-offset-4">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Műsorok</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$sql = $MySqliLink->query("SELECT `position`, `show_name`, `length` FROM `oi_onair` WHERE `date`='".$url_pieces[2]."' ORDER BY `position`");
							while($data = $sql->fetch_array()) {
								$time = strtotime('+'.$data['length'].' minutes', $time);
								$starttime = strtotime('-'.$data['length'].' minutes', $time);
							    echo '
							        <tr>
										<td>'.date("H:i", $starttime).'&nbsp;&nbsp;<b>'.$data['show_name'].'</b></td>
							        </tr>
							    ';
                            }
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<a class="mainbutton" style="background-color:#35b3db; background:linear-gradient(to bottom, #35b3db 5%, #25a8d1 100%); box-shadow:inset 0px 1px 0px 0px #25a8d1; text-shadow:0px 1px 0px #25a8d1;" href="onair">Vissza</a><br><br><br>
</div>