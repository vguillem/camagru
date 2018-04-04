<?php
$_SESSION['token'] = $token;
?>
<div class="f"><form method="post" action="index.php?page=galerie&type=commentaire&id=<?php echo $id ?>">
Commentaire : <textarea name='commentaire' rows='15%' class='commentaire'></textarea>
<br />
<input type='hidden' name='token' value='<?php echo $token ?>'/>
<input type='submit' name='submit' value='Commenter'>
</form>
</div>
