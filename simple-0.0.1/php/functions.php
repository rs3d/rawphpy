<?php
function show ($mixed,$echo = 'true') {
	$vars = func_get_args();
	$order = array("\r\n", "\n", "\r");
	$prefix = str_repeat('&nbsp;',8);

	foreach ($vars as $key => $val) {
			if(is_array($val) || is_object($val)) {
			$return .= '<pre>';
			$temp = $prefix.htmlspecialchars(var_export($val,true),ENT_QUOTES,'UTF-8');
			$return .= str_replace($order, "\n".$prefix, $temp);
			$return .= '</pre>';
		}else {
			$temp = var_export($val,true).$prefix;
			$return .= $temp;
		}

	}
	$return .= '<br />';
	#print_r($vars);
	echo $return;



}

function strings2search ($string){

	$string = str_replace(' ','',$string);
	$array = explode(',',$string);

	$return = '';
	foreach ($array as $item) {
		$item = str_replace(' ','',$item);
		$new_array[] = urlencode($item);
	}
	$return = implode('+',$new_array);
	return $return;
}
function search2folder ($string) {
	$array = explode(' ',$string);

	foreach ($array as $item) {
		if ($item) $new_array[] = makeLinkValid($item);
	}
	if (sizeof($new_array) >0 )	$string = implode('/',$new_array);

	$return = substr ($string,0,100);


	return $return;

}
function getdefaultvalue ($key, $map,$value = 'default_search') {
	if ($map[$key]) return $map[$key][$value];
	else return $map['default'][$value];

}
function makeLinkValid ($link_folder) {
		$replacement   = array(
	'&' => '+',
	'\\' => '-',
	'/' => '-',
	' ' => '-',
	'.' => '-',
	#' ' => '-',

	'ä' => 'ae',
	'ö' => 'oe',
	'ü' => 'ue',
	'Ä' => 'Ae',
	'Ö' => 'Oe',
	'Ü' => 'Ue',
	'ß' => 'ss',

);


		#$link_folder = utf8_decode($link_folder);


		$link_folder = str_replace(array_keys($replacement),array_values($replacement),$link_folder);

		$link_folder = preg_replace("/[^A-Z a-z 0-9 \- _ . ÄäÖöÜüß]/", "", $link_folder);

		$link_folder = rawurlencode($link_folder);
		return $link_folder;
	}
?>