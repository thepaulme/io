<?php
namespace io\Routing;

use io\Http\Request;

class RouteCollection {

    /**
     * An array of the routes keyed by method.
     *
     * @var array
     */
    private $routes = [];

	/**
	 * An flattened array of all of the routes.
	 *
	 * @var array
	 */
	private $allRoutes = [];

	/**
	 * Add a Route instance to the collection.
	 *
	 * @param  \Partisan\Routing\Route  $route
	 * @return \Partisan\Routing\Route
	 */
	public function add (Route $route) {
		$this -> addToCollections ($route);

//		$route -> compiled = (new RouteCompiler ()) -> compile ($route);

		return $route;
	}

	/**
	 * Add the given route to the arrays of routes.
	 *
	 * @param  \Illuminate\Routing\Route  $route
	 * @return void
	 */
	private function addToCollections ($route) {
		$domainAndUri = $route -> getUri (); //$route -> getDomain () ;

		foreach ($route -> getMethods () as $method) {
			$this -> routes[$method][$domainAndUri] = $route;
		}

		$this -> allRoutes[$method . $domainAndUri] = $route;
	}

	public function getRoutes () {
		return array_values ($this -> allRoutes);
	}

	private function getRoutesByMethod ($method = null) {
		if (is_null($method)) {
			return $this -> getRoutes ();
		} else {
			return $this -> routes[$method];
		}
		
		
//		return is_null ($method) ? $this -> getRoutes () : $this -> routes[$method];
		// Arr::get ($this -> routes, $method, []);
	}

	public function match (Request $request) {
//		print_r($request -> getMethod ());
// print_r($this -> routes);

		$routes = $this -> getRoutesByMethod ($request -> getMethod ());

// print_r($routes);

		if (is_array($routes)) {
			if (count ($routes) === 0) { return false; }
		} else { return false; }

		foreach ($routes as $uri => $route) {

			$route -> compile ();

			if (preg_match_all ($route -> compiled -> getRegex (), $request -> getRequestUri (), $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER)) {

				if (is_callable ($route -> callback)) {
					array_shift ($matches[0]);

					$args = [];
					$variables = $route -> compiled -> getVariables ();

					for ($i = 0; $i < count ($matches[0]); ++$i) {
						$match = $matches[0][$i];
						$arg = substr ($request -> getRequestUri (), $match[1], \strlen ($match[0]));

						$args[$i] = $arg;
					}

//					$route -> runCallable ($args);
				}
// echo('cl');
				return $route;

				break;
			}

		}

		return false;
	}
}