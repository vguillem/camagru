<div class="f"><form method="POST" action="index.php?page=auth&type=create" id='create'>
<label>Prenom: <input type='text' name='firstname' value='' placeholder="Prenom"/></label>
<div><?PHP if (isset($errorfirstname)) echo $errorfirstname; ?></div>
<label>Nom: <input type='text' name='lastname' value='' placeholder="Nom"/></label>
<div><?PHP if (isset($errorlastname)) echo $errorlastname; ?></div>
<label>Adresse mail: <input type='text' name='mail' value='' placeholder="Email"/></label>
<div><?PHP if (isset($errormail)) echo $errormail; ?></div>
<label>Mot de passe: <input type='password' name='passwd' value='' placeholder="Password"/></label>
<div><?PHP if (isset($errorpasswd)) echo $errorpasswd; ?></div>
<input type='submit' name='submit' value='creer'>
</form>
</div>
