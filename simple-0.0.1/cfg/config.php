<?php
/**
 * Globale Werte
 */
$config['global']['charset'] = 'utf-8';

/**
 * Verzeichniseinstellungen
 */
#showArray($init);

/**
 * Spracheinstellungen
 */
/*$language = 'de_DE';
$config['language'][$language]['alias'] = $language;
$config['language'][$language]['name'] = 'deutsch';
$config['language'][$language]['email'] = 'robin.schmitz@rs3d.de';
$config['language'][$language]['dictionary'] = '';
*/
$language = 'de_DE';
$config['language'][$language]['alias'] = $language;
$config['language'][$language]['name'] = 'deutsch';
$config['language'][$language]['email'] = '';
$config['language'][$language]['dictionary'] = '';

$config['xml']['navigation'] = 'navigation.xml';
$config['xml']['navigation-tmp'] = 'navigation-tmp.xml';
$config['xml']['navigation-pub'] = 'navigation-pub.xml';

/**
 * Site/Navigaton/Rounting, Action, View, Para
 */

$config['view']['default']['view'] = 'view';
$config['view']['default']['name'] = 'Standardansicht';
$config['view']['default']['lang'] = 'de';
$config['view']['default']['template'] = 'page_html5.php';
$config['view']['default']['css'] = 'view.css';

/*
$config['view']['admin']['view'] = 'admin';
$config['view']['admin']['name'] = 'Admin';
$config['view']['admin']['lang'] = 'de';
$config['view']['admin']['template'] = 'admin.php';
$config['view']['admin']['css'] = 'view_admin.css';
/*

$config['view']['en']['view'] = 'view';
$config['view']['en']['name'] = 'englisch';
$config['view']['en']['lang'] = 'en';
$config['view']['en']['template'] = 'page.php';
$config['view']['en']['css'] = 'view.css';

$config['view']['print']['view'] = 'print';
$config['view']['print']['name'] = 'Druckansicht';
$config['view']['print']['css'] = 'view_print.css';

$config['view']['barrierefrei']['view'] = 'barrierefrei';
$config['view']['barrierefrei']['name'] = 'Barrierefreie Ansicht';
$config['view']['barrierefrei']['css'] = 'view_barrierearm.css';
*/


$config['name_string_replacement'] = array(
	'&lt;' => '<',
	'&gt;' => '>;',
	'&amp;' => '&',
	'&' => '&#38;',
	'"' => '&#34;',
	'<' => '&#60;',
	'>' => '&#62;',
	'...' => '&#8230;',
	'$' => '&#36;',
	'€' => '&#8364;',
);

$config['link_string_replacement'] = array(
	' ' => '-',
	'&' => '+',
	'\\' => '-',
	#'/' => '-',
	'*' => '-',
	'#' => '-',
	'\'' => '-',
	'ä' => 'ae',
	'ö' => 'oe',
	'ü' => 'ue',
	'Ä' => 'Ae',
	'Ö' => 'Oe',
	'Ü' => 'Ue',
	'ß' => 'ss',
);



?>