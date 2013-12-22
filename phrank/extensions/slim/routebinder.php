<?php
/**
 * A facility for declarative route binding with Slim.
 */

namespace Phrank\Extensions\Slim;

class RouteBinder
{
	protected static $ctrl_cache = [];

	public static function bind($app, $routes, $middleware=[], $prefix='')
	{
		foreach($routes as $spec=>$dest) {
			// Tokenize the spec. It can be one of two forms:
			//   1. "GET /path"
			//   2. "/post"
			//
			// The latter means that the $dest value is actually an
			// array of routes that will bind under the "/post" path.
			
			// Flatten whitespace and tokenize path spec
			$spec = preg_replace('/\s+/', ' ', $spec);
			$specparts = explode(' ', $spec);

			if(count($specparts) == 1) {
				// This is form #2, where the value is a sub-array of routes.
				self::bind($app, $dest, $middleware, $specparts[0]);
				continue;
			}

			// The rest of this code handles form #1.
			$method = $specparts[0];
			$path   = $prefix . $specparts[1];

			$ctrlname  = $dest[0];
			$ctrlfunc  = $dest[1];
			$appliedmw = $dest[2] ?: [];
			$routename = $dest[3] ?: null;

			// Instantiate the controller if it hasn't already been done.
			if(isset(self::$ctrl_cache[$ctrlname])) {
				$ctrl = self::$ctrl_cache[$ctrlname];
			} else {
				$cn = "\\App\\Controllers\\$ctrlname";
				$ctrl = self::$ctrl_cache[$ctrlname] = new $cn($app);
			}

			// Parameters can have 2 different prefixes to control the type:
			//   '#' indicates an integer
			//   ':' is a catch-all handled directly by Slim
			// Wildcard parameters carry a '+' suffix.
			$conditions = [];
			$typeify = function($coercion) use(&$conditions) {
				return function($m) use($coercion, &$conditions) {
					$conditions[$m[1]] = $coercion;
					return ':' . $m[1];
				};
			};
			$path = preg_replace_callback('/#([A-z_]+)/', $typeify('\d+'), $path);

			$route = $app->map($path, $ctrl->proxy($ctrlfunc))->via($method);
			if($routename)  $route->name($routename);
			if($conditions) $route->conditions($conditions);

			// Apply middleware.
			foreach($appliedmw as $mw) {
				$route->setMiddleware($middleware[$mw]);
			}
		}
	}
}

?>
