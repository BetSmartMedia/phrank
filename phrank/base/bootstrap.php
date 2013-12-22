<?php
/**
 * Bootstrap the framework. This code is shared between web-based
 * and CLI-based execution paths.
 */

chdir(ROOT);
require 'app/config/config.php';

/*-----------------------------------------------------------------------
 * Setup Auto-loading
 *-----------------------------------------------------------------------*/
require 'vendor/autoload.php';
spl_autoload_register(function($class) {
	$class = strtolower(str_replace('\\', '/', $class));
	require_once ROOT . "/$class.php";
});
// Paris isn't namespace-aware, so put it in our include path
set_include_path(get_include_path() . PATH_SEPARATOR . ROOT . '/app/models');

/*-----------------------------------------------------------------------
 * Our resource container
 *-----------------------------------------------------------------------*/
$container = \Phrank\Base\Container::getInstance();

/*-----------------------------------------------------------------------
 * Setup a logger
 *-----------------------------------------------------------------------*/
$logger = new \Monolog\Logger('app');
@mkdir(ROOT . '/log');
$logfile = ROOT . '/log/' . date('Y-m-d') . '.log';
$loglevel = MODE === 'development'
	? \Monolog\Logger::DEBUG
	: \Monolog\Logger::WARNING;
$logger->pushHandler(new \Monolog\Handler\StreamHandler($logfile, $loglevel));
$container['logger'] = $logger;

/*-----------------------------------------------------------------------
 * Setup Twig (we use the Slim adapter though Slim isn't required)
 *-----------------------------------------------------------------------*/
$view = new \Slim\Views\Twig();
$view->parserOptions = [
	'debug' => MODE === 'development',
	'cache' => ROOT . '/cache',
];
$view->parserExtensions = [
	new \Slim\Views\TwigExtension()
];
$container['view'] = $view;

/*-----------------------------------------------------------------------
 * Instantiate Idiorm and Paris (ORM, Models) and connect to database.
 *-----------------------------------------------------------------------*/
require 'vendor/j4mie/idiorm/idiorm.php';
require 'vendor/j4mie/paris/paris.php';
ORM::configure(DSN);
Model::$auto_prefix_models = '\\App\\Models\\';

?>
