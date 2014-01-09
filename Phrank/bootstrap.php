<?php
/**
 * Bootstrap the framework. This code is shared between web-based
 * and CLI-based execution paths.
 */

chdir(ROOT);
require 'app/config/config.php';

/*-----------------------------------------------------------------------
 * Add Phrank to the include path
 *-----------------------------------------------------------------------*/
$phrank = realpath(dirname(__FILE__) . '/../');
set_include_path(get_include_path() . PATH_SEPARATOR . $phrank);

/*-----------------------------------------------------------------------
 * Setup Auto-loading
 *-----------------------------------------------------------------------*/
require 'vendor/autoload.php';
spl_autoload_register(function($class) use($phrank) {
	if(substr($class, 0, 1) == '\\') {
		$class = substr($class, 1);
	}
	switch(true) {
		case substr($class, 0, 7) == 'Phrank\\':
			$path = $phrank;
			break;
		case substr($class, 0, 4) == 'App\\':
			$path = ROOT;
			$class = strtolower($class);
			break;
		default:
			return;
	}
	$class = str_replace('\\', '/', $class);
	require_once $path . "/$class.php";
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
if(MODE === 'development') {
	$view->parserExtensions[] = new Twig_Extension_Debug();
}
$container['view'] = $view;

/*-----------------------------------------------------------------------
 * Instantiate Idiorm and Paris (ORM, Models) and connect to database.
 *-----------------------------------------------------------------------*/
require 'vendor/j4mie/idiorm/idiorm.php';
require 'vendor/j4mie/paris/paris.php';
ORM::configure(DSN);
ORM::configure('return_result_sets', true);
Model::$auto_prefix_models = '\\App\\Models\\';

/*-----------------------------------------------------------------------
 * Instantiate RedBean (ORM, Models) and connect to database.
 *-----------------------------------------------------------------------*/
/*
define('REDBEAN_MODEL_PREFIX', '\App\Models\\');
use RedBean_Facade as R;
R::setup(DSN);
*/

?>
