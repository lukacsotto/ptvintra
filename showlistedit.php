<?php

$sql = $MySqliLink->query("SELECT `name`, `description` FROM `oi_showlist` WHERE `id`='".$url_pieces[2]."' LIMIT 1");

while($data = $sql->fetch_array()) {
	$name = $data['name'];
	$description = $data['description'];
	}
	
?>
<div class="doboz_0">
<span class="lapcim">Tartalom szerkesztése</span><br><hr style="margin-top:0;">
<form action="showlist/<?php if ($url_pieces[2] == 'emptyform') { echo 'create'; } else { echo 'save/'.$url_pieces[2]; } ?>" method="post">
  <a class="mainbutton" style="background-color:#35b3db; background:linear-gradient(to bottom, #35b3db 5%, #25a8d1 100%); box-shadow:inset 0px 1px 0px 0px #25a8d1; text-shadow:0px 1px 0px #25a8d1;" href="showlist">Mégsem</a>
  <input class="mainbutton submission" style="background-color:#30d89b; background:linear-gradient(to bottom, #30d89b 5%, #2dad7f 100%); box-shadow:inset 0px 1px 0px 0px #2dad7f; text-shadow:0px 1px 0px #2dad7f;" type="submit" value="Mentés"><br><br><br>
  <label for="name">&#9776;&nbsp;&nbsp;&nbsp;Műsor címe*</label><br>
  <input type="text" id="name" name="name" value="<?php echo $name; ?>"><br>
  <label for="description">&#9776;&nbsp;&nbsp;&nbsp;Leírás (pl. alcím, epizód, műfaj)</label><br>
  <input type="text" id="description" name="description" value="<?php echo $description; ?>">
  <br><br><br><br>
  <a class="mainbutton" style="background-color:#35b3db; background:linear-gradient(to bottom, #35b3db 5%, #25a8d1 100%); box-shadow:inset 0px 1px 0px 0px #25a8d1; text-shadow:0px 1px 0px #25a8d1;" href="showlist">Mégsem</a>
  <input class="mainbutton submission" style="background-color:#30d89b; background:linear-gradient(to bottom, #30d89b 5%, #2dad7f 100%); box-shadow:inset 0px 1px 0px 0px #2dad7f; text-shadow:0px 1px 0px #2dad7f;" type="submit" value="Mentés"><br><br><br>
</form>
</div>
<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<?php if ($url_pieces[2] == 'emptyform') { include 'showlistvalidate.php'; } ?>