<?php
/**
 * Run a CLI script within a bootstrapped environment.
 *
 * Eg: php phrank/bin/run.php app/bin/myscript.php
 */

define('ROOT', getcwd());
define('PHRANK', realpath(dirname(__FILE__) . '/../Phrank'));
include PHRANK . '/bootstrap.php';
if(file_exists(ROOT . '/app/bootstrap.php')) {
	include ROOT . '/app/bootstrap.php';
}

if(count($argv) < 2) {
	die("usage: {$argv[0]} <script>\n");
}

if(!file_exists($argv[1])) {
	die("File {$argv[1]} does not exist.\n");
}

/*-----------------------------------------------------------------------
 * Pass control to the specified PHP script.
 *-----------------------------------------------------------------------*/
include $argv[1];

?>
