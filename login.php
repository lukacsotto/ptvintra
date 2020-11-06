<?php
session_start();

if(isset($_POST['Submit'])) {
	include 'sql_connect.php';
	$logins = array();
	$sql = $MySqliLink->query("SELECT `id`, `pass` FROM `oi_user` WHERE `id`!='notselected'");
	while($data = $sql->fetch_array()) {
	$logins[$data['id']] = $data['pass'];
	}
	//$logins = array('felhasznalo' => 'belepes2020','hirado' => 'mesterjelszo2020','magazin' => 'versenyutca2020');
	$Username = isset($_POST['Username']) ? $_POST['Username'] : '';
	$Password = isset($_POST['Password']) ? $_POST['Password'] : '';

	if (isset($logins[$Username]) && $logins[$Username] == $Password) {
	$_SESSION['UserData']['Username']=$logins[$Username];
	header("location:index.php");
	exit;
	} else {
	$msg='<br><span class="notification" style="width:350px; text-align:center; background:crimson; color:white;">Hibás a név vagy a jelszó!</span>';
	}
}
?>
<!DOCTYPE html>
<html lang="hu">
    <head>
		<meta charset="utf-8">
	    <link href="main.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="bootstrap.min.css" type="text/css">
        <title>Belépés: Televíziós tartalommenedzsment-rendszer - Pannon Televízió</title>
		<!-- Favicon -->
		<link rel="apple-touch-icon" sizes="57x57" href="/elements/favicon/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="/elements/favicon/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="/elements/favicon/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="/elements/favicon/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="/elements/favicon/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="/elements/favicon/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="/elements/favicon/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="/elements/favicon/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="/elements/favicon/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="/elements/favicon/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/elements/favicon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="/elements/favicon/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/elements/favicon/favicon-16x16.png">
		<link rel="manifest" href="/elements/favicon/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="/elements/favicon/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">
    </head>
    <body>
    <form action="" method="post" name="Login_Form" style="width:350px; margin:auto; margin-top:100px;">
	<img src="elements/login-logo.png" alt="Televíziós tartalommenedzsment-rendszer - Pannon Televízió" style="display:block; margin-left:auto; margin-right:auto;">
	<br>
    <input name="Username" type="text" placeholder="Felhasználónév" style="font-family:inherit;">
	<br>
	<input name="Password" type="password" placeholder="Jelszó" style="font-family:inherit;">
    <br><br>
    <input name="Submit" type="submit" value="Belépek" class="mainbutton" style="width:100%; background-color:#30d89b; background:linear-gradient(to bottom, #30d89b 5%, #2dad7f 100%); box-shadow:inset 0px 1px 0px 0px #2dad7f; text-shadow:0px 1px 0px #2dad7f;">
	<?php if(isset($msg)) { echo $msg; } ?>
	</form>
    </body>
</html>