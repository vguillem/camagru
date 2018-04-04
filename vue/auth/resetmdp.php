<div class="f"><form method="post" action="index.php?page=auth&type=resetmdp">
<label>Nouveau mot de passe : <input type='password' name='passwd' value=''/></label>
<div><?PHP if (isset($errorpasswd)) echo $errorpasswd; ?></div>
<input type='submit' name='submit' value='Nouveau mot de passe'>
</form>
</div>
