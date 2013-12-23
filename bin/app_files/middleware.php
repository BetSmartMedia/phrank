<?php
/**
 * Application (Slim) and Route middleware.
 *
 * Middleware is applied in the order it is presented here.
 */

/*
 * An array of middleware class names.
 */
$app_middleware = [
];

/*
 * A map (associative array) of functions. Can be declared inline
 * here, or could be pulled in from a directory of your choosing,
 * such as app/middleware/route.
 */
$route_middleware = [
	// Check whether a visitor is in an authenticated state, and if not,
	// re-route them to the login page.
	'auth' => function() use($app) {
		if(!isset($_SESSION['_authenticated']) || !$_SESSION['_authenticated']) {
			$app->redirect($app->urlFor('loginForm'));
		}
	}
];

?>
