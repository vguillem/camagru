<?php
include(dirname(__FILE__) . '/../../config/connect.php');
session_start();
function fusion_img($dest, $src, $bdd)
{
	$source = imagecreatefrompng($src);
	$largeur_source = imagesx($source);
	$hauteur_source = imagesy($source);
	imagealphablending($source, true);
	imagesavealpha($source, true);
	$destination = imagecreatefrompng($dest);
	$largeur_destination = imagesx($destination);
	$hauteur_destination = imagesy($destination);
	$destination_x = ($largeur_destination - $largeur_source)/2;
	$destination_y = ($hauteur_destination - $hauteur_source)/2;
	imagecopy($destination, $source, $destination_x, $destination_y, 0, 0, $largeur_source, $hauteur_source);
	$req = "INSERT INTO galerie (user_id) VALUES('" . $_SESSION['loged']['id'] . "')";
	$bdd->exec($req);
	$id = $bdd->lastInsertId();
	$req2 = "UPDATE galerie SET img='vue/montage/galerie/" . $id . ".png' WHERE id='" . $id . "'";
	$bdd->exec($req2);
	$ch = dirname(__FILE__) . '/../../vue/montage/galerie/' . $id .'.png';
	imagepng($destination, $ch);
	return ($id);
}

if(isset($_POST['photo']) && isset($_SESSION['loged']['id']) && isset($_POST['radio']))
{
	$resu = substr($_POST['photo'], 22, strlen($_POST['photo']));
	$resu = str_replace(' ', '+', $resu);
	//file_put_contents('../../vue/montage/upload/9.png', $resu);
	file_put_contents('../../vue/montage/upload/' . $_SESSION['loged']['id'] . '.png', base64_decode($resu));
	file_put_contents('../../vue/montage/upload/test.html', $_POST['radio']);
	$id = fusion_img('upload/' . $_SESSION['loged']['id'] . '.png', 'img/' . $_POST['radio'], $bdd);
	echo json_encode($id);
}
?>
