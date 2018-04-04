<!DOCTYPE html>
<html>
<head>
<title>Camagru</title>
<meta charset="UTF-8" name="viewport" initial-scale="1" content="width=device-width">
<?php $d = time();?>
<link rel="stylesheet" href="style/css.css?<?php echo $d; ?>" type="text/css">
</head>
<body>
<header>
    <a href="index.php"><h1>Camagru</h1></a>
	<ul class="menu">
<?php
include_once(dirname(__FILE__) . '/../../modele/securite.php');
include_once(dirname(__FILE__) . '/../../modele/ajax.php');
if (isset($_SESSION['loged']) && !empty($_SESSION['loged']['id']))
{
echo "<li><a href='index.php?page=auth&type=compte'>" . Securite::prothtml($_SESSION['loged']['firstname']) . "</a></li>";
?>
	<li><a href='index.php?page=montage'>Montage</a></li>
    <li><a href="index.php?page=auth&logout">Deconnexion</a></li>
<?PHP
}
else
{
?>
	<li><a href="index.php?page=auth&type=create">Inscription</a></li>
    <li><a href="index.php?page=auth&type=login">Connexion</a></li>
<?PHP
}
?>
</ul>
</header>
<div id="page">
