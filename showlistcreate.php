<div id="loading"></div>
<?php

function newId($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$repeatloop = true;
while($repeatloop) {
$id = newId();
$sql = $MySqliLink->query("SELECT `id` FROM `oi_showlist` WHERE `id`='".$id."' LIMIT 1");
if (mysqli_num_rows($sql)==0) { $repeatloop = false; }
}

$sql_write = $MySqliLink->query("INSERT INTO `oi_showlist` (`id`, `name`, `description`) VALUES ('".$id."', '".$_POST["name"]."', '".$_POST["description"]."')");

?>
<meta http-equiv="refresh" content="1;url=showlist">