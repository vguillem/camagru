<?PHP
class Auth {

public function __construct()
{
}

public function verif_reset($code, $bdd)
{
	$code = Securite::protsql($code, $bdd);
	$req = $bdd->prepare("SELECT email FROM reset_mdp WHERE confirmation=" . $code);
	$req->execute();
	$req4 = "DELETE FROM reset_mdp WHERE confirmation=" . $code;
	$bdd->exec($req4);
	$result = $req->fetch();
	if ($result)
	{
		$mail = Securite::protsql($result['email'], $bdd);
		$req2 = $bdd->prepare("SELECT id FROM users WHERE email=" . $mail);
		$req2->execute();
		$result2 = $req2->fetch();
		if ($result2)
		{
			$_SESSION['resetmdp'] = $result2['id'];
			return (true);
		}
	}
	return (false);
}

public function resetmdp($code, $passwd, $bdd)
{
	$passwd = hash('whirlpool', $passwd);
	$code = Securite::protsql($code, $bdd);
	$req3 = "UPDATE users SET passwd='" . $passwd . "' WHERE id=" . $code;
	$bdd->exec($req3);
}

public function ifam($bdd)
{
	$req = $bdd->prepare("SELECT id FROM alertemail WHERE user_id='" . $_SESSION['loged']['id'] . "'");
	$req->execute();
	while ($result = $req->fetch())
	{
		return (true);
	}
	return (false);
}

public function alertemailoff($bdd)
{
	$req = "INSERT INTO alertemail (am, user_id) VALUES('1', '" . $_SESSION['loged']['id'] . "')";
	$bdd->exec($req);
}

public function alertemailon($bdd)
{
	$req = "DELETE FROM alertemail WHERE user_id='" . $_SESSION['loged']['id'] . "'";
	$bdd->exec($req);
}

public function verif_pass($pwd)
{
	if (strlen($pwd) < 8)
		return (false);
	$match = preg_match('/[a-z]/', $pwd);
	if ($match === 0)
		return (false);
	$match = preg_match('/[0-9]/', $pwd);
	if ($match === 0)
		return (false);
	$match = preg_match('/[A-Z]/', $pwd);
	if ($match === 0)
		return (false);
	return (true);
}

public function reinitialiser($mail, $bdd, $S_NAME)
{
	$cmail = Securite::protsql($mail, $bdd);
	$req3 = $bdd->prepare("DELETE FROM reset_mdp WHERE email=" . $cmail);
	$req3->execute();
	$req2 = $bdd->prepare("SELECT id FROM users WHERE email=" . $cmail);
	$req2->execute();
	$result2 = $req2->fetch();
	if (!$result2)
		return (false);
	$rand = 0;
	while ($rand === 0)
	{
		$rand = rand(100000, 999999);
		$req = $bdd->prepare("SELECT email FROM reset_mdp WHERE confirmation=" . $rand);
		$req->execute();
		$result = $req->fetch();
		if ($result)
			$rand = 0;
	}
	$message = "Bonjour, cliquez sur le lien suivant pour changer votre mot de passe : " . $S_NAME . "index.php?page=auth&reset=" . $rand;
	if(mail($mail, "Reinitialisation mot de passe Camagru", $message))
	{
		$req = "INSERT INTO reset_mdp (email, confirmation) VALUES(" . $cmail . ", '" . $rand . "')";
		$bdd->exec($req);
	}
	return (true);
}

public function modifier($mail, $passwd, $firstname, $lastname, $oldpasswd, $bdd)
{
	try{
	if (empty($_SESSION['loged']['id']))
		return (false);
	$oldpasswd = hash('whirlpool', $oldpasswd);
	$req = $bdd->prepare("SELECT id FROM users WHERE id='" . $_SESSION['loged']['id'] . "' AND passwd='" . $oldpasswd . "'");
	$req->execute();
	$result = $req->fetch();
	if ($result)
	{
		if (!empty($firstname))
		{
			$_SESSION['loged']['firstname'] = $firstname;
			$firstname = Securite::protsql($firstname, $bdd);
			$req = "UPDATE users SET firstname =" . $firstname . " WHERE id='" . $_SESSION['loged']['id'] . "'";
			$bdd->exec($req);
		}
		if (!empty($lasttname))
		{
			$lastname = Securite::protsql($lastname, $bdd);
			$req = "UPDATE users SET lasstname =" . $lastname. " WHERE id='" . $_SESSION['loged']['id'] . "'";
			$bdd->exec($req);
		}
		if (!empty($mail))
		{
			$mail = Securite::protsql($mail, $bdd);
			$req = "UPDATE users SET email =" . $mail . " WHERE id='" . $_SESSION['loged']['id'] . "'";
			$bdd->exec($req);
		}
		if (!empty($passwd))
		{
			$passwd = hash('whirlpool', $passwd);
			$req = "UPDATE users SET passwd =" . $passwd . " WHERE id='" . $_SESSION['loged']['id'] . "'";
			$bdd->exec($req);
		}
		return(true);
	}
	else
	{
		return (false);
	}
	}
	catch(PDOExeption $e) {
		echo "error : " . $e;
	}
}

public function login($mail, $passwd, $bdd)
{
	try{
	$mail = Securite::protsql($mail, $bdd);
	$passwd = hash('whirlpool', $passwd);
	$req = $bdd->prepare("SELECT id, firstname, lastname, email FROM users WHERE email=" . $mail . " AND passwd='" . $passwd . "'");
	$req->execute();
	$result = $req->fetch();
	if ($result)
	{
		$_SESSION['loged']['id'] = $result['id'];
		$_SESSION['loged']['firstname'] = $result['firstname'];

	}
	}
	catch(PDOExeption $e) {
		echo "error : " . $e;
	}
}

public function resendmail($bdd, $mail, $S_NAME)
{
	$mailr = Securite::protsql($mail, $bdd);
	$req = $bdd->prepare("SELECT confirmation FROM users_tmp WHERE email=" . $mailr . " LIMIT 1");
	$req->execute();
	$result = $req->fetch();
	if ($result)
	{
		$message = "Bonjour, cliquez sur le lien suivant pour activer votre compte : " . $S_NAME . "index.php?page=auth&code=" . $result['confirmation'];
		mail($mail, "validation creation compte camagru", $message);
	}
}


public function send_mail($code, $mail, $S_NAME)
{
	$message = "Bonjour, cliquez sur le lien suivant pour activer votre compte : " . $S_NAME . "index.php?page=auth&code=" . $code;
	if(mail($mail, "validation creation compte camagru", $message))
		return (true);
	return (false);
}

public function create($code, $bdd)
{
	try{
	$code = Securite::protsql($code, $bdd);
	$req = $bdd->prepare("SELECT id, firstname, lastname, email, passwd FROM users_tmp WHERE confirmation=" . $code);
	$req->execute();
	$result = $req->fetch();
	if ($result)
	{
		$req = "INSERT INTO users (firstname, lastname, passwd, email) VALUES('" . $result['firstname'] . "', '" . $result['lastname'] . "', '" . $result['passwd'] . "', '" . $result['email'] . "')";
		$bdd->exec($req);
		$req = "DELETE FROM users_tmp WHERE confirmation=" . $code;
		$bdd->exec($req);
		echo "<p>Votre comte a ete active.</p>";
	}
	else
		echo "<p class='p_error'>Code incorect</p>";
	}
	catch(PDOExeption $e) {
		echo "error : " . $e;
	}
}

public function verif_mail($mail, $bdd)
{
	try{
	$atom = '[-a-z0-9!#$%&\'*+\\/=?^_`{|}~]';
	$domain = '([a-z0-9]([-a-z0-9]*[a-z0-9]+)?)';
	$regexmail = '/^' . $atom . '+' . '(\.' . $atom . '+)*' . '@' . '(' . $domain . '{1,63}\.)+' .$domain . '{2,63}$/i';
	$match = preg_match($regexmail, $mail);
	if ($match === 0)
	{
		return ("<p>Mail invalide.</p>");
	}
	$mail = Securite::protsql($mail, $bdd);
	$req = $bdd->prepare("SELECT id FROM users WHERE email=" . $mail);
	$req->execute();
	if ($result = $req->fetch())
	{
		if(!empty($_SESSION['loged']['id']) && $_SESSION['loged']['id'] === $result['id'])
			return ("OK");
		return ("<p>Un compte existe deja avec cet email.</p>");
	}
	$req = $bdd->prepare("SELECT id FROM users_tmp WHERE email=" . $mail);
	$req->execute();
	if ($req->fetch())
	{
		return ("<p>Un compte est en cours de creation avec cet email.</p>");
	}
	return ("OK");
	}
	catch(PDOExeption $e) {
		echo "error : " . $e;
	}
}

public function create_tmp($firstname, $lastname, $passwd, $mail, $bdd)
{
	try{
	$firstname = Securite::protsql($firstname, $bdd);
	$lastname = Securite::protsql($lastname, $bdd);
	$mail = Securite::protsql($mail, $bdd);
	$passwd = hash('whirlpool', $_POST['passwd']);
	$rand = 0;
	while ($rand === 0)
	{
		$rand = rand(100000, 999999);
		$req = $bdd->prepare("SELECT id FROM users_tmp WHERE confirmation=" . $rand);
		$req->execute();
		$result = $req->fetch();
		if ($result)
			$rand = 0;
	}
	$req = "INSERT INTO users_tmp (firstname, lastname, passwd, email, confirmation) VALUES(" . $firstname . ",  " . $lastname . ", '" . $passwd . "', " . $mail . ", " . $rand . ")";
	$bdd->exec($req);
	return ($rand);
	}
	catch(PDOExeption $e) {
		echo "error : " . $e;
	}
	
}

private function logout()
{
	unset($_SESSION['loged']);
}
}
?>
