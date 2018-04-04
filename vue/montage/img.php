<form action='index.php?page=montage' method='post' >
<div class="img_montage">
<?php
$_SESSION['token'] = $token;
foreach($tab as $v)
{
	echo "<label><img src='vue/montage/img/" . $v . "'><input onclick='bton()' type='radio' name='image' value='" . $v . "'/></label>";
}
?>
</div>
<input type='hidden' name='token' value='<?php echo $token ?>'/>
<input id='b_creer' class='b_creer' type='submit' name='submit' value='creer'>
</form>
