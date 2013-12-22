<?php
/**
 * Start a REPL environment.
 */

define('ROOT', dirname(__FILE__) . '/../..');
include ROOT . '/phrank/base/bootstrap.php';

if(!function_exists('posix_getpid')) {
	die("Error: The 'posix' PHP extension is required.\n");
}

/*-----------------------------------------------------------------------
 * Fire up the REPL.
 *-----------------------------------------------------------------------*/
$boris = new \Boris\Boris('php> ');
$boris->start();

?>
