<div class="f"><form method="post" action="index.php?page=auth&type=alertmail">
<input type='hidden' name='token' value='<?php echo $token ?>'/>
<?php
$_SESSION['token'] = $token;
if ($alertemail)
{
?>
	<input type='submit' name='submit' value='Activer'>
<?php
}
else
{
?>
	<input type='submit' name='submit' value='Desactiver'>
<?php
}
?>
</form>
</div>
