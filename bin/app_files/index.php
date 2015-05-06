<?php
/**
 * Entry point for web requests.
 */

define('ROOT', dirname(__FILE__) . '/..');

// This path assumes you've installed Phrank via composer. If that's
// not the case, then adjust these paths to point to the correct
// location of the bootstrap files.
define('PHRANK', ROOT . '/vendor/bsm/phrank/Phrank');

include PHRANK . '/bootstrap.php';
include PHRANK . '/bootstrap-web.php';

try {
	$app->run();
} catch(\Exception $e) {
	// Slim should handle our exceptions, but just in case, catch here.
	\Phrank\Base\Controller::internalError($app, $e);
}

?>
