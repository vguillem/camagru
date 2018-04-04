<?PHP
session_start();

include('vue/hf/header.php');
if (!empty($_GET['page']) && is_file('controleur/' . $_GET['page'] . '.php'))
{
	include('controleur/' . $_GET['page'] . '.php');
}
else
{
	include('controleur/galerie.php');
}
include('vue/hf/footer.php');
?>
