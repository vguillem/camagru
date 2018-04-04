<div class="f"><form method="post" action="index.php?page=galerie&type=like&id=<?php echo $id ?>">
<input type='hidden' name='token' value='<?php echo $token ?>'/>
<?php
$_SESSION['token'] = $token;
if ($like)
{
?>
	<input type='submit' name='submit' value='dislike'>
<?php
}
else
{
?>
	<input type='submit' name='submit' value='Like'>
<?php
}
?>
</form>
</div>
