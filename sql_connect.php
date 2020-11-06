<?php
//Kapcsolat létrehozása
$MySqliLink = mysqli_connect('localhost', 'root', '********', 'intra_2020');
//Kapcsolat ellenőrzése
if (!$MySqliLink) {
    die('Kapcsolódási hiba (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}
?>