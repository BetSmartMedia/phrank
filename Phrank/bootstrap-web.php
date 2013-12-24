<?php
/**
 * Web-specific bootstrap code. This code should be included after the 
 * initial code in bootstrap.php has been executed.
 */

/*-----------------------------------------------------------------------
 * Session control
 * TODO: Control session lifetime.
 *-----------------------------------------------------------------------*/
session_cache_limiter(false);
session_start();

/*-----------------------------------------------------------------------
 * Our resource container
 *-----------------------------------------------------------------------*/
$container = \Phrank\Base\Container::getInstance();

/*-----------------------------------------------------------------------
 * Instantiate Slim
 *-----------------------------------------------------------------------*/
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->config('mode', MODE);
$app->config('debug', MODE === 'development');
$app->config('templates.path', ROOT . '/app/templates');

/*-----------------------------------------------------------------------
 * Custom error handlers
 *-----------------------------------------------------------------------*/
$app->notFound(function() use($app) {
	\Phrank\Base\Controller::routeNotFound($app);
});
$app->error(function(Exception $e) use($app) {
	// Here we could handle various exceptions before passing
	// control to the base controller.
	\Phrank\Base\Controller::internalError($app, $e);
});

/*-----------------------------------------------------------------------
 * Connect our logger to Slim
 *-----------------------------------------------------------------------*/
$logger = $container['logger'];
$app->config('log.writer', new \Phrank\Extensions\Slim\LogWriter($logger));

/*-----------------------------------------------------------------------
 * Connect our view renderer to Slim
 *-----------------------------------------------------------------------*/
$app->config('view', $container['view']);

/*-----------------------------------------------------------------------
 * Apply middleware
 *-----------------------------------------------------------------------*/
include ROOT . '/app/config/middleware.php';
foreach($app_middleware as $mw) {
	$app->add(new $mw);
}

/*-----------------------------------------------------------------------
 * Bind routes to controllers
 *-----------------------------------------------------------------------*/
include ROOT . '/app/config/routes.php';
\Phrank\Extensions\Slim\RouteBinder::bind($app, $routes, $route_middleware);

?>
