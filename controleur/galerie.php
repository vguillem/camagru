<?php
require dirname(__FILE__) . '/../modele/galerie.php';
require dirname(__FILE__) . '/../config/connect.php';
$galerie = new Galerie;
$token = Securite::token();
if (isset($_GET['type']))
{
	$id = 0;
	if (isset($_GET['id']))
		$id = $_GET['id'];
	$pathid = dirname(__FILE__) . '/../vue/montage/galerie/' . $id . '.png';
	if(!file_exists($pathid))
	{
		$id = 0;
	}
	if($_GET['type'] === 'commentaire')
	{
		if (!isset($_SESSION['loged']['id']))
			header('Location: index.php?page=auth&type=join');
		if(isset($_POST['submit']) && $_POST['submit'] === "Commenter" && $id !== 0 && isset($_SESSION['token']) && isset($_POST['token']) && $_SESSION['token'] === $_POST['token'])
		{
			if(isset($_POST['commentaire']))
			{
				$galerie->commenter($_POST['commentaire'], $_GET['id'], $bdd, $S_NAME);
			}
			header('Location: index.php?page=galerie&type=image&id=' . $_GET['id']);
		}
		include(dirname(__FILE__) . '/../vue/galerie/commentaire.php');
	}
	else if($_GET['type'] === 'image' && $id !== 0)
	{
		$commentaire = $galerie->get_comment($id, $bdd);
		$liker = $galerie->get_like($id, $bdd);
		include(dirname(__FILE__) . '/../vue/galerie/image.php');
	}
	else if($_GET['type'] === 'like' && $id !== 0)
	{
		$like = $galerie->iflike($_SESSION['loged']['id'], $id, $bdd);
		if (!isset($_SESSION['loged']['id']))
			header('Location: index.php?page=auth&type=join');
		if (isset($_POST['submit']) && isset($_GET['id']) && isset($_SESSION['token']) && isset($_POST['token']) && $_SESSION['token'] === $_POST['token'])
		{
			if($_POST['submit'] === "Like")
			{
				$galerie->liker($_GET['id'], $bdd);
			}
			else if($_POST['submit'] === "dislike")
			{
				$galerie->unliker($_GET['id'], $bdd);
			}
			header('Location: index.php?page=galerie&type=image&id=' . $_GET['id']);
		}
		else
			include(dirname(__FILE__) . '/../vue/galerie/like.php');
	}
	else if($_GET['type'] === 'mes_images')
	{
		if (!isset($_SESSION['loged']['id']))
			header('Location: index.php?page=auth&type=join');
		if (isset($_POST['submit']) && isset($_SESSION['token']) && isset($_POST['token']) && $_SESSION['token'] === $_POST['token'])
		{
			if($_POST['submit'] === "Supprimer" && isset($_POST['image']))
			{
				$galerie->supprimer($_POST['image'], $bdd);
			}
		}
		$mes_images = $galerie->mes_images($bdd);
		include(dirname(__FILE__) . '/../vue/galerie/mes_images.php');
	}
	else
	{
		header('Location: index.php');
	}
}
else
{
	$pagination = 0;
	$page = 0;
	$nbpage = $galerie->nbpage($bdd);
	if (!empty($_GET['nopage']))
	{
		if (ctype_digit($_GET['nopage']) && $_GET['nopage'] <= $nbpage)
		{
			$pagination = $_GET['nopage'];
			$page = (intval($_GET['nopage']) - 1) * 5;
		}
	}
	$img_galerie = $galerie->img($bdd, $page);
	include(dirname(__FILE__) . '/../vue/galerie/jgalerie.php');
}
?>
