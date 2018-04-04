<form class="sup_img" action='index.php?page=galerie&type=mes_images' method='post' >
<table class="mes_img">
<?php
$_SESSION['token'] = $token;
foreach($mes_images as $v)
{
	echo "<tr>";
	echo "<td>";
	echo "<a href='index.php?page=galerie&type=image&id=" . $v . "'><img src='vue/montage/galerie/" . $v . ".png'></a>";
	echo "</td>";
	echo "<td>";
	echo "<input type='radio' name='image' value='" . $v . "'/>";
	echo "</td>";
	echo "</tr>";
}
?>
</table>
<input type='hidden' name='token' value='<?php echo $token ?>'/>
<input class='b_sup' type='submit' name='submit' value='Supprimer'>
</form>
