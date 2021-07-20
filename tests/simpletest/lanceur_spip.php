<?php
/**
 * Démarre SPIP afin d'obtenir ses fonctions depuis
 * les jeux de tests unitaires de type simpletest
 */
$remonte = "";
while (!is_file($remonte."test.inc") and !is_dir($remonte.'ecrire/'))
	$remonte = $remonte."../";
foreach ([$remonte."test.inc", $remonte."tests/test.inc", $remonte."tests/tests/legacy/test.inc"] as $f) {
	if (is_file($f)){
		require $f;
		break;
	}
}
if (!defined('_SPIP_TEST_INC')) {
	die('Impossible de trouver test.inc depuis ' .getcwd());
}

demarrer_simpletest();
