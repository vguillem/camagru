<?php
if (!empty($_SESSION['loged']['id']))
{
$_SESSION['token'] = $token;
?>
<div><?PHP if (isset($info)) echo $info; ?></div>
    <div class="f">
<form method="post" action="index.php?page=auth&type=modif">
<h4>Entrez le ou les champs que vous souhaitez modifier et votre mot de passe actuel</h4>
<div><?PHP if (isset($errorall)) echo $errorall; ?></div>
<label>firstname: <input type='text' name='firstname' value=''/></label>
<div><?PHP if (isset($errorfirstname)) echo $errorfirstname; ?></div>
<label>lastname: <input type='text' name='lastname' value=''/></label>
<div><?PHP if (isset($errorlastname)) echo $errorlastname; ?></div>
<label>Email: <input type='text' name='mail' value=''/></label>
<div><?PHP if (isset($errormail)) echo $errormail; ?></div>
<label>Mot de passe: <input type='password' name='passwd' value=''/></label>
<div><?PHP if (isset($errorpasswd)) echo $errorpasswd; ?></div>
<hr>
<label>Mot de passe actuel: <input type='password' name='oldpasswd' value=''/></label>
<div><?PHP if (isset($erroroldpasswd)) echo $erroroldpasswd; ?></div>
<input type='hidden' name='token' value='<?php echo $token ?>'/>
<input type='submit' name='submit' value='modifier'>
</form>
    </div>
<?php
}
else
	header("Location: index.php");
?>
