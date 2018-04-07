<?php
include(dirname(__FILE__) . '/../config/connect.php');
header('Content-Type: application/json');
try {
	$tab = array();
	$req = $bdd->prepare("SELECT id FROM galerie");
	$req->execute();
	while ($result = $req->fetch())
	{
		$tab[] = $result['id'];
	}
	echo json_encode($tab);
}
	catch(PDOExeption $e) {
		echo "error : " . $e;
	}
