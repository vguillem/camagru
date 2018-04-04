<?php
class Montage {

public function verif_upload($file)
{
	$extv = array('png');
	$ext = strtolower(substr(strchr($file['name'], '.'), 1));
	if (!in_array($ext, $extv))
		return (false);
	if ($file['size'] > 4096001)
		return (false);
	if (empty($file['tmp_name']))
		return (false);
	$img = @imagecreatefrompng($file['tmp_name']);
	if (!$img)
		return false;
	if (imagesx($img) > 500 || imagesy($img) > 350)
		return (false);
	return (true);
}

public function fusion_img($dest, $src, $bdd)
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
	$ch = dirname(__FILE__) . '/../vue/montage/galerie/' . $id .'.png';
	imagepng($destination, $ch);
	return ($id);
}

public function img_montage($bdd)
{
	$tab = array();
	$req = $bdd->prepare("SELECT img FROM img_montage");
	$req->execute();
	while ($result = $req->fetch())
	{
		$tab[] = $result['img'];
	}
	return ($tab);
}

public function upload_img($file)
{
	$ext = strtolower(substr(strchr($file['name'], '.'), 1));
	$nom = "vue/montage/upload/" . $_SESSION['loged']['id'] . "." . $ext;
	$push = move_uploaded_file($file['tmp_name'], $nom);
}

}
?>
