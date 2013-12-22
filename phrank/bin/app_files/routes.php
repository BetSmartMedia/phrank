<?php
/**
 * Define URL routes and bind them to controllers.
 *
 * Example:

	'GET /' => ['Post', 'view_recent'],

	'/auth' => [
		'GET  /login'  => ['Auth', 'login', [], 'loginForm'],    // arg #3 is route middleware
		'POST /login'  => ['Auth', 'auth'],
		'GET  /logout' => ['Auth', 'logout'],
	],

	'/post' => [
		'GET    /#id'      => ['Post', 'view', [], 'viewPost'],  // arg #4 is a route name
		'GET    /create'   => ['Post', 'create', ['auth']],
		'POST   /create'   => ['Post', 'save', ['auth']],
		'GET    /edit/#id' => ['Post', 'edit', ['auth']],
		'POST   /edit/#id' => ['Post', 'save', ['auth']],
		'DELETE /#id'      => ['Post', 'delete', ['auth']],

 */

$routes = [
	'GET /' => ['Home', 'index'],
];

?>
