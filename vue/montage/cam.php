<div id='conteneur'>
<form class="montage" method="post" action="index.php?page=montage">
<ul class="img_montage">
<?php
$_SESSION['token'] = $token;
foreach($tab as $v)
{
	echo "<li><label><img src='vue/montage/img/" . $v . "'><input onclick='bton()' type='radio' name='image' value='" . $v . "'/></label></li>";
}
?>
</ul>
<input type='hidden' name='token' value='<?php echo $token ?>'/>
<div class="video">
<div id="cam">
<video id="sourcevid" autoplay="true"></video>
<input id='b_creer' type="submit" onclick="clone(event)" name='submit' value='Selectionner une image'/>
</div>
<div id="can">
		</div>
</div>
</form>
<div id='ma_galerie'>
<?php
foreach($mes_images as $v)
	echo "<a href='index.php?page=galerie&type=image&id=" . $v . "'><img src='vue/montage/galerie/" . $v . ".png'></a>";
?>
</div>
</div>
<form class='import' method="post" enctype="multipart/form-data" action="index.php?page=montage">
<input type='hidden' name='token' value='<?php echo $token ?>'/>
<label>Selectionner une image a uploader (PNG)</label>
<input type='file' name='img' value=''/>
<input type='hidden' name='MAX_FILE_SIZE' value='4096000'/>
<input class='b_importer' type='submit' name='submit' value='importer'>
</form>
<script type="text/javascript" src="js/cam.js?<?php echo $d; ?>"></script>

