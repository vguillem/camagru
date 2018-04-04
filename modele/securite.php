<?php
class Securite {

	public function protsql($str, $bdd) {
		if (ctype_digit($str))
		{
			$str = intval($str);
		}
		else
		{
			$str = $bdd->quote($str);
		}
		return $str;
	}

	public function token()
	{
		$res = "";
		$base = "azertyuiopqsdfghjklmwxcvbn123456789AZERTYUIOPQSDFGHJKLMWXCVBN";
		srand((double)microtime()*1000000);
		for($i=0; $i<12; $i++){
			$res .= $base[rand() % strlen($base)];
		}
		return ($res);
	}

	public function prothtml($str) {
		return htmlentities($str);
	}
}
?>
