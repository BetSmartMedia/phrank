<?php
/**
 * Start a REPL environment.
 */

define('ROOT', getcwd());
define('PHRANK', ROOT . '/vendor/bsm/phrank/Phrank');
include PHRANK . '/bootstrap.php';

if(!function_exists('posix_getpid')) {
	die("Error: The 'posix' PHP extension is required.\n");
}

/*-----------------------------------------------------------------------
 * Fire up the REPL.
 *-----------------------------------------------------------------------*/
$boris = new \Boris\Boris('php> ');
$boris->start();

?>
