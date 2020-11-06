<div id="loading"></div>
<?php

$sql_write = $MySqliLink->query("UPDATE `oi_showlist` SET `name`='".$_POST["name"]."', `description`='".$_POST["description"]."' WHERE `id`='".$url_pieces[2]."'");

?>
<meta http-equiv="refresh" content="1;url=showlist">