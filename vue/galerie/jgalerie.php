<?PHP
if (!empty($info))
{
	echo $info;
}
?>
<noscript>
<?PHP
echo "<div class='pagination'>";
$nb = 1;
if ($nbpage > 30)
{
	echo "<a href='index.php?nopage=" . $nb . "'>" . $nb . "</a><a href=#>...</a>";
	$nb = $pagination - 2;
	if ($nb <= 0)
		$nb = 1;
	While ($nb <= $pagination + 2 && $nb <= $nbpage)
	{
		echo "<a href='index.php?nopage=" . $nb . "'>" . $nb . "</a>";
		$nb++;
	}
	echo "<a href=#>...</a><a href='index.php?nopage=" . $nbpage . "'>" . $nbpage . "</a>";
}
else 
{
	While ($nb <= $nbpage)
	{
		echo "<a href='index.php?nopage=" . $nb . "'>" . $nb . "</a>";
		$nb++;
	}
}
echo "</div>";
?>
</noscript>
<div id='galerie'>
<noscript>
<?php
foreach($img_galerie as $k => $v)
{
	echo "<div class='img_galerie'><a href='index.php?page=galerie&type=image&id=" . $k . "'><img src='vue/montage/galerie/" . $v . ".png'></a></div>";
}
echo "</div>";
echo "<div class='pagination'>";
$nb = 1;
if ($nbpage > 30)
{
	echo "<a href='index.php?nopage=" . $nb . "'>" . $nb . "</a><a href=#>...</a>";
	$nb = $pagination - 2;
	if ($nb <= 0)
		$nb = 1;
	While ($nb <= $pagination + 2 && $nb <= $nbpage)
	{
		echo "<a href='index.php?nopage=" . $nb . "'>" . $nb . "</a>";
		$nb++;
	}
	echo "<a href=#>...</a><a href='index.php?nopage=" . $nbpage . "'>" . $nbpage . "</a>";
}
else 
{
	While ($nb <= $nbpage)
	{
		echo "<a href='index.php?nopage=" . $nb . "'>" . $nb . "</a>";
		$nb++;
	}
}
?>
</noscript>
</div>
<script type="text/javascript" src="js/img.js?<?php echo $d?>"></script>
