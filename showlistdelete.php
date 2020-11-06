<div id="loading"></div>
<?php

$sql_delete = $MySqliLink->query("DELETE FROM `oi_showlist` WHERE `id`='".$url_pieces[2]."'");

?>
<meta http-equiv="refresh" content="1;url=showlist">