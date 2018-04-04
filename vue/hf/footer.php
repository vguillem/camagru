</div>
<footer>
<ul class="menuf">
<?php
if (isset($_SESSION['loged']) && !empty($_SESSION['loged']['id']))
{
echo "<li><a href='index.php?page=montage'>Montage</a></li>";
}
?>
    <li><a href="index.php?page=galerie">Accueil</a></li>
	</ul>
</footer>
</body>
</html>
