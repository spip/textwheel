<?php
/**
 * Test unitaire des raccourcis Markdown dans SPIP
 *
 */

$test = 'tw_propre_typo';
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

find_in_path("inc/texte.php", '', true);

$GLOBALS['spip_lang'] = 'fr'; // corrections typo
$GLOBALS['class_spip_plus'] = '';
$GLOBALS['class_spip'] = '';

// ajouter le dossier squelettes de test au chemin
_chemin(_DIR_PLUGIN_TW . "tests/squelettes/");

$notes = charger_fonction("notes", "inc");
function propre_notes($texte) {
	global $notes;
	$texte = propre($texte);
	if ($r = $notes(array())) {
		$texte .= "<div class='notes'>$r</div>";
		$notes('', 'depiler');
		$notes('', 'empiler');
	}

	return $texte;
}

//
// hop ! on y va
//
$err = tester_fun('propre_notes', essais_tw_propre_typo());

// si le tableau $err est pas vide ca va pas
if ($err) {
	die ('<dl>' . join('', $err) . '</dl>');
}

echo "OK";


function essais_tw_propre_typo() {

	$tests = preg_files(_DIR_PLUGIN_TW . "tests/data/typo/", '\.txt$');

	$texte = $expected = "";
	$essais = array();

	foreach ($tests as $t) {
		lire_fichier($t, $texte);
		lire_fichier(substr($t, 0, -4) . ".html", $expected);
		$essais[basename($t, ".txt")] = array(
			$expected,
			$texte
		);
	}

	return $essais;
}


?>