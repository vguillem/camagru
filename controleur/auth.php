<?php
require dirname(__FILE__) . '/../modele/auth.php';
require dirname(__FILE__) . '/../config/connect.php';
$token = Securite::token();
$auth = new Auth;
if (isset($_GET['type']))
{
	if($_GET['type'] === 'create')
	{
		if (isset($_POST['submit']) && $_POST['submit'] === 'creer')
		{
			if (empty($_POST['firstname']))
				$errorfirstname = "<p class='p_error'>champ requis : Prenom </p>";
			if (empty($_POST['lastname']))
				$errorlastname = "<p class='p_error'>champ requis : Nom </p>";
			if (empty($_POST['mail']))
				$errormail = "<p class='p_error'>champ requis : email </p>";
			if (empty($_POST['passwd']))
				$errorpasswd = "<p class='p_error'>champ requis : mot de passe </p>";
			if(!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['passwd']) && !empty($_POST['mail']))
			{
				if ($auth->verif_pass($_POST['passwd']))
				{
					$verif = $auth->verif_mail($_POST['mail'], $bdd);
					if ($verif === "OK")
					{
						$code = $auth->create_tmp($_POST['firstname'], $_POST['lastname'], $_POST['passwd'], $_POST['mail'], $bdd);
						if ($auth->send_mail($code, $_POST['mail'], $S_NAME))
							echo "<p>Compte cree, vous allez recevoir un mail d'activation.</p>";
					}
					else
					{
						$errormail = $verif;
						include(dirname(__FILE__) . '/../vue/auth/create.php');
						if ($verif === "<p>Un compte est en cours de creation avec cet email.</p>")
							include(dirname(__FILE__) . '/../vue/auth/resendmail.php');
					}
				}
				else
				{
					$errorpasswd = "<p class='p_error'>Le mot de passe doit faire 8 caractere minimum, contenir minuscule, majuscule et chiffre.</p>";
					include(dirname(__FILE__) . '/../vue/auth/create.php');
				}
			}
			else
				include(dirname(__FILE__) . '/../vue/auth/create.php');
		}
		else
			include(dirname(__FILE__) . '/../vue/auth/create.php');
	}
	else if($_GET['type'] === 'compte')
	{
		if (!isset($_SESSION['loged']['id']))
			header('Location: index.php?page=auth&type=join');
		include(dirname(__FILE__) . '/../vue/auth/compte.php');
	}
	else if($_GET['type'] === 'modif')
	{
		if (!isset($_SESSION['loged']['id']))
			include(dirname(__FILE__) . '/../vue/auth/join.php');
		else if (isset($_POST['submit']) && $_POST['submit'] === "modifier" && isset($_POST['token']) && isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token'])
		{
			if (empty($_POST['oldpasswd']))
			{
				$erroroldpasswd = "<p class='p_error'>champ requis : mot de passe actuel </p>";
			}
			else if (empty($_POST['mail']) && empty($_POST['passwd']) && empty($_POST['firstname'])  && empty($_POST['lastname']))
			{
					$errorall = "<p class='p_error'>Tous les champs sont vides.</p>";
			}
			else
			{
				if ($auth->verif_pass($_POST['passwd']) || empty($_POST['passwd']))
				{
					if (!empty($_POST['mail']))
						$verif = $auth->verif_mail($_POST['mail'], $bdd);
					else
						$verif = "OK";
					if ($verif === "OK")
					{
						if ($auth->modifier($_POST['mail'], $_POST['passwd'], $_POST['firstname'], $_POST['lastname'], $_POST['oldpasswd'], $bdd))
							$info = "<p>Compte mis a jour.</p>";
						else
							$erroroldpasswd = "<p class='p_error' >Ancien mot de passe incorrect.</p>";
					}
					else
					{
						$errormail = $verif;
					}
				}
				else
				{
					$errorpasswd = "<p class='p_error'>Le mot de passe doit faire 8 caractere minimum, contenir minuscule, majuscule et chiffre.</p>";
				}
			}
			include(dirname(__FILE__) . '/../vue/auth/modif.php');
		}
		else
			include(dirname(__FILE__) . '/../vue/auth/modif.php');
	}
	else if($_GET['type'] === 'alertmail')
	{
		if (!isset($_SESSION['loged']['id']))
			include(dirname(__FILE__) . '/../vue/auth/join.php');
		else
		{
			if(isset($_POST['submit']) && $_POST['submit'] === "Activer")
			{
				$auth->alertemailon($bdd);
			}
			else if(isset($_POST['submit']) && $_POST['submit'] === "Desactiver")
			{
				$auth->alertemailoff($bdd);
			}
			$alertemail = $auth->ifam($bdd);
			include(dirname(__FILE__) . '/../vue/auth/alertmail.php');
		}
	}
	else if($_GET['type'] === 'join')
		include(dirname(__FILE__) . '/../vue/auth/join.php');
	else if($_GET['type'] === 'login')
	{
		if (isset($_POST['submit']))
		{
			if (!empty($_POST['mail']) && !empty($_POST['passwd']) && isset($_POST['submit']) && $_POST['submit'] === "login")
			{
				$auth->login($_POST['mail'], $_POST['passwd'], $bdd);
			}
			if(!empty($_SESSION['loged']['id']))
				header('Location: index.php');
			else
			{
				echo "<p class='p_error'>Email / mot de passe incorrect </p>";
				include(dirname(__FILE__) . '/../vue/auth/login.php');
			}
		}
		else
			include(dirname(__FILE__) . '/../vue/auth/login.php');
	}
	else if($_GET['type'] === 'oublie')
	{
		if (isset($_POST['submit']) && $_POST['submit'] === "Reinitialiser")
		{
			if (isset($_POST['mail']) && $auth->reinitialiser($_POST['mail'], $bdd, $S_NAME))
				$mailsend =  "<p>Vous allez recevoir un mail de reinitialisation.</p>";
			else
			{
				$errormail = "<p class='p_error'> mail invalide.</p>";
			}
		}
		include(dirname(__FILE__) . '/../vue/auth/oublie.php');
	}
	else if($_GET['type'] === 'resendmail')
	{
		if (isset($_POST['mail']))
			$auth->resendmail($bdd, $_POST['mail'], $S_NAME);
		include(dirname(__FILE__) . '/../vue/auth/resendmail.php');
	}
	else if($_GET['type'] === 'resetmdp')
	{
		if(isset($_POST['submit']) && $_POST['submit'] === "Nouveau mot de passe" && isset($_SESSION['resetmdp']) && isset($_POST['passwd']))
		{
			if ($auth->verif_pass($_POST['passwd']))
			{
				if ($auth->resetmdp($_SESSION['resetmdp'], $_POST['passwd'], $bdd) === false)
					echo "<p class='p_error'>Erreur de reinitialisation</p>";
			}
			else
			{
				$errorpasswd = "<p class='p_error'>Le mot de passe doit faire 8 caractere minimum, contenr minuscule, majuscule et chiffre.</p>";
				include(dirname(__FILE__) . '/../vue/auth/resetmdp.php');
			}
		}
		else
			include(dirname(__FILE__) . '/../vue/auth/resetmdp.php');
	}
	else
		header('Location: index.php');
}
else if (isset($_GET['reset']))
{
	if ($auth->verif_reset($_GET['reset'], $bdd))
		include(dirname(__FILE__) . '/../vue/auth/resetmdp.php');
	else
		header('Location: index.php');

}
else if (isset($_GET['logout']))
{
	unset($_SESSION['loged']);
	header('Location: index.php');
}
else if (isset($_GET['code']))
{
	$auth->create($_GET['code'], $bdd);
}
else
	header('Location: index.php');
?>
