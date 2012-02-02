<?php

define('BASE_PATH', dirname(__FILE__));
define('BASE_RELPATH', dirname($_SERVER['PHP_SELF']));
/*
echo BASE_PATH;
echo '<br />';
echo $_SERVER['DOCUMENT_ROOT'];
echo '<br />';
echo str_replace($_SERVER['DOCUMENT_ROOT'], '', BASE_PATH);
echo '<br />';
echo dirname($_SERVER['PHP_SELF']);
echo BASE_RELPATH;
*/

require_once(BASE_PATH.'/php/BuilderFront.php');