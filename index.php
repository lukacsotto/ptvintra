<?php
session_start();
if(!isset($_SESSION['UserData']['Username'])) {
header("location:http://pecs.pannontv.eu:3000/login.php");
exit;
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<base href="http://pecs.pannontv.eu:3000">
    <title>Televíziós tartalommenedzsment-rendszer - Pannon Televízió</title>
	<link href="main.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="bootstrap.min.css" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Catamaran" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@1,200&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
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
	<?php
	include 'sql_connect.php';
	
	$sql_usercheck = $MySqliLink->query("SELECT `id`, `name` FROM `oi_user` WHERE `pass`='".$_SESSION['UserData']['Username']."' LIMIT 1");
	while($data_usercheck = $sql_usercheck->fetch_array()) {
	$user_online = $data_usercheck['id'];
	$user_fullname = $data_usercheck['name'];
	}
	
    if (isset($_GET["param"])) {
	
	$url_pieces = explode("/", $_GET["param"]);
	
	for ($x = 0; $x <= 2; $x++) {
		if (!isset($url_pieces[$x])) {
             $url_pieces[$x] = null;
        }
	}
    
	if ($url_pieces[0].$url_pieces[1] == 'programscript') { echo '<div style="margin-top:0px;">'; } else { echo '<div style="margin-top:77px;">'; include 'header.php'; }
	switch ($url_pieces[0].$url_pieces[1]) {
    case "productionedit":
        include 'productionedit.php';
        break;
	case "programcreate":
        include 'programcreate.php';
        break;
	case "programoptions":
        include 'programoptions.php';
        break;
	case "programedit":
        include 'programedit.php';
        break;
	case "programsave":
        include 'programsave.php';
        break;
	case "programgenerate":
        include 'programgenerate.php';
        break;
	case "programscript":
        include 'programscript.php';
        break;
	case "programtoprompter":
        include 'programtoprompter.php';
        break;
	case "contentcreate":
        include 'contentcreate.php';
        break;
	case "contentedit":
        include 'contentedit.php';
        break;
	case "contentsave":
        include 'contentsave.php';
        break;
	case "contentdelete":
        include 'contentdelete.php';
        break;
	case "compilationselect":
        include 'compilationselect.php';
        break;
	case "compilationsave":
        include 'compilationsave.php';
        break;
	case "onair":
        include 'onair.php';
        break;	
	case "onairlist":
        include 'onairlist.php';
        break;	
	case "onaircreate":
        include 'onaircreate.php';
        break;
	case "onairedit":
        include 'onairedit.php';
        break;
	case "onairgenerate":
        include 'onairgenerate.php';
        break;
	case "showlist":
        include 'showlist.php';
        break;
	case "showlistedit":
        include 'showlistedit.php';
        break;
	case "showlistsave":
        include 'showlistsave.php';
        break;
	case "showlistcreate":
        include 'showlistcreate.php';
        break;
	case "showlistdelete":
        include 'showlistdelete.php';
        break;
	case "salaryotherworks":
        include 'salaryotherworks.php';
        break;
	case "salarytotal":
        include 'salarytotal.php';
        break;
	default:
	    echo "Nincs ilyen oldal";
	}	
	
	} else { header("location:production/edit/hirado"); }
	?>
	</div>
<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>