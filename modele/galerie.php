<?PHP
class Galerie {


public function __construct()
{
}

public function iflike($user, $id, $bdd)
{
	try {
	$id = Securite::protsql($id, $bdd);
	$user = Securite::protsql($user, $bdd);
	$req = $bdd->prepare("SELECT id FROM liker WHERE img=" . $id . " AND user_id=" . $user . " AND liker='1'");
	$req->execute();
	while ($result = $req->fetch())
	{
		return (true);
	}
	return (false);
	}
	catch(PDOExeption $e) {
		echo "error : " . $e;
	}
}

public function get_comment($id, $bdd)
{
	try {
	$tab = array();
	$i = 0;
	$id = Securite::protsql($id, $bdd);
	$req = $bdd->prepare("SELECT user_id, commentaire FROM commentaire WHERE img=" . $id);
	$req->execute();
	while ($result = $req->fetch())
	{
		$req2 = $bdd->prepare("SELECT firstname FROM users WHERE id='" . $result['user_id'] . "'");
		$req2->execute();
		$user = $req2->fetch();
		$tab[$i]['user'] = $user['firstname'];
		$tab[$i]['commentaire'] = $result['commentaire'];
		$i++;
	}
	return ($tab);
	}
	catch(PDOExeption $e) {
		echo "error : " . $e;
	}
}

public function nbpage($bdd)
{
	try {
	$req = $bdd->prepare("SELECT COUNT(id) AS nbpage FROM galerie");
	$req->execute();
	$result = $req->fetch();
	$i = 1;
	if ($result['nbpage'] % 5 === 0)
		$i = 0;
	return ((int)($result['nbpage'] / 5) + $i);
	}
	catch(PDOExeption $e) {
		echo "error : " . $e;
	}
}

public function get_like($id, $bdd)
{
	try {
	$i = 0;
	$id = Securite::protsql($id, $bdd);
	$req = $bdd->prepare("SELECT id FROM liker WHERE img=" . $id);
	$req->execute();
	while ($result = $req->fetch())
	{
		$i++;
	}
	return ($i);
	}
	catch(PDOExeption $e) {
		echo "error : " . $e;
	}
}

public function liker($id, $bdd)
{
	try {
	$id = Securite::protsql($id, $bdd);
	$req = "INSERT INTO liker (img, liker, user_id) VALUES(" . $id . ", '1', '" . $_SESSION['loged']['id'] . "')";
	$bdd->exec($req);
	}
	catch(PDOExeption $e) {
		echo "error : " . $e;
	}
}

public function unliker($id, $bdd)
{
	try {
	$id = Securite::protsql($id, $bdd);
	$req = "DELETE FROM liker WHERE img=" . $id . " AND user_id='" . $_SESSION['loged']['id'] . "'";
	$bdd->exec($req);
	}
	catch(PDOExeption $e) {
		echo "error : " . $e;
	}
}

public function supprimer($id, $bdd)
{
	try {
	$name = dirname(__FILE__) . '/../vue/montage/galerie/' . $id . '.png';
	$id = Securite::protsql($id, $bdd);
	$req = "DELETE FROM galerie WHERE id=" . $id . " AND user_id='" . $_SESSION['loged']['id'] . "'";
	$bdd->exec($req);
	$req2 = "DELETE FROM commentaire WHERE img=" . $id;
	$bdd->exec($req2);
	$req3 = "DELETE FROM liker WHERE img=" . $id;
	$bdd->exec($req3);
	if (file_exists($name))
	{
		unlink($name);
	}
	}
	catch(PDOExeption $e) {
		echo "error : " . $e;
	}
}

public function commenter($comment, $id, $bdd, $S_NAME)
{
	try {
	$comment = Securite::protsql($comment, $bdd);
	$id = Securite::protsql($id, $bdd);
	$req = "INSERT INTO commentaire (img, commentaire, user_id) VALUES(" . $id . ", " . $comment . ", '" . $_SESSION['loged']['id'] . "')";
	$bdd->exec($req);
	$req2 = $bdd->prepare("SELECT user_id FROM galerie WHERE id='" . $id . "'");
	$req2->execute();
	$result = $req2->fetch();
	$req4 = $bdd->prepare("SELECT user_id FROM alertemail WHERE user_id='" . $result['user_id'] . "'");
	$req4->execute();
	$result4 = $req4->fetch();
	if (!$result4)
	{
		$req3 = $bdd->prepare("SELECT email FROM users WHERE id='" . $result['user_id'] . "'");
		$req3->execute();
		$mail = $req3->fetch();
		$message = "voir le commentaire : " . $S_NAME . "index.php?page=galerie&type=image&id=" . $id;
		mail($mail['email'], "Votre image a ete commentee", $message);
	}
	}
	catch(PDOExeption $e) {
		echo "error : " . $e;
	}
}

public function mes_images($bdd)
{
	try {
	$tab = array();
	$req = $bdd->prepare("SELECT id FROM galerie WHERE user_id='" . $_SESSION['loged']['id'] . "'");
	$req->execute();
	while ($result = $req->fetch())
	{
		$tab[] = $result['id'];
	}
	return ($tab);
	}
	catch(PDOExeption $e) {
		echo "error : " . $e;
	}
}

public function img($bdd, $page)
{
	try {
	$tab = array();
	$req = $bdd->prepare("SELECT id FROM galerie LIMIT " . $page . ", 5");
	$req->execute();
	while ($result = $req->fetch())
	{
		$tab[] = $result['id'];
	}
	return ($tab);
	}
	catch(PDOExeption $e) {
		echo "error : " . $e;
	}
}
}
?>
