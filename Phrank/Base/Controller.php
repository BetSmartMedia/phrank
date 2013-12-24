<?php
namespace Phrank\Base;

abstract class Controller
{
	function __construct($app)
	{
		$this->app = $app;
	}

	/**
	 * Ex: $app->get('/user/get/:id', $user->proxy('get'));
	 */
	public function proxy($name)
	{
		return function() use($name) {
			call_user_func_array([$this, $name], func_get_args());
		};
	}

	/**
	 * Retrieve an instance of the logger singleton.
	 */
	function getLogger()
	{
		$container = \Phrank\Base\Container::getInstance();
		return $container['logger'];
	}

	/*----------------------------------------------------------------------
	 * Convenience methods for standard HTTP status error responses.
	 *----------------------------------------------------------------------*/
	public function status403()
	{
		$this->app->response->setStatus(403);
		$this->app->render('error/403.html');
	}

	public function status404()
	{
		$this->app->response->setStatus(404);
		$this->app->render('error/404.html');
	}

	public function status500()
	{
		$this->app->response->setStatus(500);
		$this->app->render('error/500.html');
	}

	/**
	 * These do the same as the 404/500 handlers above, but
	 * Slim can call these directly without instantiating a
	 * specific controller.
	 */
	public static function routeNotFound($app)
	{
		$app->response->setStatus(404);
		$app->render('error/404.html');
	}

	public static function internalError($app, $exception=null)
	{
		$app->response->setStatus(500);
		$app->render('error/500.html');
	}
}

?>
