<?php
include_once('connect.php');

$sql = "CREATE DATABASE IF NOT EXISTS camagru";

try
{
	$bdd->exec($sql);
	echo "BDD camagru : SUCCES.<br />";
}
catch(PDOExeption $e) {
	echo "BDD camagru : ERROR.<br />";
}


$sql = "CREATE TABLE IF NOT EXISTS users (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50) NOT NULL,
passwd TEXT
)";

try
{
	$bdd->exec($sql);
	echo "Table Users : SUCCES.<br />";
}
catch(PDOExeption $e) {
	echo "Table Users : ERROR.<br />";
}
$sql = "CREATE TABLE IF NOT EXISTS users_tmp (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50) NOT NULL,
confirmation INT(6) NOT NULL,
passwd TEXT
)";

try
{
	$bdd->exec($sql);
	echo "Table users_tmp : SUCCES.<br />";
}
catch(PDOExeption $e) {
	echo "Table users_tmp : ERROR.<br/>";
}

$sql = "CREATE TABLE IF NOT EXISTS reset_mdp (
email VARCHAR(50) NOT NULL,
confirmation INT(6) NOT NULL
)";

try
{
	$bdd->exec($sql);
	echo "Table reset_mdp : SUCCES.<br />";
}
catch(PDOExeption $e) {
	echo "Table reset_mdp : ERROR.<br />";
}

$sql = "CREATE TABLE IF NOT EXISTS img_montage (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
img VARCHAR(50) NOT NULL
)";

try
{
	$bdd->exec($sql);
	echo "Table img_montage : SUCCES.<br />";
}
catch(PDOExeption $e) {
	echo "Table img_montage : ERROR.<br />";
}

$sql = "CREATE TABLE IF NOT EXISTS galerie (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
img VARCHAR(50) NOT NULL,
user_id INT(6) UNSIGNED
)";

try
{
	$bdd->exec($sql);
	echo "Table galerie : SUCCES.<br />";
}
catch(PDOExeption $e) {
	echo "Table galerie : ERROR.<br />";
}

$sql = "CREATE TABLE IF NOT EXISTS liker (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
img INT(6) NOT NULL,
liker boolean,
user_id INT(6) UNSIGNED
)";

try
{
	$bdd->exec($sql);
	echo "Table like : SUCCES.<br />";
}
catch(PDOExeption $e) {
	echo "Table like : ERROR.<br />";
}

$sql = "CREATE TABLE IF NOT EXISTS commentaire (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
img INT(6) NOT NULL,
commentaire TEXT,
user_id INT(6) UNSIGNED
)";

try
{
	$bdd->exec($sql);
	echo "Table commentaire : SUCCES.<br />";
}
catch(PDOExeption $e) {
	echo "Table commentaire : ERROR.<br />";
}

$sql = "CREATE TABLE IF NOT EXISTS alertemail (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
am boolean,
user_id INT(6) UNSIGNED
)";

try
{
	$bdd->exec($sql);
	echo "Table alertemail : SUCCES.<br />";
}
catch(PDOExeption $e) {
	echo "Table alertmail : ERROR.<br />";
}

try
{
	$bdd->beginTransaction();
	$bdd->exec("INSERT INTO img_montage (id, img) VALUES ('1', 'sang.png')");
	$bdd->exec("INSERT INTO img_montage (id, img) VALUES ('2', 'sapin.png')");
	$bdd->exec("INSERT INTO img_montage (id, img) VALUES ('3', 'coeur.png')");
	$bdd->exec("INSERT INTO img_montage (id, img) VALUES ('4', 'yeux.png')");
	$bdd->conmmit();
	echo "Insertion : SUCCES.<br />";
}
catch(PDOExeption $e) {
	echo "Insertion : ERROR.<br />";
}

?>
