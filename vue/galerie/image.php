<?php
if (isset($id))
{
echo "<div class='img_one'>";
echo "<img src='vue/montage/galerie/" . $id . ".png'>";
echo "<div class='like_comment'>";
echo "<a href='index.php?page=galerie&type=like&id=" . $id . "' class='btn'>liker</a>";
echo "<a href='index.php?page=galerie&type=commentaire&id=" . $id . "' class='btn'>Commenter.</a>";
echo "</div>";
}
if (isset($commentaire))
{
foreach($commentaire as $v)
{

	echo "<p>";
	echo Securite::prothtml($v['commentaire']);
	echo "</p><p class='p_user'>";
	echo Securite::prothtml($v['user']) . "</p>";
}
echo "<p>total like :" . $liker . "</p>";
}
?>
</div>
