<?php
/**
 * Entry point for web requests.
 */

define('ROOT', dirname(__FILE__) . '/..');

// This path assumes you've installed Phrank via composer. If that's
// not the case, then adjust these paths to point to the correct
// location of the bootstrap files.
include ROOT . '/vendor/bsm/phrank/Phrank/bootstrap.php';
include ROOT . '/vendor/bsm/phrank/Phrank/bootstrap-web.php';
$app->run();

?>
