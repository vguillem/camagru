<form class="montage" method="post" action="index.php?page=montage">
<input type='hidden' name='token' value='<?php echo $token ?>'/>
<ul class="img_montage">
<?php
$_SESSION['token'] = $token;
foreach($tab as $v)
{
	echo "<li><label><img src='vue/montage/img/" . $v . "'><input onclick='bton()' type='radio' name='image' value='" . $v . "'/></label></li>";
}
?>
</ul>
<div id="cam">
<?php
echo $img_upl;
if (isset($fexist))
{
echo "<input id='b_creer' type='submit' onclick='clone(event)' name='submit' value='Sélectionner l image à superposer'/>";
}?>
</div>
</form>
<hr>
<form class='import' method="post" enctype="multipart/form-data" action="index.php?page=montage">
<input type='hidden' name='token' value='<?php echo $token ?>'/>
<label>Si vous ne souhaitez pas utiliser la webcam, choisissez une photo à télécharger(PNG)</label>
<input type='file' name='img' value=''/>
<input type='hidden' name='MAX_FILE_SIZE' value='4096000'/>
<input class='b_importer' type='submit' name='submit' value='importer'>
</form>
<script type="text/javascript" src="js/import.js?<?php echo $d; ?>"></script>

