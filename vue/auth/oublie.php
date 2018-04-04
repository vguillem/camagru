<?php if (isset($mailsend))
{
?>
<div><?PHP echo $mailsend; ?></div>
<?php
}
else
{
?>
<div><?PHP if(isset($errormail))echo $errormail; ?></div>
<div class="f"><form method="post" action="index.php?page=auth&type=oublie">
<label>Email: <input type='text' name='mail' value=''/></label>
<br />
<input type='submit' name='submit' value='Reinitialiser'>
</form>
</div>
<?php } ?>
