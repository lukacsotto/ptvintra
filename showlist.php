<div class="doboz_0">
<span class="lapcim">Állandó műsorok szerkesztése</span><br><hr style="margin-top:0;">
<a class="mainbutton" href="showlist/edit/emptyform/">Új műsor</a><br>
	<div class="container" style="margin-top:100px; margin-bottom:100px;">
		<div class="row justify-content-center">
			<div class="col-md col-md-offset-4">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Műsor címe</th>
							<th>Leírás</th>
							<th>Műveletek</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$sql = $MySqliLink->query("SELECT `id`, `name`, `description` FROM `oi_showlist` WHERE `id` NOT IN ('emptyform') ORDER BY `name`");
							while($data = $sql->fetch_array()) {
							    echo '
							        <tr>';
										echo '<td style="width:50%">'.$data['name'].'</td>';
										echo '<td style="width:50%">'.$data['description'].'</td>';
										echo '<td style="text-align:center; width:8.33%"><div class="dropdown">
													<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
													<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
													<a class="dropdown-item" href="showlist/edit/'.$data['id'].'">&#9998;&nbsp;&nbsp;&nbsp;Szerkesztés</a>
													<a class="dropdown-item" href="showlist/delete/'.$data['id'].'">&#10060;&nbsp;&nbsp;&nbsp;Törlés</a>
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