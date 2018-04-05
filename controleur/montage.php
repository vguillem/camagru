<?php
include(dirname(__FILE__) . '/../modele/montage.php');
include(dirname(__FILE__) . '/../config/connect.php');
include(dirname(__FILE__) . '/../modele/galerie.php');
$Montage = new Montage;
if (!empty($_SESSION['loged']['id']))
{
$mes_images = Galerie::mes_images($bdd);
$token = Securite::token();
if (isset($_SESSION['token']))
	$veriftoken = $_SESSION['token'];
$tab = $Montage->img_montage($bdd);
if (isset($_POST['submit']) && isset($veriftoken) && isset($_POST['token']) && $veriftoken === $_POST['token'])
{
	if($_POST['submit'] === 'creer' && !empty($_POST['image']))
	{
		$path = dirname(__FILE__) . '/../vue/montage/upload/' . $_SESSION['loged']['id'] . '.png';
		if(!file_exists($path))
			echo "uploader une image.";
		else
		{
			$name = $Montage->fusion_img('vue/montage/upload/' . $_SESSION['loged']['id'] . '.png', 'vue/montage/img/' . $_POST['image'], $bdd);
			header('Location: index.php?page=montage');
		}
	}
	else if($_POST['submit'] === 'importer')
	{
		$img_upl = "<p>Le document n'est pas valide.</p>";
		if($Montage->verif_upload($_FILES['img']))
		{
			$Montage->upload_img($_FILES['img']);
			$path = dirname(__FILE__) . '/../vue/montage/upload/' . $_SESSION['loged']['id'] . '.png';
			if(file_exists($path))
			{
				$img_upl = "<img style='height:300px'src='vue/montage/upload/" . $_SESSION['loged']['id'] . ".png'>";
				$fexist = true;
			}
			include(dirname(__FILE__) . '/../vue/montage/import.php');
		}
		else
		{
			include(dirname(__FILE__) . '/../vue/montage/import.php');
		}
	}
}
else if (isset($_GET['type']))
{
	if (!isset($_POST['submit']))
	{
		$path = dirname(__FILE__) . '/../vue/montage/' . $_GET['type'] . '.php';
		if(file_exists($path))
			include($path);
		else
			include(dirname(__FILE__) . '/index.php');
	}
}
else if (!isset($_POST['submit']))
	include(dirname(__FILE__) . '/../vue/montage/cam.php');
}
else
	include(dirname(__FILE__) . '/../vue/galerie/jgalerie.php');

?>
